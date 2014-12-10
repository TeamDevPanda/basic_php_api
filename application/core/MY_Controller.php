<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller 
{
	private $CI = NULL;
	public $data = array();	
	
	function __construct() 
	{
		parent::__construct();
	}
	
	protected function is_ajax()
	{
		return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'));
	}

	protected function is_console()
	{
		return (isset($_SERVER['REMOTE_ADDR']) == FALSE);
	}
}