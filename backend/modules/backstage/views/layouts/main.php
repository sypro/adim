<!DOCTYPE html>
<?php /* @var $this \backstage\components\BackstageController */ ?>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<meta name="description" content="">
	<meta name="author" content="">
	<?php cs()->registerPackage('backend.main'); ?>
	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>

<body>
<div class="container">
	<?php $this->widget('\menu\widgets\MenuWidget'); ?>
</div>


<?php echo $content; ?>
<div class="container">
	<hr>
	<footer>
		<p class="pull-left">Copyright &copy; <?php echo date('Y'); ?> by <a href="http://vintage.com.ua/" target="_blank">VintageUA</a></p>
		<p class="pull-right"><?php echo Yii::powered(); ?></p>
		<div class="clearfix"></div>
		<p>Отработало за <?php echo sprintf('%0.5f', \Yii::getLogger()->getExecutionTime()); ?> с. Память: <?php echo round(memory_get_peak_usage() / (1024 * 1024), 2) . "MB"; ?></p>
	</footer>
</div>
</body>
</html>
