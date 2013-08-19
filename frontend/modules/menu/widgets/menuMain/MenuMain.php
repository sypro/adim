<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace menu\widgets\menuMain;

use core\components\Menu;
use news\models\News;

/**
 * Class MenuMain
 * @package menu\widgets\menuMain
 */
class MenuMain extends Menu
{
	public function init()
	{
		$items = array(
			array('label' => t('Company'), 'url' => '#'),
			array('label' => t('To partners'), 'url' => '#'),
			array('label' => t('Objects'), 'url' => '#'),
			array('label' => t('News'), 'url' => News::getListPageUrl()),
			array('label' => t('Contacts'), 'url' => '#'),
		);
		$this->items = $items;
		parent::init();
	}
}
