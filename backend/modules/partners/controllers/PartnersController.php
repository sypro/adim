<?php
/**
 *
 */

namespace partners\controllers;

use back\components\BackController;

/**
 * Class PartnersController
 */
class PartnersController extends BackController
{
	/**
	 * @return string
	 */
	public function getModelClass()
	{
		return '\partners\models\Partners';
	}
}
