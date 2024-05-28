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
			$student_id = $this->session->userdata('wizard_student_id');
			$get_form_data = array(
								'student_email'    => html_escape($this->input->post('email')),
								'student_password' => sha1(html_escape($this->input->post('password'))),
								'student_regdate'  => date("Y-m-d H:i:s"),
								'student_gtp'      => html_escape($this->input->post('password')),
								'student_ip_address'  => $this->input->ip_address(),
							 );
							 
			$validate = array(
							array(
								'field' => 'password',
								'label' => 'Password',
								'rules' => 'required|trim',
							),
							array(
								'field' => 'email',
								'label' => 'email',
								'rules' => 'required|trim|is_unique[starter_students.student_email]',
							),
						);
			$this->form_validation->set_rules($validate);
			$check_email = $this->Registration_model->check_email(html_escape($this->input->post('email')));
			if($check_email == true && $check_email['student_id'] != $student_id)
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
			$check_teacher_email = $this->Registration_model->check_teacher_email(html_escape($this->input->post('email')));
			if($check_teacher_email == true)
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
				$this->Registration_model->update_account($student_id, $get_form_data);
				$sess['wizard_eml'] = $this->input->post('email');
				$sess['wizard_p'] = $this->input->post('password');
				$sess['account_completed'] = TRUE;
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
									<div class="single-step-flow five">
										<div class="bullet-check-mark"><i class="zmdi zmdi-circle"></i></div>
										<div class="step-name-intext">
											<span class="bold-text">STEP 5</span>
											<span class="normal-text">Payment</span>
										</div>
									</div>
								</div>
							</div>
						  ';
				$template['display_template'] = TRUE;
				
				$check_personal_info = $this->Registration_model->get_personal_info($student_id);
				if($check_personal_info == true)
				{
					$template['student_id'] = $student_id;
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
								'student_email'    => html_escape($this->input->post('email')),
								'student_password' => sha1(html_escape($this->input->post('password'))),
								'student_regdate'  => date("Y-m-d H:i:s"),
								'batch_name' => html_escape($this->input->post('batch_name')),
								'student_gtp'      => html_escape($this->input->post('password')),
								'student_ip_address' => $this->input->ip_address(),
							 );
							 
			$validate = array(
							array(
								'field' => 'password',
								'label' => 'Password',
								'rules' => 'required|trim',
							),
						);
			$this->form_validation->set_rules($validate);
			/*$this->form_validation->set_rules('email', 'Email', 'required|trim|is_unique[starter_students.student_email]', array('is_unique'=>'The email is already exist!'));
			$this->form_validation->set_rules('email', 'Email', 'required|trim|is_unique[starter_teachers.teacher_email]', array('is_unique'=>'The email is already exist!'));*/
			$check_email = $this->Registration_model->check_email(html_escape($this->input->post('email')));
			if($check_email == true)
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
			$check_teacher_email = $this->Registration_model->check_teacher_email(html_escape($this->input->post('email')));
			if($check_teacher_email == true)
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
				$st_insert_id = $this->Registration_model->save_account($get_form_data);
				$student_id = $this->db->insert_id($st_insert_id);
				
				$sess['wizard_student_id'] = $student_id;
				$sess['wizard_eml'] = $this->input->post('email');
				$sess['wizard_p'] = $this->input->post('password');
				$sess['account_completed'] = TRUE;
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
									<div class="single-step-flow five">
										<div class="bullet-check-mark"><i class="zmdi zmdi-circle"></i></div>
										<div class="step-name-intext">
											<span class="bold-text">STEP 5</span>
											<span class="normal-text">Payment</span>
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
		$template['student_id'] = $this->session->userdata('wizard_student_id');
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
							<div class="single-step-flow five">
								<div class="bullet-check-mark"><i class="zmdi zmdi-circle"></i></div>
								<div class="step-name-intext">
									<span class="bold-text">STEP 5</span>
									<span class="normal-text">Payment</span>
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
		if($update == '1')
		{
			$student_id = $this->session->userdata('wizard_student_id');
			$phn = html_escape($this->input->post('mobile'));
			if(substr($phn, 0, 2) != '88')
			{
				$phone_number = '88'.$phn;
			}else
			{
				$phone_number = $phn;
			}


			
			$get_form_data = array(
								'spinfo_first_name'        => html_escape($this->input->post('first_name')),
								'spinfo_middle_name'       => html_escape($this->input->post('middle_name')),
								'spinfo_last_name'         => html_escape($this->input->post('last_name')),
								'spinfo_birth_date'        => html_escape($this->input->post('birthday')),
								'spinfo_gender'            => html_escape($this->input->post('gender')),
								'spinfo_nationality'       => html_escape($this->input->post('nationality')),
								'spinfo_fmorspouse_name'   => html_escape($this->input->post('fms_name')),
								'spinfo_father_name'   => html_escape($this->input->post('father_name')),
								'spinfo_mother_name'   => html_escape($this->input->post('mother_name')),
								'spinfo_national_id'       => html_escape($this->input->post('national_id')),
								'spinfo_email'             => html_escape($this->input->post('contact_email')),
								'spinfo_personal_phone'    => $phone_number,
								'spinfo_office_phone'      => html_escape($this->input->post('office')),
								'spinfo_home_phone'        => html_escape($this->input->post('home')),
								'spinfo_current_address'   => html_escape($this->input->post('current_address')),
								'spinfo_permanent_address' => html_escape($this->input->post('permanent_address')),
								'spinfo_current_division' => html_escape($this->input->post('current_division')),
								'spinfo_current_district' => html_escape($this->input->post('current_district')),
								'spinfo_permanent_division' => html_escape($this->input->post('permanent_division')),
								'spinfo_permanent_district' => html_escape($this->input->post('permanent_district')),
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
			if($check_mobile == true && $check_mobile['spinfo_student_id'] != $student_id)
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
			
			$check_teacher_mobile = $this->Registration_model->check_teacher_mobile(html_escape($phone_number));
			if($check_teacher_mobile == true)
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
			$user_name = $this->session->userdata('wizard_username');
			$this->load->library('upload');
			$this->load->library('image_lib');
			$config['upload_path']          = 'attachments/students/';
			/*$config['upload_path']          = 'attachments/students/'.$user_name.'/';*/
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
				$get_form_data['spinfo_photo'] = $fileData['file_name'];
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
				$this->Registration_model->update_personal_info($student_id, $get_form_data);
				$sess['personal_completed'] = TRUE; 
				$sess['wzrd_full_name'] = $get_form_data['spinfo_first_name'].' '.$get_form_data['spinfo_middle_name'].' '.$get_form_data['spinfo_last_name']; 
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
									<div class="single-step-flow five">
										<div class="bullet-check-mark"><i class="zmdi zmdi-circle"></i></div>
										<div class="step-name-intext">
											<span class="bold-text">STEP 5</span>
											<span class="normal-text">Payment</span>
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
			
			if($this->input->post('nationality') == '18')
			{
				$get_format_prefix = 'CCVD';
			}else
			{
				$get_format_prefix = 'eK';
			}
			
			$student_serial_no = $this->Registration_model->total_students();
			$counter_digit = str_pad($student_serial_no, 4, '0', STR_PAD_LEFT);
			$student_entryid = $get_format_prefix.date('Ym').$counter_digit;
			
			//update entryid
			$this->db->where('student_id', $this->session->userdata('wizard_student_id'));
			$this->db->update('starter_students', array('student_entryid' =>$student_entryid, 'student_portid' => sha1($student_entryid)));
			
			//create directory for the student
			/*$dirpath = users_directory('students/'.$student_entryid);
			if(file_exists($dirpath))
			{
				echo null;
			}else
			{
				mkdir($dirpath);
			}*/
			
			$get_form_data = array(
								'spinfo_student_id'        => $this->session->userdata('wizard_student_id'),
								'spinfo_first_name'        => html_escape($this->input->post('first_name')),
								'spinfo_middle_name'       => html_escape($this->input->post('middle_name')),
								'spinfo_last_name'         => html_escape($this->input->post('last_name')),
								'spinfo_birth_date'        => html_escape($this->input->post('birthday')),
								'spinfo_gender'            => html_escape($this->input->post('gender')),
								'spinfo_nationality'       => html_escape($this->input->post('nationality')),
								'spinfo_fmorspouse_name'   => html_escape($this->input->post('fms_name')),
								'spinfo_father_name'   => html_escape($this->input->post('father_name')),
								'spinfo_mother_name'   => html_escape($this->input->post('mother_name')),
								'spinfo_national_id'       => html_escape($this->input->post('national_id')),
								'spinfo_email'             => html_escape($this->input->post('contact_email')),
								'spinfo_personal_phone'    => $phone_number,
								'spinfo_office_phone'      => html_escape($this->input->post('office')),
								'spinfo_home_phone'        => html_escape($this->input->post('home')),
								'spinfo_current_address'   => html_escape($this->input->post('current_address')),
								'spinfo_permanent_address' => html_escape($this->input->post('permanent_address')),
								'spinfo_current_division' => html_escape($this->input->post('current_division')),
								'spinfo_current_district' => html_escape($this->input->post('current_district')),
								'spinfo_permanent_division' => html_escape($this->input->post('permanent_division')),
								'spinfo_permanent_district' => html_escape($this->input->post('permanent_district')),								
							 );
			$validate = array(
							array(
								'field' => 'first_name',
								'label' => 'First Name',
								'rules' => 'required|trim',
							),
						);
			$this->form_validation->set_rules($validate);
			/*$this->form_validation->set_rules('mobile', 'Mobile Number', 'required|trim|is_unique[starter_students_personalinfo.spinfo_personal_phone]', array('is_unique'=>'The mobile number is already exist!'));
			$this->form_validation->set_rules('mobile', 'Mobile Number', 'required|trim|is_unique[starter_teachers_personalinfo.tpinfo_personal_phone]', array('is_unique'=>'The mobile number is already exist!'));*/
			$check_mobile = $this->Registration_model->check_mobile(html_escape($phone_number));
			if($check_mobile == true)
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
			$user_name = $student_entryid;
			$this->load->library('upload');
			$this->load->library('image_lib');
			$config['upload_path']          = 'attachments/students/';
			/*$config['upload_path']          = 'attachments/students/'.$user_name.'/';*/
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
				$get_form_data['spinfo_photo'] = $fileData['file_name'];
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
				$sess['personal_completed'] = TRUE; 
				$sess['wizard_username'] = $student_entryid;
				$sess['wzrd_full_name'] = $get_form_data['spinfo_first_name'].' '.$get_form_data['spinfo_middle_name'].' '.$get_form_data['spinfo_last_name']; 
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
									<div class="single-step-flow five">
										<div class="bullet-check-mark"><i class="zmdi zmdi-circle"></i></div>
										<div class="step-name-intext">
											<span class="bold-text">STEP 5</span>
											<span class="normal-text">Payment</span>
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
		$template['student_id'] = $this->session->userdata('wizard_student_id');
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
							<div class="single-step-flow five">
								<div class="bullet-check-mark"><i class="zmdi zmdi-circle"></i></div>
								<div class="step-name-intext">
									<span class="bold-text">STEP 5</span>
									<span class="normal-text">Payment</span>
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
		$file_bmdc = $_FILES['certificate_bmdc']['name'];
		if(!$file_bmdc)
		{
			$error_content = '
								<div role="alert" class="alert alert-danger alert-light alert-dismissible">
									<button aria-label="Close" data-dismiss="alert" class="close" type="button"><i class="zmdi zmdi-close"></i></button>
									Please upload your BMDC certificate!
								</div>
							 ';
			$result = array('status' => 'error', 'error' => $error_content);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
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
		

		
		$student_id = $this->session->userdata('wizard_student_id');
		$student_username = $this->session->userdata('wizard_username');
		
		//Save professional information
		$professional_data = array(
								'spsinfo_student_id'           => $student_id,
								'spsinfo_designation'          => html_escape($this->input->post('designation')),
								'spsinfo_organization'         => html_escape($this->input->post('organization')),
								'spsinfo_organization_address' => html_escape($this->input->post('organization_address')),
								'spsinfo_bmanddc_number'       => html_escape($this->input->post('bmanddc_number')),
								'spsinfo_typeof_practice'      => $this->input->post('practice_type'),
								'spsinfo_sinceyear_mbbs'       => $this->input->post('years_since'),
								'spsinfo_experience'           => $this->input->post('years_experience'),
							);

		$this->load->library('upload');
				$config['upload_path']          = 'attachments/students/';
				/*$config['upload_path']          = 'attachments/students/'.$student_username.'/';*/
				$config['allowed_types']        = 'gif|jpg|png|jpeg|pdf|doc';
				$config['detect_mime']          = TRUE;
				$config['remove_spaces']        = TRUE;
				$config['encrypt_name']         = TRUE;
				$config['max_size']             = '0';
				$this->upload->initialize($config);
				if (!$this->upload->do_upload('certificate_bmdc')){
					 $upload_error = $this->upload->display_errors();
				}else{
					$fileData = $this->upload->data();
					$professional_data['spsinfo_bmanddc_certificate'] = $fileData['file_name'];
				}
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
										'ss_student_id' => $student_id,
										'ss_specilzation_has_other' => 1,
										'ss_specilzation_other' => html_escape($this->input->post('other_specialization')),
									);
					$this->Registration_model->save_specialization_info($specialization_data);
				}else
				{
				$specialization_data = array(
									'ss_student_id' => $student_id,
									'ss_specilzation_id' => $this->input->post('specialization')[$x],
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
									'sacinfo_student_id'  => $student_id,
									'sacinfo_degree'      => html_escape($this->input->post('degree_'.$x)),
									'sacinfo_year'        => html_escape($this->input->post('year_'.$x)),
									'sacinfo_institute'   => html_escape($this->input->post('institute_'.$x)),
									'sacinfo_cgpa'        => html_escape($this->input->post('cgpa_'.$x)),
									'sacinfo_certificate' => null,
								);
				$this->load->library('upload');
				$config['upload_path']          = 'attachments/students/';
				/*$config['upload_path']          = 'attachments/students/'.$student_username.'/';*/
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
					$academic_data['sacinfo_certificate'] = $fileData['file_name'];
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
								'sdc_student_id' => $student_id,
								'sdc_category_id' => $this->input->post('dlp_category')[$x],
							);
				$this->Registration_model->save_categories_info($categories_data);
			}		
		}
		
		$sess['academic_completed'] = TRUE;
		$this->session->set_userdata($sess);

		//update info status
		$this->db->where('student_id', $this->session->userdata('wizard_student_id'));
		$this->db->update('starter_students', array('info_status' =>1));
		//$this->Registration_model->updatestudentinfo($this->session->userdata('wizard_student_id'));
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
							<div class="single-step-flow five">
								<div class="bullet-check-mark"><i class="zmdi zmdi-circle"></i></div>
								<div class="step-name-intext">
									<span class="bold-text">STEP 5</span>
									<span class="normal-text">Payment</span>
								</div>
							</div>
						</div>
					</div>
				  ';
		
		//Send email
		
		$get_studentinfo = $this->Registration_model->get_student_info($student_id);
		
		/*Send An Emain Congratulation*/
		$data['full_name'] = $this->session->userdata('wzrd_full_name');
		$data['login_username'] = $this->session->userdata('wizard_username');
		$data['login_password'] = $this->session->userdata('wizard_p');
		$data['student'] = $this->session->userdata('wizard_student_id');
		$data['student_ID_No'] = $get_studentinfo['student_entryid'];
		$data['mail_title'] = '<h2 class="main-title"><span>Dear Mr/Ms/Mrs </span>'.$data['full_name'].',</h2>';
		$data['mail_content'] = '<p>Thank you for your application. Your Application ID No :'.$data['student_ID_No'].'. Please wait for approval from Coordinator, CCD. You will receive an SMS and email upon approval.</p>';
		$body = mail_body($data);
		$config = Array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_port' => 465,
			'smtp_user' => 'ccvd@ibrahimcardiac.org.bd',
			'smtp_pass' => 'ccvd@cardiac2020',
			'mailtype'  => 'html', 
			'charset'   => 'iso-8859-1',
			'wordwrap'  => TRUE
		);
		
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		$this->email->from('ccvd@ibrahimcardiac.org.bd', 'Certificate Course on Cardiovascular Disease (CCVD)');
		
		$this->email->to($this->session->userdata('wizard_eml')); 
		$this->email->subject('Registration successful');
		$this->email->set_crlf('\r\n');
		$this->email->set_header('MIME-Version', '1.0; charset=utf-8');
		$this->email->set_header('Content-Type', 'text/html');
		$this->email->message($body); 
		$this->email->send();
		
		$template['display_template'] = TRUE;
		$content = $this->load->view('regflow/approval', $template, true);
		
		$phone_number = $get_studentinfo['spinfo_personal_phone'];
		$name = $get_studentinfo['spinfo_first_name'].' '.$get_studentinfo['spinfo_middle_name'].' '.$get_studentinfo['spinfo_last_name'];
$message ='Dear '.$name.',
Thank you for your application. Your Application ID No. '.$get_studentinfo['student_entryid'].'. Please wait for Coordinator approval.
';
		sendsms($phone_number, $message);
		
		$result = array('status' => 'ok', 'wizard' => $wizard, 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function payment()
	{
		$confirm = $this->input->post('confirm');
		$student_portid = html_escape($this->input->post('port'));
		$get_student_info = $this->Registration_model->student_basic_info($student_portid);
		/* print_r($get_student_info);exit; */
		if($confirm === '1' && $get_student_info == true)
		{
			$sess['customer_name'] = $get_student_info['spinfo_first_name'].' '.$get_student_info['spinfo_middle_name'].' '.$get_student_info['spinfo_last_name'];
			$sess['customer_email'] = $get_student_info['student_email'];
			$sess['customer_phone'] = $get_student_info['spinfo_personal_phone'];
			$sess['customer_additional'] = $get_student_info['student_entryid'];
			$sess['payment_fr'] = 'Admission';
			
			$this->session->set_userdata($sess);
			
			$result = array('status' => 'ok');
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else
		{
			exit;
		}
	}
	
	public function updeposit()
	{
		$file_data = $_FILES['slip']['name'];
		
		if(!$file_data)
		{
			$error = '<strong style="color:#F00">No deposit slip has been selected!</strong>';
			$result = array('status' => 'error', 'error' => $error);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
		
		$portid = html_escape($this->input->post('portid'));
		$portinfo = $this->Registration_model->student_basic_info($portid);
		if($portinfo == true)
		{
			$deposit_data = array(
								'deposit_student_entryid' => $portinfo['student_entryid'],
								'deposit_payment'         => html_escape($this->input->post('payment')),
								'deposit_amount'         => html_escape($this->input->post('amount')),
								'deposit_bank'            => html_escape($this->input->post('bank_name')),
								'deposit_account_number'  => html_escape($this->input->post('ac_number')),
								'deposit_branch'          => html_escape($this->input->post('branch_name')),
								'deposit_user_ip'         => $this->input->ip_address(),
								'deposit_submit_date'     => date("Y-m-d H:i:s"),
							); 
			
			//upload deposit file
			$this->load->library('upload');
			$config['upload_path']          = 'attachments/students/';
			/*$config['upload_path']          = 'attachments/students/'.$portinfo['student_entryid'].'/';*/
			$config['allowed_types']        = 'jpg|png|jpeg|pdf';
			$config['detect_mime']          = TRUE;
			$config['remove_spaces']        = TRUE;
			$config['encrypt_name']         = TRUE;
			$config['max_size']             = '0';
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('slip')){
				 $upload_error = $this->upload->display_errors();
			}else{
				$fileData = $this->upload->data();
				$deposit_data['deposit_slip_file'] = $fileData['file_name'];
			}
			
			$this->Registration_model->save_deposit_info($deposit_data);
			$sid = sha1($portinfo['student_entryid']);
			$result = array('status' => 'ok', 'sid' => $sid);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else
		{
			$error = '<strong style="color:#F00">Sorry! something happening wrong there.</strong>';
			$result = array('status' => 'error', 'error' => $error);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
	}
}