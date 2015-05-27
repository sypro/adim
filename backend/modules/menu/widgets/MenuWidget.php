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
	/**
	 * @var bool
	 */
	public $fixed = false;

	/**
	 * @var bool
	 */
	public $collapse = true;

	public function init()
	{
		$items = array();

        // $items[] = array('label' => 'Админпанель', 'url' => array('/site/index'));
//        $items[] = array('label' => 'Pages', 'items' => array(
//            array('label' => 'Home', 'url' => array('/admin/user/index'), ),
//            array('label' => 'About', 'url' => array('/admin/user/index'), ),
//            array('label' => 'Gallery', 'url' => array('/admin/user/index'), ),
//            array('label' => 'Principles', 'url' => array('/admin/user/index'), ),
//            array('label' => 'Partners', 'url' => array('/admin/user/index'), ),
//            array('label' => 'Contacts', 'url' => array('/admin/user/index'), ),
//        ), );
        $items[] = array('label' => 'Слайдер', 'url' => array('/slider/default'));

        $items[] = array('label' => 'Партнеры', 'url' => array('/partners/partners'));
        $items[] = array('label' => 'Принципы', 'url' => array('/principles/principles'));
        $items[] = array('label' => 'Заказы', 'url' => array('/page/orders'));

        $items[] = array('label' => 'Галерея', 'items' => array(
            array('label' => 'Категории', 'url' => array('/gallery/gallery'), ),
            array('label' => 'Изображения', 'url' => array('/gallery/image'), ),
        ), );


        $items[] = array('label' => 'Настройки', 'items' => array(
			array('label' => 'Языки', 'url' => array('/language/language/index'), ),
			array('label' => 'Переводы', 'items' => array(
				array('label' => 'Переводы', 'url' => array('/translate/message/index'), ),
				array('label' => 'Оригиналы', 'url' => array('/translate/sourceMessage/index'), ),
				array('label' => 'Не переведенные фразы', 'url' => array('/translate/messageMissing/index'), ),
			),),
			array('label' => 'Конфигурация', 'url' => array('/configuration/configuration/index'), ),
			array('label' => 'Seo', 'url' => array('/seo/seo/index'), ),
			array('label' => 'Почта', 'url' => array('/emailQueue/emailQueue/index'), ),
		));
		$items[] = array('label' => 'Объекты', 'items' => array(

		),);
		$items[] = array('label' => 'Пользователи', 'items' => array(
			array('label' => 'Админ', 'url' => array('/admin/user/index'), ),
		), );

		$items[] = array('label' => 'Выход' .' (' . user()->name . ')', 'url' => array('/admin/user/logout'));

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
