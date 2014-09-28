<?php
/**
 *
 */

namespace seo\widgets\seoWidget;

use back\components\ActiveRecord;
use back\components\Widget;
use seo\models\Seo;

/**
 * Class SeoWidget
 */
class SeoWidget extends Widget
{
	/**
	 * @var ActiveRecord
	 */
	public $model;

	/**
	 * @return null|void
	 */
	public function run()
	{
		if (!$this->model->asa('seo')) {
			return null;
		}

		\Yii::import('bootstrap.widgets.TbForm');
		foreach ($this->model->getSeoData() as $key => $data) {
			/** @var $data Seo */
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
