<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sitemap extends CI_Controller{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Sitemap_model');
	}
	
	public function index()
	{
		$this->load->view('sitemap');
	}
	
}
