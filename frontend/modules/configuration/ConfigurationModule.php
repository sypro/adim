<?php
/**
 *
 */

namespace configuration;

use core\components\WebModule;

/**
 * Class ConfigurationModule
 */
class ConfigurationModule extends WebModule
{
	public $controllerNamespace = '\configuration\controllers';
	//public $defaultController = 'configuration';

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
