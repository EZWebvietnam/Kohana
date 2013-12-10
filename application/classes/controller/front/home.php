<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Front_Home extends Controller_Front {

	public function action_index()
	{
		$this->_view->content(
			View::factory('front/home/index')
				->set('products', Jelly::query('product')->list_latest(8)->select_all())
		);
	}

	public function action_left_special()
	{
		$this->partial();
		$this->response->body(
			View::factory('front/left_special')
				->set('products', Jelly::query('product')->list_by_special()->paging(0, 2)->select_all())
		);
	}
	
	public function action_left_origin()
	{
		$this->partial();
		$origin_id = (int) $this->request->param('id');

		$this->response->body(
			View::factory('front/left_origin')
				->set('origin_id', $origin_id)
				->set('origins', Jelly::query('origin')->select_all())			
		);
	}
	
	public function action_left_menu()
	{
		$this->partial();
		$category_id = (int) $this->request->param('id');
		$selected_category = Jelly::query('product_category', $category_id)->select();
		$list_selected_id = new Collection_List;
		while($selected_category->loaded())
		{
			$list_selected_id->add($selected_category->id);
			$selected_category = $selected_category->parent;
		}

		$this->response->body(
			View::factory('front/left_menu')
				->set('category_id', $category_id)
				->set('list_selected_id', $list_selected_id)
				->set('categories', $this->_populate_product_categories($list_selected_id))
		);
	}
	
	public function action_menu()
	{
		$this->partial();
		$menu_item_id = (int) $this->request->param('id');
		$this->response->body(
			View::factory('front/menu')
				->set('menu_item_id', $menu_item_id)
				->set('menu_items', Jelly::query('menu_item')->by_parent(0)->sort_order()->select_all())
		);
	}
	
	public function action_footer()
	{
		$this->partial();
		$menu_item_id = (int) $this->request->param('id');
		$this->response->body(
			View::factory('front/footer')
				->set('menu_item_id', $menu_item_id)
				->set('menu_items', Jelly::query('menu_item')->by_parent(0)->sort_order()->select_all())
		);
	}

	public function action_currency()
	{
		$this->partial();
		$currency_id = (int) $this->request->post('currency_id');
		$this->_session['currency_id'] = $currency_id;
		$this->request->redirect($this->request->referrer());
	}

	private static $_category_level = 0;

	private function _populate_product_categories(Collection_List $list_selected_id, $parent_id = 0)
	{
		$categories = Jelly::query('product_category')->by_parent((int) $parent_id)->sort_order()->select_all();
		$list_categories = new Collection_List;
		foreach($categories as $category)
		{
			$category->level = self::$_category_level;
			$list_categories->add($category);
			if($category->have_children() AND $list_selected_id->contains($category->id))
			{
				self::$_category_level++;
				$list_categories->merge_with($this->_populate_product_categories($list_selected_id, (int) $category->id));
				self::$_category_level--;
			}
		}
		return $list_categories;
	}
} // End Controller Front Home
