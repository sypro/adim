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
<li><img src="/images/slide-1.jpg" /></li>
            <li><img src="/images/slide-2.jpg" /></li>
          </ul>
        </div>
        <div class="caption"><h1><?=t('BELIEVE')?> <span class="cap-sm"><?=t('professionals')?></span><br /> <span class="cap-red" ><?=t('and immediately')?> </span></h1>
		    <a href="#" class="btn btn-cap"data-toggle="modal" data-target="#myModal"><?=t('MAKE AN ORDER')?></a>
	    </div>
	</div>