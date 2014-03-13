<?php
/**
 *
 */

namespace front\components;

use \core\components\HttpRequest as CoreHttpRequest;

/**
 * Class HttpRequest
 *
 * @package front\components
 */
class HttpRequest extends CoreHttpRequest
{
	/**
	 * @var array
	 */
	public $noCsrfValidationUrls = array();

	/**
	 *
	 */
	protected function normalizeRequest()
	{
		parent::normalizeRequest();
		if ($this->getIsPostRequest()) {
			if ($this->enableCsrfValidation && $this->checkPaths() !== false) {
				app()->detachEventHandler('onBeginRequest', array($this, 'validateCsrfToken'));
			}
		}
	}

	/**
	 * @return bool
	 */
	private function checkPaths()
	{
		foreach ($this->noCsrfValidationUrls as $checkPath) {
			// allows * in check path
			if (strstr($checkPath, "*")) {
				$pos = strpos($checkPath, "*");
				$checkPath = substr($checkPath, 0, $pos);
				if (strstr($this->pathInfo, $checkPath)) {
					return true;
				}
			} else {
				if ($this->pathInfo == $checkPath) {
					return true;
				}
			}
		}

		return false;
	}
}
