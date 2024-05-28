<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Templates extends CI_Controller{
	
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Dhaka');
	}
	
	public function index()
	{
		$this->load->view('design/home');
	}
	
	public function course()
	{
		
	}
	
	public function result()
	{
		
	}
	
	public function payment()
	{
		
	}
	
	public function exam()
	{
		
	}
	
	public function contact()
	{
		
	}
	
	public function apply()
	{
		
	}
	
}