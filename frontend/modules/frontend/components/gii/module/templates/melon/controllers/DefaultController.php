<?php echo "<?php\n"; ?>
/**
 *
 */

namespace <?php echo $this->moduleID; ?>\controllers;

use frontend\components\FrontendController;

/**
 * Class DefaultController
 */
class DefaultController extends FrontendController
{
	public function actionIndex()
	{
		$this->render('index');
	}
}
