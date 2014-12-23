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
        <h1 class="page-title"><?=$model->label.' '.t('style')?><span><a href="/gallery"><?=t('back to gallery')?></a></span></h1>
        <div class="gal-one">
            <!-- main slider carousel -->
            <div class="row">
                <div class="col-md-12" id="slider">

                    <div class="col-md-12" id="carousel-bounding-box">
                        <div id="myCarousel" class="carousel slide">
                            <!-- main slider carousel items -->
                            <div class="carousel-inner">
                                <!-- 1. Link to jQuery (1.8 or later), -->

                                <!-- fotorama.css & fotorama.js. -->
                                <link  href="http://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.2/fotorama.css" rel="stylesheet"> <!-- 3 KB -->
                                <script src="http://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.2/fotorama.js"></script> <!-- 16 KB -->

                                <!-- 2. Add images to <div class="fotorama"></div>. -->
                                <div class="fotorama" data-nav="thumbs">
                                    <?php foreach($model->images as $image):?>
                                        <a href="<?=\fileProcessor\helpers\FPM::originalSrc($image->image_id)?>"><?=\fileProcessor\helpers\FPM::image($image->image_id,'gallery','thumbs',$model->label,array('class'=>'img-responsive'))?></a>
                                    <?php endforeach ?>
                                </div>

                                <!-- 3. Enjoy! -->

                            </div>
                            <!-- main slider carousel nav controls --><!-- <a class="carousel-control left" href="#myCarousel" data-slide="prev">‹</a>
                        <a class="carousel-control right" href="#myCarousel" data-slide="next">›</a>-->
                        </div>
                    </div>
                </div>
            </div>

            <!--/main slider carousel-->
        </div>
    </div>
</div>
