<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */
namespace core\components;

/**
 * Class HttpRequest
 *
 * @package core\components
 */
class HttpRequest extends \CHttpRequest
{
	public $noCsrfValidationRoutes = array();

	protected function normalizeRequest()
	{
		parent::normalizeRequest();
		if ($this->getIsPostRequest()) {
			if ($this->enableCsrfValidation && $this->checkPaths() !== false) {
				app()->detachEventHandler('onBeginRequest', array($this, 'validateCsrfToken'));
			}
		}
	}

	private function checkPaths()
	{
		foreach ($this->noCsrfValidationRoutes as $checkPath) {
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
