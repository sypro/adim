<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace back\components;

use core\components\Controller;
use admin\models\User;
use fileProcessor\helpers\FPM;

/**
 * Class BackController
 *
 * @package core\components
 */
class BackController extends Controller
{
	/**
	 * Default backend layout
	 *
	 * @var string
	 */
	public $layout = '//layouts/column1';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return mergeArray(
			parent::filters(),
			array(
				'postOnly +change +deleteFile',
				'ajaxOnly +change +deleteFile',
				'jsonHeader +change +deleteFile',
			)
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 *
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array(
				'allow',
				'roles' => array(User::ROLE_ADMIN,),
			),
			array(
				'deny',
				'users' => array('*',),
			),
		);
	}

	/**
	 * Displays a particular model.
	 *
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render(
			'//templates/admin/view',
			array(
				'model' => $this->loadModel($id),
			)
		);
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
		$model = $this->loadModel($id);

		$modelName = \CHtml::modelName($model);
		if (isset($_POST[$modelName])) {
			$model->setAttributes($_POST[$modelName]);
		}

		\Yii::import('bootstrap.widgets.TbForm');
		/** @var $form \TbForm */
		$form = \TbForm::createForm(
			$model->prepareFormConfig($model->getFormConfig()),
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
					$this->redirect(array('view', 'id' => $model->getPrimaryKey()));
				}
			} catch (\Exception $exception) {
				$model->addError($model->tableSchema->primaryKey, $exception->getMessage());
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

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$class = $this->getModelClass();
		$modelName = \CHtml::modelName($class);
		/** @var $model ActiveRecord */
		$model = new $class();

		\Yii::import('bootstrap.widgets.TbForm');

		if (isset($_POST[$modelName])) {
			$model->setAttributes($_POST[$modelName]);
		}

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

		if ($form->submitted('submit') && $form->validate()) {
			$transaction = $model->getDbConnection()->beginTransaction();
			try {
				if ($model->save()) {
					$transaction->commit();
					$this->redirect(array('view', 'id' => $model->getPrimaryKey()));
				}
			} catch (\Exception $exception) {
				$model->addError($model->tableSchema->primaryKey, $exception->getMessage());
				$transaction->rollback();
			}
		}

		$this->render(
			'//templates/admin/create',
			array(
				'model' => $model,
				'form' => $form,
			)
		);
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$class = $this->getModelClass();
		$model = \CActiveRecord::model($class);
		$modelName = \CHtml::modelName($model);
		$model->setScenario('search');
		$model->unsetAttributes(); // clear any default values
		if (isset($_GET[$modelName])) {
			$model->attributes = $_GET[$modelName];
		}

		$this->render(
			'//templates/admin/index',
			array(
				'model' => $model,
			)
		);
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 *
	 * @param integer $id the ID of the model to be deleted
	 *
	 * @throws \CDbException
	 * @throws \CHttpException
	 * @return void
	 */
	public function actionDelete($id)
	{
		if (\Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			$model = $this->loadModel($id);
			$transaction = $model->getDbConnection()->beginTransaction();
			try {
				if (!$model->delete()) {
					throw new \CDbException(\Yii::t('yii', 'The active record cannot be deleted because it is new.'));
				}
				$transaction->commit();
			} catch (\Exception $exception) {
				$transaction->rollback();
				// TODO: wtf?
				throw new \CDbException(\Yii::t('yii', $exception->getMessage()));
			}

			if (\Yii::app()->request->isAjaxRequest) {
				$data = array(
					'redirect' => nu(array('index')),
				);
				$this->renderJson($data);
			} else {
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
			}
		} else {
			throw new \CHttpException(400, 'Invalid request. Please do not repeat this request again.');
		}
	}

	/**
	 * Delete only related file
	 *
	 * @param $id
	 */
	public function actionDeleteFile($id)
	{
		FPM::deleteFiles($id);
		$data = array(
			'replaces' => array(
				array(
					'what' => '#file' . $id,
					'data' => null,
				),
			),
		);
		$this->renderJson($data);
	}

	/**
	 * Change some param
	 *
	 * @param $id
	 * @param $attributeName
	 *
	 * @throws \CHttpException
	 */
	public function actionChange($id, $attributeName)
	{
		$value = r()->getPost('value');
		if ($value === null) {
			throw new \CHttpException(400, t('Value not set'));
		}

		$model = $this->loadModel($id);
		if (!$model->hasAttribute($attributeName)) {
			throw new \CHttpException(405, t('Method not allowed'));
		}

		$model->setScenario('change');
		$model->$attributeName = $value;
		$model->save(true, array($attributeName,));
		$model->refresh();

		$element = \CHtml::activeCheckBox(
			$model,
			$attributeName,
			array(
				'class' => 'do-change-value',
				'id' => 'element-change-' . $attributeName . '-' . $model->primaryKey,
				'data-url' => \CHtml::normalizeUrl(
						array('change', 'id' => $model->primaryKey, 'attributeName' => $attributeName,)
					),
			)
		);
		$data = array(
			'replaces' => array(
				array(
					'what' => '#element-change-' . $attributeName . '-' . $model->primaryKey,
					'data' => $element,
				),
			),
		);
		$this->renderJson($data);
	}

	/**
	 * Dependent drop downs
	 *
	 * @throws \CHttpException
	 */
	public function actionDependent()
	{
		$nextId = r()->getPost('next');
		$model = r()->getPost('model');
		$nextAttribute = r()->getPost('attribute');
		$dependentModel = r()->getPost('dependent');
		$id = r()->getPost('id');

		if ($nextId === null || $model === null || $id === null || $dependentModel === null || $nextAttribute === null) {
			throw new \CHttpException(400, t("Values necessary to dependent dropDowns not setted"));
		}

		$dependentModel = new $dependentModel();

		$model = new $model();

		$formConfig = $model->getFormConfig();

		if (!isset($formConfig['elements'][$nextAttribute])) {
			throw new \CHttpException(400, t('Attribute can not found in model form config'));
		}
		$attributeConfig = $formConfig['elements'][$nextAttribute];
		$class = $attributeConfig['type'];
		unset($attributeConfig['type']);
		if ($class === 'back\components\DependentDropDownFormInputElement') {
			$attributeConfig['model'] = $model;
			$attributeConfig['attribute'] = $nextAttribute;
			$attributeConfig['data'] = \CHtml::listData($dependentModel->getDependent($id), 'id', 'label');
			$dropDown = app()->controller->widget(
				DependentDropDownFormInputElement::getClassName(),
				$attributeConfig,
				true
			);
		} elseif ($class === 'dropdownlist') {
			unset($attributeConfig['items']);
			$dropDown = \CHtml::activeDropDownList(
				$model,
				$nextAttribute,
				\CHtml::listData($dependentModel->getDependent($id), 'id', 'label'),
				$attributeConfig
			);
		} else {
			throw new \CHttpException(
				400,
				t('Field type must be "dropdownlist" or "back\components\DependentDropDownFormInputElement"')
			);
		}

		$data = array(
			'replaces' => array(
				array(
					'what' => $nextId,
					'data' => $dropDown,
				),
			),
		);
		$this->renderJson($data);
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
		$finder = \CActiveRecord::model($class)->resetScope();
		if ($finder->asa('multiLang')) {
			$finder->multiLang();
		}
		$model = $finder->findByPk($id);
		if ($model === null) {
			throw new \CHttpException(404, 'The requested page does not exist.');
		}
		if ($prepare) {
			$this->prepare($model);
		}

		return $model;
	}

	public function prepare($model)
	{
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
}
