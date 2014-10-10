<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alex
 * Date: 30.09.14
 * Time: 4:08
 * To change this template use File | Settings | File Templates.
 */
?>
<div class="container">
    <h1 class="page-title"><?=t('Gallery')?></h1>
    <?php
//    var_dump($model);
    foreach(array_chunk($model,4) as $row){
        echo '<div class="row">';
        foreach($row as $gallery){
            echo '<div class="col-sm-3">';
            echo CHtml::link(\fileProcessor\helpers\FPM::image($gallery->image_id,'page','gallery'),$gallery->getPageUrl());
//            echo  \fileProcessor\helpers\FPM::image($gallery->image_id,'page','gallery');
            echo '<div class="gal-name">'.$gallery->label.'</div></div>';

        }

        echo '</div>';
    }
    ?>
</div>