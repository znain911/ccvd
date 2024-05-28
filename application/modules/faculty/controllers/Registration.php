<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registration extends CI_Controller{
	
	private $sqtoken;
	private $sqtoken_hash;
	
	public function __construct()
	{
		parent::__construct();
		$this->sqtoken = $this->security->get_csrf_token_name();
	    $this->sqtoken_hash = $this->security->get_csrf_hash();
		
		date_default_timezone_set('Asia/Dhaka');
		$this->load->library('form_validation');
		$this->load->library('upload');
		$this->load->library('image_lib');
		$this->load->model('Registration_model');
	}
	
	public function account()
	{
		$update = $this->input->post('update');
		
		if($update === '1')
		{
			$teacher_id = $this->session->userdata('wizard_teacher_id');
			$get_form_data = array(
								'teacher_email'    => html_escape($this->input->post('email')),
								'teacher_password' => sha1(html_escape($this->input->post('password'))),
								'teacher_regdate'  => date("Y-m-d H:i:s"),
								'teacher_ip_address'  => $this->input->ip_address(),
							 );
							 
			$validate = array(
							array(
								'field' => 'password',
								'label' => 'Password',
								'rules' => 'required|trim',
							),
						);
			$this->form_validation->set_rules($validate);
			$check_email = $this->Registration_model->check_email(html_escape($this->input->post('email')));
			if($check_email == true && $check_email['teacher_id'] != $teacher_id)
			{
				$error_content = '
									<div role="alert" class="alert alert-danger alert-light alert-dismissible">
										<button aria-label="Close" data-dismiss="alert" class="close" type="button"><i class="zmdi zmdi-close"></i></button>
										The email is already exist!
									</div>
								 ';
				$result = array('status' => 'error', 'error' => $error_content);
				$result[$this->sqtoken] = $this->sqtoken_hash;
				echo json_encode($result);
				exit;
			}
			$check_student_email = $this->Registration_model->check_student_email(html_escape($this->input->post('email')));
			if($check_student_email == true)
			{
				$error_content = '
									<div role="alert" class="alert alert-danger alert-light alert-dismissible">
										<button aria-label="Close" data-dismiss="alert" class="close" type="button"><i class="zmdi zmdi-close"></i></button>
										The email is already exist!
									</div>
								 ';
				$result = array('status' => 'error', 'error' => $error_content);
				$result[$this->sqtoken] = $this->sqtoken_hash;
				echo json_encode($result);
				exit;
			}
			
			if($this->form_validation->run() == true)
			{
				//insert student
				$this->Registration_model->update_account($teacher_id, $get_form_data);
				$sess['wizard_faclt_eml'] = $this->input->post('email');
				$sess['wizard_faclt_p'] = $this->input->post('password');
				$sess['account_completed_teacher'] = TRUE;
				$this->session->set_userdata($sess);
				
				$wizard = '
							<div class="ste-wizard-flow">
								<div class="step-absolute-container">
									<div class="single-step-flow one">
										<div class="bullet-check-mark"><i class="ion-checkmark-circled"></i></div>
										<div class="step-name-intext">
											<span class="bold-text">STEP 1</span>
											<span class="normal-text">Account</span>
										</div>
									</div>
									<div class="single-step-flow two active">
										<div class="bullet-check-mark"><i class="zmdi zmdi-circle"></i></div>
										<div class="step-name-intext">
											<span class="bold-text">STEP 2</span>
											<span class="normal-text">Personal</span>
										</div>
									</div>
									<div class="single-step-flow three">
										<div class="bullet-check-mark"><i class="zmdi zmdi-circle"></i></div>
										<div class="step-name-intext">
											<span class="bold-text">STEP 3</span>
											<span class="normal-text">Academic</span>
										</div>
									</div>
									<div class="single-step-flow four">
										<div class="bullet-check-mark"><i class="zmdi zmdi-circle"></i></div>
										<div class="step-name-intext">
											<span class="normal-text">
												Administration verification & approval
											</span>
										</div>
									</div>
								</div>
							</div>
						  ';
				
				$template['display_template'] = TRUE;
				$check_personal_info = $this->Registration_model->get_personal_info($teacher_id);
				if($check_personal_info == true)
				{
					$template['teacher_id'] = $teacher_id;
					$content = $this->load->view('regflow/personal_edit', $template, true);
				}else
				{
					$content = $this->load->view('regflow/personal', $template, true);
				}
				
				$result = array('status' => 'ok', 'wizard' => $wizard, 'content' => $content);
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
		}else
		{
			$get_form_data = array(
								'teacher_email'    => html_escape($this->input->post('email')),
								'teacher_password' => sha1(html_escape($this->input->post('password'))),
								'teacher_regdate'  => date("Y-m-d H:i:s"),
								'teacher_ip_address'  => $this->input->ip_address(),
							 );
							 
			$validate = array(
							array(
								'field' => 'password',
								'label' => 'Password',
								'rules' => 'required|trim',
							),
						);
			$this->form_validation->set_rules($validate);
			$this->form_validation->set_rules('email', 'Email', 'required|trim|is_unique[starter_students.student_email]', array('is_unique'=>'The email is already exist!'));
			$this->form_validation->set_rules('email', 'Email', 'required|trim|is_unique[starter_teachers.teacher_email]', array('is_unique'=>'The email is already exist!'));
			if($this->form_validation->run() == true)
			{
				//insert student
				$st_insert_id = $this->Registration_model->save_account($get_form_data);
				$teacher_id = $this->db->insert_id($st_insert_id);
				
				$teacher_entryid = date("Ydm").'7'.$teacher_id; 
				//update entryid
				$this->db->where('teacher_id', $teacher_id);
				$this->db->update('starter_teachers', array('teacher_entryid' =>$teacher_entryid));
				
				//create directory for the student
				$dirpath = users_directory('faculties/'.$teacher_entryid);
				if(file_exists($dirpath))
				{
					echo null;
				}else
				{
					mkdir($dirpath);
				}
				
				$sess['wizard_username_teacher'] = $teacher_entryid;
				$sess['wizard_faclt_eml'] = $this->input->post('email');
				$sess['wizard_faclt_p'] = $this->input->post('password');
				$sess['wizard_teacher_id'] = $teacher_id;
				$sess['account_completed_teacher'] = TRUE;
				$this->session->set_userdata($sess);
				
				$wizard = '
							<div class="ste-wizard-flow">
								<div class="step-absolute-container">
									<div class="single-step-flow one">
										<div class="bullet-check-mark"><i class="ion-checkmark-circled"></i></div>
										<div class="step-name-intext">
											<span class="bold-text">STEP 1</span>
											<span class="normal-text">Account</span>
										</div>
									</div>
									<div class="single-step-flow two active">
										<div class="bullet-check-mark"><i class="zmdi zmdi-circle"></i></div>
										<div class="step-name-intext">
											<span class="bold-text">STEP 2</span>
											<span class="normal-text">Personal</span>
										</div>
									</div>
									<div class="single-step-flow three">
										<div class="bullet-check-mark"><i class="zmdi zmdi-circle"></i></div>
										<div class="step-name-intext">
											<span class="bold-text">STEP 3</span>
											<span class="normal-text">Academic</span>
										</div>
									</div>
									<div class="single-step-flow four">
										<div class="bullet-check-mark"><i class="zmdi zmdi-circle"></i></div>
										<div class="step-name-intext">
											<span class="normal-text">
												Administration verification & approval
											</span>
										</div>
									</div>
								</div>
							</div>
						  ';
				$template['display_template'] = TRUE;
				$content = $this->load->view('regflow/personal', $template, true);
				$result = array('status' => 'ok', 'wizard' => $wizard, 'content' => $content);
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
	}
	
	public function back_to_account()
	{
		$template['display_template'] = TRUE;
		$template['faculty_id'] = $this->session->userdata('wizard_teacher_id');
		$content = $this->load->view('regflow/account_edit', $template, true);
		
		$wizard = '
					<div class="ste-wizard-flow">
						<div class="step-absolute-container">
							<div class="single-step-flow one active">
								<div class="bullet-check-mark"><i class="ion-checkmark-circled"></i></div>
								<div class="step-name-intext">
									<span class="bold-text">STEP 1</span>
									<span class="normal-text">Account</span>
								</div>
							</div>
							<div class="single-step-flow two">
								<div class="bullet-check-mark"><i class="ion-checkmark-circled"></i></div>
								<div class="step-name-intext">
									<span class="bold-text">STEP 2</span>
									<span class="normal-text">Personal</span>
								</div>
							</div>
							<div class="single-step-flow three">
								<div class="bullet-check-mark"><i class="ion-checkmark-circled"></i></div>
								<div class="step-name-intext">
									<span class="bold-text">STEP 3</span>
									<span class="normal-text">Academic</span>
								</div>
							</div>
							<div class="single-step-flow four">
								<div class="bullet-check-mark"><i class="zmdi zmdi-circle"></i></div>
								<div class="step-name-intext">
									<span class="normal-text">
										Administration verification & approval
									</span>
								</div>
							</div>
						</div>
					</div>
				  ';
		
		
		$result = array('status' => 'ok', 'wizard' => $wizard, 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function personal()
	{
		
		$update = $this->input->post('update');
		
		if($update === '1')
		{
			$teacher_id = $this->session->userdata('wizard_teacher_id');
			$phn = html_escape($this->input->post('mobile'));
			if(substr($phn, 0, 2) !== '88')
			{
				$phone_number = '88'.$phn;
			}else
			{
				$phone_number = $phn;
			}
			
			$get_form_data = array(
								'tpinfo_teacher_id'        => $teacher_id,
								'tpinfo_first_name'        => html_escape($this->input->post('first_name')),
								'tpinfo_middle_name'       => html_escape($this->input->post('middle_name')),
								'tpinfo_last_name'         => html_escape($this->input->post('last_name')),
								'tpinfo_birth_date'        => html_escape($this->input->post('birthday')),
								'tpinfo_gender'            => html_escape($this->input->post('gender')),
								'tpinfo_nationality'       => html_escape($this->input->post('nationality')),
								'tpinfo_fmorspouse_name'   => html_escape($this->input->post('fms_name')),
								'tpinfo_national_id'       => html_escape($this->input->post('national_id')),
								'tpinfo_email'             => html_escape($this->input->post('contact_email')),
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
			$check_mobile = $this->Registration_model->check_mobile(html_escape($phone_number));
			if($check_mobile == true && $check_mobile['tpinfo_teacher_id'] !== $teacher_id)
			{
				$error_content = '
									<div role="alert" class="alert alert-danger alert-light alert-dismissible">
										<button aria-label="Close" data-dismiss="alert" class="close" type="button"><i class="zmdi zmdi-close"></i></button>
										The mobile number is already exist!
									</div>
								 ';
				$result = array('status' => 'error', 'error' => $error_content);
				$result[$this->sqtoken] = $this->sqtoken_hash;
				echo json_encode($result);
				exit;
			}
			$check_student_mobile = $this->Registration_model->check_student_mobile(html_escape($phone_number));
			if($check_student_mobile == true)
			{
				$error_content = '
									<div role="alert" class="alert alert-danger alert-light alert-dismissible">
										<button aria-label="Close" data-dismiss="alert" class="close" type="button"><i class="zmdi zmdi-close"></i></button>
										The mobile number is already exist!
									</div>
								 ';
				$result = array('status' => 'error', 'error' => $error_content);
				$result[$this->sqtoken] = $this->sqtoken_hash;
				echo json_encode($result);
				exit;
			}
			$user_name = $this->session->userdata('wizard_username_teacher');
			$this->load->library('upload');
			$this->load->library('image_lib');
			$config['upload_path']          = 'attachments/faculties/'.$user_name.'/';
			$config['allowed_types']        = 'gif|jpg|png|jpeg';
			$config['detect_mime']          = TRUE;
			$config['remove_spaces']        = TRUE;
			$config['encrypt_name']         = TRUE;
			$config['max_size']             = '0';
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('recent_photo')){
			  $upload_error = $this->upload->display_errors();
			}else{
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
				$this->Registration_model->update_personal_info($teacher_id, $get_form_data);
				$sess['personal_completed_teacher'] = TRUE; 
				$sess['wzrd_faclt_full_name'] = $get_form_data['tpinfo_first_name'].' '.$get_form_data['tpinfo_middle_name'].' '.$get_form_data['tpinfo_last_name']; 
				$this->session->set_userdata($sess);
				
				$wizard = '
							<div class="ste-wizard-flow">
								<div class="step-absolute-container">
									<div class="single-step-flow one">
										<div class="bullet-check-mark"><i class="ion-checkmark-circled"></i></div>
										<div class="step-name-intext">
											<span class="bold-text">STEP 1</span>
											<span class="normal-text">Account</span>
										</div>
									</div>
									<div class="single-step-flow two">
										<div class="bullet-check-mark"><i class="ion-checkmark-circled"></i></div>
										<div class="step-name-intext">
											<span class="bold-text">STEP 2</span>
											<span class="normal-text">Personal</span>
										</div>
									</div>
									<div class="single-step-flow three active">
										<div class="bullet-check-mark"><i class="zmdi zmdi-circle"></i></div>
										<div class="step-name-intext">
											<span class="bold-text">STEP 3</span>
											<span class="normal-text">Academic</span>
										</div>
									</div>
									<div class="single-step-flow four">
										<div class="bullet-check-mark"><i class="zmdi zmdi-circle"></i></div>
										<div class="step-name-intext">
											<span class="normal-text">
												Administration verification & approval
											</span>
										</div>
									</div>
								</div>
							</div>
						  ';
				$template['display_template'] = TRUE;
				$content = $this->load->view('regflow/academic', $template, true);
				$result = array('status' => 'ok', 'wizard' => $wizard, 'content' => $content);
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
		}else
		{
			
			$file_data = $_FILES['recent_photo']['name'];
		
			if(!$file_data)
			{
				$error_content = '
									<div role="alert" class="alert alert-danger alert-light alert-dismissible">
										<button aria-label="Close" data-dismiss="alert" class="close" type="button"><i class="zmdi zmdi-close"></i></button>
										Please upload your photo!
									</div>
								 ';
				$result = array('status' => 'error', 'error' => $error_content);
				$result[$this->sqtoken] = $this->sqtoken_hash;
				echo json_encode($result);
				exit;
			}
			
			$phn = html_escape($this->input->post('mobile'));
			if(substr($phn, 0, 2) !== '88')
			{
				$phone_number = '88'.$phn;
			}else
			{
				$phone_number = $phn;
			}
			
			$get_form_data = array(
								'tpinfo_teacher_id'        => $this->session->userdata('wizard_teacher_id'),
								'tpinfo_first_name'        => html_escape($this->input->post('first_name')),
								'tpinfo_middle_name'       => html_escape($this->input->post('middle_name')),
								'tpinfo_last_name'         => html_escape($this->input->post('last_name')),
								'tpinfo_birth_date'        => html_escape($this->input->post('birthday')),
								'tpinfo_gender'            => html_escape($this->input->post('gender')),
								'tpinfo_nationality'       => html_escape($this->input->post('nationality')),
								'tpinfo_fmorspouse_name'   => html_escape($this->input->post('fms_name')),
								'tpinfo_national_id'       => html_escape($this->input->post('national_id')),
								'tpinfo_email'             => html_escape($this->input->post('contact_email')),
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
			$this->form_validation->set_rules('mobile', 'Mobile Number', 'required|trim|is_unique[starter_students_personalinfo.spinfo_personal_phone]', array('is_unique'=>'The mobile number is already exist!'));
			$this->form_validation->set_rules('mobile', 'Mobile Number', 'required|trim|is_unique[starter_teachers_personalinfo.tpinfo_personal_phone]', array('is_unique'=>'The mobile number is already exist!'));
			$user_name = $this->session->userdata('wizard_username_teacher');
			$this->load->library('upload');
			$this->load->library('image_lib');
			$config['upload_path']          = 'attachments/faculties/'.$user_name.'/';
			$config['allowed_types']        = 'gif|jpg|png|jpeg';
			$config['detect_mime']          = TRUE;
			$config['remove_spaces']        = TRUE;
			$config['encrypt_name']         = TRUE;
			$config['max_size']             = '0';
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('recent_photo')){
			  $upload_error = $this->upload->display_errors();
			}else{
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
				$this->Registration_model->save_personal_info($get_form_data);
				$sess['personal_completed_teacher'] = TRUE; 
				$sess['wzrd_faclt_full_name'] = $get_form_data['tpinfo_first_name'].' '.$get_form_data['tpinfo_middle_name'].' '.$get_form_data['tpinfo_last_name']; 
				$this->session->set_userdata($sess);
				
				$wizard = '
							<div class="ste-wizard-flow">
								<div class="step-absolute-container">
									<div class="single-step-flow one">
										<div class="bullet-check-mark"><i class="ion-checkmark-circled"></i></div>
										<div class="step-name-intext">
											<span class="bold-text">STEP 1</span>
											<span class="normal-text">Account</span>
										</div>
									</div>
									<div class="single-step-flow two">
										<div class="bullet-check-mark"><i class="ion-checkmark-circled"></i></div>
										<div class="step-name-intext">
											<span class="bold-text">STEP 2</span>
											<span class="normal-text">Personal</span>
										</div>
									</div>
									<div class="single-step-flow three active">
										<div class="bullet-check-mark"><i class="zmdi zmdi-circle"></i></div>
										<div class="step-name-intext">
											<span class="bold-text">STEP 3</span>
											<span class="normal-text">Academic</span>
										</div>
									</div>
									<div class="single-step-flow four">
										<div class="bullet-check-mark"><i class="zmdi zmdi-circle"></i></div>
										<div class="step-name-intext">
											<span class="normal-text">
												Administration verification & approval
											</span>
										</div>
									</div>
								</div>
							</div>
						  ';
				$template['display_template'] = TRUE;
				$content = $this->load->view('regflow/academic', $template, true);
				$result = array('status' => 'ok', 'wizard' => $wizard, 'content' => $content);
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
		
	}
	
	public function back_to_personal()
	{
		$template['display_template'] = TRUE;
		$template['teacher_id'] = $this->session->userdata('wizard_teacher_id');
		$content = $this->load->view('regflow/personal_edit', $template, true);
		
		$wizard = '
					<div class="ste-wizard-flow">
						<div class="step-absolute-container">
							<div class="single-step-flow one">
								<div class="bullet-check-mark"><i class="ion-checkmark-circled"></i></div>
								<div class="step-name-intext">
									<span class="bold-text">STEP 1</span>
									<span class="normal-text">Account</span>
								</div>
							</div>
							<div class="single-step-flow two active">
								<div class="bullet-check-mark"><i class="ion-checkmark-circled"></i></div>
								<div class="step-name-intext">
									<span class="bold-text">STEP 2</span>
									<span class="normal-text">Personal</span>
								</div>
							</div>
							<div class="single-step-flow three">
								<div class="bullet-check-mark"><i class="ion-checkmark-circled"></i></div>
								<div class="step-name-intext">
									<span class="bold-text">STEP 3</span>
									<span class="normal-text">Academic</span>
								</div>
							</div>
							<div class="single-step-flow four">
								<div class="bullet-check-mark"><i class="zmdi zmdi-circle"></i></div>
								<div class="step-name-intext">
									<span class="normal-text">
										Administration verification & approval
									</span>
								</div>
							</div>
						</div>
					</div>
				  ';
		
		$result = array('status' => 'ok', 'wizard' => $wizard, 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function academic()
	{
		$file_data_1 = $_FILES['certificate_1']['name'];
		$file_data_2 = $_FILES['certificate_2']['name'];
		$file_data_3 = $_FILES['certificate_3']['name'];
		
		if(!$file_data_1)
		{
			$error_content = '
								<div role="alert" class="alert alert-danger alert-light alert-dismissible">
									<button aria-label="Close" data-dismiss="alert" class="close" type="button"><i class="zmdi zmdi-close"></i></button>
									Please upload your SSC certificate!
								</div>
							 ';
			$result = array('status' => 'error', 'error' => $error_content);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
		
		if(!$file_data_2)
		{
			$error_content = '
								<div role="alert" class="alert alert-danger alert-light alert-dismissible">
									<button aria-label="Close" data-dismiss="alert" class="close" type="button"><i class="zmdi zmdi-close"></i></button>
									Please upload your HSC certificate!
								</div>
							 ';
			$result = array('status' => 'error', 'error' => $error_content);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
		
		if(!$file_data_3)
		{
			$error_content = '
								<div role="alert" class="alert alert-danger alert-light alert-dismissible">
									<button aria-label="Close" data-dismiss="alert" class="close" type="button"><i class="zmdi zmdi-close"></i></button>
									Please upload your MBBS certificate!
								</div>
							 ';
			$result = array('status' => 'error', 'error' => $error_content);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
		
		$teacher_id = $this->session->userdata('wizard_teacher_id');
		$teacher_username = $this->session->userdata('wizard_username_teacher');
		
		//Save professional information
		$professional_data = array(
								'tpsinfo_teacher_id'           => $teacher_id,
								'tpsinfo_designation'          => html_escape($this->input->post('designation')),
								'tpsinfo_organization'         => html_escape($this->input->post('organization')),
								'tpsinfo_organization_address' => html_escape($this->input->post('organization_address')),
								'tpsinfo_bmanddc_number'       => html_escape($this->input->post('bmanddc_number')),
								'tpsinfo_typeof_practice'      => $this->input->post('practice_type'),
								'tpsinfo_sinceyear_mbbs'       => $this->input->post('years_since'),
								'tpsinfo_experience'           => $this->input->post('years_experience'),
							);
		$this->Registration_model->save_professional_info($professional_data);
		
		//Save specialization
		$count_specialization = count($this->input->post('specialization'));
		for($x=0; $x<$count_specialization; $x++)
		{
			if(isset($this->input->post('specialization')[$x]))
			{
				if($this->input->post('specialization')[$x] == 'Other')
				{
					$specialization_data = array(
										'ts_teacher_id' => $teacher_id,
										'ts_specilzation_has_other' => 1,
										'ts_specilzation_other' => html_escape($this->input->post('other_specialization')),
									);
					$this->Registration_model->save_specialization_info($specialization_data);
				}else
				{
				$specialization_data = array(
									'ts_teacher_id' => $teacher_id,
									'ts_specilzation_id' => $this->input->post('specialization')[$x],
								);
				$this->Registration_model->save_specialization_info($specialization_data);
				}
			}		
		}
		
		//Save academic information
		$academic_row = count($this->input->post('rownumber'));
		
		for($row=0; $row < $academic_row; $row++)
		{
			$x = $this->input->post('rownumber')[$row];
			if($this->input->post('degree_'.$x) && $this->input->post('year_'.$x) && $this->input->post('institute_'.$x) && $this->input->post('cgpa_'.$x))
			{
				$academic_data = array(
									'tacinfo_teacher_id'  => $teacher_id,
									'tacinfo_degree'      => html_escape($this->input->post('degree_'.$x)),
									'tacinfo_year'        => html_escape($this->input->post('year_'.$x)),
									'tacinfo_institute'   => html_escape($this->input->post('institute_'.$x)),
									'tacinfo_cgpa'        => html_escape($this->input->post('cgpa_'.$x)),
									'tacinfo_certificate' => null,
								);
				$this->load->library('upload');
				$config['upload_path']          = 'attachments/faculties/'.$teacher_username.'/';
				$config['allowed_types']        = 'gif|jpg|png|jpeg|pdf|doc';
				$config['detect_mime']          = TRUE;
				$config['remove_spaces']        = TRUE;
				$config['encrypt_name']         = TRUE;
				$config['max_size']             = '0';
				$this->upload->initialize($config);
				if (!$this->upload->do_upload('certificate_'.$x)){
					 $upload_error = $this->upload->display_errors();
				}else{
					$fileData = $this->upload->data();
					$academic_data['tacinfo_certificate'] = $fileData['file_name'];
				}
				
				$this->Registration_model->save_academic_info($academic_data);
			}
		}
		
		//Save dlp categories
		$count_categories = count($this->input->post('dlp_category'));
		for($x=0; $x<$count_categories; $x++)
		{
			if(isset($this->input->post('dlp_category')[$x]))
			{
				$categories_data = array(
								'tdc_teacher_id' => $teacher_id,
								'tdc_category_id' => $this->input->post('dlp_category')[$x],
							);
				$this->Registration_model->save_categories_info($categories_data);
			}		
		}
		
		$sess['academic_completed_teacher'] = TRUE;
		$this->session->set_userdata($sess);
		
		$wizard = '
					<div class="ste-wizard-flow">
						<div class="step-absolute-container">
							<div class="single-step-flow one">
								<div class="bullet-check-mark"><i class="ion-checkmark-circled"></i></div>
								<div class="step-name-intext">
									<span class="bold-text">STEP 1</span>
									<span class="normal-text">Account</span>
								</div>
							</div>
							<div class="single-step-flow two">
								<div class="bullet-check-mark"><i class="ion-checkmark-circled"></i></div>
								<div class="step-name-intext">
									<span class="bold-text">STEP 2</span>
									<span class="normal-text">Personal</span>
								</div>
							</div>
							<div class="single-step-flow three">
								<div class="bullet-check-mark"><i class="ion-checkmark-circled"></i></div>
								<div class="step-name-intext">
									<span class="bold-text">STEP 3</span>
									<span class="normal-text">Academic</span>
								</div>
							</div>
							<div class="single-step-flow four active">
								<div class="bullet-check-mark"><i class="zmdi zmdi-circle"></i></div>
								<div class="step-name-intext">
									<span class="normal-text">
										Administration verification & approval
									</span>
								</div>
							</div>
						</div>
					</div>
				  ';
		
		/*Send An Emain Congratulation*/
		$data['faclt_full_name'] = $this->session->userdata('wzrd_faclt_full_name');
		$data['faclt_login_email'] = $this->session->userdata('wizard_faclt_eml');
		$data['faclt_login_password'] = $this->session->userdata('wizard_faclt_p');
		$data['teacher'] = $this->session->userdata('wizard_teacher_id');
		$body = $this->load->view('email', $data, true);
		$config = Array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_port' => 465,
			'smtp_user' => 'dlp.coordinator@dldchc-badas.org.bd',
			'smtp_pass' => 'Dlp@2018-badas',
			'mailtype'  => 'html', 
			'charset'   => 'iso-8859-1',
			'wordwrap'  => TRUE
		);
		
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		$this->email->from('dlp.coordinator@dldchc-badas.org.bd', 'Distance Learning Programme (DLP)');
		
		$this->email->to($this->session->userdata('wizard_faclt_eml')); 
		$this->email->subject('Registration successful');
		$this->email->set_crlf('\r\n');
		$this->email->set_header('MIME-Version', '1.0; charset=utf-8');
		$this->email->message($body); 
		$this->email->send();
		
		$template['display_template'] = TRUE;
		$content = $this->load->view('regflow/approval', $template, true);
		$result = array('status' => 'ok', 'wizard' => $wizard, 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
}