<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace back\components;

use fileProcessor\helpers\FPM;
use \core\components\Formatter as CoreFormatter;
/**
 * Class Formatter
 * @package back\components
 */
class Formatter extends CoreFormatter
{
	/**
	 * @var array the text to be displayed when formatting a boolean value. The first element corresponds
	 * to the text display for false, the second element for true. Defaults to <code>array('No', 'Yes')</code>.
	 */
	public $booleanFormat = array('Нет', 'Да');

	/**
	 * Formats the value as an image tag using FPM module.
	 * @param mixed $value the value to be formatted
	 * @return string the formatted result
	 */
	public function formatFpmImage($value)
	{
		return FPM::image($value, 'admin', 'view');
	}

	/**
	 * Formats the value as an link tag using FPM module.
	 * @param mixed $value the value to be formatted
	 * @return string the formatted result
	 */
	public function formatFpmLink($value)
	{
		return \CHtml::link(FPM::originalSrc($value), FPM::originalSrc($value));
	}
}
