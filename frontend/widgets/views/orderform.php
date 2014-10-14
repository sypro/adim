<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alex
 * Date: 14.10.14
 * Time: 23:57
 * To change this template use File | Settings | File Templates.
 */
?>
<?php echo CHtml::beginForm('/site/order', 'post', array('id' => 'claims-form', 'class' => 'ajax-form', )); ?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">
        <span aria-hidden="true">&times;</span>
        <span class="sr-only"><?=t('Close')?></span>
    </button>
</div>

<div class="modal-body">
    <div class="form-wrap">

        <?php echo CHtml::activeTextField($model, 'name',array('placeholder'=>t($model->getAttributeLabel('name')),'class'=>'form-control','style'=>'border:1px solid '. ( $model->getError('name')  ? 'red' : $color))); ?>
        <?php echo CHtml::activeTextField($model, 'email',array('placeholder'=>t($model->getAttributeLabel('email')),'class'=>'form-control','style'=>'border:1px solid '. ( $model->getError('email')  ? 'red' : $color))); ?>
        <?php echo CHtml::activeTextArea($model, 'message', array('maxlength' => 300, 'rows' => 6, 'cols' => 50, 'placeholder'=>t($model->getAttributeLabel('message')),'class'=>'form-control','style'=>'border:1px solid '. ( $model->getError('message')  ? 'red' : $color))); ?>
    </div>
</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-modal"><?=t('MAKE AN ORDER')?></button>
</div>
<?php echo CHtml::endForm(); ?>
