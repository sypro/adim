<?php
error_reporting(0); // Set E_ALL for debuging
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR . 'elFinderConnector.class.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR . 'elFinder.class.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR . 'elFinderVolumeDriver.class.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR . 'elFinderVolumeLocalFileSystem.class.php';

class ElFinderConnectorAction extends CAction
{
	/**
	 * @var array
	 */
	public $settings = array();

	public function run()
	{
		$connector = new elFinderConnector(new elFinder($this->settings));
		$connector->run();
	}
}
