<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace backstage\components;

\Yii::import('zii.widgets.grid.CDataColumn');

/**
 * Class DataColumn
 * @package backstage\components
 */
class DataColumn extends \CDataColumn
{
	public static function getClassName()
	{
		return get_called_class();
	}
}
