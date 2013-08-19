<?php
/**
 *
 */

namespace menu\controllers;

use backstage\components\BackstageController;

/**
 * Class MenuListController
 */
class MenuListController extends BackstageController
{
	public function getModelClass()
	{
		return '\menu\models\MenuList';
	}
}
