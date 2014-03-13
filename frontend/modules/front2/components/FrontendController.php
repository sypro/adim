<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace front2\components;

use core\components\Controller;

/**
 * Class Front2Controller
 * @package front2\components
 *
 * @method registerSEO()
 */
class Front2Controller extends Controller
{
	/**
	 * @var string
	 */
	public $layout = '//layouts/sub';

	public function init()
	{
		parent::init();

		/*if (\Yii::app()->getGlobalState('useSecondSessionWhen')+60*10 < time()) {
			\Yii::app()->setGlobalState('useSecondSession', false);
		}

		if (\Yii::app()->getGlobalState('useSecondSession')) {
			\Yii::app()->setComponent('session', \Yii::app()->getComponent('sessionSecond'));
		}*/
	}

	/**
	 * @param string $className
	 * @param array $properties
	 * @param bool $captureOutput
	 *
	 * @return bool|Widget|mixed|string
	 */
	public function widget($className, $properties = array(), $captureOutput = false)
	{
		$class = new $className();
		if (!($class instanceof Widget)) {
			return parent::widget($className, $properties, $captureOutput);
		}
		$widget = $this->createWidget($className, $properties);
		$cache = false;
		$result = false;
		/** @var $widget Widget */
		if ($widget->enableCache) {
			if ($widget->cacheID && app()->hasComponent($widget->cacheID)) {
				/** @var $cache \CDummyCache */
				$cache = app()->getComponent($widget->cacheID);
				if ($cache) {
					$result = $cache->get($widget->getCacheKey());
				}
			}
		}

		if ($result === false) {
			ob_start();
			ob_implicit_flush(false);
			$widget->run();
			$result = ob_get_clean();

			if ($cache) {
				$cache->set($widget->getCacheKey(), $result, $widget->expire, $widget->dependency);
			}
		}

		if ($captureOutput) {
			return $result;
		} else {
			echo $result;
			return $widget;
		}
	}

	/**
	 * Return class of the model
	 *
	 * @throws \CException
	 * @return string
	 */
	public function getModelClass()
	{
		throw new \CException('Need to be implemented in child class');
	}

	/**
	 * @param $id
	 * @param bool $class
	 * @param bool $attributes
	 * @param bool $prepare
	 * @param bool $seo
	 * @param string $condition
	 * @param array $params
	 *
	 * @return \CActiveRecord
	 * @throws \CHttpException
	 */
	public function loadModel($id, $class = false, $attributes = false, $prepare = true, $seo = true, $condition = '', $params = array())
	{
		if ($class === false) {
			$class = $this->getModelClass();
		}
		/** @var ActiveRecord $finder */
		$finder = ActiveRecord::model($class)->published();
		if (is_array($id) && $attributes) {
			$model = $finder->findByAttributes($id, $condition, $params);
		} else {
			$model = $finder->findByPk($id, $condition, $params);
		}
		if ($model === null) {
			throw new \CHttpException(404, t('The requested page does not exist.'));
		}
		if ($prepare) {
			$this->prepare($model);
		}
		if ($seo && $model->asa('seo') && $this->asa('seo')) {
			$this->registerSEO($model);
		}
		return $model;
	}

	/**
	 * @param $model
	 */
	public function prepare($model)
	{
	}

	/**
	 * @return array
	 */
	public function filters()
	{
		return \CMap::mergeArray(
			parent::filters(),
			array(
				array(
					'\front2\components\SetReturnUrlFilter +index +view',
				),
			)
		);
	}

	/**
	 * @return array
	 */
	public function behaviors()
	{
		return \CMap::mergeArray(
			parent::behaviors(),
			array(
				'seo' => array(
					'class' => '\seo\components\SeoControllerBehavior',
				),
			)
		);
	}
}
