<?php /** @var $model \admin\models\User */ ?>
<?php /** @var $form \TbActiveForm */ $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'user-form',
	'enableAjaxValidation' => false,
	'type' => 'horizontal',
)); ?>
	<?php echo $form->errorSummary($model); ?>
	<?php echo $form->textFieldRow($model, 'username'); ?>
	<?php echo $form->passwordFieldRow($model, 'password'); ?>
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type' => 'primary',
			'label' => 'Логин',
		)); ?>
	</div>
<?php $this->endWidget();
