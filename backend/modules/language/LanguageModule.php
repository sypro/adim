<?php
/**
 *
 */

namespace language;

use core\components\WebModule;

/**
 * Class LanguageModule
 */
class LanguageModule extends WebModule
{
	public $controllerNamespace = '\language\controllers';
	public $defaultController = 'language';

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
