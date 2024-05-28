<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller {
	
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
		
		$this->load->model('Page_model');
	}
	
	public function index()
	{
		$this->load->view('page/index');
	}
	
	public function page_create()
	{
		$this->load->library('form_validation');
		$create_slug = url_title($this->input->post('title'), 'dash', true);
		$total_cats = $this->Page_model->count_pages();
		$ifslugexist = $this->Page_model->isslug_exist($create_slug);
		if($ifslugexist == true)
		{
			$slug = $create_slug.'-'.($total_cats + 1);
		}else
		{
			$slug = $create_slug;
		}
		$data = array(
					'page_title'        => html_escape($this->input->post('title')), 
					'page_short_description' => html_escape($this->input->post('short_description')), 
					'page_slug'         => $slug, 
					'page_location'     => $this->input->post('location'), 
					'page_description'  => $this->input->post('details'), 
					'page_action'       => $this->input->post('status'), 
					'page_create_date'  => date("Y-m-d H:i:s"), 
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
			$this->Page_model->create($data);
			$data_template['display_content'] = TRUE;
			$content = $this->load->view('page/content_list', $data_template, true);
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
	
	public function page_create_item()
	{
		$data['display'] = TRUE;
		$data['phase_id'] = $this->input->post('phase_id');
		$content = $this->load->view('page/create_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function page_edit()
	{
		$data['id'] = $this->input->post('id');
		$content = $this->load->view('page/edit_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function page_update()
	{
		$this->load->library('form_validation');
		$id = $this->input->post('id');
		$create_slug = url_title($this->input->post('title'), 'dash', true);
		$total_cats = $this->Page_model->count_pages();
		$ifslugexist = $this->Page_model->isslug_exist($create_slug);
		if($ifslugexist == true && $ifslugexist['page_id'] !== $id)
		{
			$slug = $create_slug.'-'.($total_cats + 1);
		}else
		{
			$slug = $create_slug;
		}
		$data = array(
					'page_title'        => html_escape($this->input->post('title')),
					'page_short_description' => html_escape($this->input->post('short_description')),
					'page_slug'         => $slug, 
					'page_location'     => $this->input->post('location'), 
					'page_description'  => $this->input->post('details'), 
					'page_action'       => $this->input->post('status'),
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
			$this->Page_model->update($id, $data);
			$data_template['display_content'] = TRUE;
			$content = $this->load->view('page/content_list', $data_template, true);
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
	
	public function page_delete()
	{
		$id = $this->input->post('id');
		
		//Delete coordinator
		$this->db->where('page_id', $id);
		$this->db->delete('starter_pages');
		
		$data['id'] = $id;
		$content = $this->load->view('page/create_form', $data, true);
		
		$result = array("status" => "ok", "content" => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
}
