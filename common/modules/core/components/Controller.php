<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace core\components;

use CUploadedFile;
use fileProcessor\helpers\FPM;

/**
 * Class Controller
 *
 * @package core\components
 */
class Controller extends \CController
{
	/**
	 * Contains data for "CBreadcrumbs" widget
	 */
	public $breadcrumbs = array();

	/**
	 * Contains data for "CMenu" widget (provides view for menu on the site)
	 */
	public $menu = array();

	/**
	 *
	 */
	public function init()
	{
		parent::init();
	}

	/**
	 * Add header to json requests
	 *
	 * @param \CFilterChain $filterChain
	 */
	public function filterJsonHeader($filterChain)
	{
		header('Content-Type: application/json');
		$filterChain->run();
	}

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl',
			'postOnly +imperaviImageUpload +imperaviFileUpload',
			'jsonHeader +imperaviImageUpload +imperaviFileUpload',
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 *
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array(
				'deny',
				'users' => array('?',),
				'actions' => array('imperaviImageUpload', 'imperaviFileUpload',),
			),
			array(
				'allow',
				'users' => array('*',),
			),
			array(
				'deny',
				'users' => array('*',),
			),
		);
	}

	/**
	 * @param null $data
	 * @param bool $return
	 *
	 * @return null|string
	 */
	public function renderJson($data = null, $return = false)
	{
		if ($this->beforeRender(null)) {

			$output = je($data);

			$this->afterRender(null, $output);

			if ($return) {
				return $output;
			} else {
				echo $output;
			}
		}
	}

	/**
	 *
	 */
	public function actionImperaviImageUpload()
	{
		$file = CUploadedFile::getInstanceByName('imperaviImageUpload');
		if ($file) {
			$transfer = FPM::transfer();
			$imageId = $transfer->saveUploadedFile($file);
			$data = array(
				'filelink' => FPM::originalSrc($imageId),
				'filename' => $file->getName(),
			);
		} else {
			$data = array(
				'error' => t('Error while upload image!'),
			);
		}
		$this->renderJson($data);
	}

	/**
	 *
	 */
	public function actionImperaviFileUpload()
	{
		$file = CUploadedFile::getInstanceByName('imperaviFileUpload');
		if ($file) {
			$transfer = FPM::transfer();
			$imageId = $transfer->saveUploadedFile($file);

			$data = array(
				'filelink' => FPM::originalSrc($imageId),
				'filename' => $file->getName(),
			);
		} else {
			$data = array(
				'error' => t('Error while upload image!'),
			);
		}
		$this->renderJson($data);
	}
}
