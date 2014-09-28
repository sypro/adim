<?php
/**
 *
 */

namespace configuration\models;

use front\components\ActiveRecord;

/**
 * This is the model class for table "{{configuration}}".
 *
 * The followings are the available columns in table '{{configuration}}':
 * @property string $id
 * @property string $config_key
 * @property string $value
 * @property string $description
 * @property integer $type
 * @property integer $preload
 * @property integer $visible
 * @property integer $published
 * @property integer $position
 * @property integer $created
 * @property integer $modified
 */
class Configuration extends ActiveRecord
{
	/**
	 * integer
	 */
	const TYPE_INTEGER = 1;

	/**
	 * string
	 */
	const TYPE_STRING = 2;

	/**
	 * text
	 */
	const TYPE_TEXT = 3;

	/**
	 * html
	 */
	const TYPE_HTML = 4;

	/**
	 * file
	 */
	const TYPE_FILE = 5;

	/**
	 * array
	 */
	const TYPE_ARRAY = 6;

	/**
	 * boolean
	 */
	const TYPE_BOOLEAN = 7;

	/**
	 * float
	 */
	const TYPE_FLOAT = 8;

	/**
	 * image
	 */
	const TYPE_IMAGE = 9;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Configuration the static model class
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
		return '{{configuration}}';
	}

	/**
	 * Returns a list of behaviors that this model should behave as.
	 *
	 * @return array the behavior configurations (behavior name=>behavior configuration)
	 */
	public function behaviors()
	{
		return \CMap::mergeArray(
			parent::behaviors(),
			array(
				'multiLang' => array(
					'class' => '\language\components\MultilingualBehavior',
					'localizedAttributes' => self::getLocalizedAttributesList(),
					'languages' => \language\helpers\Lang::getLanguageKeys(),
					'defaultLanguage' => \language\helpers\Lang::getDefault(),
					'forceOverwrite' => true,
				),
			)
		);
	}

	/**
	 * Get only preloaded configs
	 *
	 * @return $this
	 */
	public function preloaded()
	{
		return $this->compare('preload', self::STATUS_YES);
	}

	/**
	 * Get list of localized attributes
	 *
	 * @return array
	 */
	public static function getLocalizedAttributesList()
	{
		return array('value', );
	}

	/**
	 * Return default query params
	 *
	 * @return array
	 */
	public function defaultScope()
	{
		$localized = $this->multiLang->localizedCriteria();
		return \CMap::mergeArray(
			parent::defaultScope(),
			$localized
		);
	}

	/**
	 * Parse email list
	 *
	 * @param $string
	 *
	 * @return array
	 */
	public static function parseEmailsFromString($string)
	{
		$toEmails = array();
		$emails = explode(',', $string);
		foreach ($emails as $email) {
			$timedEmail = trim($email);
			$emValidator = new \CEmailValidator();
			if ($emValidator->validateValue($timedEmail)) {
				$toEmails[] = $timedEmail;
			}
		}

		return $toEmails;
	}
}
