<?php
/**
 *
 */

namespace configuration\controllers;

use back\components\BackController;

/**
 * Class DefaultController
 */
class DefaultController extends BackController
{
	public function actionIndex()
	{
		$this->render('index');
	}
}
