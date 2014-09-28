<?php
/**
 *
 */

namespace seo\models;

use back\components\ActiveRecord;

/**
 * This is the model class for table "{{seo}}".
 *
 * The followings are the available columns in table '{{seo}}':
 *
 * @property string $model_name
 * @property integer $model_id
 * @property string $lang_id
 * @property string $title
 * @property string $keywords
 * @property string $description
 */
class Seo extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 *
	 * @param string $className active record class name.
	 *
	 * @return Seo the static model class
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
		return '{{seo}}';
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array();
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('model_name, model_id, lang_id', 'required'),
			array('model_id', 'numerical', 'integerOnly' => true),
			array('model_name', 'length', 'max' => 100),
			array('lang_id', 'length', 'max' => 6),
			array('title, keywords, description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('model_name, model_id, lang_id, title, keywords, description', 'safe', 'on' => 'search',),
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
				'model_id' => 'ID модели',
				'model_name' => 'Модель',
				'lang_id' => 'Язык',
				'title' => $this->lang_id ? 'Title [' . $this->lang_id . ']' : 'Title',
				'keywords' => $this->lang_id ? 'Keywords [' . $this->lang_id . ']' : 'Keywords',
				'description' => $this->lang_id ? 'Description [' . $this->lang_id . ']' : 'Description',
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
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria = new \CDbCriteria();

		$criteria->compare('model_name', $this->model_name, true);
		$criteria->compare('model_id', $this->model_id);
		$criteria->compare('lang_id', $this->lang_id, true);
		$criteria->compare('title', $this->title, true);
		$criteria->compare('keywords', $this->keywords, true);
		$criteria->compare('description', $this->description, true);

		return new \CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => array(
				'pageSize' => $pageSize ? $pageSize : 50,
			),
			'sort' => array(
				'defaultOrder' => array(
					'created' => \CSort::SORT_DESC,
				),
			),
		));
	}

	/**
	 * @param string $page
	 * @param null $title
	 *
	 * @return array
	 */
	public function genAdminBreadcrumbs($page, $title = null)
	{
		return parent::genAdminBreadcrumbs($page, 'SEO');
	}

	/**
	 * @return mixed|null|string
	 */
	public function getAdminPrimaryKey()
	{
		$table = $this->getMetaData()->tableSchema;
		if (is_string($table->primaryKey))
			return $this->{$table->primaryKey};
		elseif (is_array($table->primaryKey)) {
			$values = array();
			foreach ($table->primaryKey as $name) {
				$values[$name] = $this->$name;
			}

			return je($values);
		} else
			return null;
	}

	/**
	 * @param string $page
	 *
	 * @return array
	 */
	public function genAdminMenu($page)
	{
		$menu = array();
		switch ($page) {
			case 'index':
				$menu = array();
				break;
			case 'create':
				$menu = array(
					array('label' => null, 'url' => array('index'), 'icon' => 'icon-list'),
				);
				break;
			case 'update':
				$menu = array(
					array('label' => null, 'url' => array('index'), 'icon' => 'icon-list'),
				);
				break;
			case 'view':
				$menu = array(
					array(
						'label' => null,
						'url' => array('update', 'id' => $this->getAdminPrimaryKey()),
						'icon' => 'icon-pencil'
					),
					array(
						'label' => null,
						'url' => array('delete', 'id' => $this->getAdminPrimaryKey()),
						'buttonType' => 'ajaxLink',
						'ajaxOptions' => array(
							'type' => 'POST',
							'data' => array(
								app()->request->csrfTokenName => app()->request->getCsrfToken()
							),
							'success' => 'js:function(){window.location.href="' . \CHtml::normalizeUrl(
									array('index')
								) . '"}',
							'error' => 'js:function(response){alert(response.responseText);}',
						),
						'htmlOptions' => array(
							'confirm' => \Yii::t(
									'core',
									'Are you sure you want to delete this item?'
								)
						),
						'icon' => 'icon-trash'
					),
					array('label' => null, 'url' => array('index'), 'icon' => 'icon-list'),
				);
				break;
			default:
				break;
		}

		return $menu;
	}

	/**
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
					'model_name',
					'model_id',
					'lang_id',
					'title',
					'keywords',
					'description',
					array(
						'class' => 'bootstrap.widgets.TbButtonColumn',
						'updateButtonUrl' => function (Seo $data) {
								return \CHtml::normalizeUrl(array('update', 'id' => $data->getAdminPrimaryKey()));
							},
						'viewButtonUrl' => function (Seo $data) {
								return \CHtml::normalizeUrl(array('view', 'id' => $data->getAdminPrimaryKey()));
							},
						'deleteButtonUrl' => function (Seo $data) {
								return \CHtml::normalizeUrl(array('delete', 'id' => $data->getAdminPrimaryKey()));
							},
					),
				);
				break;
			case 'view':
				$columns = array(
					'model_name',
					'model_id',
					'lang_id',
					'title',
					'keywords',
					'description',
				);
				break;
			default:
				break;
		}

		return $columns;
	}

	/**
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
				'model_name' => array(
					'type' => 'text',
					'class' => 'span6',
				),
				'model_id' => array(
					'type' => 'text',
					'class' => 'span2',
				),
				'lang_id' => array(
					'type' => 'text',
					'class' => 'span2',
				),
				'title' => array(
					'type' => 'text',
					'class' => 'span6',
				),
				'keywords' => array(
					'type' => 'text',
					'class' => 'span6',
				),
				'description' => array(
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
	 * @return array
	 */
	public function getWidgetFormConfig()
	{
		return array(
			'showErrorSummary' => true,
			'attributes' => array(
				'enctype' => 'multipart/form-data',
			),
			'title' => t('core', 'Setup list page seo [{language}]', array('{language}' => $this->lang_id)),
			'elements' => array(
				'[' . $this->lang_id . ']model_name' => array(
					'type' => 'hidden',
					'class' => 'span6',
				),
				'[' . $this->lang_id . ']model_id' => array(
					'type' => 'hidden',
					'class' => 'span6',
				),
				'[' . $this->lang_id . ']lang_id' => array(
					'type' => 'hidden',
					'class' => 'span6',
				),
				'[' . $this->lang_id . ']title' => array(
					'type' => 'text',
					'class' => 'span6',
				),
				'[' . $this->lang_id . ']keywords' => array(
					'type' => 'text',
					'class' => 'span6',
				),
				'[' . $this->lang_id . ']description' => array(
					'type' => 'text',
					'class' => 'span6',
				),
			),
			'buttons' => array(
				'submit' => array(
					'type' => 'ajaxSubmit',
					'url' => array('/seo/seo/save'),
					'layoutType' => 'primary',
					'label' => $this->isNewRecord ? 'Создать' : 'Сохранить',
					'ajaxOptions' => array(
						'cache' => false,
						'dataType' => 'json',
						'error' => 'js:function (response) {alert(response.responseText);}',
						'success' => 'js:function (response) {parseResponse(response);}',
					),
				),
				'reset' => array(
					'type' => 'reset',
					'label' => 'Сбросить',
				),
			),
		);
	}
}
