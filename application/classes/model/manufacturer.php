<?php defined('SYSPATH') or die('No direct script access.');

class Model_Manufacturer extends Jelly_Model{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('manufacturers');
 
		// Fields defined by the model
		$meta->fields(array(
			'id'   => Jelly::field('primary'),
			'name' => Jelly::field('string'),
			'friendly_url' => Jelly::field('string'),
			'sort_order' => Jelly::field('integer'),
			'website' => Jelly::field('string'),
			'image' => Jelly::field('string'),
			'page_title' => Jelly::field('text'),
			'meta_keywords' => Jelly::field('text'),
			'meta_description' => Jelly::field('text'),
		));
	}    
}
