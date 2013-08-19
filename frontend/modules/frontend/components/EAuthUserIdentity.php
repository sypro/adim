<?php
/**
 *
 */

namespace frontend\components;

use user\models\User;

/**
 * Class EAuthUserIdentity
 *
 * @package frontend\components
 */
class EAuthUserIdentity extends \EAuthUserIdentity
{
	private $_id;

	/**
	 * Authenticates a user based on {@link service}.
	 * This method is required by {@link IUserIdentity}.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		if ($this->service->isAuthenticated) {
			$this->id = $this->service->id;
			$this->name = $this->service->getAttribute('name');

			$this->setState('id', $this->id);
			$this->setState('name', $this->name);
			$this->setState('service', $this->service->serviceName);

			$user = User::model()->findByAttributes(array('identity'=>$this->id, 'service'=>$this->service->serviceName));
			if (!$user) {
				$user = new User('service');
				$user->password = 'no password';
				$user->email = $this->id;
				$user->name = $this->name;
				$user->service = $this->service->serviceName;
				$user->identity = $this->id;
				$user->role = User::ROLE_USER;
				if ($user->save()) {

				}
			}

			$this->_id = $user->id;
			$this->setState('login', $user->email);
			$this->setState('id', $user->id);
			
			$this->errorCode = self::ERROR_NONE;
		}
		else {
			$this->errorCode = self::ERROR_NOT_AUTHENTICATED;
		}
		return !$this->errorCode;
	}

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->_id;
	}
}
