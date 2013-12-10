<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Product_Image extends Controller_Admin{

	public function action_index()
	{
		$product_id = (int) $this->request->param('product_id');
		$product = Jelly::query('product', (int) $product_id)->select();
		if(!$product->loaded())
		{
			$this->_return_product();
		}
		else
		{
			$content = View::factory('admin/product_image/list')
							->set('product_images', Jelly::query('product_image')->list_by_product($product_id)->select())
							->bind('product', $product)
							->set('product_pagination', (int) $this->_session->get('product_pagination'));
			$this->_view->content($content);
			
			$this->_view->head()->script_files(array('min/js/uploadify'));
			$this->_view->head()->style_files(array('min/css/uploadify'));
		}
	}

	public function action_delete()
	{
		$this->auto_render(FALSE);
		$product_id = (int) $this->request->post('product_id');
		$arr_image_id = isset($_POST['image_id']) ? $_POST['image_id'] : array('0');
		Jelly::query('product_image')->delete_all($arr_image_id);

		$lst_images = implode(',',$arr_image_id);
		Kohana::$log->add(Log::INFO,'Images ' . $lst_images . ' has been deleted by ' . $this->_user->full_name);

		$this->request->redirect('admin/product_image/' . $product_id);
	}

	public function action_re_thumbnail()
	{
		$this->auto_render(FALSE);
		$product_id = (int) $this->request->param('id');
		$images = Jelly::query('product_image')->by_product($product_id)->select();
		foreach($images as $image)
		{
			$this->_re_thumbnail($image->file_path);
		}
		$this->request->redirect('admin/product_image/' . $product_id);
	}
	
	public function after()
	{
		$this->view()->head()->title('Hình ảnh sản phẩm');
		return parent::after();
	}

	private function _re_thumbnail($file_path, $directory = NULL)
	{
		$directory = empty($directory) ? DOCROOT . 'upload/product' : $directory;
		$resize_dimension = Kohana::$config->load('upload.resize_dimension');
		$resize_type = (int) Kohana::$config->load('upload.resize_type');
		$file_name = basename($file_path);
		Image::factory($file_path)
				->resize(
					isset($resize_dimension[0]) ? (int) $resize_dimension[0] : 150,
					isset($resize_dimension[1]) ? (int) $resize_dimension[1] : 150,
					$resize_type
				)
				->save($directory . '/thumbs/' . $file_name, 0777);
	}
	
	private function _return_product()
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