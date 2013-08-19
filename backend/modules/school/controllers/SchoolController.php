<?php
/**
 *
 */

namespace school\controllers;

use backstage\components\BackstageController;

/**
 * Class SchoolController
 */
class SchoolController extends BackstageController
{
	public function getModelClass()
	{
		return '\school\models\School';
	}
}
