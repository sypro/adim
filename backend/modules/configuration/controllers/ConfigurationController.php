<?php
/**
 *
 */

namespace configuration\controllers;

use back\components\ActiveRecord;
use back\components\BackController;
use CAction;
use configuration\models\Configuration;
use core\components\ClientScript;
use language\helpers\Lang;

/**
 * Class ConfigurationController
 */
class ConfigurationController extends BackController
{
	public function filters()
	{
		return \CMap::mergeArray(
			parent::filters(),
			array(
				'postOnly +subForm',
				'ajaxOnly +subForm',
				'jsonHeader +subForm',
			)
		);
	}

	protected function beforeAction($action)
	{
		if (parent::beforeAction($action)) {
			$this->registerAssets();
			return true;
		}
		return false;
	}

	public function registerAssets()
	{
		app()->bootstrap->assetsRegistry->registerPackage('ckeditor');
	}

	public function getModelClass()
	{
		return Configuration::getClassName();
	}

	public function actionSubForm()
	{
		$this->layout = false;

		$class = $this->getModelClass();
		/** @var $model Configuration */
		$model = new $class('insert');

		\Yii::import('bootstrap.widgets.TbForm');
		/** @var $form \CForm */
		$form = \TbForm::createForm(
			$model->prepareFormConfig($model->getFormConfig()),
			$this,
			array(
				'enableAjaxValidation' => false,
				'type' => 'horizontal',
			),
			$model
		);
		$form->loadData();

		\Yii::import('bootstrap.widgets.TbActiveForm');
		$activeForm = new \TbActiveForm();
		$activeForm->type = 'horizontal';

		$replaces = array();

		$id = \CHtml::activeId($model, 'value');
		$field = $model->getValueField($activeForm, 'value');
		$replaces[] = array(
			'what' => '#cke_' . $id,
			'data' => null,
		);
		$replaces[] = array(
			'what' => '#' . $id,
			'data' => $field,
		);
		foreach (Lang::getLanguageKeys() as $language) {
			if (Lang::getDefault() == $language) {
				continue;
			}
			$id = \CHtml::activeId($model, 'value_' . $language);
			$field = $model->getValueField($activeForm, 'value_' . $language);
			$replaces[] = array(
				'what' => '#cke_' . $id,
				'data' => null,
			);
			$replaces[] = array(
				'what' => '#' . $id,
				'data' => $field,
			);
		}
		$js = null;
		if ($model->type == Configuration::TYPE_HTML) {
			$options = \CJavaScript::encode(array('width' => 800,'language' => 'ru', ));
			$js = "var editorOptions = {$options};";
			$id = \CHtml::activeId($model, 'value');
			$js .= "CKEDITOR.replace('{$id}', editorOptions);";
			foreach (Lang::getLanguageKeys() as $language) {
				if (Lang::getDefault() == $language) {
					continue;
				}
				$id = \CHtml::activeId($model, 'value_' . $language);
				$js .= "CKEDITOR.replace('{$id}', editorOptions);";
			}
		}

		$this->renderJson(array(
			'replaces' => $replaces,
			'js' => \CHtml::script($js),
		));
	}
}
