<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Minify extends Controller{
	public function action_js()
	{
		$group = (string) $this->request->param('group');
		if(empty($group)) $group = 'default';
		if(!$content = Kohana::cache('minify::js::'.$group))
		{
			$path = (string) Kohana::$config->load('minify.js.' . $group . '.path');
			$files = Kohana::$config->load('minify.js.' . $group . '.files');
			if(!is_array($files)) $files = array();

			$content = '';
			foreach($files as $file)
			{
				$content .= file_get_contents($path . DIRECTORY_SEPARATOR . $file);
			}
			if(!empty($content))
			{
				if((bool) Kohana::$config->load('minify.js.' . $group . '.packer'))
				{
					$packer = new Minify_Packer($content);
					$content = $packer->pack();
				}
				else
				{
					$content = Minify_JS::minify($content);
				}
			}

			if((bool) Kohana::$config->load('minify.cache'))
			{
				$cache_lifetime = (int) Kohana::$config->load('minify.cache_lifetime');
				Kohana::cache('minify::js::'.$group, $content, $cache_lifetime);
			}
		}
		$this->response->body($content);
	}

	public function action_css()
	{
		$group = (string) $this->request->param('group');
		if(empty($group)) $group = 'default';
		if(!$content = Kohana::cache('minify::css::'.$group))
		{
			$path = (string) Kohana::$config->load('minify.css.' . $group . '.path');
			$files = Kohana::$config->load('minify.css.' . $group . '.files');
			if(!is_array($files)) $files = array();

			$content = '';
			foreach($files as $file)
			{
				$content .= file_get_contents($path . DIRECTORY_SEPARATOR . $file);
			}

			if(!empty($content))
			{
				$content = Minify_CSS::minify($content, array('current_dir' => $path));
			}

			if((bool) Kohana::$config->load('minify.cache'))
			{
				$cache_lifetime = (int) Kohana::$config->load('minify.cache_lifetime');
				Kohana::cache('minify::css::'.$group, $content, $cache_lifetime);
			}
		}
		$this->response->body($content);
	}

	public function after()
	{
		if((bool) Kohana::$config->load('minify.compression'))
		{
			ob_start ("ob_gzhandler");
		}

		switch(strtolower($this->request->action()))
		{
			case 'css':
				$this->_headers('text/css');
				break;
			case 'js':
				$this->_headers('application/javascript');
				break;
			default:
				$this->_headers('text/html');
				break;
		}
	}

	private function _headers($ctype)
	{
		$group = (string) $this->request->param('group');
		if(!$etag = Kohana::cache('minify_cache_etag_' . $ctype . $group))
		{
			$etag = $this->request->generate_etag();
			Kohana::cache('minify_cache_etag_' . $ctype . $group, $etag);
		}
		$this->response->headers('Content-Type', $ctype)->check_cache($etag, $this->request);
					   //->headers('Expires', gmdate("D, d M Y H:i:s", time() + (int) Kohana::$config->load('minify.expires')) . ' GMT');
	}
}
