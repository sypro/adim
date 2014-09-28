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
	 * Get existing locales in framework
	 *
	 * @return array
	 */
	public static function getLocales()
	{
		$locales = array();
		$path = app()->getLocaleDataPath();
		/** @var \DirectoryIterator[] $iterator */
		$iterator = new \DirectoryIterator($path);
		foreach ($iterator as $file) {
			if ($file->isFile() && $file->getExtension() === 'php') {
				$key = pathinfo($file->getRealPath(), PATHINFO_FILENAME);
				$locales[$key] = $key;
			}
		}

		return $locales;
	}
}
