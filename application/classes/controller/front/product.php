<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Front_Product extends Controller_Front {
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
		$item->name = 'Sản Phẩm';
		$this->breadcrumb[] = $item;
	}

	public function action_index()
	{
		$jelly_query = Jelly::query('product')->sort_date_created();
		$pagination = Pagination::factory(Kohana::$config->load('pagination.product'));
		$pagination->total_items = $jelly_query->count();
		$items_per_page = Kohana::$config->load('pagination.product.items_per_page');

		View::bind_global('breadcrumb', $this->breadcrumb);
		$this->view()->content(
			View::factory('front/product/index')
				->bind('pagination', $pagination)
				->set('products', $jelly_query->paging($pagination->offset, $items_per_page)->select())
		);
	}

	public function action_category()
	{
		$category_id = (int) $this->request->param('id');
		$category = Jelly::query('product_category', $category_id)->select();
		$this->_populate_meta_data($category);
		View::bind_global('product_category_id', $category_id);

		$jelly_query = Jelly::query('product')->list_by_category($category_id);
		$pagination = Pagination::factory(Kohana::$config->load('pagination.product'));
		$pagination->total_items = $jelly_query->count();
		$items_per_page = Kohana::$config->load('pagination.product.items_per_page');

		$item = new Data_Breadcrumb;
		$item->url = URL::site('category/' . $category_id . '_' . Utils::url_lize($category->name));
		$item->name = UTF8::ucwords($category->name);
		$this->breadcrumb[] = $item;
		View::bind_global('breadcrumb', $this->breadcrumb);

		$this->view()->content(
			View::factory('front/product/category')
				->bind('pagination', $pagination)
				->bind('category', $category)
				->set('products', $jelly_query->paging($pagination->offset, $items_per_page)->select())
		);
	}

	public function action_origin()
	{
		$origin_id = (int) $this->request->param('id');
		$origin = Jelly::query('origin', $origin_id)->select();
		View::bind_global('origin_id', $origin_id);

		$jelly_query = Jelly::query('product')->by_origin($origin_id);
		$pagination = Pagination::factory(Kohana::$config->load('pagination.product'));
		$pagination->total_items = $jelly_query->count();
		$items_per_page = Kohana::$config->load('pagination.product.items_per_page');

		$item = new Data_Breadcrumb;
		$item->url = URL::site('origin/' . $origin_id . '_' . $origin->name);
		$item->name = $origin->name;
		$this->breadcrumb[] = $item;
		View::bind_global('breadcrumb', $this->breadcrumb);

		$this->view()->content(
			View::factory('front/product/origin')
				->bind('pagination', $pagination)
				->bind('origin', $origin)
				->set('products', $jelly_query->paging($pagination->offset, $items_per_page)->select())
		);
	}

	public function action_special()
	{
		$jelly_query = Jelly::query('product')->sort_date_created()->list_by_special();
		$pagination = Pagination::factory(Kohana::$config->load('pagination.product_special'));
		$pagination->total_items = $jelly_query->count();
		$items_per_page = Kohana::$config->load('pagination.product_special.items_per_page');

		$item = new Data_Breadcrumb;
		$item->url = URL::site('specials');
		$item->name = 'Sản Phẩm Đặc Biệt';
		$this->breadcrumb[] = $item;
		View::bind_global('breadcrumb', $this->breadcrumb);

		$this->view()->content(
			View::factory('front/product/special')
				->bind('pagination', $pagination)
				->set('products', $jelly_query->paging($pagination->offset, $items_per_page)->select_all())
		);
	}

	public function action_detail()
	{
		$product_id = (int) $this->request->param('id');
		$product = Jelly::query('product', $product_id)->select();
		$this->_populate_meta_data($product);
		if($product->loaded())
		{
			$product->views ++;
			$product->save();
		}

		$product_category = $product->product_category;
		$stack = new Collection_Stack;
		$stack->push($product_category);
		while($product_category->parent->loaded())
		{
			$product_category = $product_category->parent;
			$stack->push($product_category);
		}

		$item = new Data_Breadcrumb;
		$item->url = URL::site('category/' . $product->product_category->id . '_' . Utils::url_lize($product->product_category->name));
		$item->name = UTF8::ucwords($product->product_category->name);
		$this->breadcrumb[] = $item;
		View::bind_global('breadcrumb', $this->breadcrumb);		
		View::bind_global('product_category_id', $product_category->id);

		$this->view()->content(
			View::factory('front/product/detail')
				->bind('product', $product)
				->bind('images', $product->images)
				->set('categories', $stack->to_array())
				->set('other_products', Jelly::query('product')->list_by_other($product_id)->paging(0, 2)->select())
		);
	}
} // End Controller Front Product
