<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace backstage\components;

use fileProcessor\helpers\FPM;

/**
 * Class CheckColumn
 * @package backstage\components
 */
class ImageColumn extends DataColumn
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
		echo FPM::image($data->{$this->name}, 'admin', 'index');
	}
}
