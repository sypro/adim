<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace backstage\components;

/**
 * Class Widget
 * @package backstage\components
 */
class Widget extends \CWidget
{
	public static function getClassName()
	{
		return get_called_class();
	}
}
