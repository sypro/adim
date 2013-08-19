<?php
/**
 *
 */

namespace menu;

use core\components\WebModule;

/**
 * Class MenuModule
 */
class MenuModule extends WebModule
{
	public $controllerNamespace = '\menu\controllers';
	//public $defaultController = 'menu';

	public function beforeControllerAction($controller, $action)
	{
		if (parent::beforeControllerAction($controller, $action)) {
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		} else {
			return false;
		}
	}
}
