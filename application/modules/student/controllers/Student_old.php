<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student extends CI_Controller{
	
	private $sqtoken;
	private $sqtoken_hash;
	private $perPage;
	
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Dhaka');
		
		$active_student = $this->session->userdata('active_student');
		$studentLogin = $this->session->userdata('studentLogin');
		if($active_student === NULL && $studentLogin !== TRUE)
		{
			redirect('student/login', 'refresh', true);
		}
		
		$this->sqtoken = $this->security->get_csrf_token_name();
		$this->sqtoken_hash = $this->security->get_csrf_hash();
		$this->load->library('ajax_pagination');
		$this->load->model('Course_model');
		$this->load->model('Result_model');
		$this->load->model('Evaluation_model');
		$this->load->model('Faqs_model');
		$this->load->model('Discussion_model');
		$this->load->model('Payment_model');
		$this->load->model('Student_model');
		$this->load->model('Dashboard_model');
		$this->load->model('Booking_model');
	}
	
	private function check_date($mrk_colnm, $phase)
	{
		$student_id = $this->session->userdata('active_student');
		$check_exm_result = $this->Student_model->check_exm_result($student_id, $phase);
		if($check_exm_result == true && $check_exm_result['cmreport_status'] == '0')
		{
			$starting_date_from = $check_exm_result['cmreport_create_date'];
			$exam_activation_date = date("Y-m-d", strtotime(date("Y-m-d", strtotime($starting_date_from))."+7 days"));
		
			$current_date = date("Y-m-d");
			
			$time_stamp_currentdate = strtotime($current_date);
			$time_stamp_exmdate = strtotime($exam_activation_date);
			
			if($time_stamp_currentdate >= $time_stamp_exmdate)
			{
				$active = 1;
			}else{
				$active = 0;
			}
		}else
		{
			$query = $this->db->query("SELECT student_regdate FROM starter_students WHERE starter_students.student_id='$student_id' LIMIT 1");
			$student_row = $query->row_array();
			$starting_date_from = $student_row['student_regdate'];

			$marks_config = $this->db->query("SELECT $mrk_colnm FROM starter_marks_config WHERE starter_marks_config.mrkconfig_key='One_Time' LIMIT 1");
			$config_row = $marks_config->row_array();
			$after_the_end_date = $config_row[$mrk_colnm];
			
			$exam_activation_date = date("Y-m-d", strtotime(date("Y-m-d", strtotime($starting_date_from))."+".$after_the_end_date));
			
			$current_date = date("Y-m-d");
			
			$time_stamp_currentdate = strtotime($current_date);
			$time_stamp_exmdate = strtotime($exam_activation_date);
			
			if($time_stamp_currentdate >= $time_stamp_exmdate)
			{
				$active = 1;
			}else{
				$active = 0;
			}
		}
		
		return $active;
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
		
		$student_id = $this->session->userdata('active_student');
		$phn = html_escape($this->input->post('mobile'));
		if(substr($phn, 0, 2) !== '88')
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
							'spinfo_national_id'       => html_escape($this->input->post('national_id')),
							'spinfo_office_phone'      => html_escape($this->input->post('office')),
							'spinfo_home_phone'        => html_escape($this->input->post('home')),
							'spinfo_current_address'   => html_escape($this->input->post('current_address')),
							'spinfo_permanent_address' => html_escape($this->input->post('permanent_address')),
						 );
		if($phn)
		{
			$get_form_data['spinfo_personal_phone_updaterqst'] = 'YES';
			$get_form_data['spinfo_personal_phone_updated']    = $phone_number;
		}
		$validate = array(
						array(
							'field' => 'first_name',
							'label' => 'First Name',
							'rules' => 'required|trim',
						),
					);
		$this->form_validation->set_rules($validate);
		$exist_image = $this->Student_model->get_student_info();
		$student_entryid = $exist_image['student_entryid'];
		$this->load->library('upload');
		$this->load->library('image_lib');
		$config['upload_path']          = 'attachments/students/'.$student_entryid.'/';
		$config['allowed_types']        = 'gif|jpg|png|jpeg';
		$config['detect_mime']          = TRUE;
		$config['remove_spaces']        = TRUE;
		$config['encrypt_name']         = TRUE;
		$config['max_size']             = '0';
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('recent_photo')){
		  $upload_error = $this->upload->display_errors();
		}else{
			if(!empty($exist_image['spinfo_photo']) && $exist_image['spinfo_photo'] !== NULL){
				$file_name = attachment_dir("students/".$exist_image['student_entryid'].'/'.$exist_image['spinfo_photo']);
				if(file_exists($file_name)){
					unlink($file_name);
				}else{
					echo null;
				}
			}else{
				echo null;
			}
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
			$this->Student_model->update_personal_info($student_id, $get_form_data);
			
			$success_content = '<div role="alert" class="alert alert-success alert-light alert-dismissible">
									<button aria-label="Close" data-dismiss="alert" class="close" type="button"><i class="zmdi zmdi-close"></i></button>
									Information has been successfully updated!
								</div>
							   ';
			if($phn)
			{
				$personal_phone_changed = '<div role="alert" class="alert alert-info alert-light alert-dismissible">
											<button aria-label="Close" data-dismiss="alert" class="close" type="button"><i class="zmdi zmdi-close"></i></button>
											Your personal phone number is now under coordinator review!
										</div>
									   ';
			}else
			{
				$personal_phone_changed = null;
			}
			
			$result = array('status' => 'ok', 'success' => $success_content, 'personal_phone_changed' => $personal_phone_changed);
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
		$student_id = $this->session->userdata('active_student');
		
		//Save professional information
		$professional_data = array(
								'spsinfo_designation'          => html_escape($this->input->post('designation')),
								'spsinfo_organization'         => html_escape($this->input->post('organization')),
								'spsinfo_organization_address' => html_escape($this->input->post('organization_address')),
								'spsinfo_bmanddc_number'       => html_escape($this->input->post('bmanddc_number')),
								'spsinfo_typeof_practice'      => $this->input->post('practice_type'),
								'spsinfo_sinceyear_mbbs'       => $this->input->post('years_since'),
								'spsinfo_experience'           => $this->input->post('years_experience'),
							);
		$this->Student_model->update_professional_info($student_id, $professional_data);
		
		//Save specialization
		$this->db->where('ss_student_id', $student_id);
		$this->db->delete('starter_students_specializations');
		
		$count_specialization = count($this->input->post('specialization'));
		for($x=0; $x<$count_specialization; $x++)
		{
			if(isset($this->input->post('specialization')[$x]))
			{
				$specialization_data = array(
									'ss_student_id' => $student_id,
									'ss_specilzation_id' => $this->input->post('specialization')[$x],
								);
				$this->Student_model->save_specialization_info($specialization_data);
			}		
		}
		
		//Save dlp categories
		$this->db->where('sdc_student_id', $student_id);
		$this->db->delete('starter_students_dlpcategories');
		
		$count_categories = count($this->input->post('dlp_category'));
		for($x=0; $x<$count_categories; $x++)
		{
			if(isset($this->input->post('dlp_category')[$x]))
			{
				$categories_data = array(
								'sdc_student_id' => $student_id,
								'sdc_category_id' => $this->input->post('dlp_category')[$x],
							);
				$this->Student_model->save_categories_info($categories_data);
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
		$student_id = $this->session->userdata('active_student');
		$student_info = $this->Student_model->get_student_info();
		$academic_data = array(
							'sacinfo_student_id'  => $student_id,
							'sacinfo_degree'      => html_escape($this->input->post('degree')),
							'sacinfo_year'        => html_escape($this->input->post('year')),
							'sacinfo_institute'   => html_escape($this->input->post('institute')),
							'sacinfo_cgpa'        => html_escape($this->input->post('cgpa')),
						);
		$this->load->library('upload');
		$config['upload_path']          = 'attachments/students/'.$student_info['student_entryid'].'/';
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
			$academic_data['sacinfo_certificate'] = $fileData['file_name'];
		}
		
		$this->Student_model->save_academic_info($academic_data);
		
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
		$student_id = $this->session->userdata('active_student');
		$item_id = $this->input->post('id');
		$exist_image = $this->Student_model->get_certificate_row($student_id, $item_id);
		if(!empty($exist_image['sacinfo_certificate']) && $exist_image['sacinfo_certificate'] !== NULL){
			$file_name = attachment_dir("students/".$exist_image['student_entryid'].'/'.$exist_image['sacinfo_certificate']);
			if(file_exists($file_name)){
				unlink($file_name);
			}else{
				echo null;
			}
		}else{
			echo null;
		}
		
		$this->db->where('sacinfo_id', $item_id);
		$this->db->where('sacinfo_student_id', $student_id);
		$this->db->delete('starter_students_academicinfo');
		
		$result = array('status' => 'ok');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	//update password
	public function update_password()
	{
		$data['student_password'] = sha1(html_escape($this->input->post('password')));
		$student_id = $this->session->userdata('active_student');
		$this->Student_model->update_password($student_id, $data);
		
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

	public function payments()
	{
		$this->load->view('payments');
	}
	
	public function faqs()
	{
		$this->load->view('faqs');
	}
	
	public function support()
	{
		$this->load->view('support');
	}
	
	public function course()
	{
		//Back to course functions
		if(isset($_GET['rdr']) && $_GET['rdr'] == 'Course' && isset($_GET['phase']) && $_GET['phase'] == 'PCA-1' && isset($_GET['return']) && $_GET['return'] == 'true'){
			//check phase result and take step
			$phase = $this->Course_model->check_step();
			if($phase == true && ($phase['student_phaselevel_id'] == 0 || $phase['student_phaselevel_id'] == 1 || $phase['student_phaselevel_id'] == 2 || $phase['student_phaselevel_id'] == 3)){
				$data['phase_lavel'] = 1;
				
				$this->perPage = 6;
				if(isset($_GET['actmdl']))
				{
					$data['active_module'] = intval($_GET['actmdl']);
				}else
				{
					$data['active_module'] = $this->session->userdata('active_module');
				}
				
				$totalRec = count($this->Course_model->get_lessonsby_module(array('module_id' => $data['active_module'])));
				
				$config['target']      = '#postList';
				$config['base_url']    = base_url().'lessonfilter/get_lessons';
				$config['total_rows']  = $totalRec;
				$config['per_page']    = $this->perPage;
				$config['display_pages'] = FALSE;
				$config['first_link'] = FALSE;
				$config['last_link'] = FALSE;
				$config['anchor_class'] = 'course-lesson-link';
				
				$config['next_tag_open'] = '<span class="next-tg">';
				$config['next_tag_close'] = '</span>';
				
				$config['next_link'] = '<i class="fa fa-angle-right"></i>';
				$config['prev_link'] = '<i class="fa fa-angle-left"></i>';
				
				$config['prev_tag_open'] = '<span class="prev-tg">';
				$config['prev_tag_close'] = '</span>';
				
				$config['show_count']  = false;
				$config['link_func']   = 'getCourseLessons';
				$this->ajax_pagination->initialize($config);
				
				$data['items'] = $this->Course_model->get_lessonsby_module(array('limit'=>$this->perPage, 'module_id' => $data['active_module']));
				
				$active = $this->check_date('mrkconfig_exam_date', 1);
				if($active == 1 && $phase['student_phaselevel_id'] == 1)
				{
					$this->session->set_userdata(array('exam_activated' => TRUE));
					$data['pca_exam_link'] = '<div class="pca-exm-btn active-exm-bttn"><a target="_blank" href="'.base_url('student/exam/exstart/PCA-1/Phase-A/START').'">CCA - 1</a></div>';
				}else
				{
					$data['pca_exam_link'] = '<div class="pca-exm-btn"><a style="cursor:pointer">CCA - 1</a></div>';
				}
				$this->load->view('course', $data);
			}else
			{
				redirect('student/course', 'refresh', true);
			}
		}elseif(isset($_GET['rdr']) && $_GET['rdr'] == 'Course' && isset($_GET['phase']) && $_GET['phase'] == 'PCA-2' && isset($_GET['return']) && $_GET['return'] == 'true'){
			//check phase result and take step
			$phase = $this->Course_model->check_step();
			if($phase == true && ($phase['student_phaselevel_id'] == 0 || $phase['student_phaselevel_id'] == 2 || $phase['student_phaselevel_id'] == 3)){
				$data['phase_lavel'] = 2;
				
				$this->perPage = 6;
				if(isset($_GET['actmdl']))
				{
					$data['active_module'] = intval($_GET['actmdl']);
				}else
				{
					$data['active_module'] = $this->session->userdata('active_module');
				}
				
				$totalRec = count($this->Course_model->get_lessonsby_module(array('module_id' => $data['active_module'])));
				
				$config['target']      = '#postList';
				$config['base_url']    = base_url().'lessonfilter/get_lessons';
				$config['total_rows']  = $totalRec;
				$config['per_page']    = $this->perPage;
				$config['display_pages'] = FALSE;
				$config['first_link'] = FALSE;
				$config['last_link'] = FALSE;
				$config['anchor_class'] = 'course-lesson-link';
				
				$config['next_tag_open'] = '<span class="next-tg">';
				$config['next_tag_close'] = '</span>';
				
				$config['next_link'] = '<i class="fa fa-angle-right"></i>';
				$config['prev_link'] = '<i class="fa fa-angle-left"></i>';
				
				$config['prev_tag_open'] = '<span class="prev-tg">';
				$config['prev_tag_close'] = '</span>';
				
				$config['show_count']  = false;
				$config['link_func']   = 'getCourseLessons';
				$this->ajax_pagination->initialize($config);
				
				$data['items'] = $this->Course_model->get_lessonsby_module(array('limit'=>$this->perPage, 'module_id' => $data['active_module']));
				
				/* $active = $this->check_date('mrkconfig_pcatwo_exam_date', 2); */
				$active = $this->check_date('mrkconfig_pcatwo_exam_date', 1);
				if($active == 1 && $phase['student_phaselevel_id'] == 2)
				{
					$this->session->set_userdata(array('exam_activated' => TRUE));
					$data['pca_exam_link'] = '<div class="pca-exm-btn active-exm-bttn"><a target="_blank" href="'.base_url('student/exam/exstart/PCA-2/Phase-B/START').'">CCA - 2</a></div>';
				}else
				{
					$data['pca_exam_link'] = '<div class="pca-exm-btn"><a style="cursor:pointer">CCA - 2</a></div>';
				}
				$this->load->view('course_phase_b', $data);
			}else
			{
				redirect('student/course', 'refresh', true);
			}
		}elseif(isset($_GET['rdr']) && $_GET['rdr'] == 'Course' && isset($_GET['phase']) && $_GET['phase'] == 'PCA-3' && isset($_GET['return']) && $_GET['return'] == 'true'){
			//check phase result and take step
			$phase = $this->Course_model->check_step();
			if($phase == true && ($phase['student_phaselevel_id'] == 0 || $phase['student_phaselevel_id'] == 3)){
				$data['phase_lavel'] = 3;
				
				$this->perPage = 6;
				if(isset($_GET['actmdl']))
				{
					$data['active_module'] = intval($_GET['actmdl']);
				}else
				{
					$data['active_module'] = $this->session->userdata('active_module');
				}
				
				$totalRec = count($this->Course_model->get_lessonsby_module(array('module_id' => $data['active_module'])));
				
				$config['target']      = '#postList';
				$config['base_url']    = base_url().'lessonfilter/get_lessons';
				$config['total_rows']  = $totalRec;
				$config['per_page']    = $this->perPage;
				$config['display_pages'] = FALSE;
				$config['first_link'] = FALSE;
				$config['last_link'] = FALSE;
				$config['anchor_class'] = 'course-lesson-link';
				
				$config['next_tag_open'] = '<span class="next-tg">';
				$config['next_tag_close'] = '</span>';
				
				$config['next_link'] = '<i class="fa fa-angle-right"></i>';
				$config['prev_link'] = '<i class="fa fa-angle-left"></i>';
				
				$config['prev_tag_open'] = '<span class="prev-tg">';
				$config['prev_tag_close'] = '</span>';
				
				$config['show_count']  = false;
				$config['link_func']   = 'getCourseLessons';
				$this->ajax_pagination->initialize($config);
				
				$data['items'] = $this->Course_model->get_lessonsby_module(array('limit'=>$this->perPage, 'module_id' => $data['active_module']));
				
				$active = $this->check_date('mrkconfig_pcathree_exam_date', 3);
				if($active == 1 && $phase['student_phaselevel_id'] == 3)
				{
					$this->session->set_userdata(array('exam_activated' => TRUE));
					$data['pca_exam_link'] = '<div class="pca-exm-btn active-exm-bttn"><a target="_blank" href="'.base_url('student/exam/exstart/PCA-3/Phase-C/START').'">CCA - 3</a></div>';
				}else
				{
					$data['pca_exam_link'] = '<div class="pca-exm-btn"><a style="cursor:pointer">CCA - 3</a></div>';
				}
				$this->load->view('course_phase_c', $data);
			}else
			{
				redirect('student/course', 'refresh', true);
			}
		}else{
			//check phase result and take step
			$phase = $this->Course_model->check_step();
			$ece = $this->Course_model->check_ece();
			if($phase == true && $phase['student_phaselevel_id'] == 1){
				$data['phase_lavel'] = 1;
				
				$this->perPage = 6;
				if(isset($_GET['actmdl']))
				{
					$data['active_module'] = intval($_GET['actmdl']);
				}else
				{
					$data['active_module'] = $this->session->userdata('active_module');
				}
				
				$totalRec = count($this->Course_model->get_lessonsby_module(array('module_id' => $data['active_module'])));
				
				$config['target']      = '#postList';
				$config['base_url']    = base_url().'lessonfilter/get_lessons';
				$config['total_rows']  = $totalRec;
				$config['per_page']    = $this->perPage;
				$config['display_pages'] = FALSE;
				$config['first_link'] = FALSE;
				$config['last_link'] = FALSE;
				$config['anchor_class'] = 'course-lesson-link';
				
				$config['next_tag_open'] = '<span class="next-tg">';
				$config['next_tag_close'] = '</span>';
				
				$config['next_link'] = '<i class="fa fa-angle-right"></i>';
				$config['prev_link'] = '<i class="fa fa-angle-left"></i>';
				
				$config['prev_tag_open'] = '<span class="prev-tg">';
				$config['prev_tag_close'] = '</span>';
				
				$config['show_count']  = false;
				$config['link_func']   = 'getCourseLessons';
				$this->ajax_pagination->initialize($config);
				
				$data['items'] = $this->Course_model->get_lessonsby_module(array('limit'=>$this->perPage, 'module_id' => $data['active_module']));
				
				$active = $this->check_date('mrkconfig_exam_date', 1);
				if($active == 1 && $phase['student_phaselevel_id'] == 1)
				{
					$this->session->set_userdata(array('exam_activated' => TRUE));
					$data['pca_exam_link'] = '<div class="pca-exm-btn active-exm-bttn"><a target="_blank" href="'.base_url('student/exam/exstart/PCA-1/Phase-A/START').'">CCA - 1</a></div>';
				}else
				{
					$data['pca_exam_link'] = '<div class="pca-exm-btn"><a style="cursor:pointer">CCA - 1</a></div>';
				}
				$this->load->view('course', $data);
			}elseif($phase == true && $phase['student_phaselevel_id'] == 2){
				$data['phase_lavel'] = 2;
				
				$this->perPage = 6;
				if(isset($_GET['actmdl']))
				{
					$data['active_module'] = intval($_GET['actmdl']);
				}else
				{
					$data['active_module'] = $this->session->userdata('active_module');
				}
				
				$totalRec = count($this->Course_model->get_lessonsby_module(array('module_id' => $data['active_module'])));
				
				$config['target']      = '#postList';
				$config['base_url']    = base_url().'lessonfilter/get_lessons';
				$config['total_rows']  = $totalRec;
				$config['per_page']    = $this->perPage;
				$config['display_pages'] = FALSE;
				$config['first_link'] = FALSE;
				$config['last_link'] = FALSE;
				$config['anchor_class'] = 'course-lesson-link';
				
				$config['next_tag_open'] = '<span class="next-tg">';
				$config['next_tag_close'] = '</span>';
				
				$config['next_link'] = '<i class="fa fa-angle-right"></i>';
				$config['prev_link'] = '<i class="fa fa-angle-left"></i>';
				
				$config['prev_tag_open'] = '<span class="prev-tg">';
				$config['prev_tag_close'] = '</span>';
				
				$config['show_count']  = false;
				$config['link_func']   = 'getCourseLessons';
				$this->ajax_pagination->initialize($config);
				
				$data['items'] = $this->Course_model->get_lessonsby_module(array('limit'=>$this->perPage, 'module_id' => $data['active_module']));
				
				$active = $this->check_date('mrkconfig_pcatwo_exam_date', 2);
				if($active == 1 && $phase['student_phaselevel_id'] == 2)
				{
					$this->session->set_userdata(array('exam_activated' => TRUE));
					$data['pca_exam_link'] = '<div class="pca-exm-btn active-exm-bttn"><a target="_blank" href="'.base_url('student/exam/exstart/PCA-2/Phase-B/START').'">CCA - 2</a></div>';
				}else
				{
					$data['pca_exam_link'] = '<div class="pca-exm-btn"><a style="cursor:pointer">CCA - 2</a></div>';
				}
				$this->load->view('course_phase_b', $data);
			}elseif($phase == true && $phase['student_phaselevel_id'] == 3){
				$data['phase_lavel'] = 3;
				
				$this->perPage = 6;
				if(isset($_GET['actmdl']))
				{
					$data['active_module'] = intval($_GET['actmdl']);
				}else
				{
					$data['active_module'] = $this->session->userdata('active_module');
				}
				
				$totalRec = count($this->Course_model->get_lessonsby_module(array('module_id' => $data['active_module'])));
				
				$config['target']      = '#postList';
				$config['base_url']    = base_url().'lessonfilter/get_lessons';
				$config['total_rows']  = $totalRec;
				$config['per_page']    = $this->perPage;
				$config['display_pages'] = FALSE;
				$config['first_link'] = FALSE;
				$config['last_link'] = FALSE;
				$config['anchor_class'] = 'course-lesson-link';
				
				$config['next_tag_open'] = '<span class="next-tg">';
				$config['next_tag_close'] = '</span>';
				
				$config['next_link'] = '<i class="fa fa-angle-right"></i>';
				$config['prev_link'] = '<i class="fa fa-angle-left"></i>';
				
				$config['prev_tag_open'] = '<span class="prev-tg">';
				$config['prev_tag_close'] = '</span>';
				
				$config['show_count']  = false;
				$config['link_func']   = 'getCourseLessons';
				$this->ajax_pagination->initialize($config);
				
				$data['items'] = $this->Course_model->get_lessonsby_module(array('limit'=>$this->perPage, 'module_id' => $data['active_module']));
				
				$active = $this->check_date('mrkconfig_pcathree_exam_date', 3);
				if($active == 1 && $phase['student_phaselevel_id'] == 3)
				{
					$this->session->set_userdata(array('exam_activated' => TRUE));
					$data['pca_exam_link'] = '<div class="pca-exm-btn active-exm-bttn"><a target="_blank" href="'.base_url('student/exam/exstart/PCA-3/Phase-C/START').'">CCA - 3</a></div>';
				}else
				{
					$data['pca_exam_link'] = '<div class="pca-exm-btn"><a style="cursor:pointer">CCA - 3</a></div>';
				}
				$this->load->view('course_phase_c', $data);
			}elseif($ece == true && $ece['student_phaselevel_id'] == 0 && $ece['student_ece_status'] == 1){
							$data['phase_lavel'] = 4;
							
							$this->perPage = 6;
							if(isset($_GET['actmdl']))
							{
								$data['active_module'] = intval($_GET['actmdl']);
							}else
							{
								$data['active_module'] = $this->session->userdata('active_module');
							}
							
							$totalRec = count($this->Course_model->get_lessonsby_module(array('module_id' => $data['active_module'])));
							
							$config['target']      = '#postList';
							$config['base_url']    = base_url().'lessonfilter/get_lessons';
							$config['total_rows']  = $totalRec;
							$config['per_page']    = $this->perPage;
							$config['display_pages'] = FALSE;
							$config['first_link'] = FALSE;
							$config['last_link'] = FALSE;
							$config['anchor_class'] = 'course-lesson-link';
							
							$config['next_tag_open'] = '<span class="next-tg">';
							$config['next_tag_close'] = '</span>';
							
							$config['next_link'] = '<i class="fa fa-angle-right"></i>';
							$config['prev_link'] = '<i class="fa fa-angle-left"></i>';
							
							$config['prev_tag_open'] = '<span class="prev-tg">';
							$config['prev_tag_close'] = '</span>';
							
							$config['show_count']  = false;
							$config['link_func']   = 'getCourseLessons';
							$this->ajax_pagination->initialize($config);
							
							$data['items'] = $this->Course_model->get_lessonsby_module(array('limit'=>$this->perPage, 'module_id' => $data['active_module']));
							
							// $active = $this->check_date('mrkconfig_ece_exam_date', 4);
							if( $phase['student_phaselevel_id'] == 0)
							{
								$this->session->set_userdata(array('exam_activated' => TRUE));
								$data['pca_exam_link'] = '<div class="pca-exm-btn active-exm-bttn"><a target="_blank" href="'.base_url('student/exam/exstart/ECE/Phase-D/START').'">ECE</a></div>';
							}else
							{
								$data['pca_exam_link'] = '<div class="pca-exm-btn"><a target="_blank" >ECE</a></div>';
								
							}
							$this->load->view('ece_exam',$data);
						
						
						}elseif($ece == true && $ece['student_phaselevel_id'] == 0 && $ece['student_ece_status'] == 1){
				$this->load->view('ece_exam');
			}elseif($ece == true && $ece['student_phaselevel_id'] == 0 && $ece['student_ece_status'] == 0){
				$this->load->view('course_completed');
			}
		}
		
	}
	
	public function ftwof()
	{
		$this->load->view('ftwof_session');
	}
	
	public function results()
	{
		$this->load->view('results');
	}
	
	public function apply()
	{
		if(isset($_GET['type']) && $_GET['type'] === 'SDT' && $_GET['type'] !== '' && isset($_GET['to']) && $_GET['to'] !== '' && is_numeric($_GET['to'])){
			$data['type'] = 'SDT';
			$data['schdle_id'] = intval($_GET['to']);
			$data['phase_lavel'] = $this->session->userdata('active_phase');
			$this->load->view('apply', $data);
		}elseif(isset($_GET['type']) && $_GET['type'] === 'WORKSHOP' && $_GET['type'] !== '' && isset($_GET['to']) && $_GET['to'] !== '' && is_numeric($_GET['to'])){
			$data['type'] = 'WORKSHOP';
			$data['schdle_id'] = intval($_GET['to']);
			$data['phase_lavel'] = $this->session->userdata('active_phase');
			$this->load->view('apply', $data);
		}elseif(isset($_GET['type']) && $_GET['type'] === 'ECE' && $_GET['type'] !== '' && isset($_GET['to']) && $_GET['to'] !== '' && is_numeric($_GET['to'])){
			$data['type'] = 'ECE';
			$data['schdle_id'] = intval($_GET['to']);
			$data['phase_lavel'] = $this->session->userdata('active_phase');
			$this->load->view('apply', $data);
		}else
		{
			redirect('student/dashboard');
		}
	}
	
	public function contact()
	{
		$this->load->view('contact');
	}
	
	/****************************/
	/*******START DISCUSSION PART*********/
	/****************************/
	
	public function discussion()
	{
		if(isset($_GET['with']) && $_GET['with'] === 'Faculties')
		{
			$this->load->view('discussion_with_faculties');
			
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
						'ctof_user_type' => 'Student',
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
		redirect('student/login', 'refresh', true);
	}
	
}