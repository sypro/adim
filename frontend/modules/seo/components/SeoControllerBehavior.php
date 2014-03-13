<?php
/**
 *
 */

namespace seo\components;

use front\components\ActiveRecord;
use language\helpers\Lang;

/**
 * Class SeoControllerBehavior
 *
 * @package seo\components
 */
class SeoControllerBehavior extends \CBehavior
{
	/**
	 * @param ActiveRecord $model
	 *
	 * @return null
	 */
	public function registerSEO($model)
	{
		$seoData = $model->getSeoData(Lang::get());

		$pageTitle = $this->getSeoTitle($seoData, $model);
		$this->owner->setPageTitle($pageTitle);

		$pageKeywords = $this->getSeoKeywords($seoData, $model);
		if ($pageKeywords) {
			cs()->registerMetaTag($pageKeywords, 'keywords', 'keywords');
		}

		$pageDescription = $this->getSeoDescription($seoData, $model);
		if ($pageDescription) {
			cs()->registerMetaTag($pageDescription, 'description', 'description');
		}
	}

	private function getSeoTitle($seo, $model)
	{
		$pageTitle = null;
		if (!$seo->isNewRecord) {
			$pageTitle = \CHtml::encode($seo->title);
		}
		if (!$pageTitle && in_array('getSeoTitle', get_class_methods($model->getClassName()))) {
			$pageTitle = \CHtml::encode($model->getSeoTitle());
		}

		if (!$pageTitle && app()->hasModule('seo')) {
			$pageTitle = app()->getModule('seo')->defaultTitle;
		}

		return $pageTitle;
	}

	private function getSeoKeywords($seo, $model)
	{
		$pageKeywords = null;
		if (!$seo->isNewRecord) {
			$pageKeywords = \CHtml::encode($seo->keywords);
		}

		if (!$pageKeywords && in_array('getSeoKeywords', get_class_methods($model->getClassName()))) {
			$pageKeywords = \CHtml::encode($model->getSeoKeywords());
		}

		return $pageKeywords;
	}

	private function getSeoDescription($seo, $model)
	{
		$pageDescription = null;
		if (!$seo->isNewRecord) {
			$pageDescription = \CHtml::encode($seo->description);
		}

		if (!$pageDescription && in_array('getSeoDescription', get_class_methods($model->getClassName()))) {
			$pageDescription = \CHtml::encode($model->getSeoDescription());
		}

		return $pageDescription;
	}
}

