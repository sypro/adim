<?php
/**
 *
 */

namespace admin\controllers;

use back\components\BackController;
use admin\models\LoginForm;

/**
 * Class UserController
 */
class UserController extends BackController
{
	/**
	 * @return string
	 */
	public function getModelClass()
	{
		return '\admin\models\User';
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
				'roles' => array('admin',),
			),
			array(
				'allow',
				'actions' => array('login', 'logout'),
				'users' => array('*',),
			),
			array(
				'deny',
				'users' => array('*',),
			),
		);
	}

	public function actionLogin()
	{
		$model = new LoginForm();
		if (isset($_POST[\CHtml::modelName($model)])) {
			$model->attributes = $_POST[\CHtml::modelName($model)];

			if ($model->validate()) {
				$this->redirect(array('/site/index'));
			}
		}
		$this->render('login', array('model' => $model,));
	}

	public function actionLogout()
	{
		app()->user->logout();
		$this->redirect(array('/site/index'));
	}
}
