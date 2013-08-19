<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace core\components;

/**
 * Class Validator
 * @package core\components
 */
abstract class Validator extends \CValidator
{
	public static function getClassName()
	{
		return get_called_class();
	}
}
