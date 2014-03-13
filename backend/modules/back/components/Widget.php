<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace back\components;

/**
 * Class Widget
 * @package back\components
 */
class Widget extends \CWidget
{
	public static function getClassName()
	{
		return get_called_class();
	}
}
