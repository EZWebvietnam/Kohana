<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Currency extends Controller_Admin{

	public function action_index()
	{
		$filter = HTML::chars($this->request->post('currency_filter'));

		if(!empty($filter))
		{
			$this->_session['currency_filter'] = $filter;
		}
		else
		{
			$filter = $this->_session['currency_filter'];
		}

		$pagination = new Pagination;
		$jelly_query = Jelly::query('currency')->filter_all($filter, array('name', 'short_name', 'symbol'))->sort_order();
		
		$pagination->total_items = $jelly_query->count();
		$this->_session['currency_pagination'] = (int) $pagination->current_page;

		$content = View::factory('admin/currency/list')
						->bind('currency_filter', $filter)
						->bind('pagination', $pagination)
						->set('currencies', $jelly_query->paging($pagination->offset)->cached()->select());
		$this->_view->content($content);
	}

	public function action_edit(){
		$id = (int) $this->request->param('id');
		
		$content = View::factory('admin/currency/edit')
						->set('contact', Jelly::query('currency', (int) $id)->select())
						->set('currency_pagination', $this->_session['currency_pagination']);
		$this->_view->content($content);
	}

	public function action_save(){
		$this->auto_render(FALSE);

		$id = (int) $this->request->post('id');
		$currency = Jelly::query('currency', $id)->select();
		$currency->set(
			Arr::extract(
				Arr::map('HTML::chars', $_POST),
				array(
					'name',
					'short_name',
					'symbol',
				), ''
			)
		);

		$currency->rate = (float) $this->request->post('rate');
		$currency->sort_order = (int) $this->request->post('sort_order');

		try
		{
			$currency->save();
		}
		catch(Exception $e)
		{
			Kohana::$log->add(Log::ERROR, 'Error to save currency ' . $currency->name . '. By ' . $this->_user->full_name);
			Kohana::$log->add(Log::ERROR, 'Error message: ' . $e);
		}
		Kohana::$log->add(Log::INFO, 'Currency ' . $currency->name . ' has been saved by ' . $this->_user->full_name);

		$this->_return_index();
	}

	public function action_delete(){
		$this->auto_render(FALSE);

		$arr_currency_id = isset($_POST['chk_id']) ? $_POST['chk_id'] : array('0');
		if(!Arr::is_array($arr_currency_id)) $arr_currency_id = array();
		
		Jelly::query('product')->delete_by_currency($arr_currency_id);
		Jelly::query('currency')->delete_all($arr_currency_id);

		$lst_currencies = implode(',',$arr_currency_id);
		Kohana::$log->add(Log::INFO,'Currency ' . $lst_currencies . ' has been deleted by ' . $this->_user->full_name);

		$this->_return_index();
	}

	public function action_reset()
	{
		$this->_session['currency_filter'] = '';
		$this->_session['currency_pagination'] = 1;
		$this->_return_index();
	}

	public function after()
	{
		$this->view()->head()->title('Quản lý tiền tệ');
		return parent::after();
	}

	private function _return_index()
	{
		$currency_pagination = (int) $this->_session->get('currency_pagination');
		if($currency_pagination > 1)
		{
			$this->request->redirect('admin/currency/' . $currency_pagination);
		}
		else
		{
			$this->request->redirect('admin/currency');
		}
	}
}