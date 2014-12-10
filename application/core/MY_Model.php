<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model
{	
	function __construct()
	{
		parent::__construct();
	
		if ( ! isset($this->db)) {
			$this->load->database();
		}
	}
}

/* End of file MY_Model.php */
/* Location: ./application/core/MY_Model.php */