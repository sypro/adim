<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace core\components;

/**
 * Class UserIdentity
 *
 * @package core\components
 */
class UserIdentity extends \CBaseUserIdentity
{
	protected $_id;

	public $username;
	public $password;

	public function __construct($username, $password)
	{
		$this->username = $username;
		$this->password = $password;
	}

	/**
	 * Authenticates the user.
	 * 
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$this->errorCode=self::ERROR_UNKNOWN_IDENTITY;
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
