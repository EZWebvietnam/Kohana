<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Admin_News_Category extends Controller_Admin{

	public function action_index()
	{
		$filter = HTML::chars($this->request->post('news_category_filter'));
		if(!empty($filter))
		{
			$this->_session['news_category_filter'] = $filter;
		}
		else
		{
			$filter = $this->_session['news_category_filter'];
		}
		
		$parent_id = (int) $this->_session['parent_news_category_id'];

		$pagination = new Pagination;
		$jelly_query = Jelly::query('news_category')
							->filter_all($filter, array('name', 'description'))
							->by_parent($parent_id);
		
		$pagination->total_items = $jelly_query->count();
		$this->_session['news_category_pagination'] = (int) $pagination->current_page;

		$content = View::factory('admin/news_category/list')
						->bind('news_category_filter', $filter)
						->bind('parent_id', $parent_id)
						->bind('pagination', $pagination)
						->set('news_categories', $jelly_query->paging($pagination->offset)->select());
		$this->_view->content($content);
	}

	public function action_edit(){
		$id = (int) $this->request->param('id');

		$content = View::factory('admin/news_category/edit')
						->set('news_category', Jelly::query('news_category', $id)->select())
						->set('news_category_pagination', $this->_session['news_category_pagination']);
		$this->_view->content($content);
	}

	public function action_save(){
		$this->auto_render(FALSE);

		$id = (int) $this->request->post('id');
		$news_category = Jelly::query('news_category', $id)->select();
		$news_category->set(
			Arr::extract(
				Arr::map('HTML::chars', $_POST),
				array(
					'name',
					'description',
					'page_title',
					'meta_keywords',
					'meta_description',
				), ''
			)
		);

		$news_category->friendly_url = Utils::url_lize($news_category->name);
		$news_category->sort_order = (int) $this->request->post('sort_order');
		$news_category->parent = Jelly::query('news_category', (int) $this->_session['parent_news_category_id'])->select();

		try
		{
			$news_category->save();
		}
		catch(Exception $e)
		{
			Kohana::$log->add(Log::ERROR, 'Error to save news category ' . $news_category->name . '. By ' . $this->_user->full_name);
			Kohana::$log->add(Log::ERROR, 'Error message: ' . $e);
		}
		Kohana::$log->add(Log::INFO, 'News category ' . $news_category->name . ' has been saved by ' . $this->_user->full_name);

		$this->_return_index();
	}

	public function action_delete(){
		$this->auto_render(FALSE);

		$arr_news_category_id = $this->request->post('chk_id');
		if(!Arr::is_array($arr_news_category_id)) $arr_news_category_id = array('0');

		Jelly::query('news_category')->delete_all($arr_news_category_id);

		$lst_news_categorys = implode(',',$arr_news_category_id);
		Kohana::$log->add(Log::INFO, 'News category ' . $lst_news_categorys . ' has been deleted by ' . $this->_user->full_name);
		$this->_return_index();
	}

	public function action_children(){
		$news_category_id = (int) $this->request->param('id');
		$this->_session['parent_news_category_id'] = $news_category_id;
		$this->_return_index();
	}

	public function action_back(){
		$category_id = (int) $this->_session['parent_news_category_id'];
		if($category_id > 0){
			$news_category = Jelly::query('news_category', $category_id)->select();
			$this->_session['parent_news_category_id'] = $news_category->parent_id;
		}
		$this->_return_index();
	}

	public function action_reset()
	{
		$this->_session['news_category_filter'] = '';
		$this->_session['news_category_city_id'] = 0;
		$this->_session['news_category_pagination'] = 1;
		$this->_return_index();
	}

	public function action_populate()
	{
		$this->auto_render(FALSE);
		$news_categories = Jelly::query('news_category')->select();
		$categories = array();
		foreach($news_categories as $category){
			$category_obj = new stdClass;
			$category_obj->id = $category->id;
			$category_obj->name = $category->name;
			$categories[] = $category_obj;
		}
		$json = new Crypto_JSON;
		$this->response->body($json->encode($categories));
	}
	
	public function after()
	{
		$this->view()->head()->title('Quản lý chuyên mục tin');
		return parent::after();
	}

	private function _return_index()
	{
		$news_category_pagination = (int) $this->_session->get('news_category_pagination');
		if($news_category_pagination > 1)
		{
			$this->request->redirect('admin/news_category/' . $news_category_pagination);
		}
		else
		{
			$this->request->redirect('admin/news_category');
		}
	}
}