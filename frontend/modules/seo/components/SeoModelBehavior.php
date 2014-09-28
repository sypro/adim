<?php
/**
 *
 */

namespace seo\components;

use seo\models\Seo;

/**
 * Class SeoModelBehavior
 *
 * @package seo\components
 */
class SeoModelBehavior extends \CActiveRecordBehavior
{
	/**
	 * @param bool $lang
	 *
	 * @return array|Seo
	 */
	public function getSeoData($lang = false)
	{
		$seoData = null;
		$ownerPK = $this->getOwnerPK();
		$ownerClass = get_class($this->owner);
		if ($lang) {
			//gets SEO data for owner model
			$seoData = Seo::model()->findByPk(array(
				'model_name' => $ownerClass,
				'model_id' => $ownerPK,
				'lang_id' => $lang,
			));
		}
		if (!$seoData) {
			$seoData = new Seo();
			$seoData->setAttributes(array(
				'model_name' => $ownerClass,
				'model_id' => $ownerPK,
				'lang_id' => $lang,
			));
		}
		return $seoData;
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
