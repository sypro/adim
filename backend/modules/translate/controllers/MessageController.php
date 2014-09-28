<?php
/**
 *
 */

namespace translate\controllers;

use back\components\BackController;

/**
 * Class SourceMessageController
 */
class MessageController extends BackController
{
	public function getModelClass()
	{
		return '\translate\models\Message';
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
	public function actionCreate($id = null)
	{
		$model = null;
		if ($id !== null) {
			$model = $this->loadModel($id);
		}
		if (!$model) {
			$class = $this->getModelClass();
			$classPost = \CHtml::modelName($class);
			if ($post = r()->getPost($classPost)) {
				$language = isset($post['language']) ? $post['language'] : null;
				$id = isset($post['id']) ? $post['id'] : null;

				if ($language && $id) {
					$model = \CActiveRecord::model($class)->resetScope()->findByPk(array(
							'language' => $language,
							'id' => $id,
						));
				}
			}

			if (!$model) {
				$model = new $class();
			}
		}
		$model->setScenario('insert');

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
					$this->redirect(array('view', 'id'=>$model->getAdminPrimaryKey()));
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
					$this->redirect(array('view', 'id'=>$model->getAdminPrimaryKey()));
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

	public function actionMessage()
	{
		$language = r()->getPost('language');
		$id = r()->getPost('id');
		if (!$id || !$language) {
			throw new \CHttpException(400, 'Ошибка запроса. Обновите страницу');
		}
		$class = $this->getModelClass();
		$model = \CActiveRecord::model($class)->resetScope()->findByPk(array(
			'language' => $language,
			'id' => $id,
		));
		if (!$model) {
			echo '';
		} else {
			echo $model->translation;
		}
		app()->end();
	}

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
}
