<?php defined('SYSPATH') or die('No direct script access.');

class Model_Builder_Product_Image extends Model_Builder_Core{
	public function by_product($product = NULL)
	{
		$product_id = ($product instanceof Jelly_Model) ? (int) $product->product_id : (int) $product;
		if($product_id > 0) $this->where('product_id', '=', $product_id);
		return $this;
	}

	public function list_by_product($product = NULL)
	{
		$product_id = ($product instanceof Jelly_Model) ? (int) $product->product_id : (int) $product;
		return $this->where('product_id', '=', $product_id);
	}

	public function delete_by_product(array $arr_product_id = array(), $db = NULL)
	{
		$db = $this->_db($db);
		return $this->_build(Database::DELETE)->where('product_id', 'IN', $arr_product_id)->execute($db);
	}
}