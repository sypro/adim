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
	 * @param string $column
	 * @param string $index
	 *
	 * @return array
	 */
	public static function getLanguages($column = 'label', $index = 'code')
	{
		if (self::$models === null) {
			$models = Language::model()->published()->ordered()->findAll();
			$array = array();
			foreach ($models as $model) {
				$code = \CHtml::value($model, 'code');
				$label = \CHtml::value($model, 'label');
				$locale = \CHtml::value($model, 'locale');
				$array[] = array(
					'code' => $code,
					'label' => $label,
					'locale' => $locale,
				);
			}
			self::$models = $array;
		}
		return arrayColumn(self::$models, $column, $index);
	}

	/**
	 * @param string $column
	 * @param string $index
	 *
	 * @return array
	 */
	public static function getLanguagesVisible($column = 'label', $index = 'code')
	{
		$models = Language::model()->published()->visible()->ordered()->findAll();
		$array = array();
		foreach ($models as $model) {
			$code = \CHtml::value($model, 'code');
			$label = \CHtml::value($model, 'label');
			$locale = \CHtml::value($model, 'locale');
			$array[] = array(
				'code' => $code,
				'label' => $label,
				'locale' => $locale,
			);
		}
		return arrayColumn($array, $column, $index);
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

	/**
	 * @param $requestLang
	 *
	 * @return string
	 */
	public static function getLocale($requestLang)
	{
		$languages = self::getLanguages('locale', 'code');
		if (array_key_exists($requestLang, $languages)) {
			return $languages[$requestLang];
		}
		return 'en';
	}

	/**
	 * @return string
	 */
	public static function getCurrentLanguage()
	{
		$appLang = \Yii::app()->getLanguage();
		$languages = self::getLanguages('code', 'locale');
		if (array_key_exists($appLang, $languages)) {
			return $languages[$appLang];
		}
		return 'en';
	}
}
