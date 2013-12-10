<?php defined('SYSPATH') or die('No direct script access.');

class Model_News_Content extends Jelly_Model{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('news_contents');
 
		// Fields defined by the model
		$meta->fields(array(
			'id'   => Jelly::field('primary'),
			'name' => Jelly::field('string'),
			'friendly_url' => Jelly::field('string'),
			'intro_text' => Jelly::field('text'),
			'content' => Jelly::field('text'),
			'image_path' => Jelly::field('string'),
			'date_created' => Jelly::field('timestamp', array(
				'auto_now_create' => TRUE,
			)),
			'page_title' => Jelly::field('text'),
			'meta_keywords' => Jelly::field('text'),
			'meta_description' => Jelly::field('text'),

			'news_category' => Jelly::field('belongsto', array(
				'column' => 'news_category_id',
				'foreign' => 'news_category',
			)),
		));
	}
} // End Model News Content
