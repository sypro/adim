<?php
/**
 *
 */

namespace language\components;

use core\components\UrlManager;
use language\helpers\Lang;

/**
 * Class LanguageUrlManager
 *
 * @package language\components
 */
class LanguageUrlManager extends UrlManager
{
	/**
	 * Excluded routes
	 *
	 * @var array
	 */
	public $exclude = array('gii', );

	/**
	 * Language query param
	 *
	 * @var string
	 */
	public $languageVar = 'lang';

	/**
	 * Default language
	 *
	 * @var string
	 */
	public $defaultLanguage = 'ru';

	/**
	 * Show default language in url
	 *
	 * @var bool
	 */
	public $showDefault = false;

	/**
	 * Constructs a URL.
	 *
	 * @param string $route
	 * @param array $params
	 * @param string $ampersand
	 *
	 * @return string
	 */
	public function createUrl($route, $params = array(), $ampersand = '&')
	{
		if (!isset($params[$this->languageVar]) || !Lang::checkLang($params[$this->languageVar], true)) {
			$params[$this->languageVar] = Lang::get();
		}

		$routeArray = explode('/', $route);
		if (isset($routeArray[0]) && in_array($routeArray[0], $this->exclude)) {
			unset($params[$this->languageVar]);
		}

		if (isset($params[$this->languageVar]) && $params[$this->languageVar] === Lang::getDefault()) {
			unset($params[$this->languageVar]);
		}

		return parent::createUrl($route, $params, $ampersand);
	}

	/**
	 * Parsing url
	 *
	 * @param \CHttpRequest $request
	 *
	 * @return string
	 * @throws \CHttpException
	 */
	public function parseUrl($request)
	{
		$route = parent::parseUrl($request);

		$requestLang = r()->getQuery(app()->urlManager->languageVar);

		if ($requestLang && !Lang::checkLang($requestLang)) {
			throw new \CHttpException(404, t('Page not found'));
		}

		if (!$this->showDefault && $requestLang === Lang::getDefault()) {
			throw new \CHttpException(404, t('Page not found'));
		}

		$routeArray = explode('/', $route);
		if (isset($routeArray[0]) && in_array($routeArray[0], $this->exclude)) {
			$requestLang = $this->defaultLanguage;
		}

		if (is_null($requestLang)) {
			$requestLang = Lang::getDefault();
		}

		app()->setLanguage(Lang::getLocale($requestLang));

		return $route;
	}
}

