<?php
/**
 *
 */

namespace backend\controllers;

use back\components\BackController;
use page\models\Order;
use configuration\models\Configuration;
use \slider\models\Slider;

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
		// $model = Order::model();
		$this->render('index',array('orders' =>  Order::model(),'configurations' =>  Configuration::model(),'sliders' =>  Slider::model() ));
	}
	/**
	 * @return string
	 */
	// public function getModelClass()
	// {
	// 	return '\page\models\Order';
	// }


}
