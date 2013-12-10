<?php defined('SYSPATH') or die('No direct script access.');

class Model_Builder_News_Content extends Model_Builder_Core{
	public function by_category($category = NULL)
	{
		$model = $this->_meta->model();
		$news_category_id = ($category instanceof Jelly_Model) ? (int) $category->news_category_id : (int) $category;
		if($news_category_id > 0) $this->where('news_category_id', '=', $news_category_id);
		return $this;
	}

	public function list_by_category($category = NULL)
	{
		$model = $this->_meta->model();
		$news_category_id = ($category instanceof Jelly_Model) ? (int) $category->news_category_id : (int) $category;
		return $this->where('news_category_id', '=', $news_category_id);
	}

	public function delete_by_category(array $arr_category_id = array(), $db = NULL)
	{
		$db = $this->_db($db);
		return $this->_build(Database::DELETE)->where('news_category_id', 'IN', $arr_category_id)->execute($db);
	}
}