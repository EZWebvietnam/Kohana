<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_News_Content extends Controller_Admin{

	public function action_index(){
		$content_view = new View('admin/news_content/list');
		$filter = HTML::chars($this->request->post('news_content_filter'));
		$category_id = HTML::chars($this->request->post('news_category_id'));
		if(!empty($filter))
		{
			$this->_session['news_content_filter'] = $filter;
		}
		else
		{
			$filter = $this->_session['news_content_filter'];
		}

		if($category_id != '')
		{
			$this->_session['news_category_id'] = $category_id;
		}
		else
		{
			$category_id = $this->_session['news_category_id'];
		}

		$pagination = new Pagination;
		$jelly_query = Jelly::query('news_content')->filter_all($filter, array('name', 'intro_text', 'content'))
												   ->by_category((int) $category_id)
												   ->sort_date_created();

		$pagination->total_items = $jelly_query->count();
		$this->_session['news_content_pagination'] = (int) $pagination->current_page;

		$content = View::factory('admin/news_content/list')
						->bind('news_content_filter', $filter)
						->bind('news_category_id', $category_id)
						->bind('pagination', $pagination)
						->set('news_categories', Jelly::query('news_category')->select()->as_array('id', 'name'))
						->set('news_contents', $jelly_query->paging($pagination->offset)->select());
		$this->_view->content($content);
	}

	public function action_edit(){
		$id = (int) $this->request->param('id');
		
		$content = View::factory('admin/news_content/edit')
						->set('news_content', Jelly::query('news_content', $id)->select())
						->set('news_categories', Jelly::query('news_category')->select()->as_array('id', 'name'))
						->set('news_content_pagination', $this->_session['news_content_pagination']);
		$this->_view->content($content);
	}
	
	public function action_save(){
		$this->auto_render(FALSE);

		$id = (int) $this->request->post('id');
		$news_content = Jelly::query('news_content', $id)->select();
		$news_content->set(
			Arr::extract(
				Arr::map('HTML::chars', $_POST),
				array(
					'name',
					'intro_text',
					'content',
					'page_title',
					'meta_keywords',
					'meta_description',
				), ''
			)
		);

		$news_content->friendly_url = Utils::url_lize($news_content->name);
		if($file_name = $this->_upload_image('image', DOCROOT . 'upload/news'))
		{
			$news_content->image_path = $news_content->thumb_image = $file_name;
		}

		$news_content->price = (int) $this->request->post('price');
		$news_content->special = (int) $this->request->post('special');
		$news_content->capacity = (int) $this->request->post('capacity');
		$news_content->alcohol_level = (int) $this->request->post('alcohol_level');
		$news_content->news_contention_year = (int) $this->request->post('news_contention_year');

		$news_content->news_category = Jelly::query('news_category', (int) $this->request->post('news_category_id'))->select();
		
		try
		{
			$news_content->save();
		}
		catch(Exception $e)
		{
			Kohana::$log->add(Log::ERROR, 'Error to save news content ' . $news_content->name . '. By ' . $this->_user->full_name);
			Kohana::$log->add(Log::ERROR, 'Error message: ' . $e);
		}
		Kohana::$log->add(Log::INFO, 'News content ' . $news_content->name . ' has been saved by ' . $this->_user->full_name);

		$this->_return_index();
	}

	public function action_delete(){
		$this->auto_render(FALSE);

		$arr_news_content_id = isset($_POST['chk_id']) ? $_POST['chk_id'] : array('0');
		if(!Arr::is_array($arr_news_content_id)) $arr_news_content_id = array();
		Jelly::query('news_content')->delete_all($arr_news_content_id);

		$lst_cities = implode(',',$arr_news_content_id);
		Kohana::$log->add(Log::INFO,'News content ' . $lst_cities . ' has been deleted by ' . $this->_user->full_name);

		$this->_return_index();
	}

	public function action_reset()
	{
		$this->_session['news_content_filter'] = '';
		$this->_session['news_category_id'] = 0;
		$this->_session['news_content_pagination'] = 1;
		$this->_return_index();
	}

	public function action_populate()
	{
		$this->auto_render(FALSE);
		$news_category_id = (int) $this->request->param('id');
		$news_contents = Jelly::query('news_content')->list_by_category($news_category_id)->select();

		$content_obj = new stdClass;
		$content_obj->id = 0;
		$content_obj->name = '-- Nội dung tin --';
		$contents = array($content_obj);
		foreach($news_contents as $content){
			$content_obj = new stdClass;
			$content_obj->id = $content->id;
			$content_obj->name = $content->name;
			$contents[] = $content_obj;
		}
		$json = new Crypto_JSON;
		$this->response->body($json->encode($contents));
	}

	public function after()
	{
		$this->view()->head()->title('Quản lý nội dung tin');
		return parent::after();
	}

	private function _return_index()
	{
		$news_content_pagination = (int) $this->_session->get('news_content_pagination');
		if($news_content_pagination > 1)
		{
			$this->request->redirect('admin/news_content/' . $news_content_pagination);
		}
		else
		{
			$this->request->redirect('admin/news_content');
		}
	}
}