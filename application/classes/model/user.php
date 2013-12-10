<?php defined('SYSPATH') or die('No direct script access.');

class Model_User extends Jelly_Model{

	public static function initialize(Jelly_Meta $meta)
    {
        // The table the model is attached to
        $meta->table('users');

        // Fields defined by the model
        $meta->fields(array(
            'id' => Jelly::field('primary'),
            'full_name' => Jelly::field('string', array(
				'label' => 'full name',
				'rules' => array(
					array('not_empty'),
				),
			)),
            'user_name' => Jelly::field('string', array(
				'label' => 'user name',
				'rules' => array(
					array('not_empty'),
					array('min_length', array(':value', 4)),
					array('max_length', array(':value', 64)),
					array('regex', array(':value', '/^[-\pL\pN_.]++$/uD')),
				),
				'unique' => TRUE,
			)),
			'password' => Jelly::field('password', array(
				'label' => 'password',
				'rules' => array(
					array('not_empty'),
				),
				'hash_with' => array('Model_User', 'hash_password'),
			)),
            'email' => Jelly::field('email', array(
				'label' => 'email address',
				'rules' => array(
					array('not_empty'),
					array('min_length', array(':value', 4)),
					array('max_length', array(':value', 127)),
				),
				'unique' => TRUE,
			)),
			'tel' => Jelly::field('string'),
			'mobile' => Jelly::field('string'),
			'created' => Jelly::field('timestamp', array(
				'auto_now_create' => TRUE,
			)),
			'last_login' => Jelly::field('timestamp'),
			'logins' => Jelly::field('integer', array(
				'default' => 0,
				'convert_empty' => TRUE,
				'empty_value' => 0,
			)),
			'status' => Jelly::field('integer'),

            // Relationships to other models
            'tokens' => Jelly::field('hasmany', array(
				'foreign' => 'user_token',
			)),
            'roles' => Jelly::field('manytomany', array(
				'foreign' => 'role',
				'through' => 'user_role',
			)),
        ));
    }

	public function is_super_user()
	{
		return ((int) $this->id == 1);
	}
	
	public static function hash_password($password = '')
	{
		$hash_password = '';
		if(!empty($password))
		{
			$auth = Auth::instance();
			$hash_password = Crypto_Hash_Simple::compute_hash($auth->hash(md5($password)));
		}
		return $hash_password;
	}

	/**
	 * Complete the login for a user by incrementing the logins and saving login timestamp
	 *
	 * @return void
	 */
	public function complete_login()
	{
		if ($this->_loaded)
		{
			// Update the number of logins
			$this->logins = $this->logins + 1;

			// Set the last login date
			$this->last_login = time();

			// Save the user
			$this->save();
		}
	}

	/**
	 * Allows a model use both email and user_name as unique identifiers for login
	 *
	 * @param   string  unique value
	 * @return  string  field name
	 */
	public function unique_key($value)
	{
		return Valid::email($value) ? 'email' : 'user_name';
	}

	/**
	 * Password validation for plain passwords.
	 *
	 * @param array $values
	 * @return Validation
	 */
	public static function get_password_validation($values)
	{
		return Validation::factory($values)
			->rule('password', 'min_length', array(':value', 8))
			->rule('password_confirm', 'matches', array(':validation', ':field', 'password'));
	}

	/**
	 * Create a new user
	 *
	 * Example usage:
	 * ~~~
	 * $user = Jelly::factory('user')->create_user($_POST, array(
	 *	'username',
	 *	'password',
	 *	'email',
	 * );
	 * ~~~
	 *
	 * @param array $values
	 * @param array $expected
	 * @throws Validation_Exception
	 */
	public function create_user($values, $expected)
	{
		// Validation for passwords
		$extra_validation = Model_User::get_password_validation($values);

		return $this->set(Arr::extract($values, $expected))->save($extra_validation);
	}

	/**
	 * Update an existing user
	 *
	 * [!!] We make the assumption that if a user does not supply a password, that they do not wish to update their password.
	 *
	 * Example usage:
	 * ~~~
	 * $user = Jelly::factory('user', 1)
	 *	->update_user($_POST, array(
	 *		'username',
	 *		'password',
	 *		'email',
	 *	);
	 * ~~~
	 *
	 * @param array $values
	 * @param array $expected
	 * @throws Validation_Exception
	 */
	public function update_user($values, $expected)
	{
		if (empty($values['password']))
		{
			unset($values['password'], $values['password_confirm']);
		}

		// Validation for passwords
		$extra_validation = Model_User::get_password_validation($values);

		return $this->set(Arr::extract($values, $expected))->save($extra_validation);
	}
} // End Model User