<?php
/**
 *
 */

namespace seo\controllers;

use back\components\ActiveRecord;
use back\components\BackController;
use seo\models\Seo;

/**
 * Class SeoController
 */
class SeoController extends BackController
{
	/**
	 * @return array
	 */
	public function filters()
	{
		return \CMap::mergeArray(
			parent::filters(),
			array(
				'postOnly +save',
				'ajaxOnly +save',
				'jsonHeader +save',
			)
		);
	}

	public function actionSave()
	{
		$class = $this->getModelClass();
		/** @var $model ActiveRecord */
		$model = new $class();
		$postClass = \CHtml::modelName($model);
		$model->setScenario('insert');
		$js = null;

		if (isset($_POST[$postClass]) && is_array($_POST[$postClass])) {
			foreach ($_POST[$postClass] as $one) {
				$model->setAttributes($one);

				if (\CActiveRecord::model($class)->resetScope()->findByPk($model->getPrimaryKey())) {
					$model->isNewRecord = false;
					$model->setScenario('update');
				}

				if (!$model->save()) {
					$result = array();
					foreach ($model->getErrors() as $attribute => $errors) {
						foreach ($errors as $error) {
							$result[] = \CHtml::encode($error);
						}
					}
					$errors = join("\r\n", $result);
					$response = t('Fix this errors:') . " \r\n\r\n" . $errors;
					$js .= \CHtml::script('alert(' . \CJavaScript::encode($response) . ');');
				} else {
					$js = \CHtml::script(
						'alert('
						. \CJavaScript::encode(
							t(
								'core',
								'Seo for language "{language}" saved.',
								array(
									'{language}' => $model->lang_id,
								)
							)
						)
						. ');'
					);
				}
			}
		} else {
			$js = \CHtml::script('alert("' . t('Error input') . '");');
		}

		$response = array(
			'js' => $js,
		);

		$this->renderJson($response);
	}

	/**
	 * @return string
	 */
	public function getModelClass()
	{
		return Seo::getClassName();
	}

	/**
	 * @param $id
	 * @param bool $class
	 * @param bool $prepare
	 *
	 * @return \CActiveRecord|static
	 * @throws \CHttpException
	 */
	public function loadModel($id, $class = false, $prepare = true)
	{
		$id = jd($id);
		if ($class === false) {
			$class = $this->getModelClass();
		}
		if (is_int($id) || is_string($id)) {
			$model = \CActiveRecord::model($class)->resetScope()->findByPk($id);
		} else {
			$model = \CActiveRecord::model($class)->resetScope()->findByAttributes($id);
		}
		if ($model === null) {
			throw new \CHttpException(404, 'The requested page does not exist.');
		}
		if ($prepare) {
			$this->prepare($model);
		}

		return $model;
	}

	/**
	 *
	 */
	public function actionCreate()
	{
		$this->redirect(array('index',));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 *
	 * @param integer $id the ID of the model to be updated
	 *
	 * @throws \CDbException
	 * @return void
	 */
	public function actionUpdate($id)
	{
		/** @var ActiveRecord $model */
		$model = $this->loadModel($id);
		$model->setScenario('update');

		\Yii::import('bootstrap.widgets.TbForm');
		/** @var $form \TbForm */
		$form = \TbForm::createForm(
			$model->getFormConfig(),
			$this,
			array(
				'enableAjaxValidation' => false,
				'type' => 'horizontal',
			),
			$model
		);

		if ($form->submitted('submit') && $form->validate()) {
			$transaction = $model->getDbConnection()->beginTransaction();
			try {
				if ($model->save()) {
					$transaction->commit();
					$this->redirect(array('view', 'id' => $model->getAdminPrimaryKey()));
				}
			} catch (\Exception $exception) {
				$key = $model->tableSchema->primaryKey;
				if (is_array($key)) {
					$key = je($key);
				}
				$model->addError($key, $exception->getMessage());
				$transaction->rollback();
			}
		}

		$this->render(
			'//templates/admin/update',
			array(
				'model' => $model,
				'form' => $form,
			)
		);
	}
}
