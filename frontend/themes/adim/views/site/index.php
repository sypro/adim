<?php
/**
 *
 */
/**
 * @var \frontend\controllers\SiteController $this
 */
?>

    <div class="page">
	<?php echo $this->renderPartial('//layouts/header');  ?>

	<div class="full-slider">
		<div class="flexslider">
          <ul class="slides">

            <?php
                $slider = frontend\models\Slider::getItems();
                foreach($slider as $slide)
                    echo CHtml::tag('li',array(),'<img src='.\fileProcessor\helpers\FPM::originalSrc($slide->image_id).'/>');
                ?>
          </ul>
        </div>
        <div class="caption"><h1><?=t('BELIEVE')?> <span class="cap-sm"><?=t('professionals')?></span><br /> <span class="cap-red" ><?=t('and immediately')?> </span></h1>
		    <a href="#" class="btn btn-cap"data-toggle="modal" data-target="#myModal"><?=t('MAKE AN ORDER')?></a>
	    </div>
	</div>