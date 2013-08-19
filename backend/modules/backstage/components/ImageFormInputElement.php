<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace backstage\components;

use fileProcessor\helpers\FPM;

/**
 * Class ImageFormInputElement
 * @package backstage\components
 */
class ImageFormInputElement extends Widget
{
	public $htmlOptions = array();
	public $model;
	public $attribute;

	public function run()
	{
		if (!$this->model || !$this->attribute) {
			throw new \CHttpException(400, t('You need set model and attribute!'));
		}
		\Yii::import('bootstrap.widgets.TbActiveForm');
		$form = new \TbActiveForm();
		$form->type = 'horizontal';

		echo $form->fileField($this->model, $this->attribute, $this->htmlOptions);
		echo \CHtml::tag('br');
		echo FPM::image($this->model->{$this->attribute}, 'admin', 'form', '', array('class' => 'file-input-block-image', ));
	}
}
