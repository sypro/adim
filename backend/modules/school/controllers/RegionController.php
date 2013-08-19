<?php
/**
 *
 */

namespace school\controllers;

use backstage\components\BackstageController;

/**
 * Class RegionController
 */
class RegionController extends BackstageController
{
	public function getModelClass()
	{
		return '\school\models\Region';
	}
}
