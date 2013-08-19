<?php
/**
 *
 */

namespace menu\controllers;

use backstage\components\BackstageController;

/**
 * Class MenuController
 */
class MenuController extends BackstageController
{
	public function getModelClass()
	{
		return '\menu\models\Menu';
	}
}
