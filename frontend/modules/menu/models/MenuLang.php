<?php
/**
 *
 */

namespace menu\models;

use front\components\ActiveRecord;

/**
 * This is the model class for table "{{menu_lang}}".
 *
 * The followings are the available columns in table '{{menu_lang}}':
 * @property integer $l_id
 * @property integer $model_id
 * @property string $lang_id
 * @property string $l_label
 * @property string $l_link
 * @property integer $visible
 * @property integer $published
 * @property integer $position
 * @property integer $created
 * @property integer $modified
 */
class MenuLang extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MenuLang the static model class
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
		return '{{menu_lang}}';
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
			array('created, modified', 'required'),
			array('model_id, visible, published, position, created, modified', 'numerical', 'integerOnly'=>true),
			array('lang_id', 'length', 'max'=>6),
			array('l_label', 'length', 'max'=>200),
			array('l_link', 'length', 'max'=>250),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('l_id, model_id, lang_id, l_label, l_link, visible, published, position, created, modified', 'safe', 'on'=>'search', ),
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
				'l_id' => 'L',
				'model_id' => 'Model',
				'lang_id' => 'Lang',
				'l_label' => 'L Label',
				'l_link' => 'L Link',
				'visible' => 'Visible',
				'published' => 'Published',
				'position' => 'Position',
				'created' => 'Created',
				'modified' => 'Modified',
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
