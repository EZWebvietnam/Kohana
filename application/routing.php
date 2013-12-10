<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */
if (!Route::cache())
{
	/** Routing for admin **/
	Route::set('admin_user_page', 'admin/user(/<pagination>)', array('pagination' => '[0-9]+'))
		->defaults(array(
			'directory'  => 'admin',
			'controller' => 'user',
			'action'     => 'index',
			'pagination'       => 1,
		));
		
	Route::set('admin_product_category_page', 'admin/product_category(/<pagination>)', array('pagination' => '[0-9]+'))
		->defaults(array(
			'directory'  => 'admin',
			'controller' => 'product_category',
			'action'     => 'index',
			'pagination'       => 1,
		));
		
	Route::set('admin_manufacturer_page', 'admin/manufacturer(/<pagination>)', array('pagination' => '[0-9]+'))
		->defaults(array(
			'directory'  => 'admin',
			'controller' => 'manufacturer',
			'action'     => 'index',
			'pagination'       => 1,
		));

	Route::set('admin_origin_page', 'admin/origin(/<pagination>)', array('pagination' => '[0-9]+'))
		->defaults(array(
			'directory'  => 'admin',
			'controller' => 'origin',
			'action'     => 'index',
			'pagination'       => 1,
		));

	Route::set('admin_currency_page', 'admin/currency(/<pagination>)', array('pagination' => '[0-9]+'))
		->defaults(array(
			'directory'  => 'admin',
			'controller' => 'currency',
			'action'     => 'index',
			'pagination'       => 1,
		));

	Route::set('admin_product_page', 'admin/product(/<pagination>)', array('pagination' => '[0-9]+'))
		->defaults(array(
			'directory'  => 'admin',
			'controller' => 'product',
			'action'     => 'index',
			'pagination'       => 1,
		));

	Route::set('admin_product_image_page', 'admin/product_image(/<product_id>)', array('product_id' => '[0-9]+'))
		->defaults(array(
			'directory'  => 'admin',
			'controller' => 'product_image',
			'action'     => 'index',
			'product_id'       => 0,
		));

	Route::set('admin_news_category_page', 'admin/news_category(/<pagination>)', array('pagination' => '[0-9]+'))
		->defaults(array(
			'directory'  => 'admin',
			'controller' => 'news_category',
			'action'     => 'index',
			'pagination'       => 1,
		));

	Route::set('admin_news_content_page', 'admin/news_content(/<pagination>)', array('pagination' => '[0-9]+'))
		->defaults(array(
			'directory'  => 'admin',
			'controller' => 'news_content',
			'action'     => 'index',
			'pagination'       => 1,
		));

	Route::set('admin', 'admin(/<controller>(/<action>(/<id>)))')
		->defaults(array(
			'directory'  => 'admin',
			'controller' => 'home',
			'action'     => 'index',
		));

	Route::set('upload_image', 'upload_image(/<action>)')
		->defaults(array(
			'directory'  => 'upload',
			'controller' => 'image',
			'action'     => 'index',
		));

	Route::set('category_pagination', 'category(/<id>(_<friendly_url>(/<pagination>)))', array('id' => '[0-9]+', 'pagination' => '[0-9]+'))
		->defaults(array(
			'directory'		=> 'front',
			'controller'	=> 'product',
			'action'		=> 'category',
			'id'			=> 0,
			'friendly_url'	=> '',
			'pagination'	=> 1,
		));

	Route::set('product_origin', 'origin(/<id>(_<friendly_url>))', array('id' => '[0-9]+'))
		->defaults(array(
			'directory'		=> 'front',
			'controller'	=> 'product',
			'action'		=> 'origin',
			'id'			=> 0,
			'friendly_url'	=> '',
		));

	Route::set('product_origin_pagination', 'origin(/<id>(_<friendly_url>(/<pagination>)))', array('id' => '[0-9]+', 'pagination' => '[0-9]+'))
		->defaults(array(
			'directory'		=> 'front',
			'controller'	=> 'product',
			'action'		=> 'origin',
			'id'			=> 0,
			'friendly_url'	=> '',
			'pagination'	=> 1,
		));

	Route::set('product_category', 'category(/<id>(_<friendly_url>))', array('id' => '[0-9]+'))
		->defaults(array(
			'directory'		=> 'front',
			'controller'	=> 'product',
			'action'		=> 'category',
			'id'			=> 0,
			'friendly_url'	=> '',
		));

	Route::set('product_special_page', 'specials(/<pagination>)', array('pagination' => '[0-9]+'))
		->defaults(array(
			'directory'  => 'front',
			'controller' => 'product',
			'action'     => 'special',
			'pagination'       => 1,
		));

	Route::set('product_search_page', 'search/result(/<pagination>)', array('pagination' => '[0-9]+'))
		->defaults(array(
			'directory'  => 'front',
			'controller' => 'search',
			'action'     => 'result',
			'pagination'       => 1,
		));

	Route::set('product_page', 'products(/<pagination>)', array('pagination' => '[0-9]+'))
		->defaults(array(
			'directory'  => 'front',
			'controller' => 'product',
			'action'     => 'index',
			'pagination'       => 1,
		));

	Route::set('product_detail', 'product(/<id>(_<friendly_url>))', array('id' => '[0-9]+'))
		->defaults(array(
			'directory'		=> 'front',
			'controller'	=> 'product',
			'action'		=> 'detail',
			'id'			=> 0,
			'friendly_url'	=> '',
		));

	Route::set('news_category_pagination', 'news(/<id>(_<friendly_url>(/<pagination>)))', array('id' => '[0-9]+', 'pagination' => '[0-9]+'))
		->defaults(array(
			'directory'		=> 'front',
			'controller'	=> 'news',
			'action'		=> 'category',
			'id'			=> 0,
			'friendly_url'	=> '',
			'pagination'	=> 1,
		));

	Route::set('news_category', 'news(/<id>(_<friendly_url>))', array('id' => '[0-9]+'))
		->defaults(array(
			'directory'		=> 'front',
			'controller'	=> 'news',
			'action'		=> 'category',
			'id'			=> 0,
			'friendly_url'	=> '',
		));

	Route::set('content_detail', 'content(/<id>(_<friendly_url>))', array('id' => '[0-9]+'))
		->defaults(array(
			'directory'		=> 'front',
			'controller'	=> 'news',
			'action'		=> 'detail',
			'id'			=> 0,
			'friendly_url'	=> '',
		));

	/** Routing for front **/
	Route::set('default', '(<controller>(/<action>(/<id>)))')
		->defaults(array(
			'directory'  => 'front',
			'controller' => 'home',
			'action'     => 'index',
		));

	if(Kohana::$environment === Kohana::PRODUCTION)
	{
		// Cache the routes
		Route::cache(TRUE);
	}
}
