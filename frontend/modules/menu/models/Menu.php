<?php
/**
 *
 */

namespace menu\models;

use front\components\ActiveRecord;

/**
 * This is the model class for table "{{menu}}".
 *
 * The followings are the available columns in table '{{menu}}':
 * @property integer $id
 * @property integer $menu_id
 * @property string $label
 * @property integer $parent_id
 * @property integer $type_id
 * @property integer $related_id
 * @property string $link
 * @property integer $visible
 * @property integer $published
 * @property integer $position
 * @property integer $created
 * @property integer $modified
 *
 * The followings are the available model relations:
 * @property MenuList $menu
 * @property Menu $parent
 * @property Menu[] $menus
 * @property MenuType $type
 */
class Menu extends ActiveRecord
{
	/**
	 * Pre set link type
	 */
	const TYPE_LINK = 1;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Menu the static model class
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
		return '{{menu}}';
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'menu' => array(self::BELONGS_TO, MenuList::getClassName(), 'menu_id'),
			'parent' => array(self::BELONGS_TO, Menu::getClassName(), 'parent_id'),
			'menus' => array(self::HAS_MANY, Menu::getClassName(), 'parent_id'),
			'type' => array(self::BELONGS_TO, MenuType::getClassName(), 'type_id'),
		);
	}

	public function getPageUrl($params = array())
	{
		if ($this->type_id == self::TYPE_LINK) {
			return $this->link;
		}
		$modelName = $this->type->model_name;
		$url = call_user_func(array($modelName, 'getListPageUrl'));
		return $url;
	}

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
		return array('label', 'link');
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
