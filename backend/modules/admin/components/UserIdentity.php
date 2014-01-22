<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace admin\components;

use core\components\UserIdentity as CoreUserIdentity;
use admin\models\User;

/**
 * Class UserIdentity
 *
 * @package admin\components
 */
class UserIdentity extends CoreUserIdentity
{
	/**
	 * Authenticates the user.
	 *
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		/** @var User $record */
		$record = User::model()->findByAttributes(array('email' => $this->username,));
		if ($record === null) {
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		} elseif (!$record->validatePassword($this->password)) {
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		} else {
			$this->_id = $record->id;
			$this->setState('login', $record->email);
			$this->setState('name', $record->name);
			$this->errorCode = self::ERROR_NONE;
		}

		return !$this->errorCode;
	}
}
