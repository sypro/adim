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
	public static function getClassName()
	{
		return get_called_class();
	}
}
