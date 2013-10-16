<?php
/**
 *
 */

namespace seo\widgets\seoWidget;

use backstage\components\ActiveRecord;
use backstage\components\Widget;

/**
 * Class SeoWidget
 */
class SeoWidget extends Widget
{
	/**
	 * @var ActiveRecord
	 */
	public $model;

	public function run()
	{
		if (!$this->model->asa('seo')) {
			return null;
		}

		\Yii::import('bootstrap.widgets.TbForm');
		foreach ($this->model->getSeoData() as $key => $data) {
			/** @var $form \CForm */
			$form = \TbForm::createForm(
				$data->getWidgetFormConfig(),
				$this,
				array(
					'enableAjaxValidation' => false,
					'type' => 'horizontal',
				),
				$data
			);
			echo $form->render();
			echo \CHtml::tag('hr');
		}
	}
}
