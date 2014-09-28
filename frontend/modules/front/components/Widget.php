<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace front\components;

/**
 * Class Widget
 * @package front\components
 */
class Widget extends \CWidget
{
	const CACHE_PREFIX = 'cache.widget.';
	public $cacheID = 'cache';
	public $enableCache = false;
	public $expire = 86400;
	public $dependency;

	private $_cacheKey;

	public function init()
	{
		parent::init();
		$this->registerAssets();
	}

	public function registerAssets()
	{
	}

	public function getCacheKey()
	{
		if (!$this->_cacheKey) {
			$this->_cacheKey = $this->generateCacheKey();
		}
		return $this->_cacheKey;
	}

	public function generateCacheKey()
	{
		$reflect = new \ReflectionClass($this);
		$key = self::CACHE_PREFIX . "{$reflect->name}.";
		foreach ($reflect->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
			if ($property->class == $reflect->name) {
				$key .= $this->{$property->name};
			}
		}
		$key .= \Yii::app()->getLanguage();
		return $key;
	}

	/**
	 * Return class name
	 *
	 * @return string
	 */
	public static function getClassName()
	{
		return get_called_class();
	}
}
