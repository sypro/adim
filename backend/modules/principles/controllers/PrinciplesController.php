<?php
/**
 *
 */

namespace principles\controllers;

use back\components\BackController;

/**
 * Class PrinciplesController
 */
class PrinciplesController extends BackController
{
	/**
	 * @return string
	 */
	public function getModelClass()
	{
		return '\principles\models\Principles';
	}
}
