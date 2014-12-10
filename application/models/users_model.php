<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends CI_Model {

	private $tableName = 'users';
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
	
	function check_creditentials($email, $password)
	{
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('email', $email);
		$this->db->where('password', $password);
		return ($this->db->get()->row());
	}	
}

/* End of file users_model.php */
/* Location: ./application/models/users_model.php */