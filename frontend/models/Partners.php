<?php
/**
 *
 */

namespace frontend\models;

use front\components\ActiveRecord;

/**
 * This is the model class for table "{{partners}}".
 *
 * The followings are the available columns in table '{{partners}}':
 * @property integer $id
 * @property string $label
 * @property string $link
 * @property integer $image_id
 * @property integer $visible
 * @property integer $published
 * @property integer $position
 * @property integer $created
 * @property integer $modified
 *
 * The followings are the available model relations:
 * @property PartnersLang[] $partnersLangs
 */
class Partners extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Partners the static model class
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
		return '{{partners}}';
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'partnersLangs' => array(self::HAS_MANY, 'PartnersLang', 'model_id'),
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
			array('image_id, visible, published, position, created, modified', 'numerical', 'integerOnly'=>true),
			array('label, link', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, label, link, image_id, visible, published, position, created, modified', 'safe', 'on'=>'search', ),
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
				'link' => 'Link',
				'image_id' => 'Image',
				'visible' => 'Visible',
				'published' => 'Published',
				'position' => 'Position',
				'created' => 'Created',
				'modified' => 'Modified',
			)
		);
	}

	/**
	 * Generate page url
	 *
	 * @param array $params
	 *
	 * @return array
	 */
	public function getPageUrl($params = array())
	{
		return self::createUrl(array(), $params);
	}

	/**
	 * Generate list page url
	 *
	 * @param array $params
	 *
	 * @return array
	 */
	public static function getListPageUrl($params = array())
	{
		return self::createUrl(array(), $params);
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
				'seo' => array(
					'class' => '\seo\components\SeoModelBehavior',
				),
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
	 * Get list of localized attributes
	 *
	 * @return array
	 */
	public static function getLocalizedAttributesList()
	{
		return array();
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
}
