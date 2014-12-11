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
	
	/**
	 * @api {post} /users/login login
	 * @apiDescription Allow to login with user creditentials
	 * @apiName login
	 * @apiGroup Users
	 * @apiVersion 0.1.0
	 *
	 * @apiParam {String} email User email
	 * @apiParam {String} password User password
	 *
	 * @apiParamExample {json} Request-Example:
	 *  {
	 *	   "email":     "",
	 *	   "password":  ""
	 * }
	 *
	 * @apiSampleRequest http://localhost:3000/users/login
	 *
	 * @apiSuccess {JSON} user user infos json data
	 * @apiSuccessExample Success
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "user": {
	 *		 	"firstname": "",
	 *	        "lastname":  "",
	 *	        "email":     ""
	 *       }
	 *     }
	 *
	 * @apiError (4xx) {String} AuthentificationFailed Bad authentification
	 * @apiError (5xx) {String} InternalServerError An anexpected error was occured
	 * @apiErrorExample Error 400
	 *     HTTP/1.1 400 Bad Request
	 *     {
	 *       "msg": "Missing parameters",
	 *     }
	 *
	 * @apiErrorExample Error 500
	 *     HTTP/1.1 500 Internal Server Error
	 *     {
	 *       "msg": "Unexpected error was occured",
	 *     }
	 *
	 */
	
	public function login()
	{
		$this->form_validation->set_rules('email', 'email', 'required');
		$this->form_validation->set_rules('password', 'password', 'required');
		
		if ($this->form_validation->run())
		{
			$email 		= $this->input->post('email', true);
			$password	= crypt($this->input->post('password', true), 's6XgDgI33IF8P06uxw5eJA4nY0s8t1u5');
			$user = $this->users->check_identity($email, $password);
			if ($user)
			{
				//print_r($this->_newToken($user->id));
				//exit();
				$tk = $this->tokens->add_token($this->_newToken($user->id));
				$token = $this->tokens->get_token_by_id($tk, 'public_token, private_token, expiration');
				$result = array('user' => $user, 'token' => $token);
				$this->_sending_response($result);
			}
			else
			{
				$result = array('code' => 00, 'msg' => 'Authentification failed');
				$this->_sending_response($result, 400);
			}
		}
		else
		{
			$result = array('code' => 00, 'msg' => 'Missing parameters');
			$this->_sending_response($result, 400);
		}
	}
	
	/**
	 * @api {post} /users/add Add new user
	 * @apiDescription Add new user to users collection
	 * @apiName add
	 * @apiGroup Users
	 * @apiVersion 0.1.0
	 *
	 * @apiParam {String} firstname User firstname
	 * @apiParam {String} lastname User lastname
	 * @apiParam {String} email User email
	 * @apiParam {String} password User password
	 *
	 * @apiParamExample {json} Request-Example:
	 *  {
	 *     	   "firstname": "",
	 *	   "lastname":  "",
	 *	   "email":     "",
	 *	   "password":  ""
	 * }
	 *
	 * @apiSampleRequest http://localhost:3000/users/add
	 *
	 * @apiSuccess {String} msg Adding user success
	 * @apiSuccessExample Success
	 *     HTTP/1.1 200 OK
	 *     {
	 *       "msg": "Adding user success",
	 *     }
	 *
	 * @apiError (4xx) {String} BadRequest Missing parameters
	 * @apiError (5xx) {String} InternalServerError An anexpected error was occured
	 * @apiErrorExample Error 400
	 *     HTTP/1.1 400 Bad Request
	 *     {
	 *       "msg": "Missing parameters",
	 *     }
	 *
	 * @apiErrorExample Error 500
	 *     HTTP/1.1 500 Internal Server Error
	 *     {
	 *       "msg": "Unexpected error was occured",
	 *     }
	 *
	 */
	 
	 public function add()
	 {
	 	$this->form_validation->set_rules('email', 'email', 'required');
	 	$this->form_validation->set_rules('password', 'password', 'required');
	 	$this->form_validation->set_rules('firstname', 'firstname', 'required');
	 	$this->form_validation->set_rules('lastname', 'lastname', 'required');
		
		if ($this->form_validation->run())
		{
			$email 		= $this->input->post('email', true);
			$password	= crypt($this->input->post('password', true), 's6XgDgI33IF8P06uxw5eJA4nY0s8t1u5');
			$firstname	= $this->input->post('firstname', 'firstname', true);
			$lastname	= $this->input->post('lastname', 'lastname', true);
			$exist = $this->users->get_user_by(array('email' => $email));
			
			// Email pattern check
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
			{
				$result = array('code' => 00, 'msg' => 'Creating failed');
				$this->_sending_response($result, 400);
			}
			
			// User already exist
			if ($exist)
			{
				$result = array('code' => 00, 'msg' => 'Email already used');
				$this->_sending_response($result, 400);
			}
			
			$array = array(
				'email'		=> $email,
				'password'	=> $password,
				'firstname'	=> $firstname,
				'lastname'	=> $lastname,
				'date'		=> date('Y-m-d H:i:s'));
			
			// Adding new user
			$id = $this->users->add_user($array);
			$new = $this->users->get_user_by_id($id, 'firstname, lastname, email');
			
			$result = array('user' => $new);
			$this->_sending_response($result, 201);
		}
		else
		{
			$result = array('code' => 00, 'msg' => 'Missing parameters');
			$this->_sending_response($result, 400);
		}
	 }
	
	/** **************************
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
	
	private function _newToken($user)
	{
		$public		= $this->_randomKey(32);
		$private	= $this->_randomKey(128);
		$expiration	= date('Y-m-d H:i:s', strtotime('+1 DAYS'));
		
		$newToken 	= array(
			'public_token'	=> $public,
			'private_token'	=> $private,
			'expiration'	=> $expiration,
			'user'			=> $user);
			
		return ($newToken);
	}
	
	private function _sending_response($result, $status = 200)
	{
		http_response_code($status);
		header('Content-Type: application/json');
		echo json_encode($result);
		exit();
	}
}

/* End of file users.php */
/* Location: ./application/controllers/users.php */