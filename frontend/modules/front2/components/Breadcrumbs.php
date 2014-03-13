<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace front2\components;

\Yii::import('zii.widgets.CBreadcrumbs');

/**
 * Class Breadcrumbs
 * @package front2\components
 */
class Breadcrumbs extends \CBreadcrumbs
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
