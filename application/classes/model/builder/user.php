<?php defined('SYSPATH') or die('No direct script access.');

class Model_Builder_User extends Model_Builder_Core{

	public function active()
    {
		return $this->where('last_login', '>', strtotime('-3 month'));
    }

	public function user_filter($filter = '', $status = '')
	{
		if(!empty($filter))
		{
			$filter_text = '%' . $filter . '%';
			$this->where_open()
				 ->or_where('full_name', 'like', $filter_text)
				 ->or_where('user_name', 'like', $filter_text)
				 ->or_where('email', 'like', $filter_text)
				 ->where_close();
		}
		if($status != '')
		{
			$this->where('status', '=', (int) $status);
		}
		return $this;
	}
} // End Model Builder User