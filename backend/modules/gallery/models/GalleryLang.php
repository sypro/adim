<?php
/**
 *
 */

namespace gallery\models;

use back\components\ActiveRecord;

/**
 * This is the model class for table "{{gallery_lang}}".
 *
 * The followings are the available columns in table '{{gallery_lang}}':
 * @property integer $l_id
 * @property integer $model_id
 * @property string $lang_id
 * @property string $l_label
 */
class GalleryLang extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GalleryLang the static model class
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
		return '{{gallery_lang}}';
	}
}
