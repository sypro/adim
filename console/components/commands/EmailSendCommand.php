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
		$queueItem = EmailQueue::getNextItem();

		if ($queueItem) {
			$email = app()->mail->createEmail();
			$email->setBody($queueItem->body);
			$email->setSubject($queueItem->subject);

			$to = (array)jd($queueItem->to);
			foreach ($to as $address => $name) {
				if (is_int($address)) {
					$email->AddAddress($name);
				} else {
					$email->AddAddress($address, $name);
				}
			}

			if ($email->send()) {
				$queueItem->changeStatus(EmailQueue::STATUS_SENDED);
			} else {
				$queueItem->notSended($email->getError());
			}
		}
	}
}

