<?php
/**
 *
 */

namespace menu\models;

use backstage\components\ActiveRecord;

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
 */
class MenuLang extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MenuLang the static model class
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
		return '{{menu_lang}}';
	}
}
