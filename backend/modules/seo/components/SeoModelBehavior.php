<?php
/**
 *
 */

namespace seo\components;

use language\helpers\Lang;
use seo\models\Seo;

/**
 * Class SeoModelBehavior
 *
 * @package seo\components
 */
class SeoModelBehavior extends \CActiveRecordBehavior
{
	/**
	 * @var Seo seo data for current owner
	 */
	private $_seo;

	/**
	 * @param \CModelEvent $event
	 *
	 * @return bool|void
	 */
	public function afterSave($event)
	{
		parent::afterSave($event);

		$modelName = \CHtml::modelName(Seo::getClassName());
		if (isset($_POST[$modelName]) && is_array($_POST[$modelName])) {
			$ownerPK = $this->getOwnerPK();
			$ownerClass = get_class($this->owner);

			foreach (Lang::getLanguageKeys() as $key) {
				if (isset($_POST[$modelName][$key])) {
					$seoData = $this->getSeoData($key);
					if (!$seoData) {
						$seoData = new Seo('insert');
					}
					$seoData->setAttributes($_POST[$modelName][$key]);
					$seoData->setAttributes(
						array(
							'model_name' => $ownerClass,
							'model_id' => $ownerPK,
							'lang_id' => $key,
						)
					);
					$seoData->save();
				}
			}
		}

		return true;
	}

	/**
	 * @param bool $lang
	 *
	 * @return array|Seo
	 */
	public function getSeoData($lang = false)
	{
		if ($lang) {
			$ownerPK = $this->getOwnerPK();
			$ownerClass = get_class($this->owner);
			//gets SEO data for owner model
			$seoData = Seo::model()->findByPk(
				array(
					'model_name' => $ownerClass,
					'model_id' => $ownerPK,
					'lang_id' => $lang,
				)
			);
			//if no SEO data, then create new record
			if (!$seoData) {
				$seoData = new Seo();
				$seoData->setAttributes(
					array(
						'model_name' => $ownerClass,
						'model_id' => $ownerPK,
						'lang_id' => $lang,
					)
				);
			}

			return $seoData;
		} else {
			$ownerPK = $this->getOwnerPK();
			$ownerClass = get_class($this->owner);
			$seoData = array();
			foreach (Lang::getLanguageKeys() as $key) {
				$seoData[$key] = $this->owner->isNewRecord
					? null
					: Seo::model()->findByPk(
						array(
							'model_name' => $ownerClass,
							'model_id' => $ownerPK,
							'lang_id' => $key,
						)
					);
				if (!$seoData[$key]) {
					$seoData[$key] = new Seo();
				}
				$seoData[$key]->setAttributes(
					array(
						'model_name' => $ownerClass,
						'model_id' => $ownerPK,
						'lang_id' => $key,
					)
				);
			}

			return $seoData;
		}
	}

	/**
	 * Return owner model PK, converted to string
	 *
	 * @return String
	 */
	private function getOwnerPK()
	{
		if (is_array($this->owner->primaryKey)) {
			return implode('.', $this->owner->primaryKey);
		} else {
			return $this->owner->primaryKey === null ? 0 : $this->owner->primaryKey;
		}
	}
}
