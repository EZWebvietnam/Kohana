<?php defined('SYSPATH') OR die('No direct access allowed.');

abstract class Data_Core{

	public function __get($name)
	{
		$getter = 'get' . $name;
		if(method_exists($this, $getter))
			return $this->$getter();
		else
			throw new Kohana_Exception('Property "' . get_class($this) . '.' . $name . '" is not defined.');
	}

	public function __set($name,$value)
	{
		$setter = 'set' . $name;
		if(method_exists($this, $setter))
			$this->$setter($value);
		elseif(method_exists($this, 'get' . $name))
			throw new Kohana_Exception('Property "' . get_class($this) . '.' . $name . '" is read only.');
		else
			throw new Kohana_Exception('Property "' . get_class($this) . '.' . $name . '" is not defined.');
	}

	public function __isset($name)
	{
		$getter = 'get' . $name;
		if(method_exists($this, $getter))
			return $this->$getter() !== null;
		else
			return false;
	}

	public function __unset($name)
	{
		$setter = 'set' . $name;
		if(method_exists($this, $setter))
			$this->$setter(null);
		elseif(method_exists($this, 'get' . $name))
			throw new Kohana_Exception('Property "' . get_class($this) . '.' . $name . '" is read only.');
	}
}
?>