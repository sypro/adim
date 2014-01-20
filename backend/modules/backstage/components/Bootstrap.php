<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace backstage\components;

use CApplicationComponent;

/**
 * Class Bootstrap
 *
 * @package backstage\components
 */
class Bootstrap extends \Bootstrap
{
	public function init()
	{
		$this->packages = \CMap::mergeArray(
			require(\Yii::getPathOfAlias('backstage.components') . '/packages.php'),
			$this->packages
		);

		parent::init();
	}
}
