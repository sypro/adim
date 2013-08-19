<?php
/**
 *
 */

namespace language\controllers;

use backstage\components\BackstageController;
use language\models\Language;

/**
 * Class LanguageController
 */
class LanguageController extends BackstageController
{
	public function getModelClass()
	{
		return Language::getClassName();
	}
}
