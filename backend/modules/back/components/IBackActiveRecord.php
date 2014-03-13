<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace back\components;

/**
 * Interface IBackActiveRecord
 *
 * @package back\components
 */
interface IBackActiveRecord
{
	public function genAdminMenu($page);

	public function genAdminBreadcrumbs($page);

	public function genPageName($page);

	public function genColumns($page);

	public function search($pageSize = false);

	public function getFormConfig();
}
