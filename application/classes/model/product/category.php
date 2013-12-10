<?php defined('SYSPATH') or die('No direct script access.');

class Model_Product_Category extends Jelly_Model{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('product_categories');
 
		// Fields defined by the model
		$meta->fields(array(
			'id'   => Jelly::field('primary'),
			'name' => Jelly::field('string'),
			'friendly_url' => Jelly::field('string'),
			'sort_order' => Jelly::field('integer'),
			'description' => Jelly::field('text'),
			'page_title' => Jelly::field('text'),
			'meta_keywords' => Jelly::field('text'),
			'meta_description' => Jelly::field('text'),

			'parent' => Jelly::field('belongsto', array(
				'column' => 'parent_id',
				'foreign' => 'product_category',
			)),

			'products' => Jelly::field('hasmany', array(
				'foreign' => 'product',
			)),
		));
	}

	public function have_children()
	{
		return Jelly::query('product_category')->have_children($this->id);
	}
	
	public function children()
	{
		return Jelly::query('product_category')->by_parent($this->id)->select_all();
	}
} // End Model Product Category
