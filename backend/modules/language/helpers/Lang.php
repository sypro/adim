<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace language\helpers;

use language\models\Language;

/**
 * Class Lang
 *
 * @package language\helpers
 */
class Lang
{
	/**
	 * Language models
	 *
	 * @var
	 */
	private static $models;

	/**
	 * @static
	 *
	 * @return array
	 */
	public static function getLanguages()
	{
		if (self::$models === null) {
			$models = Language::model()->published()->ordered()->findAll();
			self::$models = \CHtml::listData($models, 'code', 'label');
		}
		return self::$models;
	}

	/**
	 * @return array
	 */
	public static function getLanguageKeys()
	{
		return array_keys(self::getLanguages());
	}

	/**
	 * @static
	 * @return string
	 */
	public static function get()
	{
		$getLang = r()->getQuery(app()->urlManager->languageVar);
		$lang = self::checkLang($getLang) ? $getLang : self::getDefault();
		return $lang;
	}

	/**
	 * @static
	 * @return string
	 */
	public static function getDefault()
	{
		return app()->urlManager->defaultLanguage;
	}

	/**
	 * @param $lang
	 *
	 * @return bool
	 */
	public static function checkLang($lang)
	{
		if (in_array($lang, self::getLanguageKeys(), true)) {
			return true;
		}
		return false;
	}
}
