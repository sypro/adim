<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace front\components;

\Yii::import('zii.widgets.CBreadcrumbs');

/**
 * Class Breadcrumbs
 * @package front\components
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
