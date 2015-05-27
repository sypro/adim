<?php
/**
 *
 */
/**
 * @var \frontend\controllers\SiteController $this
 */
?>

    <div class="page main">
	<?php echo $this->renderPartial('//layouts/header');  ?>

	<div class="full-slider">
		<div class="flexslider">
          <ul class="slides">
          	<?php
          	foreach ($model as $row) {
          		echo "<li>";
          		echo \fileProcessor\helpers\FPM::image($row->image_id,'page','slider',"");
          		echo "</li>";
          	}
          	?>
          </ul>
        </div>
        <div class="caption"><h1><?=t('BELIEVE')?> <span class="cap-sm"><?=t('professionals')?></span><br /> <span class="cap-red" ><?=t('and immediately')?> </span></h1>
		    <a href="#" class="btn btn-cap"data-toggle="modal" data-target="#myModal"><?=t('MAKE AN ORDER')?></a>
	    </div>
	</div>