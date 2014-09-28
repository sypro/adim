<?php echo "<?php\n"; ?>
/**
 *
 */

namespace <?php echo $this->moduleID; ?>\controllers;

use back\components\BackController;

/**
 * Class DefaultController
 */
class DefaultController extends BackController
{
	public function actionIndex()
	{
		$this->render('index');
	}
}
