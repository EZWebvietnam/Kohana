<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Product extends Controller_Admin{

	public function action_index(){
		$filter = HTML::chars($this->request->post('product_filter'));
		$category_id = HTML::chars($this->request->post('product_category_id'));
		$manufacturer_id = HTML::chars($this->request->post('product_manufacturer_id'));

		if(!empty($filter))
		{
			$this->_session['product_filter'] = $filter;
		}
		else
		{
			$filter = $this->_session['product_filter'];
		}

		if($category_id != '')
		{
			$this->_session['product_category_id'] = (int) $category_id;
		}
		else
		{
			$category_id = $this->_session['product_category_id'];
		}

		if($manufacturer_id != '')
		{
			$this->_session['product_manufacturer_id'] = (int) $manufacturer_id;
		}
		else
		{
			$manufacturer_id = $this->_session['product_manufacturer_id'];
		}

		$pagination = new Pagination;
		$jelly_query = Jelly::query('product')
							->filter_all($filter, array('name', 'sort_description', 'description'))
							->by_category((int) $category_id)
							->by_manufacturer((int) $manufacturer_id);

		$pagination->total_items = $jelly_query->count();
		$this->_session['product_pagination'] = (int) $pagination->current_page;

		$content = View::factory('admin/product/list')
						->bind('product_filter', $filter)
						->bind('product_manufacturer_id', $manufacturer_id)
						->bind('product_category_id', $category_id)
						->bind('pagination', $pagination)
						->set('product_categories', Jelly::query('product_category')->select()->as_array('id', 'name'))
						->set('manufacturers', Jelly::query('manufacturer')->select()->as_array('id', 'name'))
						->set('products', $jelly_query->paging($pagination->offset)->select());
		$this->_view->content($content);
	}

	public function action_edit(){
		$id = (int) $this->request->param('id');

		$content = View::factory('admin/product/edit')
						->set('product', Jelly::query('product', $id)->select())
						->set('product_categories', Jelly::query('product_category')->select()->as_array('id', 'name'))
						->set('product_manufacturers', Jelly::query('manufacturer')->select()->as_array('id', 'name'))
						->set('product_origins', Jelly::query('origin')->select()->as_array('id', 'name'))
						->set('product_pagination', $this->_session['product_pagination']);
		$this->_view->content($content);
	}
	
	public function action_save(){
		$this->auto_render(FALSE);

		$id = (int) $this->request->post('id');
		$product = Jelly::query('product', $id)->select();
		$product->set(
			Arr::extract(
				Arr::map('HTML::chars', $_POST),
				array(
					'sku',
					'name',
					'sort_description',
					'description',
					'color',
					'page_title',
					'meta_keywords',
					'meta_description',
				), ''
			)
		);

		$product->friendly_url = Utils::url_lize($product->name);
		if($file_name = $this->_upload_image('image', DOCROOT . 'upload/product'))
		{
			$product->full_image = $product->thumb_image = $file_name;
		}

		$product->price = (int) $this->request->post('price');
		$product->special = (int) $this->request->post('special');
		$product->capacity = (int) $this->request->post('capacity');
		$product->alcohol_level = (int) $this->request->post('alcohol_level');
		$product->production_year = (int) $this->request->post('production_year');
		if($id == 0) $product->views = 0;

		$product->product_category = Jelly::query('product_category', (int) $this->request->post('product_category_id'))->select();
		$product->manufacturer = Jelly::query('manufacturer', (int) $this->request->post('manufacturer_id'))->select();
		$product->origin = Jelly::query('origin', (int) $this->request->post('origin_id'))->select();
		
		try
		{
			$product->save();
		}
		catch(Exception $e)
		{
			Kohana::$log->add(Log::ERROR, 'Error to save product ' . $product->name . '. By ' . $this->_user->full_name);
			Kohana::$log->add(Log::ERROR, 'Error message: ' . $e);
		}
		Kohana::$log->add(Log::INFO, 'Product ' . $product->name . ' has been saved by ' . $this->_user->full_name);

		$this->_return_index();
	}

	public function action_delete(){
		$this->auto_render(FALSE);

		$arr_product_id = isset($_POST['chk_id']) ? $_POST['chk_id'] : array('0');
		if(!Arr::is_array($arr_product_id)) $arr_product_id = array();
		Jelly::query('product_image')->delete_by_product($arr_product_id);
		Jelly::query('product')->delete_all($arr_product_id);

		$lst_products = implode(',',$arr_product_id);
		Kohana::$log->add(Log::INFO,'Product ' . $lst_products . ' has been deleted by ' . $this->_user->full_name);

		$this->_return_index();
	}

	public function action_reset()
	{
		$this->_session['product_filter'] = '';
		$this->_session['product_manufacturer_id'] = 0;
		$this->_session['product_category_id'] = 0;
		$this->_session['product_pagination'] = 1;
		$this->_return_index();
	}

	public function action_populate()
	{
		$this->auto_render(FALSE);
		$product_category_id = (int) $this->request->param('id');
		$products = Jelly::query('product')->list_by_category($product_category_id)->select();

		$product_obj = new stdClass;
		$product_obj->id = 0;
		$product_obj->name = '-- Sản phẩm --';
		$arr_product = array($product_obj);
		foreach($products as $product){
			$product_obj = new stdClass;
			$product_obj->id = $product->id;
			$product_obj->name = $product->name;
			$arr_product[] = $product_obj;
		}
		$json = new Crypto_JSON;
		$this->response->body($json->encode($arr_product));
	}

	public function action_re_thumbnail()
	{
		$this->auto_render(FALSE);
		$product_id = (int) $this->request->param('id');
		$products = Jelly::query('product')->select();
		foreach($products as $product)
		{
			$this->_re_thumbnail($product->full_image);
			$images = $product->images;
			foreach($images as $image)
			{
				$this->_re_thumbnail($image->name);
			}
		}
		$this->_return_index();
	}

	public function after()
	{
		$this->view()->head()->title('Quản lý sản phẩm');
		return parent::after();
	}

	private function _re_thumbnail($file_name, $directory = NULL)
	{
		$directory = empty($directory) ? DOCROOT . 'upload/product' : $directory;
		$resize_dimension = Kohana::$config->load('upload.resize_dimension');
		$resize_type = (int) Kohana::$config->load('upload.resize_type');
		$file_path = $directory . '/' . $file_name;
		Image::factory($file_path)
				->resize(
					isset($resize_dimension[0]) ? (int) $resize_dimension[0] : 150,
					isset($resize_dimension[1]) ? (int) $resize_dimension[1] : 150,
					$resize_type
				)
				->save($directory . '/thumbs/' . $file_name, 0777);
	}

	private function _return_index()
	{
		$product_pagination = (int) $this->_session->get('product_pagination');
		if($product_pagination > 1)
		{
			$this->request->redirect('admin/product/' . $product_pagination);
		}
		else
		{
			$this->request->redirect('admin/product');
		}
	}
}