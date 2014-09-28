<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace core\components;

/**
 * Class ApplicationComponent
 * @package core\components
 */
class ApplicationComponent extends \CApplicationComponent
{
	/**
	 * Return full class name
	 *
	 * @return string
	 */
	public static function getClassName()
	{
		return get_called_class();
	}
}
