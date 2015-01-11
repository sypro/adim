<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alex
 * Date: 30.09.14
 * Time: 2:39
 * To change this template use File | Settings | File Templates.
 */
?>
<div class="container">
    <h1 class="page-title"><?=t('About the company')?>: </h1>
    <div class="col-sm-9">
        <div class="row">
            <div class="col-sm-9">
                <div class="about-in">
                    <?=config('ABOUT_TEXT')?>
                </div>
            </div>

        </div>
    </div>
    <?php echo $this->renderPartial('_order');  ?>
    <div class="row">
        <div class="c-image"><img src="/images/contact-img.jpg" /></div>
    </div>
</div>
