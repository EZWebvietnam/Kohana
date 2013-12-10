<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Admin_Product_Category extends Controller_Admin{

	public function action_index()
	{
		$filter = HTML::chars($this->request->post('product_category_filter'));
		if(!empty($filter))
		{
			$this->_session['product_category_filter'] = $filter;
		}
		else
		{
			$filter = $this->_session['product_category_filter'];
		}

		$parent_id = (int) $this->_session['parent_product_category_id'];

		$pagination = new Pagination;
		$jelly_query = Jelly::query('product_category')
							->filter_all($filter, array('name', 'description'))
							->by_parent($parent_id);

		$pagination->total_items = $jelly_query->count();
		$this->_session['product_category_pagination'] = (int) $pagination->current_page;

		$content = View::factory('admin/product_category/list')
						->bind('product_category_filter', $filter)
						->bind('parent_id', $parent_id)
						->bind('pagination', $pagination)
						->set('product_categories', $jelly_query->paging($pagination->offset)->select());
		$this->_view->content($content);
	}

	public function action_edit(){
		$id = (int) $this->request->param('id');

		$content = View::factory('admin/product_category/edit')
						->set('product_category', Jelly::query('product_category', $id)->select())
						->set('product_category_pagination', $this->_session['product_category_pagination']);
		$this->_view->content($content);
	}

	public function action_save(){
		$this->auto_render(FALSE);

		$id = (int) $this->request->post('id');
		$product_category = Jelly::query('product_category', $id)->select();
		$product_category->set(
			Arr::extract(
				Arr::map('HTML::chars', $_POST),
				array(
					'name',
					'description',
					'page_title',
					'meta_keywords',
					'meta_description',
				), ''
			)
		);

		$product_category->friendly_url = Utils::url_lize($product_category->name);
		$product_category->sort_order = (int) $this->request->post('sort_order');
		$product_category->parent = Jelly::query('product_category', (int) $this->_session['parent_product_category_id'])->select();

		try
		{
			$product_category->save();
		}
		catch(Exception $e)
		{
			Kohana::$log->add(Log::ERROR, 'Error to save product category ' . $product_category->name . '. By ' . $this->_user->full_name);
			Kohana::$log->add(Log::ERROR, 'Error message: ' . $e);
		}
		Kohana::$log->add(Log::INFO, 'Product category ' . $product_category->name . ' has been saved by ' . $this->_user->full_name);

		$this->_return_index();
	}

	public function action_delete(){
		$this->auto_render(FALSE);

		$arr_product_category_id = $this->request->post('chk_id');
		if(!Arr::is_array($arr_product_category_id)) $arr_product_category_id = array('0');

		Jelly::query('product')->delete_by_category($arr_product_category_id);
		Jelly::query('product_category')->delete_all($arr_product_category_id);

		$lst_product_categorys = implode(',',$arr_product_category_id);
		Kohana::$log->add(Log::INFO, 'Product category ' . $lst_product_categorys . ' has been deleted by ' . $this->_user->full_name);
		$this->_return_index();
	}

	public function action_children(){
		$product_category_id = (int) $this->request->param('id');
		$this->_session['parent_product_category_id'] = $product_category_id;
		$this->_return_index();
	}

	public function action_back(){
		$category_id = (int) $this->_session['parent_product_category_id'];
		if($category_id > 0){
			$product_category = Jelly::query('product_category', $category_id)->select();
			$this->_session['parent_product_category_id'] = $product_category->parent_id;
		}
		$this->_return_index();
	}

	public function action_reset()
	{
		$this->_session['product_category_filter'] = '';
		$this->_session['product_category_city_id'] = 0;
		$this->_session['product_category_pagination'] = 1;
		$this->_return_index();
	}

	public function action_populate()
	{
		$this->auto_render(FALSE);
		$product_categories = Jelly::query('product_category')->select();
		$categories = array();
		foreach($product_categories as $category){
			$category_obj = new stdClass;
			$category_obj->id = $category->id;
			$category_obj->name = $category->name;
			$categories[] = $category_obj;
		}
		$json = new Crypto_JSON;
		$this->response->body($json->encode($categories));
	}
	
	public function after()
	{
		$this->view()->head()->title('Quản lý danh mục sản phẩm');
		return parent::after();
	}

	private function _return_index()
	{
		$product_category_pagination = (int) $this->_session->get('product_category_pagination');
		if($product_category_pagination > 1)
		{
			$this->request->redirect('admin/product_category/' . $product_category_pagination);
		}
		else
		{
			$this->request->redirect('admin/product_category');
		}
	}
}