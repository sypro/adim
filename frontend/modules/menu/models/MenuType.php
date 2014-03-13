<?php
/**
 *
 */

namespace menu\models;

use front\components\ActiveRecord;

/**
 * This is the model class for table "{{menu_type}}".
 *
 * The followings are the available columns in table '{{menu_type}}':
 * @property integer $id
 * @property string $label
 * @property string $model_name
 *
 * The followings are the available model relations:
 * @property Menu[] $menus
 */
class MenuType extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MenuType the static model class
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
		return '{{menu_type}}';
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'menus' => array(self::HAS_MANY, 'Menu', 'type_id'),
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
			array('label, model_name', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, label, model_name', 'safe', 'on'=>'search', ),
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
				'id' => 'ID',
				'label' => 'Label',
				'model_name' => 'Model Name',
			)
		);
	}

	public function getPageUrl($params = array())
	{
		return self::createUrl(array(), $params);
	}

	public static function getListPageUrl($params = array())
	{
		return self::createUrl(array(), $params);
	}
}
