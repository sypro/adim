<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alex
 * Date: 30.09.14
 * Time: 4:07
 * To change this template use File | Settings | File Templates.
 */
?>
<div class="container">
    <h1 class="page-title"><?=t('Keep the good relationship with the client')?></h1>
    <div class="col-sm-9">
        <div class="row">
            <?php foreach($model as $row):?>
            <div class="col-sm-4">
                <div class="princ-w">
                    <div><?=\fileProcessor\helpers\FPM::image($row->image_id,'page','partners',$row->label,array('class'=>'img-circle'))?></div>
                    <div class="c-w-name"><p>«<?=CHtml::link( $row->label,$row->link,array('target'=>'_blank'))?>»</p></div>
                </div>
            </div>
            <?php endforeach ?>
        </div>
    </div>
    <?php echo $this->renderPartial('_order');  ?>

</div>