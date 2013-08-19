<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace backstage\components;

use backstage\helpers\GiiHelper;
use core\components\ActiveRecord as CoreActiveRecord;
use language\helpers\Lang;

/**
 * Abstract class. used to be extended by all other models
 * Contains some general functionality
 *
 * Class ActiveRecord
 *
 * @property integer $created
 * @property integer $modified
 *
 * @method getSeoData()
 */
abstract class ActiveRecord extends CoreActiveRecord
{
	/**
	 * Get array with statuses
	 *
	 * @return array
	 */
	public static function getBooleanStatuses()
	{
		return array(
			static::STATUS_NOT => t('No'),
			static::STATUS_YES => t('Yes'),
		);
	}

	/**
	 * Get text of boolean status
	 *
	 * @param $value
	 *
	 * @return null
	 */
	public static function getBooleanText($value)
	{
		$arr = static::getBooleanStatuses();
		return isset($arr[$value]) ? $arr[$value] : null;
	}

	/**
	 * Generate menu
	 *
	 * @param string $page
	 *
	 * @return array
	 */
	public function genAdminMenu($page)
	{
		$menu = array();
		switch ($page)
		{
			case 'index':
				$menu = array(
					array('label'=>null,'url'=>array('create'), 'icon'=>'icon-plus'),
				);
				break;
			case 'create':
				$menu = array(
					array('label'=>null,'url'=>array('index'), 'icon'=>'icon-list'),
				);
				break;
			case 'update':
				$menu = array(
					array('label'=>null,'url'=>array('create'), 'icon'=>'icon-plus'),
					array('label'=>null,'url'=>array('view','id'=>$this->getPrimaryKey()), 'icon'=>'icon-eye-open'),
					array('label'=>null,'url'=>array('index'), 'icon'=>'icon-list'),
				);
				break;
			case 'view':
				$menu = array(
					array('label'=>null,'url'=>array('create'), 'icon'=>'icon-plus'),
					array('label'=>null,'url'=>array('update','id'=>$this->getPrimaryKey()), 'icon'=>'icon-pencil'),
					array('label'=>null,'url'=>array('delete', 'id'=>$this->getPrimaryKey()),
						'buttonType'=>'ajaxLink',
						'ajaxOptions'=>array(
							'type'=>'POST',
							'data'=>array(
								app()->request->csrfTokenName => app()->request->getCsrfToken()
							),
							'success'=>'js:function(){window.location.href="'.\CHtml::normalizeUrl(array('index')).'"}',
							'error'=>'js:function(response){alert(response.responseText);}',
						),
						'htmlOptions'=>array('confirm'=>\Yii::t('core', 'Are you sure you want to delete this item?')), 'icon'=>'icon-trash'),
					array('label'=>null,'url'=>array('index'), 'icon'=>'icon-list'),
				);
				break;
			default: break;
		}
		return $menu;
	}

	/**
	 * Generate page title
	 *
	 * @param string $page
	 *
	 * @return array
	 */
	public function genPageName($page)
	{
		$pageName = array(
			'title' => 'Page name not set',
		);
		switch ($page)
		{
			case 'index':
				$pageName = array(
					'title' => 'Настройка',
					'headerIcon' => 'icon-th-list',
				);
				break;
			case 'create':
				$pageName = array(
					'title' => 'Добавление',
					'headerIcon' => 'icon-file',
				);
				break;
			case 'update':
				$pageName = array(
					'title' => 'Изменение',
					'headerIcon' => 'icon-edit',
				);
				break;
			case 'view':
				$pageName = array(
					'title' => 'Просмотр',
					'headerIcon' => 'icon-eye-open',
				);
				break;
			default: break;
		}
		return $pageName;
	}

	/**
	 * Generate breadcrumbs
	 *
	 * @param string $page
	 * @param null|string $title
	 *
	 * @return array
	 */
	public function genAdminBreadcrumbs($page, $title = null)
	{
		$breadcrumbs = array(
			$title => array('index'),
		);
		switch ($page)
		{
			case 'index':
				$breadcrumbs[] = 'Управление';
				break;
			case 'create':
				$breadcrumbs[] = 'Создать';
				break;
			case 'update':
				$breadcrumbs[] = 'Изменить';
				break;
			case 'view':
				$breadcrumbs[] = 'Просмотр';
				break;
			default: break;
		}
		return $breadcrumbs;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return GiiHelper::getDefaultLabels();
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
	 * Generate localized attribute labels
	 *
	 * @param $labels
	 *
	 * @return mixed
	 */
	public function generateLocalizedAttributeLabels($labels)
	{
		foreach (static::getLocalizedAttributesList() as $attribute) {
			foreach (Lang::getLanguageKeys() as $language) {
				$key = $attribute . '_' . $language;
				$labels[$key] = (isset($labels[$attribute]) ? $labels[$attribute] : $attribute) . '[' . $language . ']';
			}
		}
		foreach (static::getLocalizedAttributesList() as $attribute) {
			$key = $attribute;
			$labels[$key] = (isset($labels[$attribute]) ? $labels[$attribute] : $attribute) . '[' . Lang::getDefault() . ']';
		}
		return $labels;
	}

	/**
	 * Get form config
	 *
	 * @return array
	 */
	public function getFormConfig()
	{
		return array();
	}

	/**
	 * Get columns configs to specified page for grid or detail view
	 *
	 * @param $page
	 *
	 * @return array
	 */
	public function genColumns($page)
	{
		return array();
	}

	/**
	 * Prepare view columns
	 *
	 * @param array $columns
	 * @return array
	 */
	public function prepareViewColumns($columns)
	{
		$result = array();
		if ($this->asa('multiLang')) {
			foreach ($columns as $column) {
				$result[] = $column;
				$columnName = null;
				if (is_array($column)) {
					// if isset value than we can not configure localized fields
					if (!isset($column['value'])) {
						$columnName = isset($column['name']) ? $column['name'] : null;
						$items = $this->getLocalizedAttributeNames($columnName);
						foreach ($items as $item) {
							$itemColumn = $column;
							$itemColumn['name'] = $item;
							$result[] = $itemColumn;
						}
					}
				} elseif (is_string($column)) {
					if (preg_match('#^.([a-zA-Z0-9_-])+#', $column, $matches)) {
						$columnName = $matches[0];
					}
					$items = $this->getLocalizedAttributeNames($columnName);
					foreach ($items as $item) {
						if ($column == $columnName) {
							$result[] = $item;
						} else {
							$result[] = str_replace($columnName, $item, $column);
						}
					}
				}

			}
		}
		$result = empty($result) ? $columns : $result;
		return $result;
	}

	/**
	 * Generation localized attribute names
	 *
	 * @param $column
	 *
	 * @return array
	 */
	public function getLocalizedAttributeNames($column)
	{
		$attributes = array();
		if ($column && in_array($column, $this->getLocalizedAttributesList())) {
			foreach (Lang::getLanguageKeys() as $language) {
				if ($language == Lang::getDefault()) {
					continue;
				}
				$attributes[] = $column . '_' . $language;
			}
		}
		return $attributes;
	}

	/**
	 * Prepare multi language config form
	 *
	 * @param $config
	 *
	 * @return mixed
	 */
	public function prepareFormConfig($config)
	{
		$elements = isset($config['elements']) ? $config['elements'] : null;
		$result = array();
		if ($this->asa('multiLang')) {
			foreach ($elements as $field => $element) {
				$result[$field] = $element;
				if (in_array($field, $this->getLocalizedAttributesList())) {
					foreach (Lang::getLanguageKeys() as $language) {
						if ($language == Lang::getDefault()) {
							continue;
						}
						$languageField = $field . '_' . $language;
						$result[$languageField] = $element;
					}
				}
			}
		}
		$result = empty($result) ? $elements : $result;
		$config['elements'] = $result;
		return $config;
	}

	/**
	 * Prepare behavior to work with behaviors assigned to language
	 *
	 * @param $behaviors
	 *
	 * @return array
	 */
	public function prepareBehaviors($behaviors)
	{
		$result = array();
		foreach ($behaviors as $key => $behavior) {
			$configLanguageAttribute = $behavior['configLanguageAttribute'];
			$configBehaviorAttribute = $behavior['configBehaviorAttribute'];
			$configBehaviorKey = isset($behavior['configBehaviorKey']) ? $behavior['configBehaviorKey'] : 'b_' . $key;
			unset($behavior['configLanguageAttribute']);
			unset($behavior['configBehaviorAttribute']);
			unset($behavior['configBehaviorKey']);
			$result[$key] = $behavior;
			foreach (Lang::getLanguageKeys() as $language) {
				if (Lang::getDefault() == $language) {
					continue;
				}
				$languageBehaviorKey = $configBehaviorKey . '_' . $language;
				$languageBehavior = $behavior;
				$languageBehavior[$configBehaviorAttribute] = $configLanguageAttribute . '_' . $language;
				$result[$languageBehaviorKey] = $languageBehavior;
			}
		}
		$result = empty($result) ? $behaviors : $result;
		return $result;
	}
}
