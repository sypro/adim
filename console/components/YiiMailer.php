<?php
/**
 *
 */

namespace console\components;

use CException;
use Exception;
use PHPMailer;
use phpmailerException;

/**
 * YiiMailer class - wrapper for PHPMailer
 * Yii extension for sending emails using views and layouts
 * https://github.com/vernes/YiiMailer
 * Copyright (c) 2013 YiiMailer
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 *
 * @package YiiMailer
 * @author Vernes Šiljegović
 * @copyright  Copyright (c) 2013 YiiMailer
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version 1.5, 2013-06-03
 */
class YiiMailer extends PHPMailer
{
	/**
	 * The From email address for the message.
	 * @type string
	 */
	public $From = 'noreply@domain.com';

	/**
	 * The From name of the message.
	 * @type string
	 */
	public $FromName = 'noreply';

	/**
	 * Sets the CharSet of the message.
	 *
	 * @var string
	 */
	public $CharSet = 'UTF-8';

	/**
	 * @var bool
	 */
	public $testMode = false;

	/**
	 * @var string
	 */
	public $savePath = 'console.runtime';

	/**
	 * @var string
	 */
	public $ContentType = 'text/html';

	/**
	 * Set and configure initial parameters
	 *
	 */
	public function __construct($config = array(), $exceptions = false)
	{
		parent::__construct($exceptions);
		$this->setConfig($config);
	}

	/**
	 * Configure parameters
	 *
	 * @param array $config Config parameters
	 *
	 * @throws CException
	 */
	private function setConfig(array $config = array())
	{
		foreach ($config as $key => $val) {
			$this->$key = $val;
		}
	}

	/**
	 * Set From address and name
	 *
	 * @param string $address Email address of the sender
	 * @param string $name Name of the sender
	 * @param boolean $auto Also set the Reply-To
	 *
	 * @return boolean True on success, false if address not valid
	 */
	public function setFrom($address, $name = '', $auto = true)
	{
		return parent::SetFrom($address, $name, (int)$auto);
	}

	/**
	 * Set one or more email addresses to send to
	 * Valid arguments:
	 * $mail->setTo('john@example.com');
	 * $mail->setTo(array('john@example.com','jane@example.com'));
	 * $mail->setTo(array('john@example.com'=>'John Doe','jane@example.com'));
	 *
	 * @param mixed $addresses Email address or array of email addresses
	 *
	 * @return boolean True on success, false if addresses not valid
	 */
	public function setTo($addresses)
	{
		$this->ClearAddresses();

		return $this->setAddresses('to', $addresses);
	}

	/**
	 * Set one or more CC email addresses
	 *
	 * @param mixed $addresses Email address or array of email addresses
	 *
	 * @return boolean True on success, false if addresses not valid
	 */
	public function setCc($addresses)
	{
		$this->ClearCCs();

		return $this->setAddresses('cc', $addresses);
	}

	/**
	 * Set one or more BCC email addresses
	 *
	 * @param mixed $addresses Email address or array of email addresses
	 *
	 * @return boolean True on success, false if addresses not valid
	 */
	public function setBcc($addresses)
	{
		$this->ClearBCCs();

		return $this->setAddresses('bcc', $addresses);
	}

	/**
	 * Set one or more Reply-To email addresses
	 *
	 * @param mixed $addresses Email address or array of email addresses
	 *
	 * @return boolean True on success, false if addresses not valid
	 */
	public function setReplyTo($addresses)
	{
		$this->ClearReplyTos();

		return $this->setAddresses('Reply-To', $addresses);
	}

	/**
	 * Set one or more email addresses of different kinds
	 *
	 * @param string $type Type of the recipient (to, cc, bcc or Reply-To)
	 * @param mixed $addresses Email address or array of email addresses
	 *
	 * @return boolean True on success, false if addresses not valid
	 */
	private function setAddresses($type, $addresses)
	{
		if (!is_array($addresses)) {
			$addresses = (array)$addresses;
		}

		$result = true;
		foreach ($addresses as $key => $value) {
			if (is_int($key)) {
				$r = $this->AddAnAddress($type, $value);
			} else {
				$r = $this->AddAnAddress($type, $key, $value);
			}
			if ($result && !$r) {
				$result = false;
			}
		}

		return $result;
	}

	/**
	 * Set subject of the email
	 *
	 * @param string $subject Subject of the email
	 */
	public function setSubject($subject)
	{
		$this->Subject = $subject;
	}

	/**
	 * Set text body of the email
	 *
	 * @param string $body Textual body of the email
	 */
	public function setBody($body)
	{
		$this->Body = $body;
	}

	/**
	 * Set one or more email attachments
	 * Valid arguments:
	 * $mail->setAttachment('something.pdf');
	 * $mail->setAttachment(array('something.pdf','something_else.pdf','another.doc'));
	 * $mail->setAttachment(array('something.pdf'=>'Some file','something_else.pdf'=>'Another file'));
	 *
	 * @param mixed $attachments Path to the file or array of files to attach
	 *
	 * @return boolean True on success, false if addresses not valid
	 */
	public function setAttachment($attachments)
	{
		if (!is_array($attachments)) {
			$attachments = (array)$attachments;
		}

		$result = true;
		foreach ($attachments as $key => $value) {
			if (is_int($key)) {
				$r = $this->AddAttachment($value);
			} else {
				$r = $this->AddAttachment($key, $value);
			}
			if ($result && !$r) {
				$result = false;
			}
		}

		return $result;
	}

	/**
	 * Clear all recipients and attachments
	 */
	public function clear()
	{
		$this->ClearAllRecipients();
		$this->ClearReplyTos();
		$this->ClearAttachments();
	}

	/**
	 * Get current error message
	 *
	 * @return string Error message
	 */
	public function getError()
	{
		return $this->ErrorInfo;
	}

	/**
	 * Render message and send emails
	 *
	 * @throws Exception
	 * @throws phpmailerException
	 * @return boolean True if sent successfully, false otherwise
	 */
	public function send()
	{
		//send the message
		try {
			//prepare the message
			if (!$this->PreSend()) {
				return false;
			}

			//in test mode, save message as a file
			if ($this->testMode) {
				return $this->save();
			} else {
				return $this->PostSend();
			}
		} catch (phpmailerException $e) {
			$this->mailHeader = '';
			$this->SetError($e->getMessage());
			if ($this->exceptions) {
				throw $e;
			}

			return false;
		}
	}

	/**
	 * Save message as eml file
	 *
	 * @throws CException
	 * @return boolean True if saved successfully, false otherwise
	 */
	public function save()
	{
		$filename = date('YmdHis') . '_' . uniqid() . '.eml';
		$dir = \Yii::getPathOfAlias($this->savePath);
		//check if dir exists and is writable
		if (!is_writable($dir)) {
			throw new CException('Directory "' . $dir . '" does not exist or is not writable!');
		}

		try {
			$file = fopen($dir . DIRECTORY_SEPARATOR . $filename, 'w+');
			fwrite($file, $this->GetSentMIMEMessage());
			fclose($file);

			return true;
		} catch (Exception $e) {
			$this->SetError($e->getMessage());

			return false;
		}
	}
}
