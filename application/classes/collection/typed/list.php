<?php defined('SYSPATH') or die('No direct script access.');

class Collection_Typed_List extends Collection_List{
	private $_type;

	/**
	 * Constructor.
	 * @param string class type
	 */
	public function __construct($type)
	{
		$this->_type = $type;
	}

	/**
	 * Inserts an item at the specified position.
	 * This method overrides the parent implementation by
	 * checking the item to be inserted is of certain type.
	 * @param integer the specified position.
	 * @param mixed new item
	 * @throws Kohana_Exception If the index specified exceeds the bound,
	 * the list is read-only or the element is not of the expected type.
	 */
	public function insert_at($index, $item)
	{
		if($item instanceof $this->_type)
		{
			parent::insert_at($index, $item);
		}
		else
		{
			throw new Kohana_Exception('Collection_Typed_List<:type> can only hold objects of :type class.', array(':type' => $this->_type));
		}
	}
}
