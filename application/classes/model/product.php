<?php defined('SYSPATH') or die('No direct script access.');

class Model_Product extends Jelly_Model{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('products');
 
		// Fields defined by the model
		$meta->fields(array(
			'id'   => Jelly::field('primary'),
			'sku' => Jelly::field('string'),
			'name' => Jelly::field('string'),
			'sort_description' => Jelly::field('string'),
			'description' => Jelly::field('string'),
			'thumb_image' => Jelly::field('string'),
			'full_image' => Jelly::field('string'),
			'friendly_url' => Jelly::field('string'),
			'price' => Jelly::field('integer'),
			'special' => Jelly::field('integer'),
			'capacity' => Jelly::field('integer'),
			'alcohol_level' => Jelly::field('integer'),
			'color' => Jelly::field('string'),
			'production_year' => Jelly::field('integer'),
			'views' => Jelly::field('integer'),
			'date_created' => Jelly::field('timestamp', array(
				'auto_now_create' => TRUE,
			)),
			'page_title' => Jelly::field('text'),
			'meta_keywords' => Jelly::field('text'),
			'meta_description' => Jelly::field('text'),

			'product_category' => Jelly::field('belongsto', array(
				'column' => 'product_category_id',
				'foreign' => 'product_category',
			)),

			'manufacturer' => Jelly::field('belongsto', array(
				'column' => 'manufacturer_id',
				'foreign' => 'manufacturer',
			)),

			'origin' => Jelly::field('belongsto', array(
				'column' => 'origin_id',
				'foreign' => 'origin',
			)),

			'images' => Jelly::field('hasmany', array(
				'foreign' => 'product_image',
			)),
		));
	}    
}
