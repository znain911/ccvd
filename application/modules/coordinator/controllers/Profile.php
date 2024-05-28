<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
	
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
		
		$this->load->model('Coordinator_model');
	}
	
	public function index()
	{
		$data['id'] = $this->session->userdata('active_user');
		$this->load->view('setup/coordinators/profile', $data);
	}
	
	public function coordinators_update()
	{
		$this->load->library('form_validation');
		$id = $this->session->userdata('active_user');
		$check_email = $this->Coordinator_model->get_info($id);
		$data = array(
					'owner_name'         => html_escape($this->input->post('full_name')),  
					'owner_email'        => html_escape($this->input->post('email')), 
				);
		$validate = array(
						array(
							'field' => 'full_name', 
							'label' => 'Full Name', 
							'rules' => 'required|trim', 
						),
					);
		if($check_email == true && $check_email['owner_id'] !== $id)
		{
			$this->form_validation->set_rules('email', 'Email', 'required|trim|is_unique[starter_owner.owner_email]', array('is_unique' => 'The email is already exist!'));
		}
		$this->form_validation->set_rules($validate);
		
		$this->load->library('upload');
	    $this->load->library('image_lib');
	    $config['upload_path']          = 'attachments/coordinators/';
	    $config['allowed_types']        = 'gif|jpg|png|jpeg';
	    $config['detect_mime']          = TRUE;
	    $config['remove_spaces']        = TRUE;
	    $config['encrypt_name']         = TRUE;
	    $config['max_size']             = '0';
	    $this->upload->initialize($config);
		if (!$this->upload->do_upload('recent_photo')){
		  $upload_error = $this->upload->display_errors();
		    $error = '<div class="alert alert-danger">'.$upload_error.'</div>';
			$result = array('status' => 'error', 'error' => $error);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
	    }else{
			$exist_image = $this->Coordinator_model->get_info($id);
			if(!empty($exist_image['owner_photo']) && $exist_image['owner_photo'] !== NULL){
				$file_name = attachment_dir("coordinators/".$exist_image['owner_photo']);
				if(file_exists($file_name)){
					unlink($file_name);
				}else{
					echo null;
				}
			}else{
				echo null;
			}
			$fileData = $this->upload->data();
			
			$full_path = $fileData['full_path'];
			// check EXIF and autorotate if needed
			$this->load->library('image_autorotate', array('filepath' => $full_path));
			
			$data['owner_photo'] = $fileData['file_name'];
			$configer =  array(
			  'image_library'   => 'gd2',
			  'source_image'    =>  $config['upload_path'].$fileData['file_name'],
			  'create_thumb'    =>  FALSE,
			  'maintain_ratio'  =>  true,
			  'width'           =>  150,
			  'height'          =>  150,
			);
			$this->image_lib->clear();
			$this->image_lib->initialize($configer);
			$this->image_lib->resize();
		}
		
		if($this->form_validation->run() == true)
		{
			//Update
			$this->Coordinator_model->update($id, $data);
			
			$success = '<div class="alert alert-success">successfully updated!</div>';
			$result = array('status' => 'ok', 'success' => $success);
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
	
	public function coordinators_change_password()
	{
		$admin_id = $this->input->post('admin');
		$update_pass = array(
							'owner_password' => sha1(html_escape($this->input->post('password'))),
						);
		$this->db->where('owner_id', $admin_id);
		$this->db->update('starter_owner', $update_pass);
		
		$result = array('status' => 'ok');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
}
