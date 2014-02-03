<?php
/**
 * Author: metalguardian
 * Email: metalguardian
 */

namespace console\components\commands;

use console\components\EmailQueue;
use console\components\YiiMailer;

/**
 * Class EmailSendCommand
 *
 * @package console\commands
 */
class EmailSendCommand extends \CConsoleCommand
{
	/**
	 * @param array $args
	 *
	 * @return int|void
	 */
	public function run($args)
	{

		$email = EmailQueue::getNextItem();

		if ($email) {
			$mail = new YiiMailer();
			$mail->setBody($email->body);
			$mail->setSubject($email->subject);

			$to = (array)jd($email->to);
			foreach ($to as $address => $name) {
				if (is_int($address)) {
					$mail->AddAddress($name);
				} else {
					$mail->AddAddress($address, $name);
				}
			}

			if ($mail->send()) {
				$email->changeStatus(EmailQueue::STATUS_SENDED);
			} else {
				$email->notSended($mail->getError());
			}
		}
	}
}

