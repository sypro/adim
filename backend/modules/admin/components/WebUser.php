<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace admin\components;

use core\components\WebUser as CoreWebUser;
use admin\models\User;

/**
 * Class WebUser
 *
 * @package admin\components
 */
class WebUser extends CoreWebUser
{
	/**
	 * Cached user model
	 *
	 * @var null
	 */
	private $_model = null;

	/**
	 * Login url
	 *
	 * @var array
	 */
	public $loginUrl = array('/admin/user/login');

	/**
	 * @var bool
	 */
	public $allowAutoLogin = true;

	/**
	 * @var array
	 */
	public $identityCookie = array(
		'path' => '/',
		//'example' => '.example.com'
	);

	/**
	 * @return bool
	 */
	public function getIsAdmin()
	{
		return $this->getRole() === User::ROLE_ADMIN;
	}

	/**
	 * @return null|string
	 */
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
			$this->_model = User::model()->findByPk($this->id, array('select' => 'id, role',));
			if ($this->_model == null) {
				$this->logout();
			}
		}

		return $this->_model;
	}
}
