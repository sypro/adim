<?php
/**
 * @var $this \back\components\BackController
 * @var $model \back\components\IBackActiveRecord|\back\components\ActiveRecord
 */
$this->breadcrumbs = $model->genAdminBreadcrumbs('index');

$this->menu = $model->genAdminMenu('index');

$box = $this->beginWidget('bootstrap.widgets.TbBox', $model->genPageName('index'));

if ($model->asa('seo')) {
	$this->widget('bootstrap.widgets.TbButton', array(
		'label' => t('Page list SEO configuration'),
		'type' => 'primary',
		'size' => 'small',
		'htmlOptions' => array(
			'class' => 'toggle-item',
			'data-id' => 'toggle-seo-box',
		),
	));
	echo \CHtml::openTag('div', array('id' => 'toggle-seo-box', ));
	$this->widget(\seo\widgets\seoWidget\SeoWidget::getClassName(), array('model' => $model, ));
	echo \CHtml::closeTag('div');
}

$this->widget('bootstrap.widgets.TbExtendedGridView',array(
	'id' => class2id(get_class($model)) . '-grid',
	'type' => 'striped bordered',
	'dataProvider' => $model->resetScope()->search(),
	'filter' => $model,
	/*'bulkActions' => array(
		'actionButtons' => array(
			array(
				'buttonType' => 'button',
				'id' => 'visible',
				'type' => 'action',
				'size' => 'small',
				'label' => 'Показать',
			),
			array(
				'buttonType' => 'button',
				'id' => 'unvisible',
				'type' => 'action',
				'size' => 'small',
				'label' => 'Скрыть',
			),
			array(
				'buttonType' => 'button',
				'id' => 'publish',
				'type' => 'action',
				'size' => 'small',
				'label' => 'Опубликовать',
			),
			array(
				'buttonType' => 'button',
				'id' => 'unpublish',
				'type' => 'action',
				'size' => 'small',
				'label' => 'Снаять с публикации',
			),
			array(
				'buttonType' => 'button',
				'id' => 'delete',
				'type' => 'action',
				'size' => 'small',
				'label' => 'Удалить',
			),
		),
		'checkBoxColumnConfig' => array(
			'name' => 'id'
		),
	),*/
	'columns' => $model->genColumns('index'),
));

$this->endWidget();
