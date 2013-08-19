<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace frontend\components;

use core\components\Controller;

/**
 * Class FrontendController
 * @package frontend\components
 *
 * @method registerSEO()
 */
class FrontendController extends Controller
{
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
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 *
	 * @param      $id
	 *
	 * @param bool $class
	 * @param bool $prepare
	 *
	 * @throws \CHttpException
	 * @internal param \the $integer ID of the model to be loaded
	 * @return \CActiveRecord
	 */
	public function loadModel($id, $class = false, $prepare = true)
	{
		if ($class === false) {
			$class = $this->getModelClass();
		}
		$model = \CActiveRecord::model($class)->published()->findByPk($id);
		if ($model === null) {
			throw new \CHttpException(404, 'The requested page does not exist.');
		}
		if ($prepare) {
			$this->prepare($model);
		}
		if ($model->asa('seo')) {
			$this->registerSEO($model);
		}
		return $model;
	}

	public function prepare($model)
	{
	}

	public function filters()
	{
		return \CMap::mergeArray(
			parent::filters(),
			array(
				array(
					'\frontend\components\SetReturnUrlFilter +index +view',
				),
			)
		);
	}
}
