<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace frontend\components;

\Yii::import('zii.widgets.CBreadcrumbs');

/**
 * Class Breadcrumbs
 * @package frontend\components
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
