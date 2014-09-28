<?php
/**
 * @var $this \back\components\BackController
 * @var $model \back\components\IBackActiveRecord|\back\components\ActiveRecord
 * @var $form \TbForm
 */
use seo\widgets\seoWidget\SeoWidget;

$this->breadcrumbs=$model->genAdminBreadcrumbs('create');

$this->menu=$model->genAdminMenu('create');

$box = $this->beginWidget('bootstrap.widgets.TbBox', $model->genPageName('create'));

$form =  $form->render();
$tabs = array();
$tabs[] = array(
	'label' => 'Контент',
	'active' => true,
	'content' => $form,
);
/*if ($model->asa('seo')) {
	$tabs[] = array(
		'label' => 'SEO',
		'active' => false,
		'content' => $this->widget(SeoWidget::getClassName(), array('model' => $model, ), true),
	);
}*/

$this->widget('bootstrap.widgets.TbTabs', array(
	'type'=>'tabs',
	'tabs'=>$tabs,
));

$this->endWidget();
