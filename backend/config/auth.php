<?php
/**
 * Author: Ivan Pushkin
 * Email: metal@vintage.com.ua
 */
return array(
	'guest' => array(
		'type' => \CAuthItem::TYPE_ROLE,
		'description' => 'Guest',
		'bizRule' => null,
		'data' => null
	),
	'admin' => array(
		'type' => \CAuthItem::TYPE_ROLE,
		'description' => 'Administrator',
		'children' => array(
			'guest',
		),
		'bizRule' => null,
		'data' => null
	),
);
