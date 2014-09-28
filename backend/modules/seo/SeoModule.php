<?php
/**
 *
 */

namespace seo;

use core\components\WebModule;

/**
 * Class SeoModule
 */
class SeoModule extends WebModule
{
	public $controllerNamespace = '\seo\controllers';
	public $defaultController = 'seo';

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
