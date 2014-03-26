<?php
/**
 *
 */

namespace translate\models;

use back\components\ActiveRecord;

/**
 * This is the model class for table "{{message_missing}}".
 *
 * The followings are the available columns in table '{{message_missing}}':
 * @property integer $id
 * @property string $application_id
 * @property string $message
 * @property string $category
 * @property string $language
 */
class MessageMissing extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MessageMissing the static model class
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
		return '{{message_missing}}';
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
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
			array('message, category, language', 'required'),
			array('application_id, category', 'length', 'max' => 32),
			array('language', 'length', 'max' => 5),
			// The following rule is used by search().
			array('id, application_id, message, category, language', 'safe', 'on' => 'search', ),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		$labels = \CMap::mergeArray(
			parent::attributeLabels(),
			array(
				'application_id' => 'Ид приложения',
				'message' => 'Оригинал',
				'category' => 'Категория',
				'language' => 'Язык',
			)
		);
		$labels = $this->generateLocalizedAttributeLabels($labels);
		return $labels;
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

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.application_id', $this->application_id, true);
		$criteria->compare('t.message', $this->message, true);
		$criteria->compare('t.category', $this->category, true);
		$criteria->compare('t.language', $this->language, true);

		return new \CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => array(
				'pageSize' => $pageSize ? $pageSize : 50,
			),
			'sort' => array(
				'defaultOrder' => array(
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
		return parent::genAdminBreadcrumbs($page, $title ? $title : 'Не переведенные фразы');
	}

	/**
	 * Generate menu
	 *
	 * @param string $page
	 *
	 * @return array
	 */
	public function genAdminMenu($page)
	{
		$menu = parent::genAdminMenu($page);
		unset($menu['update'], $menu['create']);
		return $menu;
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
					'application_id',
					'category',
					'language',
					'message',
					array(
						'class' => 'bootstrap.widgets.TbButtonColumn',
						'template' => '{view}{delete}',
					),
				);
				break;
			case 'view':
				$columns = array(
					'id',
					'application_id',
					'message',
					'category',
					'language',
				);
				break;
			default:
				break;
		}
		return $columns;
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
}
