<?php
/**
 *
 */

namespace configuration\models;

use back\components\ActiveRecord;
use back\components\FileFormInputElement;
use CEvent;
use CModelEvent;
use core\components\Validator;
use language\helpers\Lang;

/**
 * This is the model class for table "{{configuration}}".
 *
 * The followings are the available columns in table '{{configuration}}':
 * @property integer $id
 * @property string $config_key
 * @property string $value
 * @property string $description
 * @property integer $type
 * @property integer $preload
 */
class Configuration extends ActiveRecord
{
	/**
	 * integer
	 */
	const TYPE_INTEGER = 1;

	/**
	 * string
	 */
	const TYPE_STRING = 2;

	/**
	 * text
	 */
	const TYPE_TEXT = 3;

	/**
	 * html
	 */
	const TYPE_HTML = 4;

	/**
	 * file
	 */
	const TYPE_FILE = 5;

	/**
	 * array
	 */
	const TYPE_ARRAY = 6;

	/**
	 * boolean
	 */
	const TYPE_BOOLEAN = 7;

	/**
	 * float
	 */
	const TYPE_FLOAT = 8;

	/**
	 * image
	 */
	const TYPE_IMAGE = 9;

	/**
	 * Values for image save
	 *
	 * @var array
	 */
	protected $_values = array();

	/**
	 * @return array
	 */
	public static function getTypes()
	{
		return array(
			self::TYPE_INTEGER => 'Целое число',
			self::TYPE_FLOAT => 'Вещественное число',
			self::TYPE_STRING => 'Строка',
			self::TYPE_TEXT => 'Текст',
			self::TYPE_HTML => 'HTML',
			self::TYPE_FILE => 'Файл',
			self::TYPE_IMAGE => 'Изображение',
			//self::TYPE_ARRAY => 'Массив',
			self::TYPE_BOOLEAN => 'Логический',
		);
	}

	/**
	 * @return null
	 */
	public function getTypeText()
	{
		$array = self::getTypes();
		return isset($array[$this->type]) ? $array[$this->type] : null;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Configuration the static model class
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
		return '{{configuration}}';
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
			// all except file upload
			array('value', 'required', 'except' => array('file', 'image', ), ),
			// integer
			array('value', 'numerical', 'integerOnly'=>true, 'on' => 'integer', ),
			// float
			array('value', 'numerical', 'on' => 'float', ),
			// safe
			array('value', 'safe', 'on' => 'safe', ),

			array('config_key, type', 'required'),
			array('config_key', 'unique'),
			array('type, preload', 'numerical', 'integerOnly'=>true),
			array('config_key', 'length', 'max'=>100),
			array('description', 'length', 'max'=>250),

			array('config_key, value, description, type', 'safe', 'on'=>'search', ),
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
				'config_key' => 'Ключ',
				'value' => 'Значение',
				'description' => 'Описание',
				'type' => 'Тип',
				'preload' => 'Прелоад',
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

		$criteria->compare('t.config_key', $this->config_key, true);
		$criteria->compare('t.value', $this->value, true);
		$criteria->compare('t.description', $this->description, true);
		$criteria->compare('t.type', $this->type);
		$criteria->compare('t.preload', $this->preload);

		return new \CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => array(
				'pageSize' => $pageSize ? $pageSize : 50,
			),
			'sort' => array(
				'defaultOrder' => array(
					'config_key' => \CSort::SORT_DESC,
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
		return parent::genAdminBreadcrumbs($page, $title ? $title : 'Конфигурация');
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
						'name' => 'config_key',
						'htmlOptions' => array('class' => 'span2 center', ),
					),
					array(
						'name' => 'type',
						'filter' => self::getTypes(),
						'value' => function ($data) {
							/** @var Configuration $data */
							return $data->getTypeText();
						},
						'htmlOptions' => array('class' => 'span2 center', ),
					),
					'description',
					array(
						'class' => 'back\components\CheckColumn',
						'header' => 'Прелоад',
						'name' => 'preload',
					),
					array(
						'class' => 'bootstrap.widgets.TbButtonColumn',
					),
				);
				break;
			case 'view':
				$columns = array(
					'config_key',
					$this->getValueView(),
					'description',
					array(
						'name' => 'type',
						'value' => $this->getTypeText(),
					),
					'preload:boolean',
				);
				break;
			default:
				break;
		}
		return $columns;
	}

	/**
	 * Get view value config
	 *
	 * @return null|string
	 */
	public function getValueView()
	{
		$view = null;
		switch ($this->type) {
			case self::TYPE_TEXT:
			case self::TYPE_STRING:
			case self::TYPE_INTEGER:
			case self::TYPE_FLOAT:
				$view = 'value';
				break;
			case self::TYPE_BOOLEAN:
				$view = 'value:boolean';
				break;
			case self::TYPE_FILE:
				$view = 'value:fpmLink';
				break;
			case self::TYPE_IMAGE:
				$view = 'value:fpmImage';
				break;
			case self::TYPE_HTML:
				$view = 'value:raw';
				break;
			default:
				break;
		}
		return $view;
	}

	/**
	 * Generate form field
	 *
	 * @param $form
	 * @param $fieldName
	 * @param array $htmlOptions
	 *
	 * @return null|string
	 */
	public function getValueFieldRow($form, $fieldName, $htmlOptions = array())
	{
		$field = null;
		/** @var $form \TbActiveForm */
		switch ($this->type) {
			case self::TYPE_INTEGER:
			case self::TYPE_FLOAT:
				$field = $form->textFieldRow($this, $fieldName, \CMap::mergeArray(array('class'=>'span2', ), $htmlOptions));
				break;
			case self::TYPE_STRING:
				$field = $form->textFieldRow($this, $fieldName, \CMap::mergeArray(array('class'=>'span6', ), $htmlOptions));
				break;
			case self::TYPE_TEXT:
				$field = $form->textAreaRow($this, $fieldName, \CMap::mergeArray(array('class'=>'span6', 'rows'=>5, ), $htmlOptions));
				break;
			case self::TYPE_BOOLEAN:
				$field = $form->checkBoxRow($this, $fieldName, $htmlOptions);
				break;
			case self::TYPE_FILE:
			case self::TYPE_IMAGE:
				$field = $form->fileFieldRow($this, $fieldName, $htmlOptions);
				break;
			case self::TYPE_HTML:
				$field = $form->ckEditorRow($this, $fieldName, \CMap::mergeArray(array('width' => 800,'language' => 'ru', ), $htmlOptions));
				break;
			default:
				break;
		}
		return $field;
	}

	/**
	 * Generate form field
	 *
	 * @param $form
	 * @param $fieldName
	 * @param array $htmlOptions
	 *
	 * @return null|string
	 */
	public function getValueField($form, $fieldName, $htmlOptions = array())
	{
		$field = null;
		/** @var $form \TbActiveForm */
		switch ($this->type) {
			case self::TYPE_INTEGER:
			case self::TYPE_FLOAT:
				$field = $form->textField($this, $fieldName, \CMap::mergeArray(array('class'=>'span2', ), $htmlOptions));
				break;
			case self::TYPE_STRING:
				$field = $form->textField($this, $fieldName, \CMap::mergeArray(array('class'=>'span6', ), $htmlOptions));
				break;
			case self::TYPE_TEXT:
				$field = $form->textArea($this, $fieldName, \CMap::mergeArray(array('class'=>'span6', 'rows'=>5, ), $htmlOptions));
				break;
			case self::TYPE_BOOLEAN:
				$field = $form->checkBox($this, $fieldName, $htmlOptions);
				break;
			case self::TYPE_FILE:
				$field = app()->controller->widget(FileFormInputElement::getClassName(), array(
					'htmlOptions' => $htmlOptions,
					'model' => $this,
					'attribute' => $fieldName,
				), true);
				break;
			case self::TYPE_IMAGE:
				$field = app()->controller->widget(FileFormInputElement::getClassName(), array(
						'htmlOptions' => $htmlOptions,
						'model' => $this,
						'attribute' => $fieldName,
						'content' => 'image',
					), true);
				break;
			case self::TYPE_HTML:
				if (isset($htmlOptions['options'])) {
					$options = $htmlOptions['options'];
					unset($htmlOptions['options']);
				}
				$field = app()->controller->widget('bootstrap.widgets.TbCKEditor', array(
					'model' => $this,
					'attribute' => $fieldName,
					'editorOptions' => isset($options) ? $options : array('width' => 800,'language' => 'ru', ),
					'htmlOptions' => $htmlOptions
				), true);
				break;
			default:
				break;
		}
		return $field;
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
				'id' => 'configuration-form',
			),
			'elements' => array(
				'config_key' => array(
					'type' => 'text',
					'class' => 'span6',
				),
				'type' => array(
					'type' => 'dropdownlist',
					'items' => self::getTypes(),
					'class' => 'span3',
					'empty' => '',
					'id' => 'configuration-type',
					'data-url' => \CHtml::normalizeUrl(array('/configuration/configuration/subForm')),
				),
				'value' => $this->getValueFormField(),
				'description' => array(
					'type' => 'text',
					'class' => 'span6',
				),
				'preload' => array(
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
	 * Generate form config row
	 *
	 * @return array
	 */
	public function getValueFormField()
	{
		$field = null;
		switch ($this->type) {
			case self::TYPE_FILE:
				$field = array(
					'type' => FileFormInputElement::getClassName(),
				);
				break;
			case self::TYPE_IMAGE:
				$field = array(
					'type' => FileFormInputElement::getClassName(),
					'content' => 'image',
				);
				break;
			case self::TYPE_BOOLEAN:
				$field = array(
					'type' => 'checkbox',
				);
				break;
			case self::TYPE_INTEGER:
			case self::TYPE_FLOAT:
				$field = array(
					'type' => 'text',
					'class' => 'span3',
				);
				break;
			case self::TYPE_TEXT:
				$field = array(
					'type' => 'textarea',
					'class' => 'span6',
					'rows' => 5,
				);
				break;
			case self::TYPE_HTML:
				$field = array(
					'type' => 'bootstrap.widgets.TbCKEditor',
					'editorOptions' => array(
						'width' => 800,
						'language' => 'ru',
					),
				);
				break;
			case self::TYPE_STRING:
				$field = array(
					'type' => 'text',
					'class' => 'span6',
				);
				break;
			default:
				$field = array(
					'type' => 'textarea',
					'class' => 'span6',
					'rows' => 5,
				);
				break;
		}
		return $field;
	}

	/**
	 * Parse email list
	 *
	 * @param $string
	 *
	 * @return array
	 */
	public static function parseEmailsFromString($string)
	{
		$toEmails = array();
		$emails = explode(',', $string);
		foreach ($emails as $email) {
			$timedEmail = trim($email);
			$emValidator = new \CEmailValidator();
			if ($emValidator->validateValue($timedEmail)) {
				$toEmails[] = $timedEmail;
			}
		}
		return $toEmails;
	}

	protected function afterFind()
	{
		parent::afterFind();
		$this->setRules();
	}


	/**
	 * This method is invoked before validation starts.
	 * The default implementation calls {@link onBeforeValidate} to raise an event.
	 * You may override this method to do preliminary checks before validation.
	 * Make sure the parent implementation is invoked so that the event can be raised.
	 * @return boolean whether validation should be executed. Defaults to true.
	 * If false is returned, the validation will stop and the model is considered invalid.
	 */
	protected function beforeValidate()
	{
		if (parent::beforeValidate()) {
			$this->setRules();
			return true;
		}
		return false;
	}

	/**
	 * set up rules
	 */
	protected function setRules()
	{
		switch($this->type)
		{
			case self::TYPE_FILE:
				$this->setScenario('file');
				break;
			case self::TYPE_IMAGE:
				$this->setScenario('image');
				break;
			case self::TYPE_BOOLEAN:
			case self::TYPE_INTEGER:
				$this->setScenario('integer');
				break;
			case self::TYPE_FLOAT:
				$this->setScenario('float');
				break;
			case self::TYPE_TEXT:
			case self::TYPE_HTML:
			case self::TYPE_STRING:
				$this->setScenario('safe');
				break;
			default:
				break;
		}
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
		$languageBehaviors = array(
			'b_file_value' => array(
				'configLanguageAttribute' => 'value',
				'configBehaviorAttribute' => 'attributeName',

				'class' => '\fileProcessor\components\FileUploadBehavior',
				'attributeName' => 'value',
				'allowEmpty' => false,
				'fileTypes' => null,
				'scenarios' => array('file', ),
			),
			'b_image_value' => array(
				'configLanguageAttribute' => 'value',
				'configBehaviorAttribute' => 'attributeName',

				'class' => '\fileProcessor\components\FileUploadBehavior',
				'attributeName' => 'value',
				'allowEmpty' => false,
				'fileTypes' => 'png, gif, jpeg, jpg',
				'scenarios' => array('image', ),
			),
		);
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
		return array('value', );
	}

	/**
	 * Query default order
	 *
	 * @return $this
	 */
	public function ordered()
	{
		return $this->order('t.config_key ASC');
	}
}
