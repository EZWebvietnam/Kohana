<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Menu extends Controller_Admin {
	
	public function action_index($language_code = '')
	{
		$this->response->body(View::factory('admin/menu'));
	}

	public function before()
	{
		$this->partial();
		return parent::before();
	}

	public function after()
	{
		return parent::after();
	}
} // End Login Controller