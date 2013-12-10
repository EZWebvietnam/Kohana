<?php defined('SYSPATH') or die('No direct script access.');

class Model_Product_Image extends Jelly_Model{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('product_images');
 
		// Fields defined by the model
		$meta->fields(array(
			'id'   => Jelly::field('primary'),
			'name' => Jelly::field('string'),
			'file_path' => Jelly::field('string'),
			'content_type' => Jelly::field('string'),
			'date_created' => Jelly::field('timestamp', array(
				'auto_now_create' => TRUE,
			)),

			'product' => Jelly::field('belongsto', array(
				'column' => 'product_id',
				'foreign' => 'product',
			)),
		));
	}
} // End Model Language
