<?php echo "<?php\n"; ?>
/**
 *
 */

namespace <?php echo $this->moduleID; ?>\controllers;

use front2\components\Front2Controller;

/**
 * Class DefaultController
 */
class DefaultController extends Front2Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
}
