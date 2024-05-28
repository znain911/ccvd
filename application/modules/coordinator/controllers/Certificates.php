<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Certificates extends CI_Controller {
	
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
		
		$check_permission = $this->Perm_model->check_permissionby_admin($active_user, 11);
		if($check_permission == true){ echo null; }else{ redirect('not-found'); }
		
		$this->sqtoken = $this->security->get_csrf_token_name();
		$this->sqtoken_hash = $this->security->get_csrf_hash();
		
		$this->load->model('Certificates_model');
	}
	
	public function index()
	{
		$this->load->view('certificates/index');
	}
	
	public function certificates_create()
	{
		$this->load->library('form_validation');
		$std_id = $this->input->post('student_id');
		$student_info = $this->Certificates_model->get_student_info($std_id);
		$student_ID = $student_info['student_entryid'];
		$data = array(
					'certificate_student_id'     => $this->input->post('student_id'),  
					'certificate_exam_helddate'  => html_escape($this->input->post('exam_held')),  
					'certificate_create_date'    => Date("Y-m-d H:i:s"),  
					'certificate_status'         => $this->input->post('status'),  
				);
		$validate = array(
						array(
							'field' => 'student_id', 
							'label' => 'Student', 
							'rules' => 'required|trim', 
						),
						array(
							'field' => 'exam_held', 
							'label' => 'Examination Held On', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		
		//create directory for certificates
		$dirpath = attachment_dir("certificates/".$student_ID);
		if(file_exists($dirpath))
		{
			echo null;
		}else
		{
			mkdir($dirpath);
		}
		
		$this->load->library('upload');
		$config['upload_path']          = attachment_dir('certificates/'.$student_ID.'/');
		$config['allowed_types']        = 'gif|jpg|png|jpeg|pdf|doc';
		$config['detect_mime']          = TRUE;
		$config['remove_spaces']        = TRUE;
		$config['encrypt_name']         = TRUE;
		$config['max_size']             = '0';
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('certificate')){
			 $upload_error = $this->upload->display_errors();
		}else{
			$fileData = $this->upload->data();
			$data['certificate_attach_file'] = $fileData['file_name'];
		}
		
		if($this->form_validation->run() == true)
		{
			//save
			$this->Certificates_model->create($data);
			//update student ece course status
			$status_array = array('student_get_certified' => 1);
			$this->Certificates_model->update_ece_coursestatus($std_id, $status_array);
			
			$data_template['display_content'] = TRUE;
			$content = $this->load->view('certificates/content_list', $data_template, true);
			$success = '<div class="alert alert-success">successfully created!</div>';
			
			$non_cece = '<option value="">Select Student</option>';
			$get_studentsid = $this->Certificates_model->get_students_ids('Completed', 0);
			foreach($get_studentsid as $sid):
			if($sid['spinfo_middle_name'])
			{
				$full_name = $sid['spinfo_first_name'].' '.$sid['spinfo_middle_name'].' '.$sid['spinfo_last_name'];
			}else
			{
				$full_name = $sid['spinfo_first_name'].' '.$sid['spinfo_last_name'];
			}
			$non_cece .= '<option value="'.$sid['student_id'].'">'.$full_name.' ('.$sid['student_entryid'].')'.'</option>';
			endforeach;
			
			$result = array('status' => 'ok', 'success' => $success, 'content' => $content, 'non_cece' => $non_cece);
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
	
	public function certificates_create_item()
	{
		$data['display'] = TRUE;
		$data['phase_id'] = $this->input->post('phase_id');
		$content = $this->load->view('certificates/create_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function certificates_edit()
	{
		$data['id'] = $this->input->post('id');
		$content = $this->load->view('certificates/edit_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function certificates_update()
	{
		$this->load->library('form_validation');
		$id = $this->input->post('id');
		$certificate_info = $this->Certificates_model->get_certificate_info($id);
		$student_info = $this->Certificates_model->get_student_info($certificate_info['certificate_student_id']);
		$student_ID = $student_info['student_entryid'];
		
		$data = array( 
					'certificate_exam_helddate'  => html_escape($this->input->post('exam_held')),   
					'certificate_status'         => $this->input->post('status'),  
				);
		$validate = array(
						array(
							'field' => 'exam_held', 
							'label' => 'Examination Held On', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		
		$this->load->library('upload');
		$config['upload_path']          = attachment_dir('certificates/'.$student_ID.'/');
		$config['allowed_types']        = 'gif|jpg|png|jpeg|pdf|doc';
		$config['detect_mime']          = TRUE;
		$config['remove_spaces']        = TRUE;
		$config['encrypt_name']         = TRUE;
		$config['max_size']             = '0';
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('certificate')){
			 $upload_error = $this->upload->display_errors();
		}else{
			$exist_image = $certificate_info;
			if(!empty($exist_image['certificate_attach_file']) && $exist_image['certificate_attach_file'] !== NULL){
				$file_name = attachment_dir("certificates/".$student_ID.'/'.$exist_image['certificate_attach_file']);
				if(file_exists($file_name)){
					unlink($file_name);
				}else{
					echo null;
				}
			}else{
				echo null;
			}
			
			$fileData = $this->upload->data();
			$data['certificate_attach_file'] = $fileData['file_name'];
		}
		
		if($this->form_validation->run() == true)
		{
			//save
			$this->Certificates_model->update($id, $data);
			$data_template['display_content'] = TRUE;
			$content = $this->load->view('certificates/content_list', $data_template, true);
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
	
	public function certificates_delete()
	{
		$id = $this->input->post('id');
		$certificate_info = $this->Certificates_model->get_certificate_info($id);
		$student_info = $this->Certificates_model->get_student_info($certificate_info['certificate_student_id']);
		$student_ID = $student_info['student_entryid'];
		
		$exist_image = $certificate_info;
		if(!empty($exist_image['certificate_attach_file']) && $exist_image['certificate_attach_file'] !== NULL){
			$file_name = attachment_dir("certificates/".$student_ID.'/'.$exist_image['certificate_attach_file']);
			if(file_exists($file_name)){
				unlink($file_name);
			}else{
				echo null;
			}
		}else{
			echo null;
		}
		
		//update student ece course status
		$status_array = array('student_get_certified' => 0);
		$this->Certificates_model->update_ece_coursestatus($certificate_info['certificate_student_id'], $status_array);
		
		//Delete coordinator
		$this->db->where('certificate_id', $id);
		$this->db->delete('starter_certificates');
		
		$data['id'] = $id;
		$content = $this->load->view('certificates/create_form', $data, true);
		
		$non_cece = '<option value="">Select Student</option>';
		$get_studentsid = $this->Certificates_model->get_students_ids('Completed', 0);
		foreach($get_studentsid as $sid):
		if($sid['spinfo_middle_name'])
		{
			$full_name = $sid['spinfo_first_name'].' '.$sid['spinfo_middle_name'].' '.$sid['spinfo_last_name'];
		}else
		{
			$full_name = $sid['spinfo_first_name'].' '.$sid['spinfo_last_name'];
		}
		$non_cece .= '<option value="'.$sid['student_id'].'">'.$full_name.' ('.$sid['student_entryid'].')'.'</option>';
		endforeach;
		
		$result = array("status" => "ok", "content" => $content, 'non_cece' => $non_cece);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	
}
