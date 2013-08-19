<?php
/**
 *
 */

namespace back\controllers;

use backstage\components\BackstageController;

/**
 * Class SiteController
 *
 * @package melon\controllers
 */
class SiteController extends BackstageController
{
	/**
	 * index page of the site
	 */
	public function actionIndex()
	{
		$this->render('index');
	}
}
