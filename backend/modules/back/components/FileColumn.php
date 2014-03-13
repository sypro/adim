<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace back\components;

use fileProcessor\helpers\FPM;

/**
 * Class FileColumn
 *
 * @package back\components
 */
class FileColumn extends DataColumn
{
	public $filter = false;
	public $type = 'html';
	public $htmlOptions = array('class' => 'span2 center', );

	/**
	 * @param int $row
	 * @param mixed $data
	 */
	protected function renderDataCellContent($row, $data)
	{
		$id = FPM::originalSrc($data->{$this->name});
		echo \CHtml::link($id, $id);
	}
}
