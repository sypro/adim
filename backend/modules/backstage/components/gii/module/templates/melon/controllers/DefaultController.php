<?php echo "<?php\n"; ?>
/**
 *
 */

namespace <?php echo $this->moduleID; ?>\controllers;

use backstage\components\BackstageController;

/**
 * Class DefaultController
 */
class DefaultController extends BackstageController
{
	public function actionIndex()
	{
		$this->render('index');
	}
}
