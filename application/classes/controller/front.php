<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Front extends Controller_Base {
	protected $page_title = 'Mua bán ruou, ruou vang, rượu, wine giá tốt nhất. ';
	protected $meta_keywords = 'Mua bán ruou, ruou vang, rượu, wine giá tốt nhất. ';
	protected $meta_description = 'Mua bán ruou, ruou vang, rượu, wine giá tốt nhất. ';

	protected $currency = null;
	
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);
		$this->_layout = 'front/layout';

		$currency_id = (int) $this->_session['currency_id'];
		$currency = Jelly::query('currency', $currency_id)->select();
		if(!$currency->loaded())
		{
			$currency = Jelly::query('currency')->limit(1)->select();
		}
		$this->currency = $currency;
	}

	public function before()
	{
		parent::before();
		View::bind_global('currency', $this->currency);
	}
	
	public function after()
	{
		if ($this->_auto_render)
		{
			$this->view()
				->bind('meta_keywords', $this->meta_keywords)
				->bind('meta_description', $this->meta_description)
				->head()->title('Presente | Luxury Gift Basket - ' . $this->page_title);
		}
		parent::after();
	}

	protected function _populate_meta_data($model)
	{
		$this->page_title .= $model->page_title;
		$this->meta_keywords .= $model->meta_keywords;
		$this->meta_description .= $model->meta_description;
	}
} // End Controller Home
