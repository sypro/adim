<?php
/**
 *
 */

namespace console\components;

use core\components\ActiveRecord;

/**
 * This is the model class for table "{{email_queue}}".
 *
 * The followings are the available columns in table '{{email_queue}}':
 *
 * @property integer $id
 * @property string $subject
 * @property string $to
 * @property string $body
 * @property integer $type
 * @property integer $errors
 * @property integer $last_attempt
 * @property integer $status
 * @property string $last_error
 * @property integer $created
 * @property integer $modified
 */
class EmailQueue extends ActiveRecord
{
	/**
	 * waiting for send
	 */
	const STATUS_WAITING = 0;

	/**
	 * in progress
	 */
	const STATUS_IN_PROGRESS = 1;

	/**
	 * email was send
	 */
	const STATUS_SENDED = 2;

	/**
	 * error while sending
	 */
	const STATUS_ERROR = 3;

	/**
	 * general email
	 */
	const TYPE_GENERAL = 0;

	/**
	 * system emails: errors, logs, other
	 */
	const TYPE_SYSTEM = 1;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 *
	 * @param string $className active record class name.
	 *
	 * @return EmailQueue the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{email_queue}}';
	}

	/**
	 * @param string $subject
	 * @param string $to
	 * @param string $body if array you need setup view file name
	 * @param null $view file name
	 * @param int $type
	 * @param int $status
	 */
	public static function add($subject, $to, $body, $view = null, $type = self::TYPE_GENERAL, $status = self::STATUS_WAITING)
	{
		if ($view && !empty($view) && is_array($body)) {
			$controller = new \CController('email');
			$bodyText = $controller->renderPartial($view, $body, true);
		} else {
			$bodyText = $body;
		}

		$queue = new EmailQueue();
		$queue->subject = $subject;
		$queue->to = json_encode($to);
		$queue->type = $type;
		$queue->status = $status;
		$queue->body = $bodyText;

		return $queue->save();
	}

	/**
	 * @return EmailQueue|null
	 */
	public static function getNextItem()
	{
		/** @var $item EmailQueue */
		$item = EmailQueue::model()->compare('t.status', EmailQueue::STATUS_WAITING)->compare(
			'errors',
			'<' . 10
		)->order('last_attempt ASC')->compare('last_attempt', '<=' . time())->find();
		if ($item) {
			$item->changeStatus(EmailQueue::STATUS_IN_PROGRESS);

			return $item;
		}

		return null;
	}

	/**
	 * @param int $status
	 */
	public function changeStatus($status = self::STATUS_WAITING)
	{
		$this->status = $status;
		$this->last_attempt = time() + 60 * 5;
		$this->save(true, array('status', 'last_attempt',));
		$this->refresh();
	}

	/**
	 * @param $error
	 */
	public function notSended($error)
	{
		$this->last_error = $error;
		$this->status = self::STATUS_ERROR;
		$this->last_attempt = time() + 60 * 5;
		$this->save(true, array('last_error', 'status', 'last_attempt',));
		$this->incErrors();
		$this->refresh();
	}

	/**
	 * return void
	 */
	public function incErrors()
	{
		$this->saveCounters(array('errors' => 1));
	}
}
