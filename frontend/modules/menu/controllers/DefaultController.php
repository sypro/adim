<?php
/**
 *
 */

namespace menu\controllers;

use frontend\components\FrontendController;

/**
 * Class DefaultController
 */
class DefaultController extends FrontendController
{
	public function actionIndex()
	{
		$this->render('index');
	}
}
