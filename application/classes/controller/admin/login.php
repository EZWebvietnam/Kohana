<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Login extends Controller_Base {
	
	public function action_index()
	{
		$view = View::factory('admin/login')
					->set('return_url', $this->_session['return_url']);
		$this->response->body(Minify_HTML::minify($view->render(),
			array(
				'jsMinifier' => 'Minify_JS::minify',
				'cssMinifier' => 'Minify_CSS::minify',
			))
		);
	}

	public function action_redirect()
	{
		header('Pragma: no-cache');
		$user_name = HTML::chars($this->request->post('user_name'));
		$md5_password = HTML::chars($this->request->post('md5_password'));
		$remember = !is_null($this->request->post('remember'));
		$return_url = HTML::chars($this->request->post('return_url'));

		$auth = Auth::instance();
		if($auth->login($user_name, $md5_password, $remember))
		{
			Kohana::$log->add(Log::INFO, $user_name . ' logged in successfully');
		}
		else
		{
			Kohana::$log->add(Log::INFO, $user_name . ' logged in fail');
		}
		$this->request->redirect(!empty($return_url) ? $return_url : 'admin');
	}

	public function action_logout()
	{
		$auth = Auth::instance();
		$user = $auth->get_user();
		if($user)
		{
			Kohana::$log->add(Log::INFO, $user->full_name . ' has been logged out');
		}
		$auth->logout();
		$this->request->redirect('admin');
		
	}

	public function before()
	{
		$this->auto_render(FALSE);
		return parent::before();
	}

	public function after()
	{
		return parent::after();
	}
} // End Login Controller