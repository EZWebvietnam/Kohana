<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Base extends Controller{
	protected $_auto_render = TRUE;
	protected $_layout = 'layout';
	protected $_compression = TRUE;

	protected $_view = NULL;
	protected $_session;

	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);
		$this->_session = Session::instance();
	}

	public function before()
	{
		parent::before();
		if ($this->_auto_render)
		{
			$this->_view = View::factory($this->_layout);
		}
	}

	public function after()
	{
		parent::after();
		if ($this->_auto_render)
		{
			$this->response->body(Minify_HTML::minify($this->_view->render(),
				array(
					'js_minifier' => 'Minify_JS::minify',
					'css_minifier' => 'Minify_CSS::minify',
				))
			);
		}

		if((bool) $this->_compression)
		{
			ob_start ("ob_gzhandler");
		}
	}

	protected function partial()
	{
		return $this->auto_render(FALSE)->compression(FALSE);
	}
	
	protected function compression($compression = TRUE)
	{
		$this->_compression = (bool) $compression;
		return $this;
	}
	
	protected function auto_render($render = TRUE)
	{
		$this->_auto_render = (bool) $render;
		return $this;
	}

	protected function layout($layout)
	{
		if($layout === NULL)
		{
			return $this->_layout;
		}
		$this->_layout = (string) $layout;
		return $this;
	}

	protected function view()
	{
		return $this->_view;
	}

	protected function _upload_file($file_upload = 'file', $directory = NULL)
	{
		if ($this->_valid_upload($file_upload))
		{
			$file_path = Upload::save(
							$_FILES[$file_upload],
							NULL, $directory,
							0777
						);
			$file_name = basename($file_path);
			Kohana::$log->add(Log::INFO, 'Upload successfully - File ' . $file_name . ' has been uploaded');
			return $file_name;
		}else{
			return FALSE;
		}
	}
	
	protected function _upload_image($file_upload = 'file', $directory = NULL)
	{
		if($this->_valid_upload($file_upload))
		{
			$file_path = Upload::save(
							$_FILES[$file_upload],
							NULL, $directory,
							0777
						);
			$file_name = basename($file_path);
			$resize_dimension = Kohana::$config->load('upload.resize_dimension');
			$resize_type = (int) Kohana::$config->load('upload.resize_type');

			Image::factory($file_path)
					->resize(
						isset($resize_dimension[0]) ? (int) $resize_dimension[0] : 100,
						isset($resize_dimension[1]) ? (int) $resize_dimension[1] : 100,
						$resize_type
					)
					->save($directory . '/thumbs/' . $file_name, 0777);

			Kohana::$log->add(Log::INFO, 'Upload successfully - File ' . $file_name . ' has been uploaded');
			return $file_name;
		}else{
			return FALSE;
		}
	}

	private function _valid_upload($file_upload = 'file'){
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
}
