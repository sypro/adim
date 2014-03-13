<?php
/** @var $this \back\components\BackController */
/** @var $model \back\components\IBackActiveRecord */
$this->breadcrumbs = $model->genAdminBreadcrumbs('view');

$this->menu = $model->genAdminMenu('view');

$box = $this->beginWidget('bootstrap.widgets.TbBox', $model->genPageName('view'));

$this->widget('bootstrap.widgets.TbDetailView', array(
	'data' => $model,
	'attributes' => $model->prepareViewColumns($model->genColumns('view')),
));

$this->endWidget();
