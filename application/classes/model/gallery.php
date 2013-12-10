<?php defined('SYSPATH') or die('No direct script access.');

class Model_Gallery extends Jelly_Model{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('galleries');
 
		// Fields defined by the model
		$meta->fields(array(
			'id'   => Jelly::field('primary'),
			'name' => Jelly::field('string'),
			'url_name' => Jelly::field('string'),
			'title' => Jelly::field('text'),
			'meta_keyword' => Jelly::field('text'),
			'meta_description' => Jelly::field('text'),

			'language' => Jelly::field('belongsto', array(
				'column' => 'language_id',
				'foreign' => 'language',
			)),

			'city' => Jelly::field('belongsto', array(
				'column' => 'city_id',
				'foreign' => 'city',
			)),
		));
	}    
}
