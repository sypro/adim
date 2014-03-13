<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace front\components;

use core\components\WebUser as CoreWebUser;
use user\models\User;

/**
 * Class WebUser
 *
 * @package front\components
 */
class WebUser extends CoreWebUser
{
	/**
	 * Social login url
	 *
	 * @var string
	 */
	public $socialLoginUrl = array('/user/default/social');

	/**
	 * General user login url
	 *
	 * @var string
	 */
	public $logoutUrl = array('/user/default/logout');

	public $loginUrl = array('/user/default/login');

	public $ajaxLoginUrl = array('/user/default/ajaxLogin');

	public $ajaxSignUpUrl = array('/user/default/ajaxSignUp');

	/**
	 * User model
	 *
	 * @var null
	 */
	protected $_model = null;

	/**
	 * Get role
	 *
	 * @return null|string
	 */
	public function getRole()
	{
		$model = $this->getModel();
		if (!$model) {
			return null;
		}
		return $model->role;
	}

	public function getName()
	{
		$name = parent::getName();
		return \CHtml::encode($name);
	}

	/**
	 * Get user page url
	 *
	 * @param array $params
	 *
	 * @return array
	 */
	public function getPageUrl($params = array())
	{
		$model = $this->getModel();
		if (!$model) {
			return null;
		}
		return $model->getPageUrl($params);
	}

	/**
	 * @return User|null
	 */
	public function getModel()
	{
		if (!$this->isGuest && $this->_model === null) {
			$this->_model = User::model()->findByPk($this->id);
			if ($this->_model == null) {
				$this->logout();
			}
		}
		return $this->_model;
	}
}
