<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends CI_Model {

	function __construct()
	{
		parent:: __construct();
	}
	
	function get_user_by_id($id, $fields = '*')
	{
		$this->db->select($fields);
		$this->db->from('users');
		$this->db->where('id', $id);
		return ($this->db->get()->row());
	}
	
	function get_user_by($where, $fields = '*', $ret = 'row')
	{
		$this->db->select($fields);
		$this->db->from('users');
		$this->db->where($where);
		if ($ret == 'result')
			return ($this->db->get()->result());
		return ($this->db->get()->row());
	}
	
	function add_user($user)
	{
		$this->db->insert('users', $user);
		return ($this->db->insert_id());
	}

	function edit_user($id, $data)
	{
		$this->db->set($data);
		$this->db->where('id', $id);
		$this->db->update('users');
	}
	
	function check_identity($email, $password)
	{
		$this->db->select('id, firstname, lastname, email');
		$this->db->from('users');
		$this->db->where('email', $email);
		$this->db->where('password', $password);
		return ($this->db->get()->row());
	}	
}

/* End of file users_model.php */
/* Location: ./application/models/users_model.php */