<?php
/**
 * Author: metal
 * Email: metal
 */

namespace console\components;

use CApplicationComponent;
use CException;

/**
 * Class Mail
 * @package console\components
 */
class Mail extends CApplicationComponent
{
	/**
	 * @var array
	 */
	protected $configs = array();

	/**
	 * @param array $configs
	 *
	 * @return YiiMailer
	 */
	public function createEmail(array $configs = array())
	{
		return new YiiMailer(mergeArray($this->configs, $configs));
	}

	/**
	 * @param string $name
	 *
	 * @return mixed|string
	 * @throws CException
	 * @throws \Exception
	 */
	public function __get($name)
	{
		try {
			return parent::__get($name);
		} catch (CException $e) {
			if (isset($this->configs[$name])) {
				return $this->configs[$name];
			} else {
				throw $e;
			}
		}
	}

	/**
	 * @param string $name
	 * @param mixed $value
	 *
	 * @return mixed|void
	 * @throws CException
	 * @throws \Exception
	 */
	public function __set($name, $value)
	{
		try {
			parent::__set($name, $value);
		} catch (\CException $e) {
			$this->configs[$name] = $value;
		}
	}

	/**
	 * @param string $name
	 *
	 * @return bool
	 */
	public function __isset($name)
	{
		if (!parent::__isset($name)) {
			return (isset($this->configs[$name]));
		} else {
			return true;
		}
	}

	/**
	 * @param string $name
	 *
	 * @return bool
	 */
	public function canGetProperty($name)
	{
		return parent::canGetProperty($name) or isset($this->configs[$name]);
	}

	/**
	 * @param string $name
	 *
	 * @return bool
	 */
	public function canSetProperty($name)
	{
		return true;
	}

	/**
	 * @param string $name
	 *
	 * @return bool
	 */
	public function hasProperty($name)
	{
		return parent::hasProperty($name) or isset($this->configs[$name]);
	}
}
