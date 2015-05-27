<?php
/**
 * @var $this \back\components\BackController
 * @var $model \back\components\IBackActiveRecord|\back\components\ActiveRecord
 */
// $this->breadcrumbs = $model->genAdminBreadcrumbs('index');

// $this->menu = $model->genAdminMenu('index');

// $box = $this->beginWidget('bootstrap.widgets.TbBox', $model->genPageName('index'));

// if ($model->asa('seo')) {
// 	$this->widget('bootstrap.widgets.TbButton', array(
// 		'label' => t('Page list SEO configuration'),
// 		'type' => 'primary',
// 		'size' => 'small',
// 		'htmlOptions' => array(
// 			'class' => 'toggle-item',
// 			'data-id' => 'toggle-seo-box',
// 		),
// 	));
// 	echo \CHtml::openTag('div', array('id' => 'toggle-seo-box', ));
// 	$this->widget(\seo\widgets\seoWidget\SeoWidget::getClassName(), array('model' => $model, ));
// 	echo \CHtml::closeTag('div');
// }

// $this->widget('bootstrap.widgets.TbExtendedGridView',array(
// 	'id' => class2id(get_class($model)) . '-grid main-page-grid',
// 	'type' => 'striped bordered',
// 	'dataProvider' => $model->resetScope()->search(),
// 	'filter' => $model,
// 	'bulkActions' => array(
// 		'actionButtons' => array(
// 			array(
// 				'buttonType' => 'button',
// 				'id' => 'visible',
// 				'type' => 'action',
// 				'size' => 'small',
// 				'label' => 'Показать',
// 			),
// 			array(
// 				'buttonType' => 'button',
// 				'id' => 'unvisible',
// 				'type' => 'action',
// 				'size' => 'small',
// 				'label' => 'Скрыть',
// 			),
// 			array(
// 				'buttonType' => 'button',
// 				'id' => 'publish',
// 				'type' => 'action',
// 				'size' => 'small',
// 				'label' => 'Опубликовать',
// 			),
// 			array(
// 				'buttonType' => 'button',
// 				'id' => 'unpublish',
// 				'type' => 'action',
// 				'size' => 'small',
// 				'label' => 'Снаять с публикации',
// 			),
// 			array(
// 				'buttonType' => 'button',
// 				'id' => 'delete',
// 				'type' => 'action',
// 				'size' => 'small',
// 				'label' => 'Удалить',
// 			),
// 		),
// 		'checkBoxColumnConfig' => array(
// 			'name' => 'id'
// 		),
// 	),
// 	'columns' => $model->genColumns('index'),
// ));

// $this->endWidget();

//		$this->render('index',array('orders' =>  Order::model(),'configurations' =>  Configuration::model(),'sliders' =>  Slider::model() ));


// $this->widget(
//     'TbHighCharts',
//     array(
//         'options' => array(
//             'title' => array(
//                 'text' => 'Статистика посещений',
//                 'x' => -20 //center
//             ),
//             'subtitle' => array(
//                 'text' => 'сайта',
//                 'x' -20
//             ),
//             'xAxis' => array(
//                 'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
//             ),
//             'yAxis' => array(
//                 'title' => array(
//                     'text' =>  'Количетво',
//                 ),
//                 'plotLines' => [
//                     [
//                         'value' => 0,
//                         'width' => 1,
//                         'color' => '#808080'
//                     ]
//                 ],
//             ),
//             // 'tooltip' => array(
//             //     'valueSuffix' => '°C'
//             // ),
//             'legend' => array(
//                 'layout' => 'vertical',
//                 'align' => 'right',
//                 'verticalAlign' => 'middle',
//                 'borderWidth' => 0
//             ),
//             'series' => array(
//                 [
//                     'name' => 'Tokyo',
//                     'data' => [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 325.2, 26.5, 23.3, 18.3, 13.9, 9.6]
//                 ],
//                 [
//                     'name' => 'New York',
//                     'data' => [-0.2, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5]
//                 ],
//                 [
//                     'name' => 'Berlin',
//                     'data' => [-0.9, 0.6, 3.5, 8.4, 13.5, 17.0, 18.6, 17.9, 14.3, 9.0, 3.9, 1.0]
//                 ],
//                 [
//                     'name' => 'London',
//                     'data' => [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
//                 ]
//             )
//         ),
//         'htmlOptions' => array(
//             'style' => 'min-width: 310px; height: 400px; margin: 0 auto'
//         )
//     )
// );

$box = $this->beginWidget('bootstrap.widgets.TbBox',  array('title' => 'Последние заказы', 'headerIcon' => 'icon-home'));
$this->widget('bootstrap.widgets.TbExtendedGridView',array(
	'id' => class2id(get_class($orders)) . '-grid main-orders-grid',
	'type' => 'striped bordered',
	'dataProvider' => $orders->resetScope()->search(),
	'columns' => array_slice($orders->genColumns('index'),0,4),
));
$this->endWidget();

$box = $this->beginWidget('bootstrap.widgets.TbBox',  array('title' => 'Конфигурации', 'headerIcon' => 'icon-home'));
$this->widget('bootstrap.widgets.TbExtendedGridView',array(
	'id' => class2id(get_class($configurations)) . '-grid main-configurations-grid',
	'type' => 'striped bordered',
	'dataProvider' => $configurations->resetScope()->search(),
	'filter' => $configurations,
	'columns' => array_slice($configurations->genColumns('index'),0,3),

));
$this->endWidget();

$box = $this->beginWidget('bootstrap.widgets.TbBox',  array('title' => 'Слайдер', 'headerIcon' => 'icon-home'));
$this->widget('bootstrap.widgets.TbExtendedGridView',array(
	'id' => class2id(get_class($sliders)) . '-grid main-sliders-grid',
	'type' => 'striped bordered',
	'dataProvider' => $sliders->resetScope()->search(),
	'filter' => $sliders,
	'columns' => array_slice($sliders->genColumns('index'),1,1),
));
$this->endWidget();

