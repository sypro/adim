<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace core\components;

/**
 * Class WebModule
 *
 * @package core\components
 */
class WebModule extends \CWebModule
{
	/**
	 * Assets url
	 *
	 * @var
	 */
	private $_assetsUrl;

	/**
	 * debug mode
	 *
	 * @var bool
	 */
	public $debug = false;

	/**
	 * Return full class name
	 *
	 * @return string
	 */
	public static function getClassName()
	{
		return get_called_class();
	}

	/**
	 * Publishes the module assets path.
	 * @return string the base URL that contains all published asset files of Rights.
	 */
	public function getAssetsUrl()
	{
		if ($this->_assetsUrl === null) {
			$assetsPath = $this->getBasePath() . DIRECTORY_SEPARATOR . 'assets';
			$this->_assetsUrl = app()->getAssetManager()->publish($assetsPath);
			if ($this->debug===true) {
				$this->_assetsUrl = app()->getAssetManager()->publish($assetsPath, false, -1, true);
			} else {
				$this->_assetsUrl = app()->getAssetManager()->publish($assetsPath);
			}
		}
		return $this->_assetsUrl;
	}
}
