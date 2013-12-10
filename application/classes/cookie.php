<?php defined('SYSPATH') or die('No direct script access.');

class Cookie extends Kohana_Cookie{
    // Set a new salt
    public static $salt = '9ZuTXEYtt4cXPuwGW8meBakQSlcEjy1';
 
    // Don't allow javascript access to cookies
    public static $httponly = TRUE; 
}