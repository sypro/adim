<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace core\components;

/**
 * Class FormModel
 * @package core\components
 */
class FormModel extends \CFormModel
{
	/**
	 * Get class name
	 *
	 * @return string
	 */
	public static function getClassName()
	{
		return get_called_class();
	}
}
