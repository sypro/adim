<?php
/**
 *
 */

namespace menu\controllers;

use back\components\BackController;

/**
 * Class MenuListController
 */
class MenuListController extends BackController
{
	public function getModelClass()
	{
		return '\menu\models\MenuList';
	}
}
