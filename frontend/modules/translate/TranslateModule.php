<?php
/**
 *
 */

namespace translate;

use core\components\WebModule;

/**
 * Class TranslateModule
 */
class TranslateModule extends WebModule
{
	public $controllerNamespace = '\translate\controllers';
	//public $defaultController = 'translate';

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
