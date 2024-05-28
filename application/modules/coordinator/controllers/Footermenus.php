<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Footermenus extends CI_Controller {
	
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
		$this->load->model('Footermenu_menu_model');
		$this->load->model('Footermenu_model');
	}
	
	public function index()
	{
		if(isset($_GET['type']) && $_GET['type'] == 'social')
		{
			$this->load->view('footermenu/social/index');
		}elseif(isset($_GET['type']) && $_GET['type'] == 'footermenu'){
			$this->load->view('footermenu/menu/index');
		}elseif(isset($_GET['type']) && $_GET['type'] == 'Faculties'){
			$this->load->view('footermenu/faculties/index');
		}elseif(isset($_GET['type']) && $_GET['type'] == 'importantlink'){
			$this->load->view('footermenu/important/index');
		}elseif(isset($_GET['type']) && $_GET['type'] == 'youtubevideo'){
			$this->load->view('footermenu/video/index');
		}else{
			redirect('not-found');
		}
	}
	
	/**********************************/
	/********START SOCIAL***********/
	/**********************************/
	
	public function social_create()
	{
		$this->load->library('form_validation');
		$data = array(
					'title'       => html_escape($this->input->post('title')),  
					'details' => $this->input->post('details'), 
					'link' => $this->input->post('link'),
					'type'        => 'social',
					'status'      => $this->input->post('status'),
					'ordering' => $this->input->post('ordering'),
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
			$this->Footermenu_model->create($data);
			$data_template['display_content'] = TRUE;
			$content = $this->load->view('footermenu/social/content_list', $data_template, true);
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
		$content = $this->load->view('footermenu/social/create_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function website_edit()
	{
		$data['id'] = $this->input->post('id');
		$content = $this->load->view('footermenu/social/edit_form', $data, true);
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
					'title'       => html_escape($this->input->post('title')),  
					'details' => $this->input->post('details'), 
					'link' => $this->input->post('link'),
					'type'        => 'social',
					'status'      => $this->input->post('status'),
					'ordering' => $this->input->post('ordering'),
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
			$this->Footermenu_model->update($id, $data);
			$data_template['display_content'] = TRUE;
			$content = $this->load->view('footermenu/social/content_list', $data_template, true);
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
		$this->db->where('id', $id);
		$this->db->delete('starter_common_info');
		
		$data['id'] = $id;
		$content = $this->load->view('footermenu/social/create_form', $data, true);
		
		$result = array("status" => "ok", "content" => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	/**********************************/
	/********END Social***********/
	/**********************************/
	
	
	
	/**********************************/
	/********START Menu***********/
	/**********************************/
	
	public function menu_create()
	{
		$this->load->library('form_validation');
		$data = array(
					'title'       => html_escape($this->input->post('title')), 
					'link' => $this->input->post('link'),
					'type'        => 'footermenu',
					'status'      => $this->input->post('status'),
					'ordering' => $this->input->post('ordering'),
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
			$this->Footermenu_model->create($data);
			$data_template['display_content'] = TRUE;
			$content = $this->load->view('footermenu/menu/content_list', $data_template, true);
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
	
	public function menu_create_item()
	{
		$data['display'] = TRUE;
		$data['phase_id'] = $this->input->post('phase_id');
		$content = $this->load->view('footermenu/menu/create_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function menu_edit()
	{
		$data['id'] = $this->input->post('id');
		$content = $this->load->view('footermenu/menu/edit_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function menu_update()
	{
		$this->load->library('form_validation');
		$id = $this->input->post('id');
		$data = array(
					'title'       => html_escape($this->input->post('title')),
					'link' => $this->input->post('link'),
					'type'        => 'footermenu',
					'status'      => $this->input->post('status'),
					'ordering' => $this->input->post('ordering'),
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
			$this->Footermenu_model->update($id, $data);
			$data_template['display_content'] = TRUE;
			$content = $this->load->view('footermenu/menu/content_list', $data_template, true);
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
	
	public function menu_delete()
	{
		$id = $this->input->post('id');
		
		//Delete coordinator
		$this->db->where('id', $id);
		$this->db->delete('starter_common_info');
		
		$data['id'] = $id;
		$content = $this->load->view('footermenu/menu/create_form', $data, true);
		
		$result = array("status" => "ok", "content" => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	/**********************************/
	/********END Footer Menu***********/
	/**********************************/
	

	/**********************************/
	/********START Importantlink***********/
	/**********************************/
	
	public function importantlink_create()
	{
		$this->load->library('form_validation');
		$data = array(
					'title'       => html_escape($this->input->post('title')), 
					'link' => $this->input->post('link'),
					'type'        => 'importantlink',
					'status'      => $this->input->post('status'),
					'ordering' => $this->input->post('ordering'),
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
			$this->Footermenu_model->create($data);
			$data_template['display_content'] = TRUE;
			$content = $this->load->view('footermenu/important/content_list', $data_template, true);
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
	
	public function importantlink_create_item()
	{
		$data['display'] = TRUE;
		$data['phase_id'] = $this->input->post('phase_id');
		$content = $this->load->view('footermenu/important/create_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function importantlink_edit()
	{
		$data['id'] = $this->input->post('id');
		$content = $this->load->view('footermenu/important/edit_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function importantlink_update()
	{
		$this->load->library('form_validation');
		$id = $this->input->post('id');
		$data = array(
					'title'       => html_escape($this->input->post('title')),
					'link' => $this->input->post('link'),
					'status'      => $this->input->post('status'),
					'ordering' => $this->input->post('ordering'),
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
			$this->Footermenu_model->update($id, $data);
			$data_template['display_content'] = TRUE;
			$content = $this->load->view('footermenu/important/content_list', $data_template, true);
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
	
	public function importantlink_delete()
	{
		$id = $this->input->post('id');
		
		//Delete coordinator
		$this->db->where('id', $id);
		$this->db->delete('starter_common_info');
		
		$data['id'] = $id;
		$content = $this->load->view('footermenu/important/create_form', $data, true);
		
		$result = array("status" => "ok", "content" => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	/**********************************/
	/********END Important Link***********/
	/**********************************/



/**********************************/
	/********START YouTube Video***********/
	/**********************************/
	
	public function youtubevideo_create()
	{
		$this->load->library('form_validation');
		$data = array(
					'title'       => html_escape($this->input->post('title')), 
					'link' => $this->input->post('link'),
					'type'        => 'video',
					'status'      => $this->input->post('status'),
					'ordering' => $this->input->post('ordering'),
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
			$this->Footermenu_model->create($data);
			$data_template['display_content'] = TRUE;
			$content = $this->load->view('footermenu/video/content_list', $data_template, true);
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
	
	public function youtubevideo_create_item()
	{
		$data['display'] = TRUE;
		$data['phase_id'] = $this->input->post('phase_id');
		$content = $this->load->view('footermenu/video/create_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function youtubevideo_edit()
	{
		$data['id'] = $this->input->post('id');
		$content = $this->load->view('footermenu/video/edit_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function youtubevideo_update()
	{
		$this->load->library('form_validation');
		$id = $this->input->post('id');
		$data = array(
					'title'       => html_escape($this->input->post('title')),
					'link' => $this->input->post('link'),
					'status'      => $this->input->post('status'),
					'ordering' => $this->input->post('ordering'),
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
			$this->Footermenu_model->update($id, $data);
			$data_template['display_content'] = TRUE;
			$content = $this->load->view('footermenu/video/content_list', $data_template, true);
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
	
	public function youtubevideo_delete()
	{
		$id = $this->input->post('id');
		
		//Delete coordinator
		$this->db->where('id', $id);
		$this->db->delete('starter_common_info');
		
		$data['id'] = $id;
		$content = $this->load->view('footermenu/video/create_form', $data, true);
		
		$result = array("status" => "ok", "content" => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	/**********************************/
	/********END YouTube Video***********/
	/**********************************/












	
	
}
