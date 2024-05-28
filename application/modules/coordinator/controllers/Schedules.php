<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Schedules extends CI_Controller {
	
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
		
		$check_permission = $this->Perm_model->check_permissionby_admin($active_user, 8);
		if($check_permission == true){ echo null; }else{ redirect('not-found'); }
		
		$this->sqtoken = $this->security->get_csrf_token_name();
		$this->sqtoken_hash = $this->security->get_csrf_hash();
		
		$this->load->model('Schedules_model');
		$this->load->model('F2fschedule_model');
		$this->load->model('Phaseschedule_model');
		$this->load->model('Sdtschedule_model');
		$this->load->model('Workshop_model');
		$this->load->model('Eceschedule_model');
		$this->load->library('sendmaillib');
	}
	
	/************************************/
	/*********START END-MODULE EXAM SCHEDULE***********/
	/************************************/
	
	public function moduleexam()
	{
		$this->load->view('schedules/moduleexam');
	}
	
	public function create()
	{
		$this->load->library('form_validation');
		$data = array(
					'endmschedule_phase_id'      => $this->input->post('phase_id'), 
					'endmschedule_title'         => html_escape($this->input->post('exam_title')), 
					'endmschedule_from_date'     => $this->input->post('from_date'), 
					'endmschedule_to_date'       => $this->input->post('to_date'), 
					'endmschedule_status'        => html_escape($this->input->post('status')), 
					'endmschedule_created_by'    => $this->session->userdata('active_user'), 
					'endmschedule_create_date'   => date("Y-m-d H:i:s"), 
				);
		$validate = array(
						array(
							'field' => 'exam_title', 
							'label' => 'Exam Title', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->Schedules_model->create_endmodule_schedule($data);
			$data_template['display_content'] = TRUE;
			$content = $this->load->view('schedules/modules', $data_template, true);
			
		$get_students = $this->Schedules_model->get_students($this->input->post('phase_id'));
		foreach($get_students as $get_studentinfo):
		$name = $get_studentinfo['spinfo_first_name'].' '.$get_studentinfo['spinfo_middle_name'].' '.$get_studentinfo['spinfo_last_name'];
		//Send email
		$email_data['get_studentinfo'] = $get_studentinfo;
		$email_data['full_name'] = $name;
		$body = $this->load->view('schedules/email', $email_data, true);
		
		$this->sendmaillib->from('info@dldchc-badas.org.bd');
		$this->sendmaillib->to($get_studentinfo['student_email']);
		$this->sendmaillib->subject('End of module exam schedule Available');
		$this->sendmaillib->content($body);
		$this->sendmaillib->send();
		
		$phone_number = $get_studentinfo['spinfo_personal_phone'];
$message ='Dear '.$name.',
Please view your Dashboard for new notification on End Module Exam:
link : '.base_url('student/login').'
';
		sendsms($phone_number, $message);	
		endforeach;
			
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
	
	public function module()
	{
		$data['display'] = TRUE;
		$data['phase_id'] = $this->input->post('phase_id');
		$content = $this->load->view('schedules/module_create_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function edit()
	{
		$data['schedule_id'] = $this->input->post('schedule_id');
		$content = $this->load->view('schedules/module_edit_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function update()
	{
		$this->load->library('form_validation');
		$phase_id = $this->input->post('phase_id');
		$schedule_id = $this->input->post('schedule_id');
		$data = array(
					'endmschedule_phase_id'      => $phase_id, 
					'endmschedule_title'         => html_escape($this->input->post('exam_title')), 
					'endmschedule_from_date'     => $this->input->post('from_date'), 
					'endmschedule_to_date'       => $this->input->post('to_date'), 
					'endmschedule_status'        => html_escape($this->input->post('status')), 
					'endmschedule_created_by'    => $this->session->userdata('active_user'), 
					'endmschedule_create_date'   => date("Y-m-d H:i:s"), 
				);
		$validate = array(
						array(
							'field' => 'exam_title', 
							'label' => 'Exam Title', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->Schedules_model->update_endmodule_schedule($schedule_id, $data);
			$data_template['display_content'] = TRUE;
			$data_template['phase_id'] = $phase_id;
			$content = $this->load->view('schedules/modules', $data_template, true);
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
	
	public function delschedule()
	{
		$schedule_id = $this->input->post('schedule_id');
		
		//Delete from module table
		$this->db->where('endmschedule_id', $schedule_id);
		$this->db->delete('starter_endmodule_exschedule');
		
		$data['schedule_id'] = $schedule_id;
		$content = $this->load->view('schedules/module_create_form', $data, true);
		
		$result = array("status" => "ok", "content" => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	/************************************/
	/*********END END-MODULE EXAM SCHEDULE***********/
	/************************************/
	
	
	
	/************************************/
	/*********START F2F SESSION SCHEDULE***********/
	/************************************/
	
	public function ftwofsession()
	{
		$this->load->view('schedules/ftwof/ftwofsession');
	}
	
	public function ftwof_create()
	{
		$this->load->library('form_validation');
		$data = array(
					'endmschedule_phase_id'      => $this->input->post('phase_id'), 
					'endmschedule_title'         => html_escape($this->input->post('schedule_title')), 
					'endmschedule_from_date'     => $this->input->post('from_date'), 
					'endmschedule_to_date'       => $this->input->post('to_date'), 
					'endmschedule_status'        => html_escape($this->input->post('status')), 
					'endmschedule_created_by'    => $this->session->userdata('active_user'), 
					'endmschedule_create_date'   => date("Y-m-d H:i:s"), 
				);
		$validate = array(
						array(
							'field' => 'schedule_title', 
							'label' => 'Schedule Title', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->F2fschedule_model->create_schedule($data);
			$data_template['display_content'] = TRUE;
			$content = $this->load->view('schedules/ftwof/content_lists', $data_template, true);
			
		$get_students = $this->Schedules_model->get_students($this->input->post('phase_id'));
		foreach($get_students as $get_studentinfo):
		$name = $get_studentinfo['spinfo_first_name'].' '.$get_studentinfo['spinfo_middle_name'].' '.$get_studentinfo['spinfo_last_name'];
		//Send email
		$email_data['get_studentinfo'] = $get_studentinfo;
		$email_data['full_name'] = $name;
		$body = $this->load->view('schedules/ftwof/email', $email_data, true);
		
		$this->sendmaillib->from('info@dldchc-badas.org.bd');
		$this->sendmaillib->to($get_studentinfo['student_email']);
		$this->sendmaillib->subject('F2F session schedule available');
		$this->sendmaillib->content($body);
		$this->sendmaillib->send();
		
		$phone_number = $get_studentinfo['spinfo_personal_phone'];
$message ='Dear '.$name.',
Please view your Dashboard for new notification on F2F Session Schedule:
link : '.base_url('student/login').'
';
		sendsms($phone_number, $message);	
		endforeach;
			
			
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
	
	public function ftwof_schedule()
	{
		$data['display'] = TRUE;
		$data['phase_id'] = $this->input->post('phase_id');
		$content = $this->load->view('schedules/ftwof/create_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function ftwof_edit()
	{
		$data['schedule_id'] = $this->input->post('schedule_id');
		$content = $this->load->view('schedules/ftwof/edit_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function ftwof_update()
	{
		$this->load->library('form_validation');
		$phase_id = $this->input->post('phase_id');
		$schedule_id = $this->input->post('schedule_id');
		$data = array(
					'endmschedule_phase_id'      => $phase_id, 
					'endmschedule_title'         => html_escape($this->input->post('schedule_title')), 
					'endmschedule_from_date'     => $this->input->post('from_date'), 
					'endmschedule_to_date'       => $this->input->post('to_date'), 
					'endmschedule_status'        => html_escape($this->input->post('status')), 
					'endmschedule_created_by'    => $this->session->userdata('active_user'), 
					'endmschedule_create_date'   => date("Y-m-d H:i:s"), 
				);
		$validate = array(
						array(
							'field' => 'schedule_title', 
							'label' => 'Schedule Title', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->F2fschedule_model->update_schedule($schedule_id, $data);
			$data_template['display_content'] = TRUE;
			$data_template['phase_id'] = $phase_id;
			$content = $this->load->view('schedules/ftwof/content_lists', $data_template, true);
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
	
	public function ftwof_delschedule()
	{
		$schedule_id = $this->input->post('schedule_id');
		
		//Delete from module content
		$this->db->where('centerschdl_parentschdl_id', $schedule_id);
		$this->db->delete('starter_ftwo_centerschdl');
		
		//Delete from module table
		$this->db->where('endmschedule_id', $schedule_id);
		$this->db->delete('starter_ftwof_schedule');
		
		$data['schedule_id'] = $schedule_id;
		$content = $this->load->view('schedules/ftwof/create_form', $data, true);
		
		$result = array("status" => "ok", "content" => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function ftwof_lesson()
	{
		$schedule_id = $this->input->post('schedule_id');
		$data['schedule_id'] = $schedule_id;
		$content = $this->load->view('schedules/ftwof/centers', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function ftwof_createlesson()
	{
		$this->load->library('form_validation');
		$schedule_id = $this->input->post('schedule_id');
		$last_booking_time = html_escape($this->input->post('close_date')).' '.html_escape($this->input->post('close_time'));
		$data = array(
					'centerschdl_parentschdl_id'   => $schedule_id, 
					'centerschdl_center_id'        => $this->input->post('center_id'), 
					'centerschdl_to_date'          => html_escape($this->input->post('to_date')), 
					'centerschdl_to_time'          => html_escape($this->input->post('to_time')), 
					'centerschdl_maximum_sit'      => html_escape($this->input->post('max_sit')), 
					'centerschdl_last_bookingtime' => $last_booking_time, 
					'centerschdl_create_date'      => date("Y-m-d H:i:s"), 
					'centerschdl_status'           => $this->input->post('status'),
				);
		$validate = array(
						array(
							'field' => 'center_id', 
							'label' => 'Center', 
							'rules' => 'required|trim', 
						),
						array(
							'field' => 'to_date', 
							'label' => 'Date', 
							'rules' => 'required|trim', 
						),
						array(
							'field' => 'to_time', 
							'label' => 'Time', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->F2fschedule_model->create_center_schedule($data);
			$data_template['display_content'] = TRUE;
			$data_template['schedule_id'] = $schedule_id;
			$content = $this->load->view('schedules/ftwof/center_list', $data_template, true);
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
	
	public function ftwof_getlessoncreate()
	{
		$schedule_id = $this->input->post('schedule_id');
		$data['display'] = TRUE;
		$data['schedule_id'] = $schedule_id;
		$content = $this->load->view('schedules/ftwof/center_create_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function ftwof_editlesson()
	{
		$schedule_id = $this->input->post('schedule_id');
		$data['schedule_id'] = $schedule_id;
		$content = $this->load->view('schedules/ftwof/center_edit_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function ftwof_updatelesson()
	{
		$this->load->library('form_validation');
		$schedule_id = $this->input->post('schedule_id');
		$parent_schedule_id = $this->input->post('parent_schedule_id');
		$last_booking_time = html_escape($this->input->post('close_date')).' '.html_escape($this->input->post('close_time'));
		$data = array(
					'centerschdl_center_id'        => $this->input->post('center_id'), 
					'centerschdl_to_date'          => html_escape($this->input->post('to_date')), 
					'centerschdl_to_time'          => html_escape($this->input->post('to_time')), 
					'centerschdl_maximum_sit'      => html_escape($this->input->post('max_sit')), 
					'centerschdl_last_bookingtime' => $last_booking_time, 
					'centerschdl_create_date'      => date("Y-m-d H:i:s"), 
					'centerschdl_status'           => $this->input->post('status'),
				);
		$validate = array(
						array(
							'field' => 'center_id', 
							'label' => 'Center', 
							'rules' => 'required|trim', 
						),
						array(
							'field' => 'to_date', 
							'label' => 'Date', 
							'rules' => 'required|trim', 
						),
						array(
							'field' => 'to_time', 
							'label' => 'Time', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->F2fschedule_model->update_center_schedule($schedule_id, $data);
			$data_template['display_content'] = TRUE;
			$data_template['schedule_id'] = $parent_schedule_id;
			$content = $this->load->view('schedules/ftwof/center_list', $data_template, true);
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
	
	public function ftwof_dellesson()
	{
		$schedule_id = $this->input->post('schedule_id');
		$parent_schedule_id = $this->input->post('parent_schedule_id');
		//Delete from module table
		$this->db->where('centerschdl_id', $schedule_id);
		$this->db->delete('starter_ftwo_centerschdl');
		
		$retrive_button = '
						    <div class="generate-buttons text-right display-crtbtn">
								<button class="btn btn-purple m-b-5 return-create-lesson" data-schedule="'.$parent_schedule_id.'" type="button">Create New Schedule</button>
								<button class="btn btn-purple m-b-5 back-to-modules" type="button">Back To Schedules</button>
							</div>
						  ';
		$result = array("status" => "ok", "retrive_button" => $retrive_button);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function ftwof_backtoschedules()
	{
		$data['display'] = TRUE;
		$content = $this->load->view('schedules/ftwof/contents', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	/************************************/
	/*********END F2F SESSION SCHEDULE***********/
	/************************************/
	
	
	/************************************/
	/*********START PHASE EXAM SCHEDULE***********/
	/************************************/
	
	public function phaseexam()
	{
		$this->load->view('schedules/phase/phaseexam');
	}
	
	public function phase_create()
	{
		$this->load->library('form_validation');
		$data = array(
					'endmschedule_phase_id'      => $this->input->post('phase_id'), 
					'endmschedule_title'         => html_escape($this->input->post('schedule_title')), 
					'endmschedule_exam_type'     => $this->input->post('exam_type'), 
					'endmschedule_from_date'     => $this->input->post('from_date'), 
					'endmschedule_to_date'       => $this->input->post('to_date'), 
					'endmschedule_status'        => html_escape($this->input->post('status')), 
					'endmschedule_created_by'    => $this->session->userdata('active_user'), 
					'endmschedule_create_date'   => date("Y-m-d H:i:s"), 
				);
		$validate = array(
						array(
							'field' => 'schedule_title', 
							'label' => 'Schedule Title', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->Phaseschedule_model->create_schedule($data);
			$data_template['display_content'] = TRUE;
			$content = $this->load->view('schedules/phase/content_lists', $data_template, true);
			
		$get_students = $this->Schedules_model->get_students($this->input->post('phase_id'));
		foreach($get_students as $get_studentinfo):
		$name = $get_studentinfo['spinfo_first_name'].' '.$get_studentinfo['spinfo_middle_name'].' '.$get_studentinfo['spinfo_last_name'];
		//Send email
		$email_data['get_studentinfo'] = $get_studentinfo;
		$email_data['full_name'] = $name;
		$body = $this->load->view('schedules/phase/email', $email_data, true);
		
		$this->sendmaillib->from('info@dldchc-badas.org.bd');
		$this->sendmaillib->to($get_studentinfo['student_email']);
		$this->sendmaillib->subject('Phase exam schedule available');
		$this->sendmaillib->content($body);
		$this->sendmaillib->send();
		
		$phone_number = $get_studentinfo['spinfo_personal_phone'];
$message ='Dear '.$name.',
Please view your Dashboard for new notification on Phase Exam Schedule:
link : '.base_url('student/login').'
';
		sendsms($phone_number, $message);	
		endforeach;
			
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
	
	public function phase_schedule()
	{
		$data['display'] = TRUE;
		$data['phase_id'] = $this->input->post('phase_id');
		$content = $this->load->view('schedules/phase/create_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function phase_edit()
	{
		$data['schedule_id'] = $this->input->post('schedule_id');
		$content = $this->load->view('schedules/phase/edit_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function phase_update()
	{
		$this->load->library('form_validation');
		$phase_id = $this->input->post('phase_id');
		$schedule_id = $this->input->post('schedule_id');
		$data = array(
					'endmschedule_phase_id'      => $phase_id, 
					'endmschedule_title'         => html_escape($this->input->post('schedule_title')), 
					'endmschedule_exam_type'     => $this->input->post('exam_type'),
					'endmschedule_from_date'     => $this->input->post('from_date'), 
					'endmschedule_to_date'       => $this->input->post('to_date'), 
					'endmschedule_status'        => html_escape($this->input->post('status')), 
					'endmschedule_created_by'    => $this->session->userdata('active_user'), 
					'endmschedule_create_date'   => date("Y-m-d H:i:s"), 
				);
		$validate = array(
						array(
							'field' => 'schedule_title', 
							'label' => 'Schedule Title', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->Phaseschedule_model->update_schedule($schedule_id, $data);
			$data_template['display_content'] = TRUE;
			$data_template['phase_id'] = $phase_id;
			$content = $this->load->view('schedules/phase/content_lists', $data_template, true);
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
	
	public function phase_delschedule()
	{
		$schedule_id = $this->input->post('schedule_id');
		
		//Delete from module content
		$this->db->where('centerschdl_parentschdl_id', $schedule_id);
		$this->db->delete('starter_phase_centerschdl');
		
		//Delete from module table
		$this->db->where('endmschedule_id', $schedule_id);
		$this->db->delete('starter_phase_exschedule');
		
		$data['schedule_id'] = $schedule_id;
		$content = $this->load->view('schedules/phase/create_form', $data, true);
		
		$result = array("status" => "ok", "content" => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function phase_lesson()
	{
		$schedule_id = $this->input->post('schedule_id');
		$data['schedule_id'] = $schedule_id;
		$content = $this->load->view('schedules/phase/centers', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function phase_createlesson()
	{
		$this->load->library('form_validation');
		$schedule_id = $this->input->post('schedule_id');
		$last_booking_time = html_escape($this->input->post('close_date')).' '.html_escape($this->input->post('close_time'));
		$data = array(
					'centerschdl_parentschdl_id'   => $schedule_id, 
					'centerschdl_center_id'        => $this->input->post('center_id'), 
					'centerschdl_to_date'          => html_escape($this->input->post('to_date')), 
					'centerschdl_to_time'          => html_escape($this->input->post('to_time')), 
					'centerschdl_maximum_sit'      => html_escape($this->input->post('max_sit')), 
					'centerschdl_last_bookingtime' => $last_booking_time, 
					'centerschdl_create_date'      => date("Y-m-d H:i:s"), 
					'centerschdl_status'           => $this->input->post('status'),
				);
		$validate = array(
						array(
							'field' => 'center_id', 
							'label' => 'Center', 
							'rules' => 'required|trim', 
						),
						array(
							'field' => 'to_date', 
							'label' => 'Date', 
							'rules' => 'required|trim', 
						),
						array(
							'field' => 'to_time', 
							'label' => 'Time', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->Phaseschedule_model->create_center_schedule($data);
			$data_template['display_content'] = TRUE;
			$data_template['schedule_id'] = $schedule_id;
			$content = $this->load->view('schedules/phase/center_list', $data_template, true);
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
	
	public function phase_getlessoncreate()
	{
		$schedule_id = $this->input->post('schedule_id');
		$data['display'] = TRUE;
		$data['schedule_id'] = $schedule_id;
		$content = $this->load->view('schedules/phase/center_create_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function phase_editlesson()
	{
		$schedule_id = $this->input->post('schedule_id');
		$data['schedule_id'] = $schedule_id;
		$content = $this->load->view('schedules/phase/center_edit_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function phase_updatelesson()
	{
		$this->load->library('form_validation');
		$schedule_id = $this->input->post('schedule_id');
		$parent_schedule_id = $this->input->post('parent_schedule_id');
		$last_booking_time = html_escape($this->input->post('close_date')).' '.html_escape($this->input->post('close_time'));
		$data = array(
					'centerschdl_center_id'        => $this->input->post('center_id'), 
					'centerschdl_to_date'          => html_escape($this->input->post('to_date')), 
					'centerschdl_to_time'          => html_escape($this->input->post('to_time')), 
					'centerschdl_maximum_sit'      => html_escape($this->input->post('max_sit')), 
					'centerschdl_last_bookingtime' => $last_booking_time, 
					'centerschdl_create_date'      => date("Y-m-d H:i:s"), 
					'centerschdl_status'           => $this->input->post('status'),
				);
		$validate = array(
						array(
							'field' => 'center_id', 
							'label' => 'Center', 
							'rules' => 'required|trim', 
						),
						array(
							'field' => 'to_date', 
							'label' => 'Date', 
							'rules' => 'required|trim', 
						),
						array(
							'field' => 'to_time', 
							'label' => 'Time', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->Phaseschedule_model->update_center_schedule($schedule_id, $data);
			$data_template['display_content'] = TRUE;
			$data_template['schedule_id'] = $parent_schedule_id;
			$content = $this->load->view('schedules/phase/center_list', $data_template, true);
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
	
	public function phase_dellesson()
	{
		$schedule_id = $this->input->post('schedule_id');
		$parent_schedule_id = $this->input->post('parent_schedule_id');
		//Delete from module table
		$this->db->where('centerschdl_id', $schedule_id);
		$this->db->delete('starter_phase_centerschdl');
		
		$retrive_button = '
						    <div class="generate-buttons text-right display-crtbtn">
								<button class="btn btn-purple m-b-5 return-create-lesson" data-schedule="'.$parent_schedule_id.'" type="button">Create New Schedule</button>
								<button class="btn btn-purple m-b-5 back-to-modules" type="button">Back To Schedules</button>
							</div>
						  ';
		$result = array("status" => "ok", "retrive_button" => $retrive_button);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function phase_backtoschedules()
	{
		$data['display'] = TRUE;
		$content = $this->load->view('schedules/phase/contents', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	/************************************/
	/*********END PHASE EXAM SCHEDULE***********/
	/************************************/
	
	
	/************************************/
	/*********START SDT SCHEDULE*********/
	/************************************/
	
	public function sdt()
	{
		if(isset($_GET['type']) && is_numeric($_GET['type']))
		{
			$data['sdt_type'] = $_GET['type'];
			$this->load->view('schedules/sdt/sdt', $data);
		}else{
			redirect('coordinator');
		}
	}
	
	public function sdt_create()
	{
		$this->load->library('form_validation');
		$data = array(
					'endmschedule_phase_id'      => $this->input->post('phase_id'), 
					'endmschedule_title'         => html_escape($this->input->post('schedule_title')), 
					'endmschedule_from_date'     => $this->input->post('from_date'), 
					'endmschedule_to_date'       => $this->input->post('to_date'), 
					'endmschedule_sdt_type'      => html_escape($this->input->post('sdt_type')), 
					'endmschedule_status'        => html_escape($this->input->post('status')), 
					'endmschedule_created_by'    => $this->session->userdata('active_user'), 
					'endmschedule_create_date'   => date("Y-m-d H:i:s"), 
				);
		$validate = array(
						array(
							'field' => 'schedule_title', 
							'label' => 'Schedule Title', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		
		$this->load->library('upload');
	    $config['upload_path']          = 'attachments/resources/sdt/';
	    $config['allowed_types']        = 'pdf|doc';
	    $config['detect_mime']          = TRUE;
	    $config['remove_spaces']        = TRUE;
	    $config['encrypt_name']         = TRUE;
	    $config['max_size']             = '0';
	    $this->upload->initialize($config);
		if (!$this->upload->do_upload('students_resource')){
		  $upload_error = $this->upload->display_errors();
	    }else{
			$fileData = $this->upload->data();
			$data['endmschedule_student_resource'] = $fileData['file_name'];
		}
		
		$config['upload_path']          = 'attachments/resources/sdt/';
	    $config['allowed_types']        = 'pdf|doc';
	    $config['detect_mime']          = TRUE;
	    $config['remove_spaces']        = TRUE;
	    $config['encrypt_name']         = TRUE;
	    $config['max_size']             = '0';
	    $this->upload->initialize($config);
		if (!$this->upload->do_upload('faculties_resource')){
		  $upload_error = $this->upload->display_errors();
	    }else{
			$fileData = $this->upload->data();
			$data['endmschedule_faculty_resource'] = $fileData['file_name'];
		}
		
		if($this->form_validation->run() == true)
		{
			//save
			$inschedule = $this->Sdtschedule_model->create_schedule($data);
			
			$schedule_id = $this->db->insert_id($inschedule);
			
			//save notification
			$notification_data = array(
									'notif_schedule_id'   => $schedule_id,
									'notif_schedule_type' => 'SDT',
									'notif_content'       => 'SDT '.$data['endmschedule_sdt_type'].' schedule is now available for you. Please go to apply or view book to join at SDT.',
									'notif_phase_level'   => $this->input->post('phase_id'),
									'notif_create_date'   => date("Y-m-d H:i:s"),
								);
			$this->Schedules_model->save_notification($notification_data);
			
			$data_template['display_content'] = TRUE;
			$data_template['sdt_type'] = $data['endmschedule_sdt_type'];
			$content = $this->load->view('schedules/sdt/content_lists', $data_template, true);
			
		$get_students = $this->Schedules_model->get_students($this->input->post('phase_id'));
		foreach($get_students as $get_studentinfo):
		$name = $get_studentinfo['spinfo_first_name'].' '.$get_studentinfo['spinfo_middle_name'].' '.$get_studentinfo['spinfo_last_name'];
		//Send email
		if($_SERVER['HTTP_HOST']=='education.dldchc-badas.org.bd')
		{
		$email_data['get_studentinfo'] = $get_studentinfo;
		$email_data['full_name'] = $name;
		$body = $this->load->view('schedules/sdt/email', $email_data, true);
		
		$this->sendmaillib->from('info@dldchc-badas.org.bd');
		$this->sendmaillib->to($get_studentinfo['student_email']);
		$this->sendmaillib->subject('SDT '.$data['endmschedule_sdt_type'].' schedule available');
		$this->sendmaillib->content($body);
		$this->sendmaillib->send();
	
		$phone_number = $get_studentinfo['spinfo_personal_phone'];
$message ='Dear '.$name.',
Please view your Dashboard for new notification on SDT '.$data['endmschedule_sdt_type'].' Session Schedule:
link : '.base_url('student/login').'
';
		sendsms($phone_number, $message);
		}
	
		endforeach;
			
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
	
	public function sdt_schedule()
	{
		$data['display'] = TRUE;
		$data['phase_id'] = $this->input->post('phase_id');
		$content = $this->load->view('schedules/sdt/create_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function sdt_edit()
	{
		$data['schedule_id'] = $this->input->post('schedule_id');
		$content = $this->load->view('schedules/sdt/edit_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function sdt_update()
	{
		$this->load->library('form_validation');
		$phase_id = $this->input->post('phase_id');
		$schedule_id = $this->input->post('schedule_id');
		$data = array(
					'endmschedule_phase_id'      => $phase_id, 
					'endmschedule_title'         => html_escape($this->input->post('schedule_title')), 
					'endmschedule_from_date'     => $this->input->post('from_date'), 
					'endmschedule_to_date'       => $this->input->post('to_date'), 
					'endmschedule_status'        => html_escape($this->input->post('status')), 
					'endmschedule_created_by'    => $this->session->userdata('active_user'), 
					'endmschedule_create_date'   => date("Y-m-d H:i:s"), 
				);
		$validate = array(
						array(
							'field' => 'schedule_title', 
							'label' => 'Schedule Title', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		
		$this->load->library('upload');
		$config['upload_path']          = 'attachments/resources/sdt/';
		$config['allowed_types']        = 'pdf|doc';
		$config['detect_mime']          = TRUE;
		$config['remove_spaces']        = TRUE;
		$config['encrypt_name']         = TRUE;
		$config['max_size']             = '0';
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('students_resource')){
		  $upload_error = $this->upload->display_errors();
		}else{
			$exist_image = $this->Sdtschedule_model->get_schedule_info($schedule_id);
			if(!empty($exist_image['endmschedule_student_resource']) && $exist_image['endmschedule_student_resource'] !== NULL){
				$file_name = attachment_dir("resources/sdt/".$exist_image['endmschedule_student_resource']);
				if(file_exists($file_name)){
					unlink($file_name);
				}else{
					echo null;
				}
			}else{
				echo null;
			}
			$fileData = $this->upload->data();
			$data['endmschedule_student_resource'] = $fileData['file_name'];
		}

		/*=====================================*/

		$config['upload_path']          = 'attachments/resources/sdt/';
		$config['allowed_types']        = 'pdf|doc';
		$config['detect_mime']          = TRUE;
		$config['remove_spaces']        = TRUE;
		$config['encrypt_name']         = TRUE;
		$config['max_size']             = '0';
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('faculties_resource')){
		  $upload_error = $this->upload->display_errors();
		}else{
			$exist_image = $this->Sdtschedule_model->get_schedule_info($schedule_id);
			if(!empty($exist_image['endmschedule_faculty_resource']) && $exist_image['endmschedule_faculty_resource'] !== NULL){
				$file_name = attachment_dir("resources/sdt/".$exist_image['endmschedule_faculty_resource']);
				if(file_exists($file_name)){
					unlink($file_name);
				}else{
					echo null;
				}
			}else{
				echo null;
			}
			$fileData = $this->upload->data();
			$data['endmschedule_faculty_resource'] = $fileData['file_name'];
		}
		
		if($this->form_validation->run() == true)
		{
			//save
			$this->Sdtschedule_model->update_schedule($schedule_id, $data);
			$data_template['display_content'] = TRUE;
			$data_template['phase_id'] = $phase_id;
			$data_template['sdt_type'] = $this->input->post('sdt_type');
			$content = $this->load->view('schedules/sdt/content_lists', $data_template, true);
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
	
	public function sdt_delete_student_resource()
	{
		$endmschedule_id = $this->input->post('endmschedule_id');
		$exist_image = $this->Sdtschedule_model->get_schedule_info($endmschedule_id);
		if(!empty($exist_image['endmschedule_student_resource']) && $exist_image['endmschedule_student_resource'] !== NULL){
			$file_name = attachment_dir("resources/sdt/".$exist_image['endmschedule_student_resource']);
			if(file_exists($file_name)){
				unlink($file_name);
			}else{
				echo null;
			}
		}else{
			echo null;
		}
		
		//Update SDT schedule table
		$updated_data = array(
							'endmschedule_student_resource' => null,
						);
		$this->db->where('endmschedule_id', $endmschedule_id);
		$this->db->update('starter_sdt_schedule', $updated_data);
		
		$result = array('status' => 'ok');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
		
	}
	public function sdt_delete_faculty_resource()
	{
		$endmschedule_id = $this->input->post('endmschedule_id');
		$exist_image = $this->Sdtschedule_model->get_schedule_info($endmschedule_id);
		if(!empty($exist_image['endmschedule_faculty_resource']) && $exist_image['endmschedule_faculty_resource'] !== NULL){
			$file_name = attachment_dir("resources/sdt/".$exist_image['endmschedule_faculty_resource']);
			if(file_exists($file_name)){
				unlink($file_name);
			}else{
				echo null;
			}
		}else{
			echo null;
		}
		
		//Update SDT schedule table
		$updated_data = array(
							'endmschedule_faculty_resource' => null,
						);
		$this->db->where('endmschedule_id', $endmschedule_id);
		$this->db->update('starter_sdt_schedule', $updated_data);
		
		$result = array('status' => 'ok');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function sdt_delschedule()
	{
		$schedule_id = $this->input->post('schedule_id');
		
		//Delete from module content
		$this->db->where('centerschdl_parentschdl_id', $schedule_id);
		$this->db->delete('starter_sdt_centerschdl');
		
		//Delete from module table
		$this->db->where('endmschedule_id', $schedule_id);
		$this->db->delete('starter_sdt_schedule');
		
		$data['schedule_id'] = $schedule_id;
		$content = $this->load->view('schedules/sdt/create_form', $data, true);
		
		$result = array("status" => "ok", "content" => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function sdt_lesson()
	{
		$schedule_id = $this->input->post('schedule_id');
		$data['schedule_id'] = $schedule_id;
		$content = $this->load->view('schedules/sdt/centers', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function sdt_createlesson()
	{
		$this->load->library('form_validation');
		$schedule_id = $this->input->post('schedule_id');
		$last_booking_time = html_escape($this->input->post('close_date')).' '.html_escape($this->input->post('close_time'));
		
		$schedule_range = $this->Schedules_model->get_schedule_range($schedule_id, 'SDT');
		
		$selected_date = strtotime($this->input->post('to_date'));
		$schedule_to_date = strtotime($schedule_range['endmschedule_to_date']);
		$schedule_from_date = strtotime($schedule_range['endmschedule_from_date']);
		
		if($schedule_to_date < strtotime(date('Y-m-d'))){
			$error = '<div class="alert alert-danger">Sorry : The schedule date is over!</div>';
			$result = array('status' => 'error', 'error' => $error);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}elseif($selected_date > $schedule_to_date || $selected_date < $schedule_from_date)
		{
			$error = '<div class="alert alert-danger">Note : Please select date within '.booking_schedule_range($schedule_id, 'SDT').'</div>';
			$result = array('status' => 'error', 'error' => $error);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
		
		$schedule_serial_no = $this->Sdtschedule_model->get_total_sdt_centerschedule();
		$counter_digit = str_pad($schedule_serial_no, 6, '0', STR_PAD_LEFT);
		$schedule_title = $this->Sdtschedule_model->get_sdt_schedule_title($schedule_id);
		$schedule_title = str_replace(' ', '', $schedule_title);
		$schedule_title = str_replace('T', '', $schedule_title);
		$sdt_centerscheduleID = $schedule_title.'BD'.$counter_digit;
		
		$data = array(
					'centerschdl_entryid'          => $sdt_centerscheduleID, 
					'centerschdl_parentschdl_id'   => $schedule_id, 
					'centerschdl_center_id'        => $this->input->post('center_id'), 
					'centerschdl_to_date'          => html_escape($this->input->post('to_date')), 
					'centerschdl_to_time'          => html_escape($this->input->post('to_time')), 
					'centerschdl_maximum_sit'      => html_escape($this->input->post('max_sit')), 
					'centerschdl_last_bookingtime' => $last_booking_time, 
					'centerschdl_create_date'      => date("Y-m-d H:i:s"), 
					'centerschdl_status'           => $this->input->post('status'),
				);
		$validate = array(
						array(
							'field' => 'center_id', 
							'label' => 'Center', 
							'rules' => 'required|trim', 
						),
						array(
							'field' => 'to_date', 
							'label' => 'Date', 
							'rules' => 'required|trim', 
						),
						array(
							'field' => 'to_time', 
							'label' => 'Time', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->Sdtschedule_model->create_center_schedule($data);
			$data_template['display_content'] = TRUE;
			$data_template['schedule_id'] = $schedule_id;
			$content = $this->load->view('schedules/sdt/center_list', $data_template, true);
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
	
	public function sdt_getlessoncreate()
	{
		$schedule_id = $this->input->post('schedule_id');
		$data['display'] = TRUE;
		$data['schedule_id'] = $schedule_id;
		$content = $this->load->view('schedules/sdt/center_create_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function sdt_editlesson()
	{
		$schedule_id = $this->input->post('schedule_id');
		$data['schedule_id'] = $schedule_id;
		$content = $this->load->view('schedules/sdt/center_edit_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function sdt_updatelesson()
	{
		$this->load->library('form_validation');
		$schedule_id = $this->input->post('schedule_id');
		$parent_schedule_id = $this->input->post('parent_schedule_id');
		$last_booking_time = html_escape($this->input->post('close_date')).' '.html_escape($this->input->post('close_time'));
		
		$schedule_range = $this->Schedules_model->get_schedule_range($schedule_id, 'SDT');
		
		$selected_date = strtotime($this->input->post('to_date'));
		$schedule_to_date = strtotime($schedule_range['endmschedule_to_date']);
		$schedule_from_date = strtotime($schedule_range['endmschedule_from_date']);
		
		if($schedule_to_date < strtotime(date('Y-m-d'))){
			$error = '<div class="alert alert-danger">Sorry : The schedule date is over!</div>';
			$result = array('status' => 'error', 'error' => $error);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}elseif($selected_date > $schedule_to_date || $selected_date < $schedule_from_date)
		{
			$error = '<div class="alert alert-danger">Note : Please select date within '.booking_schedule_range($schedule_id, 'SDT').'</div>';
			$result = array('status' => 'error', 'error' => $error);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
		
		$data = array(
					'centerschdl_center_id'        => $this->input->post('center_id'), 
					'centerschdl_to_date'          => html_escape($this->input->post('to_date')), 
					'centerschdl_to_time'          => html_escape($this->input->post('to_time')), 
					'centerschdl_maximum_sit'      => html_escape($this->input->post('max_sit')), 
					'centerschdl_last_bookingtime' => $last_booking_time, 
					'centerschdl_create_date'      => date("Y-m-d H:i:s"), 
					'centerschdl_status'           => $this->input->post('status'),
				);
		$validate = array(
						array(
							'field' => 'center_id', 
							'label' => 'Center', 
							'rules' => 'required|trim', 
						),
						array(
							'field' => 'to_date', 
							'label' => 'Date', 
							'rules' => 'required|trim', 
						),
						array(
							'field' => 'to_time', 
							'label' => 'Time', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->Sdtschedule_model->update_center_schedule($schedule_id, $data);
			$data_template['display_content'] = TRUE;
			$data_template['schedule_id'] = $parent_schedule_id;
			$content = $this->load->view('schedules/sdt/center_list', $data_template, true);
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
	
	public function sdt_dellesson()
	{
		$schedule_id = $this->input->post('schedule_id');
		$parent_schedule_id = $this->input->post('parent_schedule_id');
		//Delete from module table
		$this->db->where('centerschdl_id', $schedule_id);
		$this->db->delete('starter_sdt_centerschdl');
		
		$retrive_button = '
						    <div class="generate-buttons text-right display-crtbtn">
								<button class="btn btn-purple m-b-5 return-create-lesson" data-schedule="'.$parent_schedule_id.'" type="button">Create New Schedule</button>
								<button class="btn btn-purple m-b-5 back-to-modules" type="button">Back To Schedules</button>
							</div>
						  ';
		$result = array("status" => "ok", "retrive_button" => $retrive_button);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function sdt_backtoschedules()
	{
		$data['display'] = TRUE;
		$content = $this->load->view('schedules/sdt/contents', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	/************************************/
	/*********END SDT SCHEDULE***********/
	/************************************/
	
	
	
	/************************************/
	/*********START WORKSHOP SCHEDULE***********/
	/************************************/
	
	public function workshop()
	{
		$this->load->view('schedules/workshop/workshop');
	}
	
	public function workshop_create()
	{
		$this->load->library('form_validation');
		$data = array(
					'endmschedule_phase_id'      => $this->input->post('phase_id'), 
					'endmschedule_title'         => html_escape($this->input->post('schedule_title')), 
					'endmschedule_from_date'     => $this->input->post('from_date'), 
					'endmschedule_to_date'       => $this->input->post('to_date'), 
					'endmschedule_status'        => html_escape($this->input->post('status')), 
					'endmschedule_created_by'    => $this->session->userdata('active_user'), 
					'endmschedule_create_date'   => date("Y-m-d H:i:s"), 
				);
		$validate = array(
						array(
							'field' => 'schedule_title', 
							'label' => 'Schedule Title', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		
		$this->load->library('upload');
		$config['upload_path']          = 'attachments/resources/workshop/';
		$config['allowed_types']        = 'pdf|doc';
		$config['detect_mime']          = TRUE;
		$config['remove_spaces']        = TRUE;
		$config['encrypt_name']         = TRUE;
		$config['max_size']             = '0';
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('students_resource')){
		  $upload_error = $this->upload->display_errors();
		}else{
			$fileData = $this->upload->data();
			$data['endmschedule_student_resource'] = $fileData['file_name'];
		}

		/*=====================================*/

		$config['upload_path']          = 'attachments/resources/workshop/';
		$config['allowed_types']        = 'pdf|doc';
		$config['detect_mime']          = TRUE;
		$config['remove_spaces']        = TRUE;
		$config['encrypt_name']         = TRUE;
		$config['max_size']             = '0';
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('faculties_resource')){
		  $upload_error = $this->upload->display_errors();
		}else{
			$fileData = $this->upload->data();
			$data['endmschedule_faculty_resource'] = $fileData['file_name'];
		}
		
		if($this->form_validation->run() == true)
		{
			//save
			$inschedule = $this->Workshop_model->create_schedule($data);
			$schedule_id = $this->db->insert_id($inschedule);
			
			//save notification
			$notification_data = array(
									'notif_schedule_id'   => $schedule_id,
									'notif_schedule_type' => 'WORKSHOP',
									'notif_content'       => 'WORKSHOP schedule is now available for you. Please go to apply or view book to join at WORKSHOP.',
									'notif_phase_level'   => $this->input->post('phase_id'),
									'notif_create_date'   => date("Y-m-d H:i:s"),
								);
			$this->Schedules_model->save_notification($notification_data);
			
			$data_template['display_content'] = TRUE;
			$content = $this->load->view('schedules/workshop/content_lists', $data_template, true);
			
		$get_students = $this->Schedules_model->get_students($this->input->post('phase_id'));
		foreach($get_students as $get_studentinfo):
		$name = $get_studentinfo['spinfo_first_name'].' '.$get_studentinfo['spinfo_middle_name'].' '.$get_studentinfo['spinfo_last_name'];
		//Send email
		if($_SERVER['HTTP_HOST']=='education.dldchc-badas.org.bd')
		{
		$email_data['get_studentinfo'] = $get_studentinfo;
		$email_data['full_name'] = $name;
		$body = $this->load->view('schedules/workshop/email', $email_data, true);
		
		$this->sendmaillib->from('info@dldchc-badas.org.bd');
		$this->sendmaillib->to($get_studentinfo['student_email']);
		$this->sendmaillib->subject('Workshop schedule available');
		$this->sendmaillib->content($body);
		$this->sendmaillib->send();
		
		$phone_number = $get_studentinfo['spinfo_personal_phone'];
$message ='Dear '.$name.',
Please view your Dashboard for new notification on Workshop Schedule:
link : '.base_url('student/login').'
';
		sendsms($phone_number, $message);	
		}
		endforeach;
			
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
	
	public function workshop_schedule()
	{
		$data['display'] = TRUE;
		$data['phase_id'] = $this->input->post('phase_id');
		$content = $this->load->view('schedules/workshop/create_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function workshop_edit()
	{
		$data['schedule_id'] = $this->input->post('schedule_id');
		$content = $this->load->view('schedules/workshop/edit_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function workshop_update()
	{
		$this->load->library('form_validation');
		$phase_id = $this->input->post('phase_id');
		$schedule_id = $this->input->post('schedule_id');
		$data = array(
					'endmschedule_phase_id'      => $phase_id, 
					'endmschedule_title'         => html_escape($this->input->post('schedule_title')), 
					'endmschedule_from_date'     => $this->input->post('from_date'), 
					'endmschedule_to_date'       => $this->input->post('to_date'), 
					'endmschedule_status'        => html_escape($this->input->post('status')), 
					'endmschedule_created_by'    => $this->session->userdata('active_user'), 
					'endmschedule_create_date'   => date("Y-m-d H:i:s"), 
				);
		$validate = array(
						array(
							'field' => 'schedule_title', 
							'label' => 'Schedule Title', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		
		$this->load->library('upload');
		$config['upload_path']          = 'attachments/resources/workshop/';
		$config['allowed_types']        = 'pdf|doc';
		$config['detect_mime']          = TRUE;
		$config['remove_spaces']        = TRUE;
		$config['encrypt_name']         = TRUE;
		$config['max_size']             = '0';
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('students_resource')){
		  $upload_error = $this->upload->display_errors();
		}else{
			$exist_image = $this->Workshop_model->get_schedule_info($schedule_id);
			if(!empty($exist_image['endmschedule_student_resource']) && $exist_image['endmschedule_student_resource'] !== NULL){
				$file_name = attachment_dir("resources/workshop/".$exist_image['endmschedule_student_resource']);
				if(file_exists($file_name)){
					unlink($file_name);
				}else{
					echo null;
				}
			}else{
				echo null;
			}
			$fileData = $this->upload->data();
			$data['endmschedule_student_resource'] = $fileData['file_name'];
		}

		/*=====================================*/

		$config['upload_path']          = 'attachments/resources/workshop/';
		$config['allowed_types']        = 'pdf|doc';
		$config['detect_mime']          = TRUE;
		$config['remove_spaces']        = TRUE;
		$config['encrypt_name']         = TRUE;
		$config['max_size']             = '0';
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('faculties_resource')){
		  $upload_error = $this->upload->display_errors();
		}else{
			$exist_image = $this->Workshop_model->get_schedule_info($schedule_id);
			if(!empty($exist_image['endmschedule_faculty_resource']) && $exist_image['endmschedule_faculty_resource'] !== NULL){
				$file_name = attachment_dir("resources/workshop/".$exist_image['endmschedule_faculty_resource']);
				if(file_exists($file_name)){
					unlink($file_name);
				}else{
					echo null;
				}
			}else{
				echo null;
			}
			$fileData = $this->upload->data();
			$data['endmschedule_faculty_resource'] = $fileData['file_name'];
		}
		
		if($this->form_validation->run() == true)
		{
			//save
			$this->Workshop_model->update_schedule($schedule_id, $data);
			$data_template['display_content'] = TRUE;
			$data_template['phase_id'] = $phase_id;
			$content = $this->load->view('schedules/workshop/content_lists', $data_template, true);
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
	
	public function workshop_delete_student_resource()
	{
		$endmschedule_id = $this->input->post('endmschedule_id');
		$exist_image = $this->Workshop_model->get_schedule_info($endmschedule_id);
		if(!empty($exist_image['endmschedule_student_resource']) && $exist_image['endmschedule_student_resource'] !== NULL){
			$file_name = attachment_dir("resources/workshop/".$exist_image['endmschedule_student_resource']);
			if(file_exists($file_name)){
				unlink($file_name);
			}else{
				echo null;
			}
		}else{
			echo null;
		}
		
		//Update SDT schedule table
		$updated_data = array(
							'endmschedule_student_resource' => null,
						);
		$this->db->where('endmschedule_id', $endmschedule_id);
		$this->db->update('starter_workshop_schedule', $updated_data);
		
		$result = array('status' => 'ok');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	public function workshop_delete_faculty_resource()
	{
		$endmschedule_id = $this->input->post('endmschedule_id');
		$exist_image = $this->Workshop_model->get_schedule_info($endmschedule_id);
		if(!empty($exist_image['endmschedule_faculty_resource']) && $exist_image['endmschedule_faculty_resource'] !== NULL){
			$file_name = attachment_dir("resources/workshop/".$exist_image['endmschedule_faculty_resource']);
			if(file_exists($file_name)){
				unlink($file_name);
			}else{
				echo null;
			}
		}else{
			echo null;
		}
		
		//Update SDT schedule table
		$updated_data = array(
							'endmschedule_faculty_resource' => null,
						);
		$this->db->where('endmschedule_id', $endmschedule_id);
		$this->db->update('starter_workshop_schedule', $updated_data);
		
		$result = array('status' => 'ok');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function workshop_delschedule()
	{
		$schedule_id = $this->input->post('schedule_id');
		
		//Delete from module content
		$this->db->where('centerschdl_parentschdl_id', $schedule_id);
		$this->db->delete('starter_workshop_centerschdl');
		
		//Delete from module table
		$this->db->where('endmschedule_id', $schedule_id);
		$this->db->delete('starter_workshop_schedule');
		
		$data['schedule_id'] = $schedule_id;
		$content = $this->load->view('schedules/workshop/create_form', $data, true);
		
		$result = array("status" => "ok", "content" => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function workshop_lesson()
	{
		$schedule_id = $this->input->post('schedule_id');
		$data['schedule_id'] = $schedule_id;
		$content = $this->load->view('schedules/workshop/centers', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function workshop_createlesson()
	{
		$this->load->library('form_validation');
		$schedule_id = $this->input->post('schedule_id');
		$last_booking_time = html_escape($this->input->post('close_date')).' '.html_escape($this->input->post('close_time'));
		
		$schedule_range = $this->Schedules_model->get_schedule_range($schedule_id, 'WORKSHOP');
		
		$selected_date = strtotime($this->input->post('to_date'));
		$schedule_to_date = strtotime($schedule_range['endmschedule_to_date']);
		$schedule_from_date = strtotime($schedule_range['endmschedule_from_date']);
		
		if($schedule_to_date < strtotime(date('Y-m-d'))){
			$error = '<div class="alert alert-danger">Sorry : The schedule date is over!</div>';
			$result = array('status' => 'error', 'error' => $error);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}elseif($selected_date > $schedule_to_date || $selected_date < $schedule_from_date)
		{
			$error = '<div class="alert alert-danger">Note : Please select date within '.booking_schedule_range($schedule_id, 'WORKSHOP').'</div>';
			$result = array('status' => 'error', 'error' => $error);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
		$schedule_serial_no = $this->Workshop_model->get_total_workshop_centerschedule();
		$counter_digit = str_pad($schedule_serial_no, 6, '0', STR_PAD_LEFT);
		$workshop_centerscheduleID = 'WORBD'.$counter_digit;
		
		$data = array(
					'centerschdl_entryid'          => $workshop_centerscheduleID, 
					'centerschdl_parentschdl_id'   => $schedule_id, 
					'centerschdl_center_id'        => $this->input->post('center_id'), 
					'centerschdl_to_date'          => html_escape($this->input->post('to_date')), 
					'centerschdl_to_time'          => html_escape($this->input->post('to_time')), 
					'centerschdl_maximum_sit'      => html_escape($this->input->post('max_sit')), 
					'centerschdl_last_bookingtime' => $last_booking_time, 
					'centerschdl_create_date'      => date("Y-m-d H:i:s"), 
					'centerschdl_status'           => $this->input->post('status'),
				);
		$validate = array(
						array(
							'field' => 'center_id', 
							'label' => 'Center', 
							'rules' => 'required|trim', 
						),
						array(
							'field' => 'to_date', 
							'label' => 'Date', 
							'rules' => 'required|trim', 
						),
						array(
							'field' => 'to_time', 
							'label' => 'Time', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->Workshop_model->create_center_schedule($data);
			$data_template['display_content'] = TRUE;
			$data_template['schedule_id'] = $schedule_id;
			$content = $this->load->view('schedules/workshop/center_list', $data_template, true);
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
	
	public function workshop_getlessoncreate()
	{
		$schedule_id = $this->input->post('schedule_id');
		$data['display'] = TRUE;
		$data['schedule_id'] = $schedule_id;
		$content = $this->load->view('schedules/workshop/center_create_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function workshop_editlesson()
	{
		$schedule_id = $this->input->post('schedule_id');
		$data['schedule_id'] = $schedule_id;
		$content = $this->load->view('schedules/workshop/center_edit_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function workshop_updatelesson()
	{
		$this->load->library('form_validation');
		$schedule_id = $this->input->post('schedule_id');
		$parent_schedule_id = $this->input->post('parent_schedule_id');
		$last_booking_time = html_escape($this->input->post('close_date')).' '.html_escape($this->input->post('close_time'));
		
		$schedule_range = $this->Schedules_model->get_schedule_range($schedule_id, 'WORKSHOP');
		
		$selected_date = strtotime($this->input->post('to_date'));
		$schedule_to_date = strtotime($schedule_range['endmschedule_to_date']);
		$schedule_from_date = strtotime($schedule_range['endmschedule_from_date']);
		
		if($schedule_to_date < strtotime(date('Y-m-d'))){
			$error = '<div class="alert alert-danger">Sorry : The schedule date is over!</div>';
			$result = array('status' => 'error', 'error' => $error);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}elseif($selected_date > $schedule_to_date || $selected_date < $schedule_from_date)
		{
			$error = '<div class="alert alert-danger">Note : Please select date within '.booking_schedule_range($schedule_id, 'WORKSHOP').'</div>';
			$result = array('status' => 'error', 'error' => $error);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
		
		$data = array(
					'centerschdl_center_id'        => $this->input->post('center_id'), 
					'centerschdl_to_date'          => html_escape($this->input->post('to_date')), 
					'centerschdl_to_time'          => html_escape($this->input->post('to_time')), 
					'centerschdl_maximum_sit'      => html_escape($this->input->post('max_sit')), 
					'centerschdl_last_bookingtime' => $last_booking_time, 
					'centerschdl_create_date'      => date("Y-m-d H:i:s"), 
					'centerschdl_status'           => $this->input->post('status'),
				);
		$validate = array(
						array(
							'field' => 'center_id', 
							'label' => 'Center', 
							'rules' => 'required|trim', 
						),
						array(
							'field' => 'to_date', 
							'label' => 'Date', 
							'rules' => 'required|trim', 
						),
						array(
							'field' => 'to_time', 
							'label' => 'Time', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->Workshop_model->update_center_schedule($schedule_id, $data);
			$data_template['display_content'] = TRUE;
			$data_template['schedule_id'] = $parent_schedule_id;
			$content = $this->load->view('schedules/workshop/center_list', $data_template, true);
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
	
	public function workshop_dellesson()
	{
		$schedule_id = $this->input->post('schedule_id');
		$parent_schedule_id = $this->input->post('parent_schedule_id');
		//Delete from module table
		$this->db->where('centerschdl_id', $schedule_id);
		$this->db->delete('starter_workshop_centerschdl');
		
		$retrive_button = '
						    <div class="generate-buttons text-right display-crtbtn">
								<button class="btn btn-purple m-b-5 return-create-lesson" data-schedule="'.$parent_schedule_id.'" type="button">Create New Schedule</button>
								<button class="btn btn-purple m-b-5 back-to-modules" type="button">Back To Schedules</button>
							</div>
						  ';
		$result = array("status" => "ok", "retrive_button" => $retrive_button);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function workshop_backtoschedules()
	{
		$data['display'] = TRUE;
		$content = $this->load->view('schedules/workshop/contents', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	/************************************/
	/*********END WORKSHOP SCHEDULE***********/
	/************************************/
	
	
	/************************************/
	/*********START ECE EXAM SCHEDULE***********/
	/************************************/
	
	public function eceexam()
	{
		$this->load->view('schedules/ece/eceexam');
	}
	
	public function ece_create()
	{
		$this->load->library('form_validation');
		$data = array(
					'endmschedule_title'         => html_escape($this->input->post('schedule_title')), 
					'endmschedule_exam_type'     => $this->input->post('exam_type'), 
					'endmschedule_from_date'     => $this->input->post('from_date'), 
					'endmschedule_to_date'       => $this->input->post('to_date'), 
					'endmschedule_status'        => html_escape($this->input->post('status')), 
					'endmschedule_created_by'    => $this->session->userdata('active_user'), 
					'endmschedule_create_date'   => date("Y-m-d H:i:s"), 
				);
		$validate = array(
						array(
							'field' => 'schedule_title', 
							'label' => 'Schedule Title', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		
		$this->load->library('upload');
		$config['upload_path']          = 'attachments/resources/ece/';
		$config['allowed_types']        = 'pdf|doc';
		$config['detect_mime']          = TRUE;
		$config['remove_spaces']        = TRUE;
		$config['encrypt_name']         = TRUE;
		$config['max_size']             = '0';
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('students_resource')){
		  $upload_error = $this->upload->display_errors();
		}else{
			$fileData = $this->upload->data();
			$data['endmschedule_student_resource'] = $fileData['file_name'];
		}

		/*=====================================*/

		$config['upload_path']          = 'attachments/resources/ece/';
		$config['allowed_types']        = 'pdf|doc';
		$config['detect_mime']          = TRUE;
		$config['remove_spaces']        = TRUE;
		$config['encrypt_name']         = TRUE;
		$config['max_size']             = '0';
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('faculties_resource')){
		  $upload_error = $this->upload->display_errors();
		}else{
			$fileData = $this->upload->data();
			$data['endmschedule_faculty_resource'] = $fileData['file_name'];
		}
		
		if($this->form_validation->run() == true)
		{
			//save
			$inschedule = $this->Eceschedule_model->create_schedule($data);
			
			$schedule_id = $this->db->insert_id($inschedule);
			
			//save notification
			$notification_data = array(
									'notif_schedule_id'   => $schedule_id,
									'notif_schedule_type' => 'ECE',
									'notif_content'       => 'ECE schedule is now available for you. Please go to apply or view book to join at ECE.',
									'notif_ece_students'  => 1,
									'notif_create_date'   => date("Y-m-d H:i:s"),
								);
			$this->Schedules_model->save_notification($notification_data);
			
			$data_template['display_content'] = TRUE;
			$content = $this->load->view('schedules/ece/content_lists', $data_template, true);
			
		$get_students = $this->Schedules_model->get_ece_students();
		foreach($get_students as $get_studentinfo):
		$name = $get_studentinfo['spinfo_first_name'].' '.$get_studentinfo['spinfo_middle_name'].' '.$get_studentinfo['spinfo_last_name'];
		//Send email
		if($_SERVER['HTTP_HOST']=='education.dldchc-badas.org.bd')
		{
		$email_data['get_studentinfo'] = $get_studentinfo;
		$email_data['full_name'] = $name;
		$body = $this->load->view('schedules/ece/email', $email_data, true);
		
		$this->sendmaillib->from('info@dldchc-badas.org.bd');
		$this->sendmaillib->to($get_studentinfo['student_email']);
		$this->sendmaillib->subject('ECE exam schedule available');
		$this->sendmaillib->content($body);
		$this->sendmaillib->send();
		
		$phone_number = $get_studentinfo['spinfo_personal_phone'];
$message ='Dear '.$name.',
Please apply for ECE Exam in your Dashboard:
link : '.base_url('student/login').'
';
		sendsms($phone_number, $message);	
		}
		endforeach;
			
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
	
	public function ece_schedule()
	{
		$data['display'] = TRUE;
		$data['phase_id'] = $this->input->post('phase_id');
		$content = $this->load->view('schedules/ece/create_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function ece_edit()
	{
		$data['schedule_id'] = $this->input->post('schedule_id');
		$content = $this->load->view('schedules/ece/edit_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function ece_update()
	{
		$this->load->library('form_validation');
		$phase_id = $this->input->post('phase_id');
		$schedule_id = $this->input->post('schedule_id');
		$data = array(
					'endmschedule_title'         => html_escape($this->input->post('schedule_title')),
					'endmschedule_exam_type'     => $this->input->post('exam_type'),
					'endmschedule_from_date'     => $this->input->post('from_date'), 
					'endmschedule_to_date'       => $this->input->post('to_date'), 
					'endmschedule_status'        => html_escape($this->input->post('status')), 
					'endmschedule_created_by'    => $this->session->userdata('active_user'), 
					'endmschedule_create_date'   => date("Y-m-d H:i:s"), 
				);
		$validate = array(
						array(
							'field' => 'schedule_title', 
							'label' => 'Schedule Title', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		
		$this->load->library('upload');
		$config['upload_path']          = 'attachments/resources/ece/';
		$config['allowed_types']        = 'pdf|doc';
		$config['detect_mime']          = TRUE;
		$config['remove_spaces']        = TRUE;
		$config['encrypt_name']         = TRUE;
		$config['max_size']             = '0';
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('students_resource')){
		  $upload_error = $this->upload->display_errors();
		}else{
			$exist_image = $this->Eceschedule_model->get_schedule_info($schedule_id);
			if(!empty($exist_image['endmschedule_student_resource']) && $exist_image['endmschedule_student_resource'] !== NULL){
				$file_name = attachment_dir("resources/ece/".$exist_image['endmschedule_student_resource']);
				if(file_exists($file_name)){
					unlink($file_name);
				}else{
					echo null;
				}
			}else{
				echo null;
			}
			$fileData = $this->upload->data();
			$data['endmschedule_student_resource'] = $fileData['file_name'];
		}

		/*=====================================*/

		$config['upload_path']          = 'attachments/resources/ece/';
		$config['allowed_types']        = 'pdf|doc';
		$config['detect_mime']          = TRUE;
		$config['remove_spaces']        = TRUE;
		$config['encrypt_name']         = TRUE;
		$config['max_size']             = '0';
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('faculties_resource')){
		  $upload_error = $this->upload->display_errors();
		}else{
			$exist_image = $this->Eceschedule_model->get_schedule_info($schedule_id);
			if(!empty($exist_image['endmschedule_faculty_resource']) && $exist_image['endmschedule_faculty_resource'] !== NULL){
				$file_name = attachment_dir("resources/ece/".$exist_image['endmschedule_faculty_resource']);
				if(file_exists($file_name)){
					unlink($file_name);
				}else{
					echo null;
				}
			}else{
				echo null;
			}
			$fileData = $this->upload->data();
			$data['endmschedule_faculty_resource'] = $fileData['file_name'];
		}
		
		if($this->form_validation->run() == true)
		{
			//save
			$this->Eceschedule_model->update_schedule($schedule_id, $data);
			$data_template['display_content'] = TRUE;
			$data_template['phase_id'] = $phase_id;
			$content = $this->load->view('schedules/ece/content_lists', $data_template, true);
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
	
	public function ece_delete_student_resource()
	{
		$endmschedule_id = $this->input->post('endmschedule_id');
		$exist_image = $this->Eceschedule_model->get_schedule_info($endmschedule_id);
		if(!empty($exist_image['endmschedule_student_resource']) && $exist_image['endmschedule_student_resource'] !== NULL){
			$file_name = attachment_dir("resources/ece/".$exist_image['endmschedule_student_resource']);
			if(file_exists($file_name)){
				unlink($file_name);
			}else{
				echo null;
			}
		}else{
			echo null;
		}
		
		//Update SDT schedule table
		$updated_data = array(
							'endmschedule_student_resource' => null,
						);
		$this->db->where('endmschedule_id', $endmschedule_id);
		$this->db->update('starter_ece_exschedule', $updated_data);
		
		$result = array('status' => 'ok');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
		
	}
	public function ece_delete_faculty_resource()
	{
		$endmschedule_id = $this->input->post('endmschedule_id');
		$exist_image = $this->Eceschedule_model->get_schedule_info($endmschedule_id);
		if(!empty($exist_image['endmschedule_faculty_resource']) && $exist_image['endmschedule_faculty_resource'] !== NULL){
			$file_name = attachment_dir("resources/ece/".$exist_image['endmschedule_faculty_resource']);
			if(file_exists($file_name)){
				unlink($file_name);
			}else{
				echo null;
			}
		}else{
			echo null;
		}
		
		//Update SDT schedule table
		$updated_data = array(
							'endmschedule_faculty_resource' => null,
						);
		$this->db->where('endmschedule_id', $endmschedule_id);
		$this->db->update('starter_ece_exschedule', $updated_data);
		
		$result = array('status' => 'ok');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function ece_delschedule()
	{
		$schedule_id = $this->input->post('schedule_id');
		
		//Delete from module content
		$this->db->where('centerschdl_parentschdl_id', $schedule_id);
		$this->db->delete('starter_ece_centerschdl');
		
		//Delete from module table
		$this->db->where('endmschedule_id', $schedule_id);
		$this->db->delete('starter_ece_exschedule');
		
		$data['schedule_id'] = $schedule_id;
		$content = $this->load->view('schedules/ece/create_form', $data, true);
		
		$result = array("status" => "ok", "content" => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function ece_lesson()
	{
		$schedule_id = $this->input->post('schedule_id');
		$data['schedule_id'] = $schedule_id;
		$content = $this->load->view('schedules/ece/centers', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function ece_createlesson()
	{
		$this->load->library('form_validation');
		$schedule_id = $this->input->post('schedule_id');
		$last_booking_time = html_escape($this->input->post('close_date')).' '.html_escape($this->input->post('close_time'));
		
		$schedule_range = $this->Schedules_model->get_schedule_range($schedule_id, 'ECE');
		
		$selected_date = strtotime($this->input->post('to_date'));
		$schedule_to_date = strtotime($schedule_range['endmschedule_to_date']);
		$schedule_from_date = strtotime($schedule_range['endmschedule_from_date']);
		
		if($schedule_to_date < strtotime(date('Y-m-d'))){
			$error = '<div class="alert alert-danger">Sorry : The schedule date is over!</div>';
			$result = array('status' => 'error', 'error' => $error);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}elseif($selected_date > $schedule_to_date || $selected_date < $schedule_from_date)
		{
			$error = '<div class="alert alert-danger">Note : Please select date within '.booking_schedule_range($schedule_id, 'ECE').'</div>';
			$result = array('status' => 'error', 'error' => $error);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
		
		$data = array(
					'centerschdl_parentschdl_id'   => $schedule_id, 
					'centerschdl_center_id'        => $this->input->post('center_id'), 
					'centerschdl_to_date'          => html_escape($this->input->post('to_date')), 
					'centerschdl_to_time'          => html_escape($this->input->post('to_time')), 
					'centerschdl_maximum_sit'      => html_escape($this->input->post('max_sit')), 
					'centerschdl_last_bookingtime' => $last_booking_time, 
					'centerschdl_create_date'      => date("Y-m-d H:i:s"), 
					'centerschdl_status'           => $this->input->post('status'),
				);
		$validate = array(
						array(
							'field' => 'center_id', 
							'label' => 'Center', 
							'rules' => 'required|trim', 
						),
						array(
							'field' => 'to_date', 
							'label' => 'Date', 
							'rules' => 'required|trim', 
						),
						array(
							'field' => 'to_time', 
							'label' => 'Time', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->Eceschedule_model->create_center_schedule($data);
			$data_template['display_content'] = TRUE;
			$data_template['schedule_id'] = $schedule_id;
			$content = $this->load->view('schedules/ece/center_list', $data_template, true);
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
	
	public function ece_getlessoncreate()
	{
		$schedule_id = $this->input->post('schedule_id');
		$data['display'] = TRUE;
		$data['schedule_id'] = $schedule_id;
		$content = $this->load->view('schedules/ece/center_create_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function ece_editlesson()
	{
		$schedule_id = $this->input->post('schedule_id');
		$data['schedule_id'] = $schedule_id;
		$content = $this->load->view('schedules/ece/center_edit_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function ece_updatelesson()
	{
		$this->load->library('form_validation');
		$schedule_id = $this->input->post('schedule_id');
		$parent_schedule_id = $this->input->post('parent_schedule_id');
		$last_booking_time = html_escape($this->input->post('close_date')).' '.html_escape($this->input->post('close_time'));
		
		$schedule_range = $this->Schedules_model->get_schedule_range($schedule_id, 'ECE');
		
		$selected_date = strtotime($this->input->post('to_date'));
		$schedule_to_date = strtotime($schedule_range['endmschedule_to_date']);
		$schedule_from_date = strtotime($schedule_range['endmschedule_from_date']);
		
		if($schedule_to_date < strtotime(date('Y-m-d'))){
			$error = '<div class="alert alert-danger">Sorry : The schedule date is over!</div>';
			$result = array('status' => 'error', 'error' => $error);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}elseif($selected_date > $schedule_to_date || $selected_date < $schedule_from_date)
		{
			$error = '<div class="alert alert-danger">Note : Please select date within '.booking_schedule_range($schedule_id, 'ECE').'</div>';
			$result = array('status' => 'error', 'error' => $error);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
		
		$data = array(
					'centerschdl_center_id'        => $this->input->post('center_id'), 
					'centerschdl_to_date'          => html_escape($this->input->post('to_date')), 
					'centerschdl_to_time'          => html_escape($this->input->post('to_time')), 
					'centerschdl_maximum_sit'      => html_escape($this->input->post('max_sit')), 
					'centerschdl_last_bookingtime' => $last_booking_time, 
					'centerschdl_create_date'      => date("Y-m-d H:i:s"), 
					'centerschdl_status'           => $this->input->post('status'),
				);
		$validate = array(
						array(
							'field' => 'center_id', 
							'label' => 'Center', 
							'rules' => 'required|trim', 
						),
						array(
							'field' => 'to_date', 
							'label' => 'Date', 
							'rules' => 'required|trim', 
						),
						array(
							'field' => 'to_time', 
							'label' => 'Time', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->Eceschedule_model->update_center_schedule($schedule_id, $data);
			$data_template['display_content'] = TRUE;
			$data_template['schedule_id'] = $parent_schedule_id;
			$content = $this->load->view('schedules/ece/center_list', $data_template, true);
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
	
	public function ece_dellesson()
	{
		$schedule_id = $this->input->post('schedule_id');
		$parent_schedule_id = $this->input->post('parent_schedule_id');
		//Delete from module table
		$this->db->where('centerschdl_id', $schedule_id);
		$this->db->delete('starter_ece_centerschdl');
		
		$retrive_button = '
						    <div class="generate-buttons text-right display-crtbtn">
								<button class="btn btn-purple m-b-5 return-create-lesson" data-schedule="'.$parent_schedule_id.'" type="button">Create New Schedule</button>
								<button class="btn btn-purple m-b-5 back-to-modules" type="button">Back To Schedules</button>
							</div>
						  ';
		$result = array("status" => "ok", "retrive_button" => $retrive_button);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function ece_backtoschedules()
	{
		$data['display'] = TRUE;
		$content = $this->load->view('schedules/ece/contents', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	/************************************/
	/*********END ECE EXAM SCHEDULE***********/
	/************************************/
	
	
}