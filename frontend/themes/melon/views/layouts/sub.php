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
$this->beginContent('//layouts/base');
?>
	<?php echo $content; ?>
<?php
$this->endContent();
