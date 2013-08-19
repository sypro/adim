<?php echo "<?php\n"; ?>
/**
 *
 */

namespace <?php echo $this->moduleID ; ?>;

use core\components\WebModule;

/**
 * Class <?php echo $this->moduleClass, "\n"; ?>
 */
class <?php echo $this->moduleClass; ?> extends WebModule
{
	public $controllerNamespace = '\<?php echo $this->moduleID; ?>\controllers';
	//public $defaultController = '<?php echo $this->moduleID; ?>';

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
