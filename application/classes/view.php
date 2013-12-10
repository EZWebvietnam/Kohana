<?php defined('SYSPATH') or die('No direct script access.');

class View extends Kohana_View{
	protected $_head;
	protected $_layout;

	// Content blocks
	protected static $_blocks = array();

	public function __construct($file = NULL, array $data = NULL)
	{
		parent::__construct($file, $data);
		$this->bind('head', $this->head());
	}

	public function & head()
	{
		if($this->_head === NULL)
		{
			$this->_head = new View_Head;
		}
		return $this->_head;
	}

	public function content($content = NULL)
	{
		if($content !== NULL)
		{
			$this->bind('content', $content);
		}
		return $this;
	}

	public static function block($name, $closure = null)
	{
		if(!isset(self::$_blocks[$name]))
		{
			self::$_blocks[$name] = new View_Block($name, $closure);
		}
		return self::$_blocks[$name];
	}
	
	public static function partial($template, array $vars = array())
	{
		return View::factory($template, $vars);
	}
}