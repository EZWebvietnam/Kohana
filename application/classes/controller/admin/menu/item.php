<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Admin_Menu_Item extends Controller_Admin{

	public function action_index()
	{
		$filter = HTML::chars($this->request->post('menu_item_filter'));
		if(!empty($filter))
		{
			$this->_session['menu_item_filter'] = $filter;
		}
		else
		{
			$filter = $this->_session['menu_item_filter'];
		}

		$parent_id = (int) $this->_session['parent_menu_item_id'];

		$pagination = new Pagination;
		$jelly_query = Jelly::query('menu_item')->filter_all($filter, array('name'))->by_parent($parent_id);

		$pagination->total_items = $jelly_query->count();
		$this->_session['menu_item_pagination'] = (int) $pagination->current_page;

		$content = View::factory('admin/menu_item/list')
						->bind('menu_item_filter', $filter)
						->bind('parent_id', $parent_id)
						->bind('pagination', $pagination)
						->set('menu_items', $jelly_query->paging($pagination->offset)->select());
		$this->_view->content($content);
	}

	public function action_edit()
	{
		$id = (int) $this->request->param('id');
		$menu_item = Jelly::query('menu_item', (int) $id)->select();
		$params = empty($menu_item->params) ? new Data_Menu_Params : unserialize($menu_item->params);

		$content = View::factory('admin/menu_item/edit')
						->bind('menu_item', $menu_item)
						->bind('params', $params)
						->set('news_categories', Jelly::query('news_category')->select()->as_array('id', 'name'))
						->set('product_categories', Jelly::query('product_category')->select()->as_array('id', 'name'))
						->set('menu_item_pagination', $this->_session['menu_item_pagination']);
		$this->_view->content($content);
	}

	public function action_save()
	{
		$this->auto_render(FALSE);

		$id = (int) $this->request->post('id');
		$menu_item = Jelly::query('menu_item', (int) $id)->select();

		$menu_item->set(
			Arr::extract(
				Arr::map('htmlspecialchars', $_POST),
				array(
					'name',
				), ''
			)
		);
		$menu_item->sort_order = (int) $this->request->post('sort_order');
		$menu_item->item_type = (int) $this->request->post('item_type');
		$menu_item->parent = Jelly::query('menu_item', (int) $this->_session['parent_menu_item_id'])->select();

		$params = new Data_Menu_Params;
		$params->url_name = $this->request->post('url_name');
		$params->news_category_id = (int) $this->request->post('news_category_id');
		$params->news_content_id = (int) $this->request->post('news_content_id');
		$params->product_category_id = (int) $this->request->post('product_category_id');
		$params->product_id = (int) $this->request->post('product_id');
		switch($menu_item->item_type)
		{
			case 1:
				$news_category = Jelly::query('news_category', (int) $params->news_category_id)->select();
				if($news_category->loaded())
				{
					$params->url_name = 'news/' . $news_category->id . '_' . $news_category->friendly_url;
				}
				break;
			case 2:
				$news_content = Jelly::query('news_content', (int) $params->news_content_id)->select();
				if($news_content->loaded())
				{
					$params->url_name = 'content/' . $news_content->id . '_' . $news_content->friendly_url;
				}
				break;
			case 3:
				$product_category = Jelly::query('product_category', (int) $params->product_category_id)->select();
				if($product_category->loaded())
				{
					$params->url_name = 'category/' . $product_category->id . '_' . $product_category->friendly_url;
				}
				break;
			case 4:
				$product = Jelly::query('product', (int) $params->product_id)->select();
				if($product->loaded())
				{
					$params->url_name = 'product/' . $product->id . '_' . $product->friendly_url;
				}
				break;
		}

		$menu_item->params = serialize($params);

		try
		{
			$menu_item->save();
		}
		catch(Exception $e)
		{
			Kohana::$log->add(Log::ERROR, 'Error to save menu item ' . $menu_item->name . '. By ' . $this->_user->full_name);
			Kohana::$log->add(Log::ERROR, 'Error message: ' . $e);
		}
		Kohana::$log->add(Log::INFO, 'Menu item ' . $menu_item->name . ' has been saved by ' . $this->_user->full_name);
		$this->_return_index();
	}

	public function action_delete()
	{
		$this->auto_render(FALSE);

		$arr_menu_item_id = $this->request->post('chk_id');
		if(!Arr::is_array($arr_menu_item_id)) $arr_menu_item_id = array('0');
		Jelly::query('menu_item')->delete_all($arr_menu_item_id);

		$lst_menu_items = implode(',',$arr_menu_item_id);
		Kohana::$log->add(Log::INFO, 'Menu items ' . $lst_menu_items . ' has been deleted by ' . $this->_user->full_name);
		$this->_return_index();
	}

	public function action_children(){
		$parent_menu_item_id = (int) $this->request->param('id');
		$this->_session['parent_menu_item_id'] = $parent_menu_item_id;
		$this->_return_index();
	}

	public function action_back(){
		$parent_menu_item_id = (int) $this->_session['parent_menu_item_id'];
		if($parent_menu_item_id > 0){
			$menu_item = Jelly::query('menu_item', $parent_menu_item_id)->select();
			$this->_session['parent_menu_item_id'] = $menu_item->parent_id;
		}
		$this->_return_index();
	}

	public function action_reset()
	{
		$this->_session['menu_item_filter'] = '';
		$this->_session['menu_item_pagination'] = 1;
		$this->_return_index();
	}

	public function action_params()
	{
		$this->auto_render(FALSE);
		$id = (int) $this->request->param('id');
		$menu_item = Jelly::query('menu_item', (int) $id)->select();
		$json = new Crypto_JSON;
		$this->response->body($json->encode($menu_item->params()));
	}
		
	public function after()
	{
		$this->view()->head()->title('Quản lý menu');
		return parent::after();
	}

	private function _return_index()
	{
		$menu_item_pagination = (int) $this->_session->get('menu_item_pagination');
		if($menu_item_pagination > 1)
		{
			$this->request->redirect('admin/menu_item/' . $menu_item_pagination);
		}
		else
		{
			$this->request->redirect('admin/menu_item');
		}
	}
}