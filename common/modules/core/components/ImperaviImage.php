<?php
/**
 * Author: metal
 * Email: metal
 */

namespace core\components;

/**
 * Class ImperaviImage
 *
 * @package core\components
 */
class ImperaviImage extends FileUploadModel
{
	/**
	 * Allowed file types
	 *
	 * @var string | array
	 */
	public $fileTypes = 'png, gif, jpeg, jpg';
}
