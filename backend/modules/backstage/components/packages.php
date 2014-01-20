<?php
return array(
	'redactor' => array(
		'baseUrl' => $this->getAssetsUrl() . '/redactor',
		'js' => array($this->minifyCss ? 'redactor.min.js' : 'redactor.js'),
		'css' => array('redactor.css'),
		'depends' => array('jquery')
	),
	'ckeditor' => array(
		'baseUrl' => $this->getAssetsUrl() . '/ckeditor',
		'js' => array('ckeditor.js')
	),
);
