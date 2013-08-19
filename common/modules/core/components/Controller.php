<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace core\components;

/**
 * Class Controller
 *
 * @package core\components
 */
class Controller extends \CController
{
	/**
	 * Contains data for "CBreadcrumbs" widget
	 */
	public $breadcrumbs = array();

	/**
	 * Contains data for "CMenu" widget (provides view for menu on the site)
	 */
	public $menu = array();

	/**
	 *
	 */
	public function init()
	{
		parent::init();
	}

	/**
	 * Add header to json requests
	 *
	 * @param \CFilterChain $filterChain
	 */
	public function filterJsonHeader($filterChain)
	{
		header('Content-Type: application/json');
		$filterChain->run();
	}

	/**
	 *
	 */
	public function renderJson($data = null, $return = false)
	{
		if ($this->beforeRender(null)) {

			$output = je($data);

			$this->afterRender(null, $output);

			if ($return) {
				return $output;
			} else {
				echo $output;
			}
		}
	}
}
