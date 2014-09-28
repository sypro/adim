<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace back\components;

use fileProcessor\helpers\FPM;

/**
 * Class ImageFormInputElement
 *
 * @package back\components
 */
class MultiFileFormInputElement extends Widget
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
	 * @return null|string|void
	 * @throws \CHttpException
	 */
	public function run()
	{
		if (!$this->model || !$this->attribute) {
			throw new \CHttpException(400, t('You need set model and attribute!'));
		}
		if ($this->model->isNewRecord) {
			return null;
		}
		\Yii::import('bootstrap.widgets.TbActiveForm');
		$form = new \TbActiveForm();
		$form->type = 'horizontal';

		$this->htmlOptions['multiple'] = true;

		echo $form->fileField($this->model, $this->attribute, $this->htmlOptions);
		$html = \CHtml::openTag(
			'ul',
			array(
				'class' => 'well-small thumbnails',
				'data-id' => $this->model->getPrimaryKey(),
				'data-action' => \CHtml::normalizeUrl(array('sortImage')),
			)
		);
		foreach ($this->model->getRelatedFiles() as $fileId) {
			$html .= \CHtml::openTag('li', array('class' => 'height200', 'id' => 'file' . $fileId,));
			$html .= \CHtml::openTag('span', array('class' => 'thumbnail span2',));
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
		}
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
					FPM::image($fileId, 'admin', 'view'),
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
