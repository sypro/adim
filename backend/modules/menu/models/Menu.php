<?php
/**
 *
 */

namespace menu\models;

use backstage\components\ActiveRecord;
use language\helpers\Lang;

/**
 * This is the model class for table "{{menu}}".
 *
 * The followings are the available columns in table '{{menu}}':
 * @property integer $id
 * @property integer $menu_id
 * @property string $label
 * @property integer $parent_id
 * @property integer $type_id
 * @property integer $related_id
 * @property string $link
 * @property integer $visible
 * @property integer $published
 * @property integer $position
 *
 * The followings are the available model relations:
 * @property MenuList $menu
 * @property Menu $parent
 * @property Menu[] $menus
 * @property MenuType $type
 */
class Menu extends ActiveRecord
{
	/**
	 * Pre set link type
	 */
	const TYPE_LINK = 1;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Menu the static model class
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
		return '{{menu}}';
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'menu' => array(self::BELONGS_TO, MenuList::getClassName(), 'menu_id'),
			'parent' => array(self::BELONGS_TO, Menu::getClassName(), 'parent_id'),
			'menus' => array(self::HAS_MANY, Menu::getClassName(), 'parent_id'),
			'type' => array(self::BELONGS_TO, MenuType::getClassName(), 'type_id'),
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
			array('label, menu_id, type_id', 'required'),
			array('menu_id, parent_id, type_id, related_id, visible, published, position', 'numerical', 'integerOnly'=>true),
			array('label', 'length', 'max'=>200),
			array('link', 'length', 'max'=>250),
			array('type', 'checkType'),
			array('link', 'url'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, menu_id, label, parent_id, type_id, related_id, link, visible, published, position', 'safe', 'on'=>'search', ),
		);
	}

	/**
	 * Check type. if it is a link type, then add required validator to link fields
	 *
	 * @param $attribute
	 * @param $params
	 */
	public function checkType($attribute, $params)
	{
		if ($this->type_id == self::TYPE_LINK) {
			$validator = \CValidator::createValidator('required', $this, 'link');
			$this->validatorList->add($validator);
			foreach (Lang::getLanguageKeys() as $language) {
				if ($language == Lang::getDefault()) {
					continue;
				}
				$validator = \CValidator::createValidator('required', $this, 'link_' . $language);
				$this->validatorList->add($validator);
			}
		}
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		$labels = \CMap::mergeArray(
			parent::attributeLabels(),
			array(
				'menu_id' => 'Меню',
				'parent_id' => 'Родитель',
				'type_id' => 'Тип',
				'link' => 'Ссылка',
				'related_id' => 'Связанный объект',
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
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria = new \CDbCriteria();

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.menu_id', $this->menu_id);
		$criteria->compare('t.label', $this->label, true);
		$criteria->compare('t.parent_id', $this->parent_id);
		$criteria->compare('t.type_id', $this->type_id);
		$criteria->compare('t.related_id', $this->related_id);
		$criteria->compare('t.link', $this->link, true);
		$criteria->compare('t.visible', $this->visible);
		$criteria->compare('t.published', $this->published);
		$criteria->compare('t.position', $this->position);

		$criteria->with = array(
			'menu' => array(
				'select' => array('id', 'label', ),
			),
			'parent' => array(
				'select' => array('id', 'label', ),
			),
			'type' => array(
				'select' => array('id', 'label', ),
			),
		);

		return new \CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => array(
				'pageSize' => $pageSize ? $pageSize : 50,
			),
			'sort' => array(
				'defaultOrder' => array(
					'position' => \CSort::SORT_DESC,
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
		return parent::genAdminBreadcrumbs($page, $title ? $title : 'Пункты меню');
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
						'name' => 'menu_id',
						'value' => function ($data) {
							/** @var $data Menu */
							return $data->getValue('menu', 'label');
						},
						'filter' => \CHtml::listData(MenuList::getItems(true, true, array('id', 'label', )), 'id', 'label'),
					),
					'label',
					array(
						'name' => 'parent_id',
						'value' => function ($data) {
							/** @var $data Menu */
							return $data->getValue('parent', 'label');
						},
						'filter' => \CHtml::listData(Menu::getItems(true, true, array('id', 'label', )), 'id', 'label'),
					),
					array(
						'name' => 'type_id',
						'value' => function ($data) {
							/** @var $data Menu */
							return $data->getValue('type', 'label');
						},
						'filter' => \CHtml::listData(MenuType::getItems(true, true, array('id', 'label', )), 'id', 'label'),
					),
					array(
						'class' => 'backstage\components\CheckColumn',
						'header' => 'Опубликовано',
						'name' => 'published',
					),
					array(
						'name' => 'position',
						'htmlOptions' => array('class' => 'span1 center', ),
					),
					array(
						'class' => 'bootstrap.widgets.TbButtonColumn',
					),
				);
				break;
			case 'view':
				$columns = array(
					'id',
					array(
						'name' => 'menu_id',
						'value' => $this->getValue('menu', 'label'),
					),
					'label',
					array(
						'name' => 'parent_id',
						'value' => $this->getValue('parent', 'label'),
					),
					array(
						'name' => 'type_id',
						'value' => $this->getValue('type', 'label'),
					),
					'related_id',
					'link',
					array(
						'name' => 'published',
						'value' => self::getBooleanText($this->published),
					),
					'position',
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
				'menu_id' => array(
					'type' => 'dropdownlist',
					'items' => \CHtml::listData(MenuList::getItems(true, true, array('id', 'label', )), 'id', 'label'),
					'class' => 'span3',
					'empty' => '',
				),
				'label' => array(
					'type' => 'text',
					'class' => 'span6',
				),
				'parent_id' => array(
					'type' => 'dropdownlist',
					'items' => \CHtml::listData(Menu::getItems(true, true, array('id', 'label', ), array(), 'id <> :id', array(':id' => $this->id ? $this->id : 0, )), 'id', 'label'),
					'class' => 'span3',
					'empty' => '',
				),
				'type_id' => array(
					'type' => 'dropdownlist',
					'items' => \CHtml::listData(MenuType::getItems(false, false, array('id', 'label', )), 'id', 'label'),
					'class' => 'span3',
					'empty' => '',
				),
				'related_id' => array(
					'type' => 'text',
					'class' => 'span3',
				),
				'link' => array(
					'type' => 'text',
					'class' => 'span6',
				),
				'published' => array(
					'type' => 'checkbox',
				),
				'position' => array(
					'type' => 'text',
					'class' => 'span2',
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
					'multiLang' => array(
						'class' => '\language\components\MultilingualBehavior',
						'localizedAttributes' => self::getLocalizedAttributesList(),
						'languages' => \language\helpers\Lang::getLanguageKeys(),
						'defaultLanguage' => \language\helpers\Lang::getDefault(),
						'forceOverwrite' => true,
					),
				)
			)
		);
	}

	/**
	 * Get list of localized attributes
	 *
	 * @return array
	 */
	public static function getLocalizedAttributesList()
	{
		return array('label', 'link');
	}
}
