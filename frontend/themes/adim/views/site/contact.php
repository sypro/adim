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
    <h1 class="page-title"><?=t('Principles of operation')?></h1>
    <div class="col-sm-9">
        <div class="row">
            <div class="col-sm-6">
                <div class="contact-in">
                    <div class="info">
                        <p><?=t('Tel.')?>: <?=config('PHONE')?></p>
                        <p><?=t('Email')?>: <?=config('EMAIL')?></p>
                        <p><?=t('Address')?>:  <?=config('ADDRESS')?></p>
                    </div>
                    <div class="info">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo $this->renderPartial('_order');  ?>
</div>
<div class="row">
    <div class="c-image"><img src="/images/contact-img.jpg" /></div>
</div>