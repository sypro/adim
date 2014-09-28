<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace front\components;

/**
 * Class ReturnUrlFilter
 * @package front\components
 */
class SetReturnUrlFilter extends \CFilter
{
	protected function preFilter($filterChain)
	{
		if (!r()->getIsAjaxRequest() && !r()->getIsPostRequest()) {
			user()->setReturnUrl(r()->getUrl());
		}
		return true;
	}
}
