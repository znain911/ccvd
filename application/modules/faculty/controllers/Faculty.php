<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faculty extends CI_Controller{
	
	private $sqtoken;
	private $sqtoken_hash;
	
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Dhaka');
		
		$active_teacher = $this->session->userdata('active_teacher');
		$teacherLogin = $this->session->userdata('teacherLogin');
		if($active_teacher === NULL && $teacherLogin !== TRUE)
		{
			redirect('faculty/login', 'refresh', true);
		}
		
		$this->sqtoken = $this->security->get_csrf_token_name();
		$this->sqtoken_hash = $this->security->get_csrf_hash();
		
		$this->load->model('Discussion_model');
		$this->load->model('Faqs_model');
		$this->load->model('Evaluation_model');
		$this->load->model('Course_model');
		$this->load->model('Teacher_model');
	}
	
	public function index()
	{
		redirect(site_url(), 'refresh', true);
	}
	
	public function profile()
	{
		$this->load->view('myaccount');
	}
	
	public function changepassword()
	{
		$this->load->view('changepassword');	
	}
	
	public function edit($param)
	{
		if(isset($param) && $param == 'personal'){
			$this->load->view('edit/personal');
		}elseif(isset($param) && $param == 'professional'){
			$this->load->view('edit/professional');
		}elseif(isset($param) && $param == 'academic'){
			$this->load->view('edit/academic');
		}else{
			redirect('not-found');
		}
	}
	
	public function update_personal_info()
	{
		$this->load->library('form_validation');
		
		$teacher_id = $this->session->userdata('active_teacher');
		$phn = html_escape($this->input->post('mobile'));
		if(substr($phn, 0, 2) !== '88')
		{
			$phone_number = '88'.$phn;
		}else
		{
			$phone_number = $phn;
		}
		
		$get_form_data = array(
							'tpinfo_first_name'        => html_escape($this->input->post('first_name')),
							'tpinfo_middle_name'       => html_escape($this->input->post('middle_name')),
							'tpinfo_last_name'         => html_escape($this->input->post('last_name')),
							'tpinfo_birth_date'        => html_escape($this->input->post('birthday')),
							'tpinfo_gender'            => html_escape($this->input->post('gender')),
							'tpinfo_nationality'       => html_escape($this->input->post('nationality')),
							'tpinfo_fmorspouse_name'   => html_escape($this->input->post('fms_name')),
							'tpinfo_national_id'       => html_escape($this->input->post('national_id')),
							'tpinfo_personal_phone'    => $phone_number,
							'tpinfo_office_phone'      => html_escape($this->input->post('office')),
							'tpinfo_home_phone'        => html_escape($this->input->post('home')),
							'tpinfo_current_address'   => html_escape($this->input->post('current_address')),
							'tpinfo_permanent_address' => html_escape($this->input->post('permanent_address')),
						 );
		$validate = array(
						array(
							'field' => 'first_name',
							'label' => 'First Name',
							'rules' => 'required|trim',
						),
					);
		$this->form_validation->set_rules($validate);
		$exist_image = $this->Teacher_model->get_teacher_info();
		$teacher_entryid = $exist_image['teacher_entryid'];
		$this->load->library('upload');
		$this->load->library('image_lib');
		$config['upload_path']          = 'attachments/faculties/'.$teacher_entryid.'/';
		$config['allowed_types']        = 'gif|jpg|png|jpeg';
		$config['detect_mime']          = TRUE;
		$config['remove_spaces']        = TRUE;
		$config['encrypt_name']         = TRUE;
		$config['max_size']             = '0';
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('recent_photo')){
		  $upload_error = $this->upload->display_errors();
		}else{
			if(!empty($exist_image['tpinfo_photo']) && $exist_image['tpinfo_photo'] !== NULL){
				$file_name = attachment_dir("faculties/".$exist_image['teacher_entryid'].'/'.$exist_image['tpinfo_photo']);
				if(file_exists($file_name)){
					unlink($file_name);
				}else{
					echo null;
				}
			}else{
				echo null;
			}
			$fileData = $this->upload->data();
			$get_form_data['tpinfo_photo'] = $fileData['file_name'];
			$configer =  array(
			  'image_library'   => 'gd2',
			  'source_image'    =>  $config['upload_path'].$fileData['file_name'],
			  'create_thumb'    =>  FALSE,
			  'maintain_ratio'  =>  FALSE,
			  'width'           =>  230,
			  'height'          =>  250,
			);
			$this->image_lib->clear();
			$this->image_lib->initialize($configer);
			$this->image_lib->resize();
		}
		
		if($this->form_validation->run() == true)
		{
			$this->Teacher_model->update_personal_info($teacher_id, $get_form_data);
			
			$success_content = '<div role="alert" class="alert alert-success alert-light alert-dismissible">
									<button aria-label="Close" data-dismiss="alert" class="close" type="button"><i class="zmdi zmdi-close"></i></button>
									Information has been successfully updated!
								</div>
							   ';
			
			$result = array('status' => 'ok', 'success' => $success_content);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else
		{
			$error_content = '
								<div role="alert" class="alert alert-danger alert-light alert-dismissible">
									<button aria-label="Close" data-dismiss="alert" class="close" type="button"><i class="zmdi zmdi-close"></i></button>
									'.validation_errors().'
								</div>
							 ';
			$result = array('status' => 'error', 'error' => $error_content);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
	}
	
	public function update_professional_info()
	{
		$teacher_id = $this->session->userdata('active_teacher');
		
		//Save professional information
		$professional_data = array(
								'tpsinfo_designation'          => html_escape($this->input->post('designation')),
								'tpsinfo_organization'         => html_escape($this->input->post('organization')),
								'tpsinfo_organization_address' => html_escape($this->input->post('organization_address')),
								'tpsinfo_bmanddc_number'       => html_escape($this->input->post('bmanddc_number')),
								'tpsinfo_typeof_practice'      => $this->input->post('practice_type'),
								'tpsinfo_sinceyear_mbbs'       => $this->input->post('years_since'),
								'tpsinfo_experience'           => $this->input->post('years_experience'),
							);
		$this->Teacher_model->update_professional_info($teacher_id, $professional_data);
		
		//Save specialization
		$this->db->where('ts_teacher_id', $teacher_id);
		$this->db->delete('starter_teachers_specializations');
		
		$count_specialization = count($this->input->post('specialization'));
		for($x=0; $x<$count_specialization; $x++)
		{
			if(isset($this->input->post('specialization')[$x]))
			{
				$specialization_data = array(
									'ts_teacher_id' => $teacher_id,
									'ts_specilzation_id' => $this->input->post('specialization')[$x],
								);
				$this->Teacher_model->save_specialization_info($specialization_data);
			}		
		}
		
		//Save dlp categories
		$this->db->where('tdc_teacher_id', $teacher_id);
		$this->db->delete('starter_teachers_dlpcategories');
		
		$count_categories = count($this->input->post('dlp_category'));
		for($x=0; $x<$count_categories; $x++)
		{
			if(isset($this->input->post('dlp_category')[$x]))
			{
				$categories_data = array(
								'tdc_teacher_id' => $teacher_id,
								'tdc_category_id' => $this->input->post('dlp_category')[$x],
							);
				$this->Teacher_model->save_categories_info($categories_data);
			}		
		}
		
		$success_content = '<div role="alert" class="alert alert-success alert-light alert-dismissible">
								<button aria-label="Close" data-dismiss="alert" class="close" type="button"><i class="zmdi zmdi-close"></i></button>
								Information has been successfully updated!
							</div>
						   ';
		
		$result = array('status' => 'ok', 'success' => $success_content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function update_academic_info()
	{
		$teacher_id = $this->session->userdata('active_teacher');
		$teacher_info = $this->Teacher_model->get_teacher_info();
		$academic_data = array(
							'tacinfo_teacher_id'  => $teacher_id,
							'tacinfo_degree'      => html_escape($this->input->post('degree')),
							'tacinfo_year'        => html_escape($this->input->post('year')),
							'tacinfo_institute'   => html_escape($this->input->post('institute')),
							'tacinfo_cgpa'        => html_escape($this->input->post('cgpa')),
						);
		$this->load->library('upload');
		$config['upload_path']          = 'attachments/faculties/'.$teacher_info['teacher_entryid'].'/';
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
			$academic_data['tacinfo_certificate'] = $fileData['file_name'];
		}
		
		$this->Teacher_model->save_academic_info($academic_data);
		
		$success_content = '<div role="alert" class="alert alert-success alert-light alert-dismissible">
								<button aria-label="Close" data-dismiss="alert" class="close" type="button"><i class="zmdi zmdi-close"></i></button>
								Information has been successfully updated!
							</div>
						   ';
		
		$result = array('status' => 'ok', 'success' => $success_content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function delete_academic_info()
	{
		$teacher_id = $this->session->userdata('active_teacher');
		$item_id = $this->input->post('id');
		$exist_image = $this->Teacher_model->get_certificate_row($teacher_id, $item_id);
		if(!empty($exist_image['tacinfo_certificate']) && $exist_image['tacinfo_certificate'] !== NULL){
			$file_name = attachment_dir("faculties/".$exist_image['teacher_entryid'].'/'.$exist_image['tacinfo_certificate']);
			if(file_exists($file_name)){
				unlink($file_name);
			}else{
				echo null;
			}
		}else{
			echo null;
		}
		
		$this->db->where('tacinfo_id', $item_id);
		$this->db->where('tacinfo_teacher_id', $teacher_id);
		$this->db->delete('starter_teachers_academicinfo');
		
		$result = array('status' => 'ok');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	//update password
	public function update_password()
	{
		$data['teacher_password'] = sha1(html_escape($this->input->post('password')));
		$teacher_id = $this->session->userdata('active_teacher');
		$this->Teacher_model->update_password($teacher_id, $data);
		
		$success_content = '<div role="alert" class="alert alert-success alert-light alert-dismissible">
								<button aria-label="Close" data-dismiss="alert" class="close" type="button"><i class="zmdi zmdi-close"></i></button>
								Password has been successfully updated!
							</div>
						   ';
		
		$result = array('status' => 'ok', 'success' => $success_content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function faqs()
	{
		$this->load->view('faqs');
	}
	
	public function support()
	{
		$this->load->view('support');
	}
	
	public function ftwof()
	{
		$this->load->view('ftwof_session');
	}
	
	/****************************/
	/*******START DISCUSSION PART*********/
	/****************************/
	
	public function discussion()
	{
		if(isset($_GET['with']) && $_GET['with'] === 'Students')
		{
			$this->load->view('discussion_with_students');
			
		}elseif(isset($_GET['with']) && $_GET['with'] === 'Coordinators'){
			
			$this->load->view('discussion_with_coordinators');
			
		}else
		{
			$this->load->view('discussion_with_coordinators');
		}
	}
	
	public function sendtocoordinator()
	{
		//send message to coordinator
		$send_data = array(
						'ctof_chat_id' => $this->input->post('selected_chat'),
						'ctof_user_type' => 'Faculty',
						'ctof_messages' => html_escape($this->input->post('cnv_text')),
						'ctof_date' => date("Y-m-d H:i:s"),
					 );
		$this->Discussion_model->send_message_tocoordinator($send_data);
		$sess['selchat'] = $this->input->post('selected_chat');
		$this->session->set_userdata($sess);
		echo $this->conversation_between_candf();
		exit;
	}
	
	public function get_conversationby_coordinator()
	{
		$faculty_id = $this->session->userdata('active_teacher');
		$coordinator_id = $this->input->post('cd');
		//add chat request
		$check_request = $this->Discussion_model->check_chat_request($faculty_id, $coordinator_id);
		if($check_request == true)
		{
			$chat_id = $check_request['chat_id'];
		}else
		{
			$chat_data = array(
							'chat_faculty_id' => $faculty_id,
							'chat_coordinator_id' => $coordinator_id,
							'chat_request_accept' => 1,
							'chat_request_date' => date("Y-m-d H:i:s"),
						 );
			$get_ins_id = $this->Discussion_model->save_chat_request($chat_data);
			$chat_id = $this->db->insert_id($get_ins_id);
		}
		$sess['selchat'] = $chat_id;
		$this->session->set_userdata($sess);
		echo $this->conversation_between_candf();
		exit;
	}
	
	public function conversation_between_candf()
	{
		echo $this->__get_conversation_coordinator();
		exit;
	}
	
	public function __get_conversation_coordinator()
	{
		$data['chat_id'] = $this->session->userdata('selchat');
		$content = $this->load->view('coordinators_chat', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function get_conversationby_student()
	{
		$data['student_id'] = $this->input->post('std');
		$data['dsp_conversation'] = TRUE;
		$content = $this->load->view('students_chat', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function contact()
	{
		$this->load->view('contact');
	}
	
	public function save_contactinfo()
	{
		$this->load->library('form_validation');
		$data = array(
					'ucontact_user_id'   => $this->session->userdata('active_student'),
					'ucontact_user_type' => 'STUDENT',
					'ucontact_roll'      => html_escape($this->input->post('roll_number')),
					'ucontact_name'      => html_escape($this->input->post('name')),
					'ucontact_email'     => html_escape($this->input->post('email')),
					'ucontact_phone'     => html_escape($this->input->post('phone')),
					'ucontact_subject'   => html_escape($this->input->post('subject')),
					'ucontact_message'   => html_escape($this->input->post('message')),
					'ucontact_date'      => date("Y-m-d H:i:s"),
				);
		$validate = array(
						array(
							'field' => 'roll_number',
							'label' => 'Roll number',
							'rules' => 'required|trim',
						),
						array(
							'field' => 'name',
							'label' => 'Name',
							'rules' => 'required|trim',
						),
						array(
							'field' => 'email',
							'label' => 'Email',
							'rules' => 'required|trim|valid_email',
						),
						array(
							'field' => 'phone',
							'label' => 'Phone number',
							'rules' => 'required|trim',
						),
						array(
							'field' => 'subject',
							'label' => 'Subject',
							'rules' => 'required|trim',
						),
						array(
							'field' => 'message',
							'label' => 'Message',
							'rules' => 'required|trim',
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			$this->Student_model->save_contactinfo($data);
			$content = '<div class="alert alert-success">Message has been sent!</div>';
			$result = array('status' => 'ok', 'content' => $content);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else
		{
			$content = '<div class="alert alert-danger">'.validation_errors().'</div>';
			$result = array('status' => 'ok', 'content' => $content);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
	}
	
	/******************************/
	/*******END DISCUSSION PART*****/
	/******************************/
	
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('faculty/login', 'refresh', true);
	}
	
}