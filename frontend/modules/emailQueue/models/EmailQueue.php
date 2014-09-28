<?php
/**
 *
 */

namespace emailQueue\models;

use front\components\ActiveRecord;

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
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subject', 'length', 'max' => 300),
			array('to', 'length', 'max' => 500),
			array('body', 'safe'),
		);
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
	 *
	 * @return bool
	 */
	public static function add($subject, $to, $body, $view = null)
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
		$queue->body = $bodyText;

		return $queue->save();
	}
}
