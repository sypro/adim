<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace front\components;

use core\components\ActiveRecord as CoreActiveRecord;

/**
 * Abstract class. used to be extended by all other models
 * Contains some general functionality
 *
 * Class ActiveRecord
 *
 * @property integer $created
 * @property integer $modified
 */
abstract class ActiveRecord extends CoreActiveRecord
{
	public function getSeoTitle()
	{
		$title = null;
		if (isset($this->label)) {
			$title = strip_tags($this->label);
		}
		return $title;
	}

	public function getSeoDescription()
	{
		$description = null;
		if (isset($this->announce)) {
			$description = mb_substr(strip_tags($this->announce), 0, 250);
		} elseif (isset($this->description)) {
			$description = mb_substr(strip_tags($this->description), 0, 250);
		}
		return $description;
	}
}
