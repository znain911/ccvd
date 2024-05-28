<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {
	
	private $sqtoken;
	private $sqtoken_hash;
	
	public function __construct()
	{
      parent::__construct();
	  date_default_timezone_set('Asia/Dhaka');
	  $this->sqtoken = $this->security->get_csrf_token_name();
	  $this->sqtoken_hash = $this->security->get_csrf_hash();
	  $this->load->model('Contact_model');
	}
	
	public function index()
	{
      $this->load->view('index');
	}
	
	public function send()
	{
		$this->load->library('form_validation');
		$data = array(
					'contact_ticket_id'   => html_escape($this->input->post('application_ID')),
					'contact_name'        => html_escape($this->input->post('name')),
					'contact_email'       => html_escape($this->input->post('email')),
					'contact_phone'       => html_escape($this->input->post('phone')),
					'contact_subject'     => html_escape($this->input->post('subject')),
					'contact_description' => html_escape($this->input->post('description')),
					'contact_date'        => date("Y-m-d H:i:s"),
					'contact_ip'          => $this->input->ip_address(),
				);
		$validate = array(
						array(
							'field' => 'name', 
							'label' => 'Name',
							'rules' => 'required|trim',
						),
						array(
							'field' => 'email', 
							'label' => 'Email',
							'rules' => 'required|trim',
						),
						array(
							'field' => 'phone', 
							'label' => 'Phone',
							'rules' => 'required|trim',
						),
						array(
							'field' => 'subject', 
							'label' => 'Subject',
							'rules' => 'required|trim',
						),array(
							'field' => 'description', 
							'label' => 'Description',
							'rules' => 'required|trim',
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			$this->Contact_model->send($data);
			$success_content = '<div role="alert" class="alert alert-success alert-light alert-dismissible">
                    <button aria-label="Close" data-dismiss="alert" class="close" type="button">
                      <i class="zmdi zmdi-close"></i>
                    </button>
                    <strong>
                      <i class="zmdi zmdi-check"></i> Success!</strong> Message has been successfully submited!</div>';
			$result = array('status' => 'ok', 'success' => $success_content);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else
		{
			$error_content = '
							 <div role="alert" class="alert alert-danger alert-light alert-dismissible">
                    <button aria-label="Close" data-dismiss="alert" class="close" type="button">
                      <i class="zmdi zmdi-close"></i>
                    </button>
                    '.validation_errors().'
					</div>
							 ';
			$result = array('status' => 'error', 'error' => $error_content);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
	}
	
}
