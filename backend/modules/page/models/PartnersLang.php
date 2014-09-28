<?php
/**
 *
 */

namespace partners\models;

use back\components\ActiveRecord;

/**
 * This is the model class for table "{{partners_lang}}".
 *
 * The followings are the available columns in table '{{partners_lang}}':
 * @property integer $l_id
 * @property integer $model_id
 * @property string $lang_id
 * @property string $l_label
 */
class PartnersLang extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PartnersLang the static model class
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
		return '{{partners_lang}}';
	}
}
