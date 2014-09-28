<?php
/**
 *
 */

namespace emailQueue\controllers;

use back\components\BackController;

/**
 * Class EmailQueueController
 */
class EmailQueueController extends BackController
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
