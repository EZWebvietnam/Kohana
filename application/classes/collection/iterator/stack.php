<?php defined('SYSPATH') or die('No direct script access.');

class Collection_Iterator_Stack implements Iterator{
	/**
	 * @var array the data to be iterated through
	 */
	private $_data;
	/**
	 * @var integer index of the current item
	 */
	private $_index;
	/**
	 * @var integer count of the data items
	 */
	private $_count;

	/**
	 * Constructor.
	 * @param array the data to be iterated through
	 */
	public function __construct(&$data)
	{
		$this->_data = &$data;
		$this->_index = 0;
		$this->_count = count($this->_data);
	}

	/**
	 * Rewinds internal array pointer.
	 * This method is required by the interface Iterator.
	 */
	public function rewind()
	{
		$this->_index = 0;
		return $this;
	}

	/**
	 * Returns the key of the current array item.
	 * This method is required by the interface Iterator.
	 * @return integer the key of the current array item
	 */
	public function key()
	{
		return $this->_index;
	}

	/**
	 * Returns the current array item.
	 * This method is required by the interface Iterator.
	 * @return mixed the current array item
	 */
	public function current()
	{
		return $this->_data[$this->_index];
	}

	/**
	 * Moves the internal pointer to the next array item.
	 * This method is required by the interface Iterator.
	 */
	public function next()
	{
		$this->_index++;
		return $this;
	}

	/**
	 * Returns whether there is an item at current position.
	 * This method is required by the interface Iterator.
	 * @return boolean
	 */
	public function valid()
	{
		return $this->_index < $this->_count;
	}
}
