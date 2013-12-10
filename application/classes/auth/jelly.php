<?php defined('SYSPATH') or die('No direct script access.');

class Auth_Jelly extends Auth{

	/**
	 * Checks if a session is active.
	 *
	 * @param   mixed    $role Role name string, role ORM object, or array with role names
	 * @return  boolean
	 */
	public function logged_in()
	{
		// Get the user from the session
		$user = $this->get_user();

		return ( ! $user) ? FALSE : TRUE;
	}

	/**
	 * Logs a user in.
	 *
	 * @param   string   username
	 * @param   string   password
	 * @param   boolean  enable autologin
	 * @return  boolean
	 */
	protected function _login($user, $password, $remember)
	{
	
		if ( ! is_object($user))
		{
			$username = $user;

			// Load the user
			$user = Jelly::query('user')
						->where(Jelly::factory('user')->unique_key($username), '=', $username)
						->limit(1)
						->select();
		}

		// If the passwords match, perform a login
		if (Crypto_Hash_Simple::verify_hash($password, $user->password))
		{
			if ($remember === TRUE)
			{
				// Token data
				$data = array(
					'user_id'    => $user->id,
					'expires'    => time() + $this->_config['lifetime'],
					'created'    => time(),
					'user_agent' => sha1(Request::$user_agent),
				);

				// Create a new autologin token
				$token = Jelly::factory('user_token')
							->set(array(
					        	'user'		 => $data['user_id'],
								'expires'	 => $data['expires'],
								'created'	 => $data['created'],
								'user_agent' => $data['user_agent'],
							))->save();

				// Set the autologin cookie
				Cookie::set('auth_auto_login', $token->token, $this->_config['lifetime']);
			}

			// Finish the login
			$this->complete_login($user);

			return TRUE;
		}

		// Login failed
		return FALSE;
	}

	/**
	 * Forces a user to be logged in, without specifying a password.
	 *
	 * @param   mixed    username string, or user ORM object
	 * @param   boolean  mark the session as forced
	 * @return  boolean
	 */
	public function force_login($user, $mark_session_as_forced = FALSE)
	{
		if ( ! is_object($user))
		{
			$username = $user;

			// Load the user
			$user = Jelly::query('user')
						->where(Jelly::factory('user')->unique_key($username), '=', $username)
						->limit(1)
						->select();
		}

		if ($mark_session_as_forced === TRUE)
		{
			// Mark the session as forced, to prevent users from changing account information
			$this->_session->set('auth_forced', TRUE);
		}

		// Run the standard completion
		$this->complete_login($user);
	}

	/**
	 * Logs a user in, based on the auth_auto_login cookie.
	 *
	 * @return  mixed
	 */
	public function auto_login()
	{
		if ($token = Cookie::get('auth_auto_login'))
		{
			// Load the token and user
			$token = Jelly::query('user_token')
							->where('token', '=', $token)
							->limit(1)
							->select();

			if ($token->loaded() AND $token->user->loaded())
			{
				if ($token->user_agent === sha1(Request::$user_agent))
				{
					// Save the token to create a new unique token
					$token->save();

					// Set the new token
					Cookie::set('auth_auto_login', $token->token, $token->expires - time());

					// Complete the login with the found data
					$this->complete_login($token->user);

					// Automatic login was successful
					return $token->user;
				}

				// Token is invalid
				$token->delete();
			}
		}

		return FALSE;
	}

	/**
	 * Gets the currently logged in user from the session (with auto_login check).
	 * Returns FALSE if no user is currently logged in.
	 *
	 * @return  mixed
	 */
	public function get_user($default = NULL)
	{
		$user = parent::get_user($default);

		if ( ! $user)
		{
			// check for "remembered" login
			$user = $this->auto_login();
		}

		return $user;
	}

	/**
	 * Log a user out and remove any autologin cookies.
	 *
	 * @param   boolean  completely destroy the session
	 * @param	boolean  remove all tokens for user
	 * @return  boolean
	 */
	public function logout($destroy = FALSE, $logout_all = FALSE)
	{
		// Set by force_login()
		$this->_session->delete('auth_forced');

		if ($token = Cookie::get('auth_auto_login'))
		{
			// Delete the autologin cookie to prevent re-login
			Cookie::delete('auth_auto_login');

			// Clear the autologin token from the database
			$token = Jelly::query('user_token')
							->where('token', '=', $token)
							->limit(1)
							->select();

			if ($token->loaded() AND $logout_all)
			{
				Jelly::query('user', $token->user->id)
						->select()
						->get('user_tokens')
						->delete();
			}
			elseif ($token->loaded())
			{
				$token->delete();
			}
		}

		return parent::logout($destroy);
	}

	/**
	 * Get the stored password for a username.
	 *
	 * @param   mixed   username string, or user ORM object
	 * @return  string
	 */
	public function password($user)
	{
		if ( ! is_object($user))
		{
			$username = $user;

			// Load the user
			$user = Jelly::query('user')
							->where(Jelly::factory('user')->unique_key($username), '=', $username)
							->limit(1)
							->select();
		}

		return $user->password;
	}

	public function change_password($password, $new_password){
		$status = false;
		if($this->check_password(md5($password)))
		{
			$user = $this->get_user();			
			$user->password = $new_password;
			$user->save();
			$status = true;
		}
		return $status;
	}
	
	/**
	 * Complete the login for a user by incrementing the logins and setting
	 * session data: user_id, username, roles.
	 *
	 * @param   object  user ORM object
	 * @return  void
	 */
	protected function complete_login($user)
	{
		$user->complete_login();

		return parent::complete_login($user);
	}

	/**
	 * Compare password with original (hashed). Works for current (logged in) user
	 *
	 * @param   string  $password
	 * @return  boolean
	 */
	public function check_password($password)
	{
		$user = $this->get_user();

		if ( ! $user)
			return FALSE;

		return Crypto_Hash_Simple::verify_hash($this->hash($password), $user->password);
	}

} // End Auth ORM