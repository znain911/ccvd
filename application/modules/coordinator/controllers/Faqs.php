<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faqs extends CI_Controller {
	
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
		
		$this->load->model('Websitefaqs_model');
		$this->load->model('Studentfaqs_model');
		$this->load->model('Facultiesfaqs_model');
	}
	
	public function index()
	{
		if(isset($_GET['type']) && $_GET['type'] == 'Website')
		{
			$this->load->view('faqs/website/index');
		}elseif(isset($_GET['type']) && $_GET['type'] == 'Students'){
			$this->load->view('faqs/students/index');
		}elseif(isset($_GET['type']) && $_GET['type'] == 'Faculties'){
			$this->load->view('faqs/faculties/index');
		}else{
			redirect('not-found');
		}
	}
	
	/**********************************/
	/********START WEBSITE FAQS***********/
	/**********************************/
	
	public function website_create()
	{
		$this->load->library('form_validation');
		$data = array(
					'faq_title'       => html_escape($this->input->post('title')),  
					'faq_description' => $this->input->post('details'),  
					'faq_type'        => 'Website',
					'faq_status'      => $this->input->post('status'),
					'faq_create_date' => date("Y-m-d H:i:s"),
				);
		$validate = array(
						array(
							'field' => 'title', 
							'label' => 'Title', 
							'rules' => 'required|trim',
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->Websitefaqs_model->create($data);
			$data_template['display_content'] = TRUE;
			$content = $this->load->view('faqs/website/content_list', $data_template, true);
			$success = '<div class="alert alert-success">successfully created!</div>';
			$result = array('status' => 'ok', 'success' => $success, 'content' => $content);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else
		{
			$error = '<div class="alert alert-danger">'.validation_errors().'</div>';
			$result = array('status' => 'error', 'error' => $error);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
	}
	
	public function website_create_item()
	{
		$data['display'] = TRUE;
		$data['phase_id'] = $this->input->post('phase_id');
		$content = $this->load->view('faqs/website/create_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function website_edit()
	{
		$data['id'] = $this->input->post('id');
		$content = $this->load->view('faqs/website/edit_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function website_update()
	{
		$this->load->library('form_validation');
		$id = $this->input->post('id');
		$data = array(
					'faq_title'       => html_escape($this->input->post('title')),  
					'faq_description' => $this->input->post('details'),  
					'faq_type'        => 'Website',
					'faq_status'      => $this->input->post('status'),
					'faq_create_date' => date("Y-m-d H:i:s"),
				);
		$validate = array(
						array(
							'field' => 'title', 
							'label' => 'Title', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->Websitefaqs_model->update($id, $data);
			$data_template['display_content'] = TRUE;
			$content = $this->load->view('faqs/website/content_list', $data_template, true);
			$success = '<div class="alert alert-success">successfully updated!</div>';
			$result = array('status' => 'ok', 'success' => $success, 'content' => $content);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else
		{
			$error = '<div class="alert alert-danger">'.validation_errors().'</div>';
			$result = array('status' => 'error', 'error' => $error);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
	}
	
	public function website_delete()
	{
		$id = $this->input->post('id');
		
		//Delete coordinator
		$this->db->where('faq_id', $id);
		$this->db->delete('starter_faqs');
		
		$data['id'] = $id;
		$content = $this->load->view('faqs/website/create_form', $data, true);
		
		$result = array("status" => "ok", "content" => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	/**********************************/
	/********END WEBSITE FAQS***********/
	/**********************************/
	
	
	
	/**********************************/
	/********START STUDENTS FAQS***********/
	/**********************************/
	
	public function students_create()
	{
		$this->load->library('form_validation');
		$data = array(
					'faq_title'       => html_escape($this->input->post('title')),  
					'faq_description' => $this->input->post('details'),  
					'faq_type'        => 'Student',
					'faq_status'      => $this->input->post('status'),
					'faq_create_date' => date("Y-m-d H:i:s"),
				);
		$validate = array(
						array(
							'field' => 'title', 
							'label' => 'Title', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->Studentfaqs_model->create($data);
			$data_template['display_content'] = TRUE;
			$content = $this->load->view('faqs/students/content_list', $data_template, true);
			$success = '<div class="alert alert-success">successfully created!</div>';
			$result = array('status' => 'ok', 'success' => $success, 'content' => $content);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else
		{
			$error = '<div class="alert alert-danger">'.validation_errors().'</div>';
			$result = array('status' => 'error', 'error' => $error);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
	}
	
	public function students_create_item()
	{
		$data['display'] = TRUE;
		$data['phase_id'] = $this->input->post('phase_id');
		$content = $this->load->view('faqs/students/create_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function students_edit()
	{
		$data['id'] = $this->input->post('id');
		$content = $this->load->view('faqs/students/edit_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function students_update()
	{
		$this->load->library('form_validation');
		$id = $this->input->post('id');
		$data = array(
					'faq_title'       => html_escape($this->input->post('title')),  
					'faq_description' => $this->input->post('details'),  
					'faq_status'      => $this->input->post('status'),
					'faq_create_date' => date("Y-m-d H:i:s"),
				);
		$validate = array(
						array(
							'field' => 'title', 
							'label' => 'Title', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->Studentfaqs_model->update($id, $data);
			$data_template['display_content'] = TRUE;
			$content = $this->load->view('faqs/students/content_list', $data_template, true);
			$success = '<div class="alert alert-success">successfully updated!</div>';
			$result = array('status' => 'ok', 'success' => $success, 'content' => $content);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else
		{
			$error = '<div class="alert alert-danger">'.validation_errors().'</div>';
			$result = array('status' => 'error', 'error' => $error);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
	}
	
	public function students_delete()
	{
		$id = $this->input->post('id');
		
		//Delete coordinator
		$this->db->where('faq_id', $id);
		$this->db->delete('starter_faqs');
		
		$data['id'] = $id;
		$content = $this->load->view('faqs/students/create_form', $data, true);
		
		$result = array("status" => "ok", "content" => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	/**********************************/
	/********END STUDENTS FAQS***********/
	/**********************************/
	
	
	/**********************************/
	/********START FACULTIES FAQS***********/
	/**********************************/
	
	public function faculties_create()
	{
		$this->load->library('form_validation');
		$data = array(
					'faq_title'       => html_escape($this->input->post('title')),  
					'faq_description' => $this->input->post('details'),  
					'faq_type'        => 'Faculty',
					'faq_status'      => $this->input->post('status'),
					'faq_create_date' => date("Y-m-d H:i:s"),
				);
		$validate = array(
						array(
							'field' => 'title', 
							'label' => 'Title', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->Facultiesfaqs_model->create($data);
			$data_template['display_content'] = TRUE;
			$content = $this->load->view('faqs/faculties/content_list', $data_template, true);
			$success = '<div class="alert alert-success">successfully created!</div>';
			$result = array('status' => 'ok', 'success' => $success, 'content' => $content);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else
		{
			$error = '<div class="alert alert-danger">'.validation_errors().'</div>';
			$result = array('status' => 'error', 'error' => $error);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
	}
	
	public function faculties_create_item()
	{
		$data['display'] = TRUE;
		$data['phase_id'] = $this->input->post('phase_id');
		$content = $this->load->view('faqs/faculties/create_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function faculties_edit()
	{
		$data['id'] = $this->input->post('id');
		$content = $this->load->view('faqs/faculties/edit_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function faculties_update()
	{
		$this->load->library('form_validation');
		$id = $this->input->post('id');
		$data = array(
					'faq_title'       => html_escape($this->input->post('title')),  
					'faq_description' => $this->input->post('details'),  
					'faq_status'      => $this->input->post('status'),
					'faq_create_date' => date("Y-m-d H:i:s"),
				);
		$validate = array(
						array(
							'field' => 'title', 
							'label' => 'Title', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->Facultiesfaqs_model->update($id, $data);
			$data_template['display_content'] = TRUE;
			$content = $this->load->view('faqs/faculties/content_list', $data_template, true);
			$success = '<div class="alert alert-success">successfully updated!</div>';
			$result = array('status' => 'ok', 'success' => $success, 'content' => $content);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else
		{
			$error = '<div class="alert alert-danger">'.validation_errors().'</div>';
			$result = array('status' => 'error', 'error' => $error);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
	}
	
	public function faculties_delete()
	{
		$id = $this->input->post('id');
		
		//Delete coordinator
		$this->db->where('faq_id', $id);
		$this->db->delete('starter_faqs');
		
		$data['id'] = $id;
		$content = $this->load->view('faqs/faculties/create_form', $data, true);
		
		$result = array("status" => "ok", "content" => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	/**********************************/
	/********END FACULTIES FAQS***********/
	/**********************************/
	
	
}
