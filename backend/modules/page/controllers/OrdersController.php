<?php
/**
 *
 */

namespace page\controllers;

use back\components\BackController;

/**
 * Class OrdersController
 */
class OrdersController extends BackController
{
	/**
	 * @return string
	 */
	public function getModelClass()
	{
		return '\page\models\Order';
	}
}
