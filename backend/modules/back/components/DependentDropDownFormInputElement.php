<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace back\components;

/**
 * Class DependentDropDownFormInputElement
 *
 * @package back\components
 */
class DependentDropDownFormInputElement extends Widget
{
	public $htmlOptions = array();
	public $model;
	public $attribute;
	public $nextId;
	public $dependentModel;
	public $nextAttribute;
	public $data = array();

	public function run()
	{
		if (!$this->model || !$this->attribute) {
			throw new \CHttpException(400, t('You need set model and attribute!'));
		}
		if (!$this->nextAttribute || !$this->dependentModel) {
			throw new \CHttpException(400, t('You need set nextAttribute and dependent model!'));
		}
		if (!$this->nextId) {
			$this->nextId = '#' . \CHtml::activeId($this->model, $this->nextAttribute);
		}
		\Yii::import('bootstrap.widgets.TbActiveForm');
		$form = new \TbActiveForm();

		$this->htmlOptions = \CMap::mergeArray(
			$this->htmlOptions,
			array(
				'class' => ($this->htmlOptions['class'] ? $this->htmlOptions['class'] . ' ' : '') . 'dependent-dropdown',
				'data-next' => $this->nextId,
				'data-model' => $this->model->getClassName(),
				'data-attribute' => $this->nextAttribute,
				'data-dependent' => $this->dependentModel,
				'data-url' => \CHtml::normalizeUrl(array('dependent')),
			)
		);

		echo $form->dropDownList($this->model, $this->attribute, $this->data, $this->htmlOptions);
	}
}
