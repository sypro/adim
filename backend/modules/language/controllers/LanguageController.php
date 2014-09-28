<?php
/**
 *
 */

namespace language\controllers;

use back\components\BackController;
use language\models\Language;

/**
 * Class LanguageController
 */
class LanguageController extends BackController
{
	/**
	 * @return string
	 */
	public function getModelClass()
	{
		return Language::getClassName();
	}
}
