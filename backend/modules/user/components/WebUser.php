<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace user\components;

use core\components\WebUser as CoreWebUser;
use user\models\User;

/**
 * Class WebUser
 *
 * @package user\components
 */
class WebUser extends CoreWebUser
{
	private $_model = null;
	public $loginUrl = array('/user/user/login');
	public $allowAutoLogin = true;
	public $identityCookie = array(
		'path' => '/',
		//'example' => '.example.com'
	);

	public function getIsAdmin()
	{
		return $this->getRole() === User::ROLE_ADMIN;
	}

	public function getRole()
	{
		if ($user = $this->getModel()) {
			return $user->role;
		}
		return null;
	}

	/**
	 * @return User
	 */
	private function getModel()
	{
		if (!$this->isGuest && $this->_model === null) {
			$this->_model = User::model()->findByPk($this->id, array('select' => 'id, role', ));
			if ($this->_model == null) {
				$this->logout();
			}
		}
		return $this->_model;
	}
}
