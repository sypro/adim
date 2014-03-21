<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace menu\widgets\menuMain;

use core\components\Menu;

/**
 * Class MenuMain
 * @package menu\widgets\menuMain
 */
class MenuMain extends Menu
{
	public function init()
	{
		$items = array();
		$this->items = $items;
		parent::init();
	}
}
