<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Router extends CI_Router
{
    function _set_request($segments = array()) {
        parent::_set_request(preg_replace('#-#Uis', '_', $segments));
    }
}