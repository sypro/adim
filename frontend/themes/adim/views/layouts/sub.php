<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

/**
 * @var $this \front\components\FrontController
 * @var $content string
 */
?>
<?php
$this->beginContent('//layouts/main');
?>
<div class="page-inner">

    <?php echo $this->renderPartial('//layouts/header');  ?>
    <div class="content">
	<?php echo $content; ?>
    </div>
<?php
$this->endContent();
?>
