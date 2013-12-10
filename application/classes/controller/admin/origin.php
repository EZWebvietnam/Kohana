<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Origin extends Controller_Admin{

	public function action_index()
	{
		$filter = HTML::chars($this->request->post('origin_filter'));

		if(!empty($filter))
		{
			$this->_session['origin_filter'] = $filter;
		}
		else
		{
			$filter = $this->_session['origin_filter'];
		}

		$pagination = new Pagination;
		$jelly_query = Jelly::query('origin')->filter_all($filter, array('name', 'description'));
		
		$pagination->total_items = $jelly_query->count();
		$this->_session['origin_pagination'] = (int) $pagination->current_page;

		$content = View::factory('admin/origin/list')
						->bind('origin_filter', $filter)
						->bind('pagination', $pagination)
						->set('origins', $jelly_query->paging($pagination->offset)->select());
		$this->_view->content($content);
	}

	public function action_edit(){
		$id = (int) $this->request->param('id');
		
		$content = View::factory('admin/origin/edit')
						->set('origin', Jelly::query('origin', (int) $id)->select())
						->set('origin_pagination', $this->_session['origin_pagination']);
		$this->_view->content($content);
	}

	public function action_save(){
		$this->auto_render(FALSE);

		$id = (int) $this->request->post('id');
		$origin = Jelly::query('origin', $id)->select();
		$origin->set(
			Arr::extract(
				Arr::map('HTML::chars', $_POST),
				array(
					'name',
					'description',
				), ''
			)
		);

		$origin->sort_order = (int) $this->request->post('sort_order');

		try
		{
			$origin->save();
		}
		catch(Exception $e)
		{
			Kohana::$log->add(Log::ERROR, 'Error to save origin ' . $origin->name . '. By ' . $this->_user->full_name);
			Kohana::$log->add(Log::ERROR, 'Error message: ' . $e);
		}
		Kohana::$log->add(Log::INFO, 'Origin ' . $origin->name . ' has been saved by ' . $this->_user->full_name);

		$this->_return_index();
	}

	public function action_delete(){
		$this->auto_render(FALSE);

		$arr_origin_id = isset($_POST['chk_id']) ? $_POST['chk_id'] : array('0');
		if(!Arr::is_array($arr_origin_id)) $arr_origin_id = array();
		
		Jelly::query('product')->delete_by_origin($arr_origin_id);
		Jelly::query('origin')->delete_all($arr_origin_id);

		$lst_origins = implode(',',$arr_origin_id);
		Kohana::$log->add(Log::INFO,'Origin ' . $lst_origins . ' has been deleted by ' . $this->_user->full_name);

		$this->_return_index();
	}

	public function action_reset()
	{
		$this->_session['origin_filter'] = '';
		$this->_session['origin_pagination'] = 1;
		$this->_return_index();
	}

	public function after()
	{
		$this->view()->head()->title('Quản lý xuất xứ');
		return parent::after();
	}

	private function _return_index()
	{
		$origin_pagination = (int) $this->_session->get('origin_pagination');
		if($origin_pagination > 1)
		{
			$this->request->redirect('admin/origin/' . $origin_pagination);
		}
		else
		{
			$this->request->redirect('admin/origin');
		}
	}
}