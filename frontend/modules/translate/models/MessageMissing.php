<?php
/**
 *
 */

namespace translate\models;

use front\components\ActiveRecord;

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
			array('application_id, category', 'length', 'max'=>32),
			array('language', 'length', 'max'=>5),
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
				'application_id' => 'Application',
				'message' => 'Message',
				'category' => 'Category',
				'language' => 'Language',
			)
		);
	}
}
