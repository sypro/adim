<?php
/**
 *
 */

namespace backend\controllers;

use back\components\BackController;

/**
 * Class SiteController
 *
 * @package melon\controllers
 */
class SiteController extends BackController
{
	/**
	 * index page of the site
	 */
	public function actionIndex()
	{
		$this->render('index');
	}
}
