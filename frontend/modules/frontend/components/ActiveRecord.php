<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace frontend\components;

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
}
