<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace back\helpers;

/**
 * Class GiiHelper
 * @package back\helpers
 */
class GiiHelper
{
	public static function getDefaultLabels()
	{
		return array(
			'id' => 'ID',
			'image_id' => 'Изображение',
			'published' => 'Опубликовано',
			'position' => 'Позиция',
			'alias' => 'Ссылка',
			'posted' => 'Дата публикации',
			'label' => 'Заголовок',
			'content' => 'Текст',
			'intro' => 'Интро',
			'visible' => 'Видимость',
			'created' => 'Создано',
			'modified' => 'Изменено',
		);
	}

	public static function getDescribedFields()
	{
		return array(
			'created',
			'modified',
		);
	}

	public static function getNotSearchFields()
	{
		return array(
			'created',
			'modified',
			'image_id',
			'file_id',
			'video_id',
		);
	}

	public static function getNotRulesFields()
	{
		return array(
			'created',
			'modified',
			'image_id',
			'file_id',
		);
	}

	public static function getDoNotShowFields($page)
	{
		$return = array();
		switch($page)
		{
			case 'index':
				$return = array(
					'content',
					'created',
					'modified',
				);
				break;
			case 'view':
				$return = array(
					'created',
					'modified',
				);
				break;
			default: break;
		}
		return $return;
	}

	public static function getDoNotEditFields()
	{
		return array(
			'created',
			'modified',
		);
	}

	public static function getAdminPageTypes()
	{
		return array(
			'index',
			'view',
		);
	}

	/**
	 * Generate form config row
	 *
	 * @param \CDbColumnSchema $column
	 *
	 * @return null|string
	 */
	public static function generateFormRow($column)
	{
		/**
		'content' => array(
		'type' => 'bootstrap.widgets.TbCKEditor',
		'editorOptions' => array(
		'width' => 800,
		'language' => 'ru',
		),
		),
		'posted' => array(
		'type' => 'ext.date-time-picker.CJuiDateTimePicker',
		'mode'=>'datetime',
		'options'=>array(
		'dateFormat'=>'yy-mm-dd',
		'showSecond'=>true,
		'timeFormat'=>'HH:mm:ss',
		),
		),
		 */
		//return print_r($column, true);
		$row = null;
		$doNotEdit = GiiHelper::getDoNotEditFields();
		if(in_array($column->name, $doNotEdit, true) || $column->autoIncrement || $column->isPrimaryKey)
		{
			return $row;
		}
		$name = $column->name;
		switch($column)
		{
			case ($column->type === 'boolean'):
				$row = "'{$name}' => array(
					'type' => 'checkbox',
				),";
				break;
			case ($name === 'position'):
				$row = "'position' => array(
					'type' => 'text',
					'class' => 'span2',
				),";
				break;
			case ($name === 'published'):
				$row = "'published' => array(
					'type' => 'checkbox',
				),";
				break;
			case ($name === 'visible'):
				$row = "'visible' => array(
					'type' => 'checkbox',
				),";
				break;
			case ($column->type === 'integer'):
				if ($column->name == 'image_id') {
					$row = "'image_id' => array(
					'type' => '\\back\\components\\FileFormInputElement',
					'content' => 'image',
				),";
				} else {
					$row = "'{$name}' => array(
					'type' => 'text',
					'class' => 'span3',
				),";
				}
				break;
			case ($column->type === 'string' && $column->dbType === 'date'):
				$row = "'{$name}' => array(
					'type' => '\\yiiDateTimePicker\\CJuiDateTimePicker',
					'mode' => 'date',
					'options' => array(
						'dateFormat' => 'yy-mm-dd',
					),
				),";
				break;
			case ($column->type === 'string' && $column->dbType === 'time'):
				$row = "'{$name}' => array(
					'type' => '\\yiiDateTimePicker\\CJuiDateTimePicker',
					'mode' => 'time',
					'options' => array(
						'showSecond' => true,
						'timeFormat' => 'HH:mm:ss',
					),
				),";
				break;
			case ($column->type === 'string' && $column->dbType === 'datetime'):
				$row = "'{$name}' => array(
					'type' => '\\yiiDateTimePicker\\CJuiDateTimePicker',
					'mode' => 'datetime',
					'options' => array(
						'dateFormat' => 'yy-mm-dd',
						'showSecond' => true,
						'timeFormat' => 'HH:mm:ss',
					),
				),";
				break;
			case ($column->dbType === 'text'):
				$row = "'{$name}' => array(
					'type' => 'textarea',
					'class' => 'span6',
					'rows' => 5,
				),";
				break;
			default:
				$row = "'{$name}' => array(
					'type' => 'text',
					'class' => 'span6',
				),";
				break;
		}
		return $row;
	}
}
