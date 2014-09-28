<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace back\components;

use CApplicationComponent;

/**
 * Class Bootstrap
 *
 * @package back\components
 */
class Bootstrap extends \Bootstrap
{
	public function init()
	{
		parent::init();

		$this->packages = \CMap::mergeArray(
			$this->getAdditionalPackages(),
			$this->packages
		);
		foreach ($this->packages as $name => $definition) {
			$this->assetsRegistry->addPackage($name, $definition);
		}
	}

	/**
	 * @return array
	 */
	public function getAdditionalPackages()
	{
		return array(
			'redactor' => array(
				'baseUrl' => $this->getAssetsUrl() . '/js/redactor',
				'js' => array($this->minifyCss ? 'redactor.min.js' : 'redactor.js'),
				'css' => array('redactor.css'),
				'depends' => array('jquery')
			),
			'ckeditor' => array(
				'baseUrl' => $this->getAssetsUrl() . '/js/ckeditor',
				'js' => array('ckeditor.js')
			),
		);
	}
}
