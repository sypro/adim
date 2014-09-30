<?php
/**
 *
 */

namespace frontend\controllers;

use front\components\FrontController;
use frontend\models\Gallery;
use frontend\models\Partners;
use frontend\models\Principles;

/**
 * Class SiteController
 *
 * @package frontend\controllers
 */
class SiteController extends FrontController
{
	/**
	 * @var string
	 */
	public $layout = '//layouts/sub';

	/**
	 * index page of the site
	 */
	public function actionIndex()
	{
        $this->layout = '//layouts/main';
        $this->render('index');
	}
    public function actionAbout()
    {
        $this->render('about');
    }
    public function actionGallery()
    {
        $this->render('gallery',array('model'=> Gallery::getItems()));
    }
    public function actionPartners()
    {
        $this->render('partners',array('model' => Partners::getItems()));
    }
    public function actionPrinciples()
    {
        $this->render('principles',array('model' => Principles::getItems()));
    }
    public function actionContacts()
    {
        $this->render('contact');
    }

	public function actionMaintenance()
	{
		$this->layout = false;
		$this->render('maintenance');
	}

	public function actionCms()
	{
		$this->layout = false;
		$this->render('cms');
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
