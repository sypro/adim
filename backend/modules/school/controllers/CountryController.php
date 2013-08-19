<?php
/**
 *
 */

namespace school\controllers;

use backstage\components\BackstageController;

/**
 * Class CountryController
 */
class CountryController extends BackstageController
{
	public function getModelClass()
	{
		return '\school\models\Country';
	}
}
