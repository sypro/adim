<?php
/**
 *
 */

namespace language\models;

use backstage\components\ActiveRecord;
use language\helpers\Lang;

/**
 * This is the model class for table "{{language}}".
 *
 * The followings are the available columns in table '{{language}}':
 * @property integer $id
 * @property string $label
 * @property string $code
 * @property integer $visible
 * @property integer $published
 * @property integer $position
 */
class Language extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Language the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{language}}';
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
			array('label, code', 'required'),
			array('visible, published, position', 'numerical', 'integerOnly'=>true),
			array('label', 'length', 'max'=>20),
			array('code', 'length', 'max'=>5),
			// The following rule is used by search().
			array('id, label, code, visible, published, position', 'safe', 'on'=>'search', ),
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
				'label' => 'Название (будет на фронте)',
				'code' => 'Код (будет в ссылке)',
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
		$criteria->compare('label', $this->label, true);
		$criteria->compare('code', $this->code, true);
		$criteria->compare('visible', $this->visible);
		$criteria->compare('published', $this->published);
		$criteria->compare('position', $this->position);

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

	public function genAdminBreadcrumbs($page, $title = null)
	{
		return parent::genAdminBreadcrumbs($page, 'Языки');
	}

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
					'code',
					array(
						'class' => '\backstage\components\CheckColumn',
						'header' => 'Опубликовано',
						'name' => 'published',
					),
					array(
						'class' => '\backstage\components\CheckColumn',
						'header' => 'Отображается',
						'name' => 'visible',
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
					'label',
					'code',
					'published:boolean',
					'visible:boolean',
					'position',
				);
				break;
			default:
				break;
		}
		return $columns;
	}

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
				'code' => array(
					'type' => 'text',
					'class' => 'span6',
				),
				'visible' => array(
					'type' => 'checkbox',
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
}
