<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Front_Contact extends Controller_Front {
	private $breadcrumb = array();

	public function before()
	{
		$item = new Data_Breadcrumb;
		$item->url = URL::site();
		$item->name = 'Trang Chủ';
		$this->breadcrumb[] = $item;

		$item = new Data_Breadcrumb;
		$item->url = URL::site('contact');
		$item->name = 'Liên Hệ';
		$this->breadcrumb[] = $item;

		View::bind_global('breadcrumb', $this->breadcrumb);
		parent::before();
	}

	public function action_index()
	{
		$contact = Jelly::factory('contact');
		$contact->set(
			Arr::extract(
				Arr::map('Utils::clean_html', $_POST),
				array(
					'name',
					'email',
					'telephone',
					'address',
					'subject',
					'content',
				), ''
			)
		);

		$key = Kohana::$config->load('encrypt.default.secret_key');
		$content = View::factory('front/contact/index');
		$secret_key = $this->request->post('secret_key');
		if (Crypto_Hash_Simple::verify_hash($key, $secret_key))
		{
			$captcha = $this->request->post('captcha');
			if(Captcha::valid($captcha))
			{				
				$contact->read = 0;
				$contact->status = 0;
				$contact->save();
				$this->request->redirect('contact/send');
			}
			else
			{
				$content->invalid_captcha = 1;
			}
		}
		$content->secret_key = Crypto_Hash_Simple::compute_hash($key);
		$content->bind('contact', $contact);
		$this->view()->content($content);
	}

	public function action_send()
	{
		$this->view()->content(View::factory('front/contact/send'));
	}
} // End Controller Contact
