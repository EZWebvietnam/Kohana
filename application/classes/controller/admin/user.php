<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_User extends Controller_Admin {
	public function action_index()
	{
		$filter = HTML::chars($this->request->post('user_filter'));
		$status = HTML::chars($this->request->post('user_status'));

		if(!empty($filter))
		{
			$this->_session['user_filter'] = $filter;
		}
		else
		{
			$filter = $this->_session->get('user_filter', '');
		}

		if(is_null($status))
		{
			$status = $this->_session->get('user_status', '');
		}
		else if($status === '-')
		{
			$this->_session['user_status'] = $status = '';
		}
		else
		{
			$this->_session['user_status'] = $status;
		}

		$pagination = new Pagination;
		$jelly_query = Jelly::query('user')->user_filter($filter, $status);

		$pagination->total_items = $jelly_query->count();
		$this->_session['user_pagination'] = (int) $pagination->current_page;

		$content = View::factory('admin/user/list')
						->bind('user_filter', $filter)
						->bind('user_status', $status)
						->bind('pagination', $pagination)
						->set('users', $jelly_query->paging($pagination->offset)->select());
		$this->_view->content($content);
	}

	public function action_edit()
	{
		$user_name = $this->request->param('id');

		$content = View::factory('admin/user/edit')
						->set('user', Jelly::query('user')->where('user_name', '=', $user_name)->limit(1)->select())
						->set('user_pagination', $this->_session['user_pagination']);
		$this->_view->content($content);
	}
	
	public function action_save()
	{
		$this->auto_render(FALSE);

		$id = (int) $this->request->post('id');
		$user = Jelly::query('user', $id)->select();
		$user->set(
			Arr::extract(
				Arr::map('HTML::chars', $_POST),
				array(
					'full_name',
					'user_name',
					'email',
					'tel',
					'mobile',
				), ''
			)
		);

		$password = trim($this->request->post('password'));
		if(!empty($password))
		{
			$user->password = $password;
		}
		$user->status = is_null($this->request->post('user_status')) ? 0 : 1;

		if(!$user->loaded())
		{
			$user->last_login = 0;
		}

		try
		{
			$user->save();
		}
		catch(Exception $e)
		{
			Kohana::$log->add(Log::ERROR, 'Error to save user ' . $user->user_name . '. By ' . $this->_user->full_name);
			Kohana::$log->add(Log::ERROR, 'Error message: ' . $e);
		}
		Kohana::$log->add(Log::INFO,'User ' . $user->user_name . ' has been saved by ' . $this->_user->full_name);

		$this->_return_index();
	}

	public function action_delete()
	{
		$this->auto_render(FALSE);

		$arr_user_id = $this->request->post('chk_id');
		if(!Arr::is_array($arr_user_id)) $arr_user_id = array('0');
		$arr_user_name = array();

		foreach($arr_user_id as $user_id)
		{
			$user = Jelly::query('user', (int) $user_id)->select();
			if($user->loaded())
			{
				$arr_user_name[] = $user->user_name;
				$user->get('tokens')->delete();
				$user->delete();
			}
		}

		$lst_user_name = implode(',',$arr_user_name);
		Kohana::$log->add(Log::INFO,'Users ' . $lst_user_name . ' has been deleted by ' . $this->_user->full_name);

		$this->_return_index();
	}

	public function action_change_password()
	{
		$this->_view->content(View::factory('admin/user/change_password'));
		if(isset($this->_session['change_password_status']))
		{
			if($this->_session['change_password_status'] === true)
			{
			}
			else if($this->_session['change_password_status'] === false)
			{
			}
		}
		$this->_session['change_password_status'] = null;
		unset($this->_session['change_password_status']);
	}

	public function action_save_password()
	{
		$this->auto_render(false);
		$auth = Auth::instance();
		if($auth->logged_in())
		{
			$current_password = HTML::chars($this->request->post('current_password'));
			$new_password = HTML::chars($this->request->post('new_password'));
			$this->_session['change_password_status'] = $auth->change_password($current_password, $new_password);
		}

		$this->request->redirect('admin/user/change_password');
	}

	public function action_reset()
	{
		$this->_session['user_filter'] = '';
		$this->_session['user_status'] = '';
		$this->_session['user_pagination'] = 0;
		$this->_return_index();
	}

	private function _return_index()
	{
		$user_pagination = (int) $this->_session['user_pagination'];
		if($user_pagination > 1)
		{
			$this->request->redirect('admin/user/' . $user_pagination);
		}
		else
		{
			$this->request->redirect('admin/user');
		}
	}

	public function after()
	{
		$this->view()->head()->title('Quản lý người dùng');
		parent::after();
	}
} // End Welcome
