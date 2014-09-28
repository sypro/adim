<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace core\helpers;

/**
 * Class Core
 *
 * @package core\helpers
 */
class Core 
{
	public static function genHashPassword($salt, $password)
	{
		return md5($salt . md5($password));
	}

	public static function genSalt($len = 32)
	{
		$len = $len > 32 ? 32 : $len;
		return mb_substr(uniqid(mt_rand(), true), 0, $len);
	}
}
