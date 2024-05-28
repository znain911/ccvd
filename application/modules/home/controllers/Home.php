<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	
	public function __construct()
	{
      parent::__construct();
	  $this->load->model('Faqs_model');
	  $this->load->model('Home_model');
	}
	
	public function index()
	{
      $this->load->view('index');
	  /*$this->load->view('maintenance');*/
	}
	
}
