<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Default auth user toke
 *
 * @package    Model/User/Token
 * @author     Kohana Team
 * @copyright  (c) 2007-2011 Kohana Team
 * @license    http://kohanaframework.org/license
 */
class Model_User_Token extends Jelly_Model{

	public static function initialize(Jelly_Meta $meta)
    {
        // The table the model is attached to
        $meta->table('user_tokens');

        // Fields defined by the model
        $meta->fields(array(
            'id' => Jelly::field('primary'),
			'user_agent' => Jelly::field('string'),
			'token' => Jelly::field('string', array(
				'unique' => TRUE,
			)),
			'type' => Jelly::field('string'),
			'created' => Jelly::field('timestamp', array(
				'auto_now_create' => TRUE,
			)),
			'expires' => Jelly::field('timestamp'),

            // Relationships to other models
			'user' => Jelly::field('belongsto', array(
				'column' => 'user_id',
				'foreign' => 'user',
			)),
        ));
    }

	/**
	 * Handles garbage collection and deleting of expired objects.
	 *
	 * @return  void
	 */
	public function __construct($id = NULL)
	{
		parent::__construct($id);

		if (mt_rand(1, 100) === 1)
		{
			// Do garbage collection
			$this->delete_expired();
		}

		if ($this->expires < time() AND $this->loaded())
		{
			// This object has expired
			$this->delete();
		}
	}

	/**
	 * Deletes all expired tokens.
	 *
	 * @return  Jelly
	 */
	public function delete_expired()
	{
		// Delete all expired tokens
		DB::delete($this->meta()->table())
			->where('expires', '<', time())
			->execute($this->meta()->db());

		return $this;
	}

	public function save(Validation $validation = NULL)
	{
		$this->token = $this->create_token();

		return parent::save($validation);
	}

	protected function create_token()
	{
		do
		{
			$token = sha1(uniqid(Text::random('alnum', 32), TRUE));
		}
		while(Jelly::query('user_token')->where('token', '=', $token)->limit(1)->select()->loaded());

		return $token;
	}

} // End User Token Model