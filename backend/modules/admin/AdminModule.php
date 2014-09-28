<?php
/**
 *
 */

namespace admin;

use core\components\WebModule;

/**
 * Class AdminModule
 */
class AdminModule extends WebModule
{
	/**
	 * @var string
	 */
	public $controllerNamespace = '\admin\controllers';

	/**
	 * @var string
	 */
	public $defaultController = 'admin';

	/**
	 * @param \CController $controller
	 * @param \CAction $action
	 *
	 * @return bool
	 */
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
