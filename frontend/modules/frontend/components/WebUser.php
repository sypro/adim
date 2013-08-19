<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace frontend\components;

use core\components\WebUser as CoreWebUser;
use user\models\User;

/**
 * Class WebUser
 *
 * @package frontend\components
 */
class WebUser extends CoreWebUser
{
	public $socialLoginUrl = '/user/default/social';
	public $userLogoutUrl = '/user/default/logout';
	private $_model = null;

	public function getIsAdmin()
	{
		return $this->getRole() === User::ROLE_ADMIN;
	}

	public function getRole()
	{
		if ($user = $this->getModel()) {
			if (!$user->role) {
				$this->logout();
			}
			return $user->role;
		}
		return null;
	}

	public function getName()
	{
		$name = parent::getName();
		return \CHtml::encode($name);
	}

	public function getPageUrl($params = array())
	{
		return User::genPageUrl($this->id, $params);
	}

	/**
	 * @return User|null
	 */
	private function getModel()
	{
		if (!$this->isGuest && $this->_model === null) {
			$this->_model = User::model()->findByPk($this->id, array('select' => 'id, role'));
			if ($this->_model == null) {
				$this->logout();
			}
		}
		return $this->_model;
	}
}
