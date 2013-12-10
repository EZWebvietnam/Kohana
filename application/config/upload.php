<?php defined('SYSPATH') or die('No direct access allowed.');

return array(
	'create_directories' => TRUE,
	'directory'          => DOCROOT . 'upload',
	'remove_spaces'      => TRUE,
	'allowed_types'      => array('gif', 'jpg', 'jpeg' , 'png', 'tiff', 'bmp'),
	'allowed_size'       => '2M',
	'resize_dimension'   => array(150, 150),
	'resize_type'        => Image::AUTO,  //0x01:NONE; 0x02:HEIGHT; 0x03:WIDTH; 0x04:AUTO; 0x05:INVERSE
	'secret_key'         => '9UTeYArdJ9QT5up9LQnmDDJWs5GfAF0',
);
