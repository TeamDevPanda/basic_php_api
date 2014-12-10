<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {

	function __construct()
	{
		parent:: __construct();
	}
	
	
	public function index($new_account = false)
	{
		echo 'hello world';
	}
	
	/*
	** *******************************************************
	** PRIVATE FUNCTIONS
	** *******************************************************
	*/
	
	private function _randomKey($length = 10) 
	{
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) 
	    {
	        $randomString .= $characters[rand(0, strlen($characters) - 1)];
	    }
	    
	    return $randomString.date('si');
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */