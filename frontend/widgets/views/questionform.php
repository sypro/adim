<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alex
 * Date: 14.10.14
 * Time: 23:57
 * To change this template use File | Settings | File Templates.
 */
?>

<div class="f-f-group">
    <?php echo CHtml::beginForm('/site/question', 'post', array('id' => 'question-form', 'class' => 'form-inline site-builders ajax-form', )); ?>
        <div class="form-group">
            <div class="input-group">
            <?php echo CHtml::activeTextField($model, 'name',array('placeholder'=>t($model->getAttributeLabel('name')),'class'=>'form-control','style'=>'border:1px solid '. ( $model->getError('name')  ? 'red' : $color))); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <?php echo CHtml::activeTextField($model, 'email',array('placeholder'=>t($model->getAttributeLabel('email')),'class'=>'form-control','style'=>'border:1px solid '. ( $model->getError('email')  ? 'red' : $color))); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo CHtml::activeTextArea($model, 'message', array('maxlength' => 300, 'rows' => 1, 'cols' => 21, 'placeholder'=>t($model->getAttributeLabel('message')),'class'=>'form-control','style'=>'border:1px solid '. ( $model->getError('message')  ? 'red' : $color))); ?>
        </div>
        <button type="submit" class="btn btn-send"><?=t('Send')?></button>
    <?php echo CHtml::endForm(); ?>
</div>
