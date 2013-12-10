<?php defined('SYSPATH') or die('No direct script access.');

abstract class Model_Builder_Core_Parent extends Model_Builder_Core{

	public function by_parent($parent = NULL)
	{
		$model = $this->_meta->model();
		$parent_id = ($parent instanceof Jelly_Model) ? (int) $parent->parent_id : (int) $parent;
		return $this->where('parent_id', '=', $parent_id);
	}

	public function have_children($parent = NULL, $db = NULL)
	{
		$db = $this->_db($db);
		$parent_id = ($parent instanceof Jelly_Model) ? (int) $parent->id : (int) $parent;
		return $this->where('parent_id', '=', $parent_id)->count($db) > 0;
	}
}