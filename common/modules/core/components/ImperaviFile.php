<?php
/**
 * Author: metal
 * Email: metal
 */

namespace core\components;

/**
 * Class ImperaviFile
 * @package core\components
 */
class ImperaviFile extends FormModel
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
				'types' => null,
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
