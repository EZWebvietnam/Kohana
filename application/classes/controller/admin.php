<?php defined('SYSPATH') or die('No direct access allowed.');

abstract class Controller_Admin extends Controller_Base{
	protected $_user = NULL;
	protected $_items_per_page = 10;

	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);
		$this->_authentication();
		$this->_layout = 'admin/layout';
		$this->_items_per_page = (int) Kohana::$config->load('pagination.default.items_per_page');
	}

	protected function _authentication()
	{
		$this->_session['return_url'] = $this->request->detect_uri();
		$auth = Auth::instance();
		if($auth->logged_in())
		{
			$this->_user = $auth->get_user();
		}
		else
		{
			$this->request->redirect('admin/login');
		}
	}

	public function get_user()
	{
		return $this->_user;
	}
}
