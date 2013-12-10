<?php defined('SYSPATH') or die('No direct script access.');

class Model_Gallery_Image extends Jelly_Model{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('gallery_images');
 
		// Fields defined by the model
		$meta->fields(array(
			'id'   => Jelly::field('primary'),
			'name' => Jelly::field('string'),
			'file_path' => Jelly::field('string'),
			'content_type' => Jelly::field('string'),

			'gallery' => Jelly::field('belongsto', array(
				'column' => 'gallery_id',
				'foreign' => 'gallery',
			)),
		));
	}    
}
