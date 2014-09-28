<?php
/**
 *
 */

namespace translate\models;

use back\components\ActiveRecord;
use core\components\DoubleUniqueValidator;
use language\helpers\Lang;

/**
 * This is the model class for table "{{message}}".
 *
 * The followings are the available columns in table '{{message}}':
 * @property integer $id
 * @property string $language
 * @property string $translation
 *
 * The followings are the available model relations:
 * @property SourceMessage $source
 */
class Message extends ActiveRecord
{
	/**
	 * Original phrase category
	 *
	 * @var
	 */
	public $category;

	/**
	 * Original phrase message
	 *
	 * @var
	 */
	public $message;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Message the static model class
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
		return '{{message}}';
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'source' => array(self::BELONGS_TO, SourceMessage::getClassName(), 'id',),
		);
	}

	/**
	 * Hack to CRUD array primary models
	 *
	 * @return mixed|null|string
	 */
	public function getAdminPrimaryKey()
	{
		$table=$this->getMetaData()->tableSchema;
		if (is_string($table->primaryKey)) {
			return $this->{$table->primaryKey};
		} elseif (is_array($table->primaryKey)) {
			$values = array();
			foreach ($table->primaryKey as $name) {
				$values[$name] = $this->$name;
			}
			return je($values);
		} else {
			return null;
		}
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
		$menu = array();
		switch ($page)
		{
			case 'index':
				$menu = array(
					array('label'=>null,'url'=>array('create'), 'icon'=>'icon-plus'),
				);
				break;
			case 'create':
				$menu = array(
					array('label'=>null,'url'=>array('index'), 'icon'=>'icon-list'),
				);
				break;
			case 'update':
				$menu = array(
					array('label'=>null,'url'=>array('create'), 'icon'=>'icon-plus'),
					array('label'=>null,'url'=>array('index'), 'icon'=>'icon-list'),
				);
				break;
			case 'view':
				$menu = array(
					array('label'=>null,'url'=>array('create'), 'icon'=>'icon-plus'),
					array('label'=>null,'url'=>array('update','id'=>$this->getAdminPrimaryKey()), 'icon'=>'icon-pencil'),
					array('label'=>null,'url'=>array('delete', 'id'=>$this->getAdminPrimaryKey()),
						'buttonType'=>'ajaxLink',
						'ajaxOptions'=>array(
							'type'=>'POST',
							'data'=>array(
								app()->request->csrfTokenName => app()->request->getCsrfToken()
							),
							'success'=>'js:function(){window.location.href="'.\CHtml::normalizeUrl(array('index')).'"}',
							'error'=>'js:function(response){alert(response.responseText);}',
						),
						'htmlOptions'=>array('confirm'=>\Yii::t('core', 'Are you sure you want to delete this item?')), 'icon'=>'icon-trash'),
					array('label'=>null,'url'=>array('index'), 'icon'=>'icon-list'),
				);
				break;
			default:
				break;
		}
		return $menu;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, language', 'required'),
			array('id', 'numerical', 'integerOnly'=>true),
			array('language', 'length', 'max'=>16),
			array('translation', 'safe'),
			array('id', DoubleUniqueValidator::getClassName(), 'with'=>'language', 'message' => 'Перевод для этой пары язык-фраза уже добавлен', ),
			// The following rule is used by search().
			array('id, language, translation, category, message', 'safe', 'on'=>'search', ),
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
				'language' => 'Язык',
				'translation' => 'Перевод',
				'category' => 'Категория',
				'message' => 'Оригинал',
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

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.language', $this->language, true);
		$criteria->compare('t.translation', $this->translation, true);
		$criteria->compare('source.category', $this->category, true);
		$criteria->compare('source.message', $this->message, true);

		$criteria->with = array('source',);

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
		return parent::genAdminBreadcrumbs($page, $title ? $title : 'Сообщения');
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
						'value' => function ($data) {
							/** @var Message $data */
							return $data->getValue('source', 'category');
						},
						'htmlOptions' => array('class' => 'span2 center', ),
					),
					array(
						'name' => 'message',
						'value' => function ($data) {
							/** @var Message $data */
							return $data->getValue('source', 'message');
						},
					),
					'translation',
					array(
						'name' => 'language',
						'filter' => Lang::getLanguages('label', 'locale'),
						'htmlOptions' => array('class' => 'span2 center', ),
					),
					array(
						'class' => 'bootstrap.widgets.TbButtonColumn',
						'updateButtonUrl' => function ($data) {
							/** @var Message $data */
							return \CHtml::normalizeUrl(array('update', 'id' => $data->getAdminPrimaryKey()));
						},
						'viewButtonUrl' => function ($data) {
							/** @var Message $data */
							return \CHtml::normalizeUrl(array('view', 'id' => $data->getAdminPrimaryKey()));
						},
						'deleteButtonUrl' => function ($data) {
							/** @var Message $data */
							return \CHtml::normalizeUrl(array('delete', 'id' => $data->getAdminPrimaryKey()));
						},
					),
				);
				break;
			case 'view':
				$columns = array(
					'id',
					'language',
					array(
						'label' => 'Категория',
						'value' => $this->getValue('source', 'category'),
					),
					array(
						'label' => 'Оригинал',
						'value' => $this->getValue('source', 'message'),
					),
					'translation',
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
		$editor = r()->getQuery('editor') !== null ? true : false;
		$isUpdate = $this->getScenario() == 'update' ? true : false;
		return array(
			'showErrorSummary' => true,
			'attributes' => array(
				'enctype' => 'multipart/form-data',
			),
			'elements' => array(
				'id' => array(
					'type' => 'bootstrap.widgets.TbSelect2',
					'data' => \CHtml::listData(SourceMessage::getItems(true, true, array('id', 'message', )), 'id', 'message'),
					'options' => array(
						'placeholder' => 'Фраза для перевода',
						'width' => '600px',
						'maximumSelectionSize' => 1,
					),
					'htmlOptions' => array(
						'empty' => '',
						'autocomplete' => 'off',
						'id' => 'language_id_select',
						'class' => 'language_selects',
						'disabled' => $isUpdate,
					),
				),
				'language' => array(
					'type' => 'dropdownlist',
					'class' => 'span3 language_selects',
					'items' => Lang::getLanguages('label', 'locale'),
					'empty' => '',
					'disabled' => $isUpdate,
					'id' => 'language_code_select',
				),
				'translation' =>
					$editor ?
					$this->getRedactorFormElement(array()) : array(
						'type' => 'textarea',
						'class' => 'span6',
						'rows' => 4,
						'id' => 'language_translate_text',
					),
			),

			'buttons' => array(
				'submit' => array(
					'type' => 'submit',
					'layoutType' => 'primary',
					'label' => $this->isNewRecord ? 'Создать' : 'Сохранить',
					'id' => 'language_send_button',
				),
				'reset' => array(
					'type' => 'reset',
					'label' => 'Сбросить',
				),
				'editor' => $editor ? array(
					'type' => 'link',
					'label' => 'Убрать редактор',
					'htmlOptions' => array(
						'href' => '?no-editor',
					),
				) : array(
					'type' => 'link',
					'label' => 'Показать в редакторе',
					'htmlOptions' => array(
						'href' => '?editor',
					)
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
}
