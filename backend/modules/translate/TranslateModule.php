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
	/**
	 * @var string Namespace that should be used when loading controllers.
	 * Default is to use global namespace.
	 * @since 1.1.11
	 */
	public $controllerNamespace = '\translate\controllers';

	/**
	 * @var string the ID of the default controller for this module. Defaults to 'default'.
	 */
	public $defaultController = 'message';

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

			$this->registerScripts();

			return true;
		} else {
			return false;
		}
	}

	/**
	 * Registers the necessary scripts.
	 */
	public function registerScripts()
	{
		$assetsUrl = $this->getAssetsUrl();

		cs()->registerCoreScript('jquery');
		cs()->registerPackage('back.main');
		cs()->registerScriptFile($assetsUrl . '/js/translate.js');
	}
}
