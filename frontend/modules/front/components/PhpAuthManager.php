<?php
/**
 *
 */

namespace front\components;

/**
 * Class PhpAuthManager
 */
class PhpAuthManager extends \CPhpAuthManager
{
	public function init()
	{
		if ($this->authFile === null) {
			$this->authFile = \Yii::getPathOfAlias('application.config.auth').'.php';
		}

		parent::init();

		if (!user()->isGuest) {
			$this->assign(user()->role, user()->id);
		}
	}
}
