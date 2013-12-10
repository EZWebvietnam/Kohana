<?php defined('SYSPATH') or die('No direct script access.');

class Model_Menu_Item extends Jelly_Model{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('menu_items');
 
		// Fields defined by the model
		$meta->fields(array(
			'id'   => Jelly::field('primary'),
			'name' => Jelly::field('string'),
			'sort_order' => Jelly::field('integer'),
			'item_type' => Jelly::field('integer'),
			'params' => Jelly::field('text'),

			'parent' => Jelly::field('belongsto', array(
				'column' => 'parent_id',
				'foreign' => 'menu_item',
			)),
		));
	}

	public function have_children()
	{
		return Jelly::query('menu_item')->have_children($this->id);
	}
	
	public function params()
	{
		return empty($this->params) ? new Data_Menu_Params : unserialize($this->params);
	}
} // End Model Language
