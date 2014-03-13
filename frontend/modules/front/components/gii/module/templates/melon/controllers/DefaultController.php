<?php echo "<?php\n"; ?>
/**
 *
 */

namespace <?php echo $this->moduleID; ?>\controllers;

use front\components\FrontController;

/**
 * Class DefaultController
 */
class DefaultController extends FrontController
{
	public function actionIndex()
	{
		$this->render('index');
	}
}
