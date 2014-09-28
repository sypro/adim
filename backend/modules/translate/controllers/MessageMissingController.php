<?php
/**
 *
 */

namespace translate\controllers;

use back\components\BackController;

/**
 * Class MessageMissingController
 */
class MessageMissingController extends BackController
{
	/**
	 * @return string
	 */
	public function getModelClass()
	{
		return '\translate\models\MessageMissing';
	}
}
