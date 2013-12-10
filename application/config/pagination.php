<?php defined('SYSPATH') or die('No direct script access.');

return array(

	// Application defaults
	'default' => array(
		'current_page'      => array('source' => 'route', 'key' => 'pagination'), // source: "query_string" or "route"
		'total_items'       => 0,
		'items_per_page'    => 10,
		'view'              => 'pagination/floating',
		'auto_hide'         => TRUE,
		'first_page_in_url' => FALSE,
	),

	'product' => array(
		'current_page'      => array('source' => 'route', 'key' => 'pagination'), // source: "query_string" or "route"
		'total_items'       => 0,
		'items_per_page'    => 6,
		'view'              => 'pagination/product',
		'auto_hide'         => TRUE,
		'first_page_in_url' => FALSE,
	),

	'product_special' => array(
		'current_page'      => array('source' => 'route', 'key' => 'pagination'), // source: "query_string" or "route"
		'total_items'       => 0,
		'items_per_page'    => 3,
		'view'              => 'pagination/product',
		'auto_hide'         => TRUE,
		'first_page_in_url' => FALSE,
	),

	'news' => array(
		'current_page'      => array('source' => 'route', 'key' => 'pagination'), // source: "query_string" or "route"
		'total_items'       => 0,
		'items_per_page'    => 10,
		'view'              => 'pagination/news',
		'auto_hide'         => TRUE,
		'first_page_in_url' => FALSE,
	),
);
