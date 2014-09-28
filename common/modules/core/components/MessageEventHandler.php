<?php
/**
 * Author: metal
 * Email: metal
 */

namespace common\modules\core\components;

use translate\models\MessageMissing;

/**
 * Class MessageEventHandler
 * @package common\modules\core\components
 */
class MessageEventHandler
{
	/**
	 * @param \CMissingTranslationEvent $event
	 */
	public static function handleMissingTranslation($event)
	{
		$missing = new MessageMissing();
		$missing->application_id = app()->getId();
		$missing->category = $event->category;
		$missing->language = $event->language;
		$missing->message = $event->message;
		$missing->save();
	}
} 
