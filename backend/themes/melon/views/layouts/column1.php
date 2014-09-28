<?php /* @var $this \back\components\BackController */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="container">
	<?php if(isset($this->breadcrumbs)): ?>
		<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
		'links' => $this->breadcrumbs,
	)); ?><!-- breadcrumbs -->
	<?php endif; ?>
</div>
<div class="container content-block">
	<?php if(isset($this->menu) && !empty($this->menu)): ?>
	<?php /*<div data-spy="affix" data-offset-top="40">*/ ?>
		<div class="btn-toolbar">
			<?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
			//'stacked'=>true,
			//'size'=>'small',
			'buttons'=>$this->menu,
		)); ?>
		</div>
	<?php /*</div>*/ ?>
	<?php endif; ?>
	<?php echo $content; ?>
</div> <!-- /container -->
<?php $this->endContent(); ?>
