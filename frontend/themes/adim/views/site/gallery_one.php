<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alex
 * Date: 10.10.14
 * Time: 11:36
 * To change this template use File | Settings | File Templates.
 */
?>
<div class="content">
    <div class="container">
        <h1 class="page-title"><?=$model->label?> style <span><a href="gallery.html"><?=t('back to gallery')?></a></span></h1>
        <div class="gal-one">
            <!-- Place somewhere in the <body> of your page -->
            <div class="flexslider-gal">
                <ul class="slides">
                    <?php foreach($model->images as $image):?>
                    <li data-thumb="<?=\fileProcessor\helpers\FPM::originalSrc($image->image_id)?>">
                        <img src="<?=\fileProcessor\helpers\FPM::originalSrc($image->image_id)?>" />
                    </li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>
    </div>
</div>