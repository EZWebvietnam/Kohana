<?php defined('SYSPATH') or die('No direct script access.');

class Model_Builder_Product extends Model_Builder_Core{
	public function by_category($category = NULL)
	{
		$product_category_id = ($category instanceof Jelly_Model) ? (int) $category->product_category_id : (int) $category;
		if($product_category_id > 0) $this->where('product_category_id', '=', $product_category_id);
		return $this;
	}

	public function list_by_category($category = NULL)
	{
		$product_category_id = ($category instanceof Jelly_Model) ? (int) $category->product_category_id : (int) $category;
		return $this->where('product_category_id', '=', $product_category_id);
	}

	public function list_by_special()
	{
		return $this->where('special', '=', 1)->sort_date_created();
	}

	public function list_by_other($product_id = 0)
	{
		return $this->where('id', '<>', $product_id)->sort_date_created();
	}

	public function list_latest($items = 10)
	{
		return $this->offset(0)->limit($items)->sort_date_created();
	}
	
	public function by_manufacturer($manufacturer = NULL)
	{
		$manufacturer_id = ($manufacturer instanceof Jelly_Model) ? (int) $manufacturer->manufacturer_id : (int) $manufacturer;
		if($manufacturer_id > 0) $this->where('manufacturer_id', '=', $manufacturer_id);
		return $this;
	}

	public function by_origin($origin = NULL)
	{
		$origin_id = ($origin instanceof Jelly_Model) ? (int) $origin->origin_id : (int) $origin;
		if($origin_id > 0) $this->where('origin_id', '=', $origin_id);
		return $this;
	}

	public function delete_by_category(array $arr_category_id = array(), $db = NULL)
	{
		$db = $this->_db($db);
		return $this->_build(Database::DELETE)->where('product_category_id', 'IN', $arr_category_id)->execute($db);
	}

	public function delete_by_manufacturer(array $arr_manufacturer_id = array(), $db = NULL)
	{
		$db = $this->_db($db);
		return $this->_build(Database::DELETE)->where('manufacturer_id', 'IN', $arr_manufacturer_id)->execute($db);
	}

	public function delete_by_origin(array $arr_origin_id = array(), $db = NULL)
	{
		$db = $this->_db($db);
		return $this->_build(Database::DELETE)->where('origin_id', 'IN', $arr_origin_id)->execute($db);
	}
}