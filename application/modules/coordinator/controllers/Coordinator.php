<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coordinator extends CI_Controller {
	
	private $sqtoken;
	private $sqtoken_hash;
	
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Dhaka');
		
		$active_user = $this->session->userdata('active_user');
		$userLogin = $this->session->userdata('userLogin');
		if($active_user === NULL && $userLogin !== TRUE)
		{
			redirect('coordinator/login', 'refresh', true);
		}
		
		$this->sqtoken = $this->security->get_csrf_token_name();
		$this->sqtoken_hash = $this->security->get_csrf_hash();
	}
	
	public function index()
	{
		redirect('coordinator/login', 'refresh', true);
	}
	
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('coordinator/login', 'refresh', true);
	}
	
}
