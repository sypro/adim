<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace language\widgets\languageChecker;

use core\components\Menu;
use front\components\FrontController;
use language\helpers\Lang;

/**
 * Class LanguageCheckerMenu
 *
 * @package language\widgets\languageChecker
 */
class LanguageCheckerMenu extends Menu
{
	public function init()
	{
		$items = array();
		foreach (Lang::getLanguagesVisible() as $key => $lang) {
			$items[] = array('label' => $lang, 'url' => $this->prepareUrl($key), 'active' => ($key === Lang::get()), );
		}

		$this->items = $items;
		parent::init();
	}

	/**
	 * @return null|void
	 */
	public function run()
	{
		if (count($this->items) < 2) {
			return null;
		}
		parent::run();
	}


	/**
	 * @param $lang
	 *
	 * @return string
	 */
	public function prepareUrl($lang)
	{
		/** @var FrontController $controller */
		$controller = app()->getController();
		$get = $_GET;
		$get = array_merge($get, array(app()->urlManager->languageVar => $lang));
		$url = $controller->createUrl('', $get);
		return $url;
	}
}
