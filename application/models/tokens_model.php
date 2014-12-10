<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tokens_model extends CI_Model {

	private $tableName = 'users';
	function __construct()
	{
		parent:: __construct();
	}
	
	function add_token($user)
	{
		$this->db->insert('tokens', $user);
		return ($this->db->insert_id());
	}
	
	function edit_token($id, $data)
	{
		$this->db->set($data);
		$this->db->where('id', $id);
		$this->db->update('tokens');
	}
}

/* End of file tokens_model.php */
/* Location: ./application/models/tokens_model.php */