<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace core\components;

\Yii::import('zii.widgets.CMenu');

/**
 * Class Menu
 * @package core\components
 */
class Menu extends \CMenu
{
	/**
	 * Get full class name
	 *
	 * @return string
	 */
	public static function getClassName()
	{
		return get_called_class();
	}
}
