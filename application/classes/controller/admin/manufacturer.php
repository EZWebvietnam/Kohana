<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Manufacturer extends Controller_Admin{

	public function action_index()
	{
		$filter = HTML::chars($this->request->post('manufacturer_filter'));

		if(!empty($filter))
		{
			$this->_session['manufacturer_filter'] = $filter;
		}
		else
		{
			$filter = $this->_session['manufacturer_filter'];
		}

		$pagination = new Pagination;
		$jelly_query = Jelly::query('manufacturer')->filter_all($filter, array('name'));
		
		$pagination->total_items = $jelly_query->count();
		$this->_session['manufacturer_pagination'] = (int) $pagination->current_page;

		$content = View::factory('admin/manufacturer/list')
						->bind('manufacturer_filter', $filter)
						->bind('pagination', $pagination)
						->set('manufacturers', $jelly_query->paging($pagination->offset)->select());
		$this->_view->content($content);
	}

	public function action_edit(){
		$id = (int) $this->request->param('id');

		$content = View::factory('admin/manufacturer/edit')
						->set('manufacturer_pagination', $this->_session['manufacturer_pagination'])
						->set('manufacturer', Jelly::query('manufacturer', (int) $id)->select());
		$this->_view->content($content);
	}

	public function action_save(){
		$this->auto_render(FALSE);

		$id = (int) $this->request->post('id');
		$manufacturer = Jelly::query('manufacturer', $id)->select();
		$manufacturer->set(
			Arr::extract(
				Arr::map('HTML::chars', $_POST),
				array(
					'name',
					'website',
					'page_title',
					'meta_keywords',
					'meta_description',
				), ''
			)
		);

		$manufacturer->friendly_url = strtolower(Inflector::underscore(Utils::utf8_to_ascii($manufacturer->name)));
		$manufacturer->sort_order = (int) $this->request->post('sort_order');
		$manufacturer->image = $this->_upload_image('image', DOCROOT . 'upload/manufacturer');

		try
		{
			$manufacturer->save();
		}
		catch(Exception $e)
		{
			Kohana::$log->add(Log::ERROR, 'Error to save manufacturer ' . $manufacturer->name . '. By ' . $this->_user->full_name);
		}
		Kohana::$log->add(Log::INFO, 'Manufacturer ' . $manufacturer->name . ' has been saved by ' . $this->_user->full_name);

		$this->_return_index();
	}

	public function action_delete(){
		$this->auto_render(FALSE);

		$arr_manufacturer_id = isset($_POST['chk_id']) ? $_POST['chk_id'] : array('0');
		if(!Arr::is_array($arr_manufacturer_id)) $arr_manufacturer_id = array();
		
		Jelly::query('product')->delete_by_manufacturer($arr_manufacturer_id);
		Jelly::query('manufacturer')->delete_all($arr_manufacturer_id);

		$lst_manufacturers = implode(',',$arr_manufacturer_id);
		Kohana::$log->add(Log::INFO,'Manufacturer ' . $lst_manufacturers . ' has been deleted by ' . $this->_user->full_name);

		$this->_return_index();
	}

	public function action_reset()
	{
		$this->_session['manufacturer_filter'] = '';
		$this->_session['manufacturer_pagination'] = 1;
		$this->_return_index();
	}

	public function after()
	{
		$this->view()->head()->title('Quản lý hãng sản xuất');
		return parent::after();
	}

	private function _return_index()
	{
		$manufacturer_pagination = (int) $this->_session->get('manufacturer_pagination');
		if($manufacturer_pagination > 1)
		{
			$this->request->redirect('admin/manufacturer/' . $manufacturer_pagination);
		}
		else
		{
			$this->request->redirect('admin/manufacturer');
		}
	}
}