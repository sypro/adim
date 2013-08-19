<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace core\components;

/**
 * Class UrlManager
 *
 * @package core\components
 */
class UrlManager extends \CUrlManager
{
	/**
	 * Excluded routes
	 *
	 * @var array
	 */
	public $exclude = array();

	/**
	 * Language query param
	 *
	 * @var string
	 */
	public $languageVar = 'lang';

	/**
	 * Default language
	 *
	 * @var string
	 */
	public $defaultLanguage = 'ru';
}
