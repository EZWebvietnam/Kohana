<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Front_News extends Controller_Front {
	private $breadcrumb = array();

	public function before()
	{
		$item = new Data_Breadcrumb;
		$item->url = URL::site();
		$item->name = 'Trang Chủ';
		$this->breadcrumb[] = $item;
		parent::before();
	}

	public function action_index()
	{
	}

	public function action_category()
	{
		$category_id = (int) $this->request->param('id');
		$category = Jelly::query('news_category', $category_id)->select();
		$this->_populate_meta_data($category);

		$jelly_query = Jelly::query('news_content')->list_by_category($category_id)->sort_date_created();
		$pagination = Pagination::factory(Kohana::$config->load('pagination.product'));
		$pagination->total_items = $jelly_query->count();
		$items_per_page = Kohana::$config->load('pagination.product.items_per_page');

		$item = new Data_Breadcrumb;
		$item->url = URL::site('news/' . $category_id . '_' . Utils::url_lize($category->name));
		$item->name = UTF8::ucwords($category->name);
		$this->breadcrumb[] = $item;
		View::bind_global('breadcrumb', $this->breadcrumb);
		View::bind_global('news_category_id', $category_id);

		$this->view()->content(
			View::factory('front/news/category')
				->bind('pagination', $pagination)
				->bind('category', $category)
				->set('contents', $jelly_query->paging($pagination->offset, $items_per_page)->select())
		);
	}

	public function action_detail()
	{
		$product_id = (int) $this->request->param('id');
		$content = Jelly::query('news_content', $product_id)->select();
		$news_category = $content->news_category;
		$this->_populate_meta_data($content);
		
		$stack = new Collection_Stack;
		$stack->push($news_category);
		while($news_category->parent->loaded())
		{
			$news_category = $news_category->parent;
			$stack->push($news_category);
		}

		$item = new Data_Breadcrumb;
		$item->url = URL::site('news/' . $content->news_category->id . '_' . Utils::url_lize($content->news_category->name));
		$item->name = UTF8::ucwords($content->news_category->name);
		$this->breadcrumb[] = $item;
		View::bind_global('breadcrumb', $this->breadcrumb);
		View::bind_global('news_category_id', $category_id);
		
		$this->view()->content(
			View::factory('front/news/detail')
				->bind('content', $content)
				->set('categories', $stack->to_array())
		);
	}
} // End Controller Front News
