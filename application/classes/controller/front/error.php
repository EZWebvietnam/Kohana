<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Front_Error extends Controller_Front {

	public function before()
	{
		parent::before();
	 
		$this->_view->page = URL::site(rawurldecode(Request::$initial->uri()));
	 
		// Internal request only!
		if (Request::$initial !== Request::$current)
		{
			if ($message = rawurldecode($this->request->param('message')))
			{
				$this->_view->message = $message;
			}
		}
		else
		{
			$this->request->action(404);
		}
	 
		$this->response->status((int) $this->request->action());
	}

	public function action_404()
	{
		$this->_view->title = '404 Not Found';
	 
		// Here we check to see if a 404 came from our website. This allows the
		// webmaster to find broken links and update them in a shorter amount of time.
		if (isset ($_SERVER['HTTP_REFERER']) AND strstr($_SERVER['HTTP_REFERER'], $_SERVER['SERVER_NAME']) !== FALSE)
		{
			// Set a local flag so we can display different messages in our template.
			$this->_view->local = TRUE;
		}
	 
		// HTTP Status code.
		$this->response->status(404);
	}
	 
	public function action_503()
	{
		$this->_view->title = 'Maintenance Mode';
	}
	 
	public function action_500()
	{
		$this->_view->title = 'Internal Server Error';
	}
} // End Controller Front Error
