<?php
/**
 *
 */

namespace menu\controllers;

use backstage\components\BackstageController;

/**
 * Class DefaultController
 */
class DefaultController extends BackstageController
{
	public function actionIndex()
	{
		$this->render('index');
	}
}
