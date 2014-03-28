<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace front\components;

use CHtml;

\Yii::import('system.web.widgets.pagers.CLinkPager');

/**
 * Class Pager
 * @package front\components
 */
class Pager extends \CLinkPager
{
	/**
	 * @var string the CSS class for the first page button. Defaults to 'first'.
	 * @since 1.1.11
	 */
	public $firstPageCssClass = self::CSS_HIDDEN_PAGE;

	/**
	 * @var string the CSS class for the last page button. Defaults to 'last'.
	 * @since 1.1.11
	 */
	public $lastPageCssClass = self::CSS_HIDDEN_PAGE;

	/**
	 * @var string the CSS class for the previous page button. Defaults to 'previous'.
	 * @since 1.1.11
	 */
	public $previousPageCssClass = self::CSS_PREVIOUS_PAGE;

	/**
	 * @var string the CSS class for the next page button. Defaults to 'next'.
	 * @since 1.1.11
	 */
	public $nextPageCssClass = self::CSS_NEXT_PAGE;

	/**
	 * @var string the CSS class for the internal page buttons. Defaults to 'page'.
	 * @since 1.1.11
	 */
	public $internalPageCssClass = self::CSS_INTERNAL_PAGE;

	/**
	 * @var string the CSS class for the hidden page buttons. Defaults to 'hidden'.
	 * @since 1.1.11
	 */
	public $hiddenPageCssClass = self::CSS_HIDDEN_PAGE;

	/**
	 * @var string the CSS class for the selected page buttons. Defaults to 'selected'.
	 * @since 1.1.11
	 */
	public $selectedPageCssClass = self::CSS_SELECTED_PAGE;

	/**
	 * @var mixed the CSS file used for the widget. Defaults to null, meaning
	 * using the default CSS file included together with the widget.
	 * If false, no CSS file will be used. Otherwise, the specified CSS file
	 * will be included when using this widget.
	 */
	public $cssFile = false;

	/**
	 * @var string the text label for the next page button. Defaults to 'Next &gt;'.
	 */
	public $nextPageLabel = '';

	/**
	 * @var string the text label for the previous page button. Defaults to '&lt; Previous'.
	 */
	public $prevPageLabel = '';

	/**
	 * @var string the text label for the first page button. Defaults to '&lt;&lt; First'.
	 */
	public $firstPageLabel = '';

	/**
	 * @var string the text label for the last page button. Defaults to 'Last &gt;&gt;'.
	 */
	public $lastPageLabel = '';

	/**
	 * @var string the text shown before page buttons. Defaults to 'Go to page: '.
	 */
	public $header = false;

	/**
	 * Add prev and next links in head
	 *
	 * @var bool
	 */
	public $headPrevNextLinks = true;

	/**
	 * Pagination template
	 *
	 * @var string
	 */
	public $template = "{header}{buttons}{footer}";

	/**
	 * Template used to render an individual button item. In this template,
	 * the token "{link}" will be replaced with the corresponding button link.
	 *
	 * @var string
	 */
	public $itemTemplate;

	/**
	 * Button list
	 *
	 * @var array
	 */
	protected $_buttons = array();

	/**
	 * Get class name
	 *
	 * @return string
	 */
	public static function getClassName()
	{
		return get_called_class();
	}

	public function run()
	{
		$this->registerClientScript();
		$this->_buttons = $this->createPageButtons();
		if (empty($this->_buttons)) {
			return;
		}
		$this->renderContent();
	}

	/**
	 * Creates a page button.
	 * You may override this method to customize the page buttons.
	 * @param string $label the text label for the button
	 * @param integer $page the page number
	 * @param string $class the CSS class for the page button.
	 * @param boolean $hidden whether this page button is visible
	 * @param boolean $selected whether this page button is selected
	 * @return string the generated button
	 */
	protected function createPageButton($label, $page, $class, $hidden, $selected)
	{
		$currentPage = $this->getCurrentPage(false);
		$linkOptions = array();

		if ($page == ($currentPage - 1)) {
			$linkOptions['rel'] = 'prev';
			if ($this->headPrevNextLinks) {
				$pageUrl = aUrl($this->createPageUrl($page));
				cs()->registerLinkTag('prev', null, $pageUrl);
			}
		} elseif ($page == ($currentPage + 1)) {
			$linkOptions['rel'] = 'next';
			if ($this->headPrevNextLinks) {
				$pageUrl = aUrl($this->createPageUrl($page));
				cs()->registerLinkTag('next', null, $pageUrl);
			}
		}

		if ($hidden || $selected) {
			$class .= ' ' . ($hidden ? $this->hiddenPageCssClass : $this->selectedPageCssClass);
		}
		$buttonItem = CHtml::link($label, $this->createPageUrl($page), $linkOptions);
		if ($this->itemTemplate) {
			$buttonItem = strtr($this->itemTemplate, array('{link}' => $buttonItem, ));
		}
		return CHtml::tag('li', array('class' => $class, ), $buttonItem);
	}

	/**
	 * Renders the main content of the view.
	 * The content is divided into sections, such as summary, items, pager.
	 * Each section is rendered by a method named as "renderXyz", where "Xyz" is the section name.
	 * The rendering results will replace the corresponding placeholders in {@link template}.
	 */
	public function renderContent()
	{
		ob_start();
		echo preg_replace_callback("/{(\w+)}/", array($this, 'renderSection'), $this->template);
		ob_end_flush();
	}

	/**
	 * Renders a section.
	 * This method is invoked by {@link renderContent} for every placeholder found in {@link template}.
	 * It should return the rendering result that would replace the placeholder.
	 * @param array $matches the matches, where $matches[0] represents the whole placeholder,
	 * while $matches[1] contains the name of the matched placeholder.
	 * @return string the rendering result of the section
	 */
	protected function renderSection($matches)
	{
		$method='render'.$matches[1];
		if (method_exists($this, $method)) {
			$this->$method();
			$html=ob_get_contents();
			ob_clean();
			return $html;
		} else {
			return $matches[0];
		}
	}

	/**
	 * Render header
	 */
	public function renderHeader()
	{
		echo $this->header;
	}

	/**
	 * Render footer
	 */
	public function renderFooter()
	{
		echo $this->footer;
	}

	public function renderButtons()
	{
		echo CHtml::tag('ul', $this->htmlOptions, implode('', $this->_buttons));
	}
}
