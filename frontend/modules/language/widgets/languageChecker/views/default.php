<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */
use language\widgets\languageChecker\LanguageChecker;
use language\helpers\Lang;

/**
 * @var language\widgets\languageChecker\LanguageChecker $this
 */
?>
<ul class="lang">
	<?php
	$i = 0;
	foreach (Lang::getLanguages() as $key => $lang) :
	?>
	<li class="item<?php echo ++$i; ?>">
		<?php echo CHtml::link($lang, $this->prepareUrl($key), array('class' => ($key === Lang::get() || (Lang::get() === 'ua' && $key === 'uk')) ? 'active' : null)); ?>
	</li>
	<?php
	endforeach;
	?>
</ul>
