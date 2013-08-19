<?php
/**
 *
 */

namespace user;

use core\components\WebModule;

/**
 * Class UserModule
 */
class UserModule extends WebModule
{
	public $controllerNamespace = '\user\controllers';
	public $defaultController = 'user';

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
