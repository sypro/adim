<?php
/**
 *
 */

namespace emailQueue;

use core\components\WebModule;

/**
 * Class EmailQueueModule
 */
class EmailQueueModule extends WebModule
{
	/**
	 * @var string Namespace that should be used when loading controllers.
	 * Default is to use global namespace.
	 * @since 1.1.11
	 */
	public $controllerNamespace = '\emailQueue\controllers';

	/**
	 * @var string the ID of the default controller for this module. Defaults to 'default'.
	 */
	//public $defaultController = 'emailQueue';

	/**
	 * The pre-filter for controller actions.
	 * This method is invoked before the currently requested controller action and all its filters
	 * are executed. You may override this method in the following way:
	 * <pre>
	 * if(parent::beforeControllerAction($controller,$action))
	 * {
	 *     // your code
	 *     return true;
	 * }
	 * else
	 *     return false;
	 * </pre>
	 * @param \CController $controller the controller
	 * @param \CAction $action the action
	 * @return boolean whether the action should be executed.
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
