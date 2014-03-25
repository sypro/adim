<?php
/**
 * Author: metal
 * Email: metal
 */

namespace core\components;

/**
 * Class ImperaviImage
 * @package core\components
 */
class ImperaviImage extends FormModel
{
	public $upload;

	/**
	 * @return array
	 */
	public function rules()
	{
		return array(
			array(
				'upload',
				'file',
				'types' => 'png, gif, jpeg, jpg',
				'allowEmpty' => false,
				'safe' => false,
				'mimeTypes' => null,
				'minSize' => null,
				'maxSize' => null,
				'tooLarge' => null,
				'tooSmall' => null,
				'wrongType' => null,
				'wrongMimeType' => null,
			),
		);
	}
}
