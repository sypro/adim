<?php
/**
 *
 */

namespace translate\controllers;

use back\components\BackController;

/**
 * Class SourceMessageController
 */
class SourceMessageController extends BackController
{
	public function getModelClass()
	{
		return '\translate\models\SourceMessage';
	}
}
