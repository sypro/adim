<?php
/**
 *
 */

namespace translate\controllers;

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
