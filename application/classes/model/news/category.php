<?php defined('SYSPATH') or die('No direct script access.');

class Model_News_Category extends Jelly_Model{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('news_categories');
 
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
				'foreign' => 'news_category',
			)),

			'contents' => Jelly::field('hasmany', array(
				'foreign' => 'news_content',
			)),
		));
	}

	public function have_children()
	{
		return Jelly::query('news_category')->have_children($this->id);
	}
} // End Model News Category
