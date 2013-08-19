<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace frontend\components;

/**
 * Class ReturnUrlFilter
 * @package frontend\components
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
