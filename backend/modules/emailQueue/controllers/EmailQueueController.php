<?php
/**
 *
 */

namespace emailQueue\controllers;

use backstage\components\BackstageController;

/**
 * Class EmailQueueController
 */
class EmailQueueController extends BackstageController
{
	/**
	 * @return string
	 */
	public function getModelClass()
	{
		return '\emailQueue\models\EmailQueue';
	}

	/**
	 * @param int $id
	 */
	public function actionUpdate($id)
	{
		$this->redirect(array('index'));
	}

	/**
	 * @param int $id
	 */
	public function actionDelete($id)
	{
		$this->redirect(array('index'));
	}
}
