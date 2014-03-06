<?php
/**
 *
 */

namespace front\controllers;

use frontend\components\FrontendController;

/**
 * Class SiteController
 *
 * @package front\controllers
 */
class SiteController extends FrontendController
{
	/**
	 * @var string
	 */
	public $layout = '//layouts/main';

	/**
	 * index page of the site
	 */
	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionMaintenance()
	{
		$this->layout = false;
		$this->render('maintenance');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if (($error = app()->errorHandler->error)) {
			if (r()->isAjaxRequest) {
				echo $error['message'];
			} else {
				$this->render('error', $error);
			}
		}
	}
}
