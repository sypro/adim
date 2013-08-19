<?php
/**
 *
 */

namespace elfinder;

use core\components\WebModule;

/**
 * Class ElfinderModule
 */
class ElfinderModule extends WebModule
{
	public $controllerNamespace = '\elfinder\controllers';
	public $defaultController = 'elfinder';

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
