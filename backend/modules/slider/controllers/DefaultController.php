<?php
/**
 *
 */

namespace slider\controllers;

use back\components\BackController;

/**
 * Class DefaultController
 */
class DefaultController extends BackController
{
	/**
	 * @return string
	 */
	public function getModelClass()
	{
		return '\slider\models\Slider';
	}
}


