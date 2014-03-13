<?php
/**
 *
 */

namespace seo\models;

use front\components\ActiveRecord;

/**
 * This is the model class for table "{{seo}}".
 *
 * The followings are the available columns in table '{{seo}}':
 * @property string $model_name
 * @property integer $model_id
 * @property string $lang_id
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property integer $visible
 * @property integer $published
 * @property integer $position
 */
class Seo extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Seo the static model class
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
		return '{{seo}}';
	}
}
