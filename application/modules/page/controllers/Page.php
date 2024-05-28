<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Page_model');
	}
	
	public function index()
	{
		$data['slug'] = html_escape($this->uri->segment(2));
		$this->load->view('page', $data);
	}
	
}
