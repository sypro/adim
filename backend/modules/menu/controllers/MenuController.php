<?php
/**
 *
 */

namespace menu\controllers;

use back\components\BackController;

/**
 * Class MenuController
 */
class MenuController extends BackController
{
	public function getModelClass()
	{
		return '\menu\models\Menu';
	}
}
