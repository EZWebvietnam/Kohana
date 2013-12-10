<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Upload_Image extends Controller {

	public function before(){
		$this->_auto_render = FALSE;
		return parent::before();
	}

	public function action_index(){
	}
	
	public function action_product()
	{
		$product_id = (int) $this->request->post('product_id');
		$product = Jelly::query('product', $product_id)->select();
		if($product->loaded())
		{
			if($file_path = $this->_upload_image('image_upload', DOCROOT . 'upload/product'))
			{
				$file_name = basename($file_path);
				$extension = strtolower(substr(strrchr($file_name, '.'), 1));
				$mime_types = Kohana::$config->load('mimes.' . $extension);
				$mime_type = (count($mime_types) > 0) ? $mime_types[0] : 'application/octet-stream';

				$product_image = Jelly::factory('product_image');
				$product_image->product  = $product;
				$product_image->name = $file_name;
				$product_image->file_path = $file_path;
				$product_image->content_type = $mime_type;

				$product_image->save();
				Kohana::$log->add(Log::INFO, 'Upload successfully - File ' . $file_name . ' has been uploaded');
			}
			else
			{
				Kohana::$log->add(Log::INFO, 'Upload failed - Product ' . $product->name . ' is not exist');
			}
		}
		echo 'Product image upload';
	}

	public function action_news()
	{
	}

	private function _upload_image($file_upload = 'file', $directory = NULL)
	{
		if($this->_valid_upload($file_upload))
		{
			$file_path = Upload::save(
							$_FILES[$file_upload],
							NULL, $directory,
							0777
						);
			$resize_dimension = Kohana::$config->load('upload.resize_dimension');
			$resize_type = (int) Kohana::$config->load('upload.resize_type');

			$file_name = basename($file_path);

			Image::factory($file_path)
					->resize(
						isset($resize_dimension[0]) ? (int) $resize_dimension[0] : 100,
						isset($resize_dimension[1]) ? (int) $resize_dimension[1] : 100,
						$resize_type
					)
					->save($directory . '/thumbs/' . $file_name, 0777);

			Kohana::$log->add(Log::INFO, 'Upload successfully - File ' . $file_name . ' has been uploaded');
			return $file_path;
		}else{
			return FALSE;
		}
	}
	
	private function _valid_upload($file_upload = 'file')
	{
		$secret_key = $this->request->post('secret_key');
		$config_key = Kohana::$config->load('upload.secret_key');

		if(Crypto_Hash_Simple::verify_hash($config_key, $secret_key))
		{
			$allowed_types = Kohana::$config->load('upload.allowed_types');
			$allowed_size = Kohana::$config->load('upload.allowed_size');

			$files = Validation::factory($_FILES)
						->rule($file_upload, 'Upload::valid')
						->rule($file_upload, 'Upload::not_empty')
						->rule($file_upload, 'Upload::type', array(':value', $allowed_types))
						->rule($file_upload, 'Upload::size', array(':value', $allowed_size));

			if($files->check())
			{
				return TRUE;
			}
			else
			{
				Kohana::$log->add(Log::INFO, 'Upload failed - Not valid file upload');
				return FALSE;
			}
		}
		else
		{
			Kohana::$log->add(Log::INFO, 'Upload failed - Not valid secret key');
			return FALSE;
		}
	}
} // End Login Controller