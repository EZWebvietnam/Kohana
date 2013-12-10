<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Builder_User_Token extends Model_Builder_Core{

	public function delete_all_by_user(array $arr_user_id = array(), $db = NULL)
	{
		$db = $this->_db($db);	
		return $this->_build(Database::DELETE)->where('user_id', 'IN', $arr_user_id)->execute($db);
	}

} // End User Builder Token Model