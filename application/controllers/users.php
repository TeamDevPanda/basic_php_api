<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends MY_Controller {

	function __construct()
	{
		parent:: __construct();
		
		$this->load->model('users_model', 'users');
		$this->load->model('tokens_model', 'tokens');
	}
	
	public function index($new_account = false)
	{
	}
	
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

/* End of file users.php */
/* Location: ./application/controllers/users.php */