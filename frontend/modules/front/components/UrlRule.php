<?php
/**
 *
 */

namespace front\components;

/**
 * Class UrlRule
 *
 * @package front\components
 */
class UrlRule extends \CUrlRule
{
	/**
	 * Creates a URL based on this rule.
	 *
	 * @param \CUrlManager $manager   the manager
	 * @param string      $route     the route
	 * @param array       $params    list of parameters
	 * @param string      $ampersand the token separating name-value pairs in the URL.
	 *
	 * @return mixed the constructed URL or false on error
	 */
	public function createUrl($manager, $route, $params, $ampersand)
	{
		return parent::createUrl($manager, $route, $params, $ampersand);
	}
}
