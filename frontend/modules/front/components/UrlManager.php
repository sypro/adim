<?php
/**
 *
 */

namespace front\components;

use core\components\UrlManager as CoreUrlManager;
use language\helpers\Lang;

/**
 * Class LanguageUrlManager
 *
 * @package front\components
 */
class UrlManager extends CoreUrlManager
{
	public $languageVar = 'lang';
	public $exclude = array('gii', );

	public function createUrl($route, $params = array(), $ampersand = '&')
	{
		if (!isset($params[$this->languageVar]) || !Lang::checkLang($params[$this->languageVar], true)) {
			$params[$this->languageVar] = Lang::get(true);
		}

		$r = explode('/', $route);
		if (isset($r[0]) && in_array($r[0], $this->exclude)) {
			unset($params[$this->languageVar]);
		}

		return parent::createUrl($route, $params, $ampersand);
	}

	public function parseUrl($request)
	{
		$route = parent::parseUrl($request);

		$requestLang = r()->getQuery(app()->urlManager->languageVar);

		$r = explode('/', $route);
		if ((isset($r[0]) && in_array($r[0], $this->exclude)) || $requestLang === 'www') {
			$requestLang = 'uk';
		}

		if (is_null($requestLang)) {
			throw new \CHttpException(404, t('Page not found'));
		}

		app()->language = $requestLang;

		return $route;
	}
}

