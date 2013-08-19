<?php
/**
 *
 */

namespace school\controllers;

use backstage\components\BackstageController;

/**
 * Class VillageController
 */
class VillageController extends BackstageController
{
	public function getModelClass()
	{
		return '\school\models\Village';
	}
}
