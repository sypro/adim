<?php
/**
 *
 */

namespace front2\controllers;

use front2\components\Front2Controller;

/**
 * Class DefaultController
 */
class DefaultController extends Front2Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
}
