<?php
/**
 *
 */

namespace school\models;

use backstage\components\ActiveRecord;
use backstage\components\DependentDropDownFormInputElement;
use backstage\components\ImageFormInputElement;

/**
 * This is the model class for table "{{school}}".
 *
 * The followings are the available columns in table '{{school}}':
 * @property integer $id
 * @property string $label
 * @property string $address
 * @property string $eaddress
 * @property string $director
 * @property integer $village_id
 * @property integer $image_id1
 * @property integer $image_id2
 * @property integer $visible
 * @property integer $published
 * @property integer $position
 *
 * The followings are the available model relations:
 * @property Village $village
 */
class School extends ActiveRecord
{
	public $regionId;
	public $areaId;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return School the static model class
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
		return '{{school}}';
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'village' => array(self::BELONGS_TO, Village::getClassName(), 'village_id'),
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
			array('village_id, label, director, address, eaddress', 'required'),
			array('village_id, visible, published, regionId, areaId', 'numerical', 'integerOnly' => true),
			array('label, director', 'length', 'max' => 150),
			array('address, eaddress', 'safe'),
			array('village_id', 'exist', 'className' => Village::getClassName(), 'attributeName' => 'id', ),
			// The following rule is used by search().
			array('id, label, address, eaddress, director, village_id, visible, published', 'safe', 'on' => 'search', ),
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
				'label' => 'Название',
				'address' => 'Адерс',
				'eaddress' => 'Электронный адрес',
				'director' => 'Директор',
				'village_id' => 'Город',
				'image_id1' => 'Фото',
				'image_id2' => 'Фото',
				'regionId' => 'Область',
				'areaId' => 'Район',
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
		$criteria->compare('t.label', $this->label, true);
		$criteria->compare('t.address', $this->address, true);
		$criteria->compare('t.eaddress', $this->eaddress, true);
		$criteria->compare('t.director', $this->director, true);
		$criteria->compare('t.village_id', $this->village_id);
		$criteria->compare('t.image_id1', $this->image_id1);
		$criteria->compare('t.image_id2', $this->image_id2);
		$criteria->compare('t.visible', $this->visible);
		$criteria->compare('t.published', $this->published);
		$criteria->compare('t.position', $this->position);

		$criteria->with = array(
			'village' => array(
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
		return parent::genAdminBreadcrumbs($page, $title ? $title : 'Школа');
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
					'label',
					'director',
					array(
						'name' => 'village_id',
						'value' => function ($data) {
							/** @var School $data */
							return $data->getValue('village', 'label');
						},
						'filter' => false,
					),
					'image_id1:fpmImage',
					'image_id2:fpmImage',
					array(
						'class' => 'backstage\components\CheckColumn',
						'header' => 'Опубликовано',
						'name' => 'published',
					),
					array(
						'class' => 'bootstrap.widgets.TbButtonColumn',
					),
				);
				break;
			case 'view':
				$columns = array(
					'id',
					'label',
					'address',
					'eaddress',
					'director',
					array(
						'name' => 'village_id',
						'value' => $this->getValue('village', 'label'),
					),
					'image_id1:fpmImage',
					'image_id2:fpmImage',
					'published:boolean',
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
				'label' => array(
					'type' => 'text',
					'class' => 'span6',
				),
				'address' => array(
					'type' => 'textarea',
					'class' => 'span6',
					'rows' => 5,
				),
				'eaddress' => array(
					'type' => 'textarea',
					'class' => 'span6',
					'rows' => 5,
				),
				'director' => array(
					'type' => 'text',
					'class' => 'span6',
				),
				'regionId' => array(
					'type' => DependentDropDownFormInputElement::getClassName(),
					'data' => \CHtml::listData(Region::getItems(false, false, array('id', 'label', )), 'id', 'label'),
					'dependentModel' => Area::getClassName(),
					'nextAttribute' => 'areaId',
					'htmlOptions' => array(
						'class' => 'span3',
						'empty' => '',
					),
				),
				'areaId' => array(
					'type' => DependentDropDownFormInputElement::getClassName(),
					'data' => array(),
					'dependentModel' => Village::getClassName(),
					'nextAttribute' => 'village_id',
					'htmlOptions' => array(
						'class' => 'span3',
						'empty' => '',
					),
				),
				'village_id' => array(
					'type' => 'dropdownlist',
					'items' => $this->village ? array($this->village->id => $this->village->label) : array(),
					'class' => 'span3',
					'empty' => '',
				),
				'image_id1' => array(
					'type' => ImageFormInputElement::getClassName(),
				),
				'image_id2' => array(
					'type' => ImageFormInputElement::getClassName(),
				),
				'published' => array(
					'type' => 'checkbox',
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
					'b_image_id1' => array(
						'class' => '\fileProcessor\components\FileUploadBehavior',
						'attributeName' => 'image_id1',
						'allowEmpty' => true,
						'fileTypes' => 'png, gif, jpeg, jpg',
					),
					'b_image_id2' => array(
						'class' => '\fileProcessor\components\FileUploadBehavior',
						'attributeName' => 'image_id2',
						'allowEmpty' => true,
						'fileTypes' => 'png, gif, jpeg, jpg',
					),
					'seo' => array(
						'class' => '\seo\components\SeoModelBehavior',
					),
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
