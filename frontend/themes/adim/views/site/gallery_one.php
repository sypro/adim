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
        <h1 class="page-title"><?=$model->label//.' '.t('style')?><span><a href="/gallery"><?=t('back to gallery')?></a></span></h1>
        <div class="gal-one">
            <!-- main slider carousel -->
            <div class="row">
                <div class="col-md-12" id="slider">

                    <div class="col-md-12" id="carousel-bounding-box">
                        <div id="myCarousel" class="carousel slide">
                            <!-- main slider carousel items -->
                            <div class="carousel-inner">
                                <div class="fotorama" data-width="100%" data-nav="thumbs">
                                    <?php foreach($model->images as $image):?>
                                        <a href="<?=\fileProcessor\helpers\FPM::src($image->image_id,'gallery','big')?>"><?=\fileProcessor\helpers\FPM::image($image->image_id,'gallery','thumbs',$model->label,array('class'=>'img-responsive'))?></a>
                                    <?php endforeach ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/main slider carousel-->
        </div>
    </div>
</div>
