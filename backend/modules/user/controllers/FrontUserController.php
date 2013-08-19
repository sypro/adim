<?php
/**
 *
 */

namespace user\controllers;

use backstage\components\BackstageController;

/**
 * Class FrontUserController
 */
class FrontUserController extends BackstageController
{
	public function getModelClass()
	{
		return '\user\models\FrontUser';
	}
}
