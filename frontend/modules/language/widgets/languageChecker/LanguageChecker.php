<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace language\widgets\languageChecker;

use front\components\FrontController;
use front\components\Widget;
use language\helpers\Lang;

/**
 * Class Language
 *
 * @package language\widgets\language
 */
class LanguageChecker extends Widget
{
	public function run()
	{
		$this->render('default');
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
