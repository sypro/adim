<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace front\components;

\Yii::import('zii.widgets.CListView');

/**
 * Class ListView
 * @package front\components
 */
class ListView extends \CListView
{
	/**
	 * @var boolean whether to leverage the {@link https://developer.mozilla.org/en/DOM/window.history DOM history object}.  Set this property to true
	 * to persist state of list across page revisits.  Note, there are two limitations for this feature:
	 * - this feature is only compatible with browsers that support HTML5.
	 * - expect unexpected functionality (e.g. multiple ajax calls) if there is more than one grid/list on a single page with enableHistory turned on.
	 * @since 1.1.11
	 */
	public $enableHistory = true;

	/**
	 * @var string the URL of the CSS file used by this list view. Defaults to null, meaning using the integrated
	 * CSS file. If this is set false, you are responsible to explicitly include the necessary CSS file in your page.
	 */
	public $cssFile = false;

	/**
	 * Get full class name
	 *
	 * @return string
	 */
	public static function getClassName()
	{
		return get_called_class();
	}
}
