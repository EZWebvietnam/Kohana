<?php defined('SYSPATH') or die('No direct script access.');

class Model_Origin extends Jelly_Model{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('origins');
 
		// Fields defined by the model
		$meta->fields(array(
			'id'   => Jelly::field('primary'),
			'name' => Jelly::field('string'),
			'description' => Jelly::field('text'),
			'sort_order' => Jelly::field('integer'),
		));
	}
} // End Model Origin
