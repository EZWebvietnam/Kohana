<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Front_Search extends Controller_Front {
	private $breadcrumb = array();
	
	public function before()
	{
		parent::before();
		$item = new Data_Breadcrumb;
		$item->url = URL::site();
		$item->name = 'Trang Chủ';
		$this->breadcrumb[] = $item;

		$item = new Data_Breadcrumb;
		$item->url = URL::site('products');
		$item->name = 'Tìm Kiếm';
		$this->breadcrumb[] = $item;
	}

	public function action_index()
	{
		$keywords = trim($this->request->post('keywords'));
		if(empty($keywords)){
			$this->request->redirect('products');
		}else{
			$this->_session['search_keywords'] = trim($keywords);
			$this->request->redirect('search/result');
		}
	}

	public function action_result()
	{
		$keywords = $this->_session['search_keywords'];
		View::bind_global('search_keywords', $keywords);
		
		$jelly_query = Jelly::query('product')->filter_all($keywords, array('name', 'sort_description', 'description'));
		$pagination = Pagination::factory(Kohana::$config->load('pagination.product'));
		$pagination->total_items = $jelly_query->count();
		$items_per_page = Kohana::$config->load('pagination.product.items_per_page');

		$this->view()->content(
			View::factory('front/product/index')
				->bind('pagination', $pagination)
				->set('products', $jelly_query->paging($pagination->offset, $items_per_page)->select())
		);
	}
} // End Controller Front Search
