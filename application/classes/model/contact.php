<?php defined('SYSPATH') or die('No direct script access.');

class Model_Contact extends Jelly_Model{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('contacts');
 
		// Fields defined by the model
		$meta->fields(array(
			'id'   => Jelly::field('primary'),
			'name' => Jelly::field('string'),
			'email' => Jelly::field('string'),
			'telephone' => Jelly::field('string'),
			'address' => Jelly::field('text'),
			'subject' => Jelly::field('text'),
			'content' => Jelly::field('text'),
			'date_created' => Jelly::field('timestamp', array(
				'auto_now_create' => TRUE,
			)),
			'read' => Jelly::field('integer'),
			'status' => Jelly::field('integer'),
		));
	}
} // End Model Language
