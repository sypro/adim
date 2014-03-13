<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace elfinder\controllers;

use back\components\BackController;

/**
 * Class ElfinderController
 *
 * @package elfinder\controllers
 */
class ElfinderController extends BackController
{
	public function actions()
	{
		return array(
			'connector' => array(
				'class' => 'ext.elFinder.ElFinderConnectorAction',
				'settings' => array(
					'roots' => array(
						array(
							'URL' => '/uploads/files/',
							'rootAlias' => 'Home',
							'mimeDetect' => 'none',
							'driver' => 'LocalFileSystem',
							'path' => \Yii::getPathOfAlias('webroot') . '/uploads/files/',
							'accessControl' => array($this, 'access')
						),
					),
				)
			),
		);
	}

	public function access($attr, $path, $data, $volume)
	{
		return strpos(basename($path), '.') === 0       // if file/folder begins with '.' (dot)
			? !($attr == 'read' || $attr == 'write')    // set read+write to false, other (locked+hidden) set to true
			:  null;                                    // else elFinder decide it itself
	}

	public function actionBrowser($CKEditorFuncNum)
	{
		$this->layout = false;
		$this->widget('ext.elFinder.ElFinderWidget', array(
				'connectorRoute' => \CHtml::normalizeUrl(array('connector')),
				'settings' => array(
					'getFileCallback' => 'js:function(file) {
						window.opener.CKEDITOR.tools.callFunction('.$CKEditorFuncNum.', file);
						window.close();
					}',
					'resizable' => false,
				),
			)
		);
		$this->render('empty');
	}
}
