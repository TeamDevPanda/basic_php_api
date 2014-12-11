<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tokens_model extends CI_Model {

	function __construct()
	{
		parent:: __construct();
	}
	
	function add_token($token)
	{
		$this->db->insert('tokens', $token);
		return ($this->db->insert_id());
	}
	
	function edit_token($id, $data)
	{
		$this->db->set($data);
		$this->db->where('id', $id);
		$this->db->update('tokens');
	}
	
	function get_token_by_id($id, $fields = '*')
	{
		$this->db->select($fields);
		$this->db->from('tokens');
		$this->db->where('id', $id);
		return ($this->db->get()->row());
	}
}

/* End of file tokens_model.php */
/* Location: ./application/models/tokens_model.php */