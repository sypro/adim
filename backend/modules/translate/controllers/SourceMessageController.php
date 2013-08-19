<?php
/**
 *
 */

namespace translate\controllers;

use backstage\components\BackstageController;

/**
 * Class SourceMessageController
 */
class SourceMessageController extends BackstageController
{
	public function getModelClass()
	{
		return '\translate\models\SourceMessage';
	}
}
