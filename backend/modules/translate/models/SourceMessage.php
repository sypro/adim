<?php
/**
 *
 */

namespace translate\models;

use back\components\ActiveRecord;
use CEvent;

/**
 * This is the model class for table "{{source_message}}".
 *
 * The followings are the available columns in table '{{source_message}}':
 * @property integer $id
 * @property string $category
 * @property string $message
 *
 * The followings are the available model relations:
 * @property Message[] $messages
 */
class SourceMessage extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SourceMessage the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{source_message}}';
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'messages' => array(self::HAS_MANY, Message::getClassName(), 'id'),
		);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category, message', 'required'),
			array('category', 'length', 'max'=>32),
			array('message', 'safe'),
			array('message', 'filter', 'filter' => 'trim', ),
			// The following rule is used by search().
			array('id, category, message', 'safe', 'on'=>'search', ),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return \CMap::mergeArray(
			parent::attributeLabels(),
			array(
				'category' => 'Категория',
				'message' => 'Сообщение',
			)
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * @param bool $pageSize
	 *
	 * @return \CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search($pageSize = false)
	{
		$criteria = new \CDbCriteria();

		$criteria->compare('id', $this->id);
		$criteria->compare('category', $this->category, true);
		$criteria->compare('message', $this->message, true);

		return new \CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => array(
				'pageSize' => $pageSize ? $pageSize : 50,
			),
			'sort' => array(
				'defaultOrder' => array(
					'position' => \CSort::SORT_DESC,
					'id' => \CSort::SORT_DESC,
				),
			),
		));
	}

	/**
	 * Generate breadcrumbs
	 *
	 * @param string $page
	 * @param null|string $title
	 *
	 * @return array
	 */
	public function genAdminBreadcrumbs($page, $title = null)
	{
		return parent::genAdminBreadcrumbs($page, $title ? $title : 'Оригиналы');
	}

	/**
	 * Get columns configs to specified page for grid or detail view
	 *
	 * @param $page
	 *
	 * @return array
	 */
	public function genColumns($page)
	{
		$columns = array();
		switch ($page) {
			case 'index':
				$columns = array(
					array(
						'name' => 'id',
						'htmlOptions' => array('class' => 'span1 center', ),
					),
					array(
						'name' => 'category',
						'htmlOptions' => array('class' => 'span2 center', ),
					),
					'message',
					array(
						'class' => 'bootstrap.widgets.TbButtonColumn',
					),
				);
				break;
			case 'view':
				$columns = array(
					'id',
					'category',
					'message',
				);
				break;
			default:
				break;
		}
		return $columns;
	}
	/**
	 * Get form config
	 *
	 * @return array
	 */
	public function getFormConfig()
	{
		return array(
			'showErrorSummary' => true,
			'attributes' => array(
				'enctype' => 'multipart/form-data',
			),
			'elements' => array(
				'category' => array(
					'type' => 'text',
					'class' => 'span6',
					'hint' => 'лучше не менять - удобнее использовать в коде',
				),
				'message' => array(
					'type' => 'text',
					'class' => 'span6',
				),
			),

			'buttons' => array(
				'submit' => array(
					'type' => 'submit',
					'layoutType' => 'primary',
					'label' => $this->isNewRecord ? 'Создать' : 'Сохранить',
				),
				'reset' => array(
					'type' => 'reset',
					'label' => 'Сбросить',
				),
			),
		);
	}

	/**
	 * Query default order
	 *
	 * @return $this
	 */
	public function ordered()
	{
		return $this->order('t.id DESC');
	}

	/**
	 * After find
	 */
	protected function afterConstruct()
	{
		parent::afterConstruct();
		if (!$this->category) {
			$this->category = 'core';
		}
		return true;
	}
}
