<?php defined('SYSPATH') or die('No direct script access.');

class Data_Menu_Params implements serializable{
	public $url_name = '';
	public $news_category_id = 0;
	public $news_content_id = 0;
	public $product_category_id = 0;
	public $product_id = 0;

	public function serialize()
	{
		foreach (array('url_name', 'news_category_id', 'news_content_id', 'product_category_id', 'product_id') as $var)
		{
			$data[$var] = $this->{$var};
		}

		return serialize($data);
	}

	public function unserialize($data)
	{
		foreach (unserialize($data) as $name => $var)
		{
			$this->{$name} = $var;
		}
	}
}
