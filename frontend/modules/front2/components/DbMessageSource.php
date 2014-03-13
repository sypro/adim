<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace front2\components;

/**
 * Class DbMessageSource
 * @package front2\components
 */
class DbMessageSource extends \CDbMessageSource
{
	/**
	 * @var string the name of the source message table. Defaults to 'SourceMessage'.
	 */
	public $sourceMessageTable = '{{source_message}}';

	/**
	 * @var string the name of the translated message table. Defaults to 'Message'.
	 */
	public $translatedMessageTable = '{{message}}';
}
