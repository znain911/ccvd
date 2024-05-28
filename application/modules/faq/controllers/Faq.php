<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq extends CI_Controller {
	
	public function __construct()
	{
      parent::__construct();
	  $this->load->model('Faqs_model');
	}
	
	public function index()
	{
      $this->load->view('index');
	}
	
	public function student_faqs()
	{
		$this->load->view('students_faqs');
	}
	
	public function faculty_faqs()
	{
		$this->load->view('faculties_faqs');
	}
	
}
