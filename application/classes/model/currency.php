<?php defined('SYSPATH') or die('No direct script access.');

class Model_Currency extends Jelly_Model{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('currencies');
 
		// Fields defined by the model
		$meta->fields(array(
			'id'   => Jelly::field('primary'),
			'name' => Jelly::field('string'),
			'short_name' => Jelly::field('string'),
			'symbol' => Jelly::field('string'),
			'rate' => Jelly::field('float'),
			'sort_order' => Jelly::field('integer'),
		));
	}
} // End Model Origin
