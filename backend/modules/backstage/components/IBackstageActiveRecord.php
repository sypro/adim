<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace backstage\components;

/**
 * Interface IBackstageActiveRecord
 *
 * @package backstage\components
 */
interface IBackstageActiveRecord
{
	public function genAdminMenu($page);

	public function genAdminBreadcrumbs($page);

	public function genPageName($page);

	public function genColumns($page);

	public function search($pageSize = false);

	public function getFormConfig();
}
