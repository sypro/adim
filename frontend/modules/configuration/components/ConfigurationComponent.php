<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace configuration\components;

use configuration\models\Configuration;
use core\components\ApplicationComponent;
use fileProcessor\helpers\FPM;

/**
 * Class ConfigurationComponents
 * @package configuration\components
 */
class ConfigurationComponent extends ApplicationComponent
{
	/**
	 *
	 * @var string
	 */
	public $cacheId = 'cache';

	/**
	 * Cache expire time
	 * @var int
	 */
	public $cacheExpire = 2592000; // 30 days

	/**
	 * Config items
	 *
	 * @var array
	 */
	protected $_configs = array();

	/**
	 * Load not loaded configs
	 *
	 * @var bool
	 */
	public $lazyLoad = true;

	/**
	 * Initialize
	 */
	public function init()
	{
		parent::init();

		/** @var Configuration[] $configs */
		$configs = Configuration::model()->select(array('config_key', 'value', 'type', ))->preloaded()->findAll();
		$this->_configs = $this->generateConfigArray($configs);
	}

	/**
	 * Generate config array with type in item array
	 *
	 * @param Configuration[] $models
	 *
	 * @return array
	 */
	public function generateConfigArray($models)
	{
		$result = array();
		foreach ($models as $model) {
			$result[$model->config_key] = array(
				'value' => $model->value,
				'type' => $model->type,
			);
		}
		return $result;
	}

	/**
	 * Get config
	 *
	 * @param $key
	 * @param bool $force do not use cache
	 *
	 * @return int|null|string
	 */
	public function get($key, $force = false)
	{
		$value = null;
		if ($force) {
			$config = Configuration::model()->select(array('config_key', 'value', 'type', ))->findByAttributes(array('config_key' => $key, ));
			$value = $config ? $this->getValue($config) : null;
		} elseif (isset($this->_configs[$key])) {
			$value = $this->getValue($this->_configs[$key]);
		} elseif ($this->lazyLoad) {
			$config = Configuration::model()->select(array('config_key', 'value', 'type', ))->findByAttributes(array('config_key' => $key, ));
			if ($config) {
				$this->_configs[$config->config_key] = array(
					'value' => $config->value,
					'type' => $config->type,
				);
				$value = $this->getValue($config);
			}
		}
		return $value;
	}

	/**
	 * Return value by type
	 *
	 * @param $array
	 *
	 * @return int|null|string
	 */
	protected function getValue($array)
	{
		$value = null;
		switch ($array['type']) {
			case Configuration::TYPE_STRING:
			case Configuration::TYPE_HTML:
			case Configuration::TYPE_TEXT:
				$value = $array['value'];
				break;
			case Configuration::TYPE_INTEGER:
			case Configuration::TYPE_BOOLEAN:
				$value = (int) $array['value'];
				break;
			case Configuration::TYPE_FLOAT:
				$value = (float) $array['value'];
				break;
			case Configuration::TYPE_FILE:
				$value = FPM::originalSrc((int) $array['value']);
				break;
			case Configuration::TYPE_IMAGE:
				$value = $array['value'];
				break;
		}
		return $value;
	}
}
