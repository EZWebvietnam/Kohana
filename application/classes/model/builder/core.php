<?php defined('SYSPATH') or die('No direct script access.');

abstract class Model_Builder_Core extends Jelly_Builder{

	public function delete_all(array $arr_id = array(), $db = NULL)
    {
		$db = $this->_db($db);
		return $this->_build(Database::DELETE)->where('id', 'IN', $arr_id)->execute($db);
    }

	public function filter_all($filter = '', array $fields = array())
	{
		$model = $this->_meta->model();
		if(!empty($filter) && count($fields) > 0)
		{
			$this->where_open();
			foreach ($fields as $field)
			{
				if($this->_meta->field($field) instanceof Jelly_Field) $this->or_where($field, 'like', '%' . $filter . '%');
			}
			$this->where_close();
		}
		return $this;
	}

	public function paging($offset, $items_per_page = NULL)
	{
		if($items_per_page === null)
		{
			$items_per_page = Kohana::$config->load('pagination.default.items_per_page');
		}
		return $this->offset($offset)->limit((int) $items_per_page);
	}
	
	public function sort_order($order = 'asc')
	{
		return $this->order_by('sort_order', $order);
	}

	public function sort_date_created($order = 'desc')
	{
		return $this->order_by('date_created', $order);
	}
	
	public function select($db = NULL)
	{
		/*$db = $this->_db($db);
		$sql = $this->compile(Database::instance($db));
		echo $sql . "\n";exit;
		$query = $this->_build(Database::SELECT);
		echo $query->compile(Database::instance($db));exit;*/
		return parent::select($db);
	}

	public function select_all($db = NULL)
	{
		return parent::select_all($db);
	}
} // End Model Builder Core