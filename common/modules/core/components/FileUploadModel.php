<?php
/**
 * Author: metal
 * Email: metal
 */

namespace core\components;

/**
 * Class FileUploadModel
 *
 * @package core\components
 */
class FileUploadModel extends FormModel
{
	/**
	 * Upload file attribute
	 *
	 * @var
	 */
	public $upload;

	/**
	 * Can attribute be empty
	 *
	 * @var bool
	 */
	public $allowEmpty = false;

	/**
	 * Allowed file types
	 *
	 * @var string | array
	 */
	public $fileTypes;

	/**
	 * @var mixed a list of MIME-types of the file that are allowed to be uploaded.
	 * This can be either an array or a string consisting of MIME-types separated
	 * by space or comma (e.g. "image/gif, image/jpeg"). MIME-types are
	 * case-insensitive. Defaults to null, meaning all MIME-types are allowed.
	 * In order to use this property fileinfo PECL extension should be installed.
	 * @since 1.1.11
	 */
	public $mimeTypes;

	/**
	 * @var integer the minimum number of bytes required for the uploaded file.
	 * Defaults to null, meaning no limit.
	 * @see tooSmall
	 */
	public $minSize;

	/**
	 * @var integer the maximum number of bytes required for the uploaded file.
	 * Defaults to null, meaning no limit.
	 * Note, the size limit is also affected by 'upload_max_filesize' INI setting
	 * and the 'MAX_FILE_SIZE' hidden field value.
	 * @see tooLarge
	 */
	public $maxSize;

	/**
	 * @var string the error message used when the uploaded file is too large.
	 * @see maxSize
	 */
	public $tooLarge;

	/**
	 * @var string the error message used when the uploaded file is too small.
	 * @see minSize
	 */
	public $tooSmall;

	/**
	 * @var string the error message used when the uploaded file has an extension name
	 * that is not listed among {@link types}.
	 */
	public $wrongType;

	/**
	 * @var string the error message used when the uploaded file has a MIME-type
	 * that is not listed among {@link mimeTypes}. In order to use this property
	 * fileinfo PECL extension should be installed.
	 * @since 1.1.11
	 */
	public $wrongMimeType;

	/**
	 * @return array
	 */
	public function rules()
	{
		return array(
			array(
				'upload',
				'file',
				'types' => $this->fileTypes,
				'allowEmpty' => $this->allowEmpty,
				'safe' => false,
				'mimeTypes' => $this->mimeTypes,
				'minSize' => $this->minSize,
				'maxSize' => $this->maxSize,
				'tooLarge' => $this->tooLarge,
				'tooSmall' => $this->tooSmall,
				'wrongType' => $this->wrongType,
				'wrongMimeType' => $this->wrongMimeType,
			),
		);
	}
}
