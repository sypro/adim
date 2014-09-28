<?php
/**
 *
 */

namespace translate\controllers;

use front\components\FrontController;

/**
 * Class DefaultController
 */
class DefaultController extends FrontController
{
	public function actionIndex()
	{
		$this->render('index');
	}
}
