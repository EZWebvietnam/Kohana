<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Home extends Controller_Admin {

	public function action_index()
	{
		$this->view()->content(View::factory('admin/index'));
	}

	public function after()
	{
		$this->view()->head()->title('Quản trị hệ thống');
		return parent::after();
	}
} // End Admin Home
