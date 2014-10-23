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
        <h1 class="page-title"><?=$model->label.' '.t('style')?><span><a href="gallery.html"><?=t('back to gallery')?></a></span></h1>
        <div class="gal-one">
            <!-- main slider carousel -->
            <div class="row">
                <div class="col-md-12" id="slider">

                    <div class="col-md-12" id="carousel-bounding-box">
                        <div id="myCarousel" class="carousel slide">
                            <!-- main slider carousel items -->
                            <div class="carousel-inner">
                                <?php foreach($model->images as $image):?>
                                    <div class="item" data-slide-number="<?=$image->image_id?>">
                                        <?=\fileProcessor\helpers\FPM::image($image->image_id,'gallery','big',$model->label,array('class'=>'img-responsive'))?>
                                    </div>
                                <?php endforeach ?>
                            </div>
                            <!-- main slider carousel nav controls --><!-- <a class="carousel-control left" href="#myCarousel" data-slide="prev">‹</a>
                        <a class="carousel-control right" href="#myCarousel" data-slide="next">›</a>-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 hidden-sm hidden-xs" id="slider-thumbs">
                <!-- thumb navigation carousel items -->
                <ul class="list-inline">
                    <?php foreach($model->images as $image):?>
                    <li>
                        <a id="carousel-selector-<?=$image->image_id?>">
                            <?=\fileProcessor\helpers\FPM::image($image->image_id,'gallery','thumbs',$model->label,array('class'=>'img-responsive'))?>
                        </a>
                    </li>
                    <?php endforeach ?>
                </ul>

            </div>
            <!--/main slider carousel-->
        </div>
    </div>
</div>

<script>
    $('#myCarousel').carousel({
        interval: 4000
    });

    // handles the carousel thumbnails
    $('[id^=carousel-selector-]').click( function(){
        var id_selector = $(this).attr("id");
        var id = id_selector.substr(id_selector.length -1);
        id = parseInt(id);
        $('#myCarousel').carousel(id);
        $('[id^=carousel-selector-]').removeClass('selected');
        $(this).addClass('selected');
    });

    // when the carousel slides, auto update
    $('#myCarousel').on('slid', function (e) {
        var id = $('.item.active').data('slide-number');
        id = parseInt(id);
        $('[id^=carousel-selector-]').removeClass('selected');
        $('[id=carousel-selector-'+id+']').addClass('selected');
    });
</script>
