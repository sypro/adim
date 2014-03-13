<?php
/**
 * This is the template for generating a form script file.
 * The following variables are available in this template:
 * @var FormCode $this
 * @var CDbColumnSchema[] $columns
 */

use back\helpers\GiiHelper;

?>
<?php echo "<?php\n"; ?>

return array(
	'showErrorSummary' => true,
	'attributes' => array(
		'enctype' => 'multipart/form-data',
	),
	'elements' => array(
<?php foreach($columns as $column): ?>
<?php $row = GiiHelper::generateFormRow($column); ?>
<?php if($row): ?>
		<?php echo $row, "\n"; ?>
<?php endif; ?>
<?php endforeach; ?>
	),

	'buttons' => array(
		'submit' => array(
			'type' => 'submit',
			'layoutType' => 'primary',
			'label' => $this->isNewRecord ? 'Создать' : 'Сохранить',
		),
		'reset' => array(
			'type' => 'reset',
			'label' => 'Сбросить',
		),
	),
);
