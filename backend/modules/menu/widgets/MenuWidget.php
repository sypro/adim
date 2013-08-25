<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */

namespace menu\widgets;

\Yii::import('bootstrap.widgets.TbNavbar');

/**
 * Class MenuWidget
 * @package menu\widgets
 */
class MenuWidget extends \TbNavbar
{
	public $fixed = false;
	public $collapse = true;

	public function init()
	{
		$items = array();

		$items[] = array('label' => 'Админпанель', 'url' => array('/site/index'));
		$items[] = array('label' => 'Настройки', 'items' => array(
			array('label' => 'Языки', 'url' => array('/language/language/index'), ),
			array('label' => 'Переводы', 'items' => array(
				array('label' => 'Переводы', 'url' => array('/translate/message/index'), ),
				array('label' => 'Оригиналы', 'url' => array('/translate/sourceMessage/index'), ),
			),),
			array('label' => 'Конфигурация', 'url' => array('/configuration/configuration/index'), ),
			array('label' => 'Seo', 'url' => array('/seo/seo/index'), ),
		));
		$items[] = array('label' => 'Объекты', 'items' => array(

		),);
		$items[] = array('label' => 'Пользователи', 'items' => array(
			array('label' => 'Админ', 'url' => array('/user/user/index'), ),
		), );

		$items[] = array('label' => 'Выход' .' (' . user()->name . ')', 'url' => array('/user/user/logout'));

		$this->items = array(
			array(
				'class' => 'bootstrap.widgets.TbMenu',
				'items' => user()->getIsAdmin() ? $items : array(),
			),
		);

		parent::init();

		if (!$this->brand) {
			$this->brand = app()->name;
		}
		if (!$this->brandUrl) {
			$this->brandUrl = app()->homeUrl;
		}
	}
}
