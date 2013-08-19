<?php
/**
 *
 */

namespace school\models;

use backstage\components\ActiveRecord;

/**
 * This is the model class for table "{{region}}".
 *
 * The followings are the available columns in table '{{region}}':
 * @property integer $id
 * @property integer $country_id
 * @property string $label
 *
 * The followings are the available model relations:
 * @property Area[] $areas
 * @property Country $country
 */
class Region extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Region the static model class
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
		return '{{region}}';
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'areas' => array(self::HAS_MANY, Area::getClassName(), 'region_id'),
			'country' => array(self::BELONGS_TO, Country::getClassName(), 'country_id'),
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
			array('country_id', 'required'),
			array('country_id', 'numerical', 'integerOnly' => true),
			array('label', 'length', 'max' => 60),
			array('country_id', 'exist', 'className' => Country::getClassName(), 'attributeName' => 'id', ),
			// The following rule is used by search().
			array('id, country_id, label', 'safe', 'on' => 'search', ),
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
				'country_id' => 'Страна',
				'label' => 'Область',
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
		$criteria->compare('t.country_id', $this->country_id);
		$criteria->compare('t.label', $this->label, true);

		$criteria->with = array(
			'country' => array(
				'select' => array(
					'id', 'label',
				),
			),
		);

		return new \CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => array(
				'pageSize' => $pageSize ? $pageSize : 50,
			),
			'sort' => array(
				'defaultOrder' => array(
					'label' => \CSort::SORT_ASC,
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
		return parent::genAdminBreadcrumbs($page, $title ? $title : 'Область');
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
						'name' => 'country_id',
						'value' => function ($data) {
							/** @var Region $data */
							return $data->getValue('country', 'label');
						},
						'filter' => \CHtml::listData(Country::getItems(true, true, array('id', 'label', )), 'id', 'label'),
						'htmlOptions' => array('class' => 'span3 center', ),
					),
					'label',
					array(
						'class' => 'bootstrap.widgets.TbButtonColumn',
					),
				);
				break;
			case 'view':
				$columns = array(
					'id',
					array(
						'name' => 'country_id',
						'value' => $this->getValue('country', 'label'),
					),
					'label',
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
				'country_id' => array(
					'type' => 'dropdownlist',
					'items' => \CHtml::listData(Country::getItems(true, true, array('id', 'label', )), 'id', 'label'),
					'class' => 'span3',
					'empty' => '',
				),
				'label' => array(
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
	 * Returns a list of behaviors that this model should behave as.
	 *
	 * @return array the behavior configurations (behavior name=>behavior configuration)
	 */
	public function behaviors()
	{
		/*
		 * Warning: every behavior need contains fields:
		 * 'configLanguageAttribute' required
		 * 'configBehaviorAttribute' required
		 * 'configBehaviorKey' optional (default: b_originKey_lang, where originKey is key of the row in array
		 * lang will be added in tail
		 */
		$languageBehaviors = array();
		$behaviors = $this->prepareBehaviors($languageBehaviors);
		return \CMap::mergeArray(
			parent::behaviors(),
			\CMap::mergeArray(
				$behaviors,
				array(
				)
			)
		);
	}

	/**
	 * Query default order
	 *
	 * @return $this
	 */
	public function ordered()
	{
		return $this->order('t.label ASC');
	}
}
