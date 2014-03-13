<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace back\components;

use fileProcessor\helpers\FPM;

/**
 * Class FileFormInputElement
 * @package back\components
 */
class FileFormInputElement extends Widget
{
	/**
	 * @var array
	 */
	public $htmlOptions = array();

	/**
	 * @var ActiveRecord
	 */
	public $model;

	/**
	 * @var
	 */
	public $attribute;

	/**
	 * Content of the showing files
	 *
	 * 'file', 'image'
	 *
	 * @var string
	 */
	public $content = 'file';

	/**
	 * @throws \CHttpException
	 */
	public function run()
	{
		if (!$this->model || !$this->attribute) {
			throw new \CHttpException(400, t('You need set model and attribute!'));
		}
		\Yii::import('bootstrap.widgets.TbActiveForm');
		$form = new \TbActiveForm();
		$form->type = 'horizontal';

		$html = $form->fileField($this->model, $this->attribute, $this->htmlOptions);

		$fileId = $this->model->{$this->attribute};

		if (!$fileId) {
			echo $html;
			return null;
		}
		$html .= \CHtml::openTag(
			'ul',
			array(
				'class' => 'well-small thumbnails',
			)
		);
		$html .= \CHtml::openTag('li', array('id' => 'file' . $fileId,));
		$html .= \CHtml::openTag('span', array('class' => 'thumbnail span3',));
		$html .= \CHtml::link(
			'<i class="icon-trash"></i>',
			array(
				'deleteFile',
				'id' => $fileId,
			),
			array(
				'class' => 'btn btn-mini remove ajax-link fpm-file' . $fileId,
				'data-confirm' => 'You really want to delete this file?',
			)
		);
		$html .= $this->renderFileView($fileId);
		$html .= \CHtml::closeTag('span');
		$html .= \CHtml::closeTag('li');
		$html .= \CHtml::closeTag('ul');

		echo $html;
	}

	/**
	 * @param string $fileId
	 *
	 * @return string
	 */
	public function renderFileView($fileId)
	{
		$return = null;
		switch ($this->content) {
			case 'file':
				$return = \CHtml::link(
					pathinfo(FPM::originalSrc($fileId), PATHINFO_BASENAME),
					FPM::originalSrc($fileId),
					array('target' => '_blank',)
				);
				break;
			case 'image':
				$return = \CHtml::link(
					FPM::image($fileId, 'admin', 'form'),
					FPM::originalSrc($fileId),
					array('target' => '_blank',)
				);
				break;
			default:
				break;
		}

		return $return;
	}
}
