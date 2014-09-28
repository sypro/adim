<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace back\components;

/**
 * Class CheckColumn
 * @package back\components
 */
class CheckColumn extends DataColumn
{
	public $filter = null;
	public $type = 'raw';
	public $htmlOptions = array('class' => 'span1 center', );

	public function init()
	{
		parent::init();
		if ($this->name === null || strpos($this->name, '.') !== false) {
			throw new \CException(t('Either "name" must be specified for CheckColumn and contain only attribute name.'));
		}
	}

	protected function renderFilterCellContent()
	{
		if ($this->filter === null) {
			$this->filter = ActiveRecord::getBooleanStatuses();
		}
		if (is_string($this->filter)) {
			echo $this->filter;
		} elseif ($this->filter !== false && $this->grid->filter !== null && $this->name !== null && strpos($this->name, '.') === false) {
			if (is_array($this->filter)) {
				echo \CHtml::activeDropDownList($this->grid->filter, $this->name, $this->filter, array('id' => false, 'prompt' => ''));
			}
		} else {
			parent::renderFilterCellContent();
		}
	}

	/**
	 * @param int $row
	 * @param mixed|\CActiveRecord $data
	 */
	protected function renderDataCellContent($row, $data)
	{
		echo \CHtml::activeCheckBox(
			$data,
			$this->name,
			array(
				'class' => 'do-change-value',
				'id' => 'element-change-' . $this->name . '-' . $data->primaryKey,
				'data-url' => \CHtml::normalizeUrl(
					array('change', 'id' => $data->primaryKey, 'attributeName' => $this->name, )
				),
			)
		);
	}
}
