<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Contact extends Controller_Admin{

	public function action_index()
	{
		$filter = HTML::chars($this->request->post('contact_filter'));

		if(!empty($filter))
		{
			$this->_session['contact_filter'] = $filter;
		}
		else
		{
			$filter = $this->_session['contact_filter'];
		}

		$pagination = new Pagination;
		$jelly_query = Jelly::query('contact')->filter_all($filter, array('name', 'short_name', 'symbol'))->sort_date_created();
		
		$pagination->total_items = $jelly_query->count();
		$this->_session['contact_pagination'] = (int) $pagination->current_page;

		$content = View::factory('admin/contact/list')
						->bind('contact_filter', $filter)
						->bind('pagination', $pagination)
						->set('currencies', $jelly_query->paging($pagination->offset)->select());
		$this->_view->content($content);
	}

	public function action_edit(){
		$id = (int) $this->request->param('id');
		$contact = Jelly::query('contact', (int) $id)->select();
		if($contact->loaded() AND $contact->read === 0)
		{
			$contact->read = 1;
			$contact->save();
		}

		$content = View::factory('admin/contact/edit')
						->bind('contact', $contact)
						->set('contact_pagination', $this->_session['contact_pagination']);
		$this->_view->content($content);
	}

	public function action_save(){
		$this->auto_render(FALSE);

		$id = (int) $this->request->post('id');
		$contact = Jelly::query('contact', $id)->select();
		$contact->status = (int) $this->request->post('status');

		try
		{
			$contact->save();
		}
		catch(Exception $e)
		{
			Kohana::$log->add(Log::ERROR, 'Error to save contact ' . $contact->name . '. By ' . $this->_user->full_name);
			Kohana::$log->add(Log::ERROR, 'Error message: ' . $e);
		}
		Kohana::$log->add(Log::INFO, 'Origin ' . $contact->name . ' has been saved by ' . $this->_user->full_name);

		$this->_return_index();
	}

	public function action_delete(){
		$this->auto_render(FALSE);

		$arr_contact_id = $this->request->post('chk_id');
		if(!Arr::is_array($arr_contact_id)) $arr_contact_id = array();
		
		Jelly::query('product')->delete_by_contact($arr_contact_id);
		Jelly::query('contact')->delete_all($arr_contact_id);

		$lst_currencies = implode(',',$arr_contact_id);
		Kohana::$log->add(Log::INFO,'Origin ' . $lst_currencies . ' has been deleted by ' . $this->_user->full_name);

		$this->_return_index();
	}

	public function action_reset()
	{
		$this->_session['contact_filter'] = '';
		$this->_session['contact_pagination'] = 1;
		$this->_return_index();
	}

	public function after()
	{
		$this->view()->head()->title('Quản lý liên hệ');
		return parent::after();
	}

	private function _return_index()
	{
		$contact_pagination = (int) $this->_session->get('contact_pagination');
		if($contact_pagination > 1)
		{
			$this->request->redirect('admin/contact/' . $contact_pagination);
		}
		else
		{
			$this->request->redirect('admin/contact');
		}
	}
}