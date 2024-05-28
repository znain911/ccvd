<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends CI_Controller{
	
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
		
		$this->load->model('Booking_model');
		$this->load->model('Course_model');
	}
	
	public function ftwof()
	{
		$center_scheduleid = $this->input->post('center');
		$data = array(
					'booking_application_id'         => $this->input->post('applicant_ID'),
					'booking_user_id'                => $this->session->userdata('active_teacher'),
					'booking_user_type'              => 'Faculty',
					'booking_phase_level'            => $this->input->post('phase_level'),
					'booking_schedule_id'            => $this->input->post('schedule'),
					'booking_schedule_centerid'      => $center_scheduleid,
					'booking_date'                   => date("Y-m-d H:i:s"),
					'booking_status'                 => 1,
				);
		$this->Booking_model->save_ftwofschedule_booking($data);
		
		//update center maximum sit
		$center_maximum_sit = $this->Booking_model->get_ftwofcentermaximum_sit($center_scheduleid);
		$minus_sit = $center_maximum_sit['centerschdl_maximum_sit'] - 1;
		$cnt_data = array(
						'centerschdl_maximum_sit' => $minus_sit,
					);
		$this->Booking_model->update_ftwofmaximum_sit($center_scheduleid, $cnt_data);
		
		//get instant center schedule details
		
		$content_session['display'] = true;
		$all_sessions = $this->load->view('session/all_sessions', $content_session, true);
		
		$content_booking['display'] = true;
		$all_bookings = $this->load->view('session/all_bookings', $content_booking, true);
		
		$result = array('status' => 'ok', 'sessions' => $all_sessions, 'bookings' => $all_bookings);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function sdt()
	{
		$center_scheduleid = $this->input->post('center');
		$data = array(
					'booking_user_id'                => $this->session->userdata('active_teacher'),
					'booking_user_type'              => 'Faculty',
					'booking_phase_level'            => $this->input->post('phase_level'),
					'booking_schedule_id'            => $this->input->post('schedule'),
					'booking_schedule_centerid'      => $center_scheduleid,
					'booking_date'                   => date("Y-m-d H:i:s"),
					'booking_status'                 => 1,
				);
		$insid = $this->Booking_model->save_sdtschedule_booking($data);
		$sdtbooking_id = $this->db->insert_id($insid);
		
		//update booking application ID
		$applicant_ID = date("Ym").$sdtbooking_id;
		$cnt_data = array(
						'booking_application_id' => $applicant_ID,
					);
		$this->Booking_model->update_sdtbooking_id($sdtbooking_id, $cnt_data);
		
		//get instant center schedule details
		$content_session['display'] = true;
		$all_sessions = $this->load->view('sdt/all_sessions', $content_session, true);
		
		$content_booking['display'] = true;
		$all_bookings = $this->load->view('sdt/all_bookings', $content_booking, true);
		
		$result = array('status' => 'ok', 'sessions' => $all_sessions, 'bookings' => $all_bookings);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function workshop()
	{
		$center_scheduleid = $this->input->post('center');
		$data = array(
					'booking_user_id'                => $this->session->userdata('active_teacher'),
					'booking_user_type'              => 'Faculty',
					'booking_phase_level'            => $this->input->post('phase_level'),
					'booking_schedule_id'            => $this->input->post('schedule'),
					'booking_schedule_centerid'      => $center_scheduleid,
					'booking_date'                   => date("Y-m-d H:i:s"),
					'booking_status'                 => 1,
				);
		$insid = $this->Booking_model->save_workshopschedule_booking($data);
		$workshop_id = $this->db->insert_id($insid);
		
		//update center maximum sit
		$applicant_ID = date("Ym").$workshop_id;
		$cnt_data = array(
						'booking_application_id' => $applicant_ID,
					);
		$this->Booking_model->update_workshop_booking($workshop_id, $cnt_data);
		
		//get instant center schedule details
		$content_session['display'] = true;
		$all_sessions = $this->load->view('workshop/all_sessions', $content_session, true);
		
		$content_booking['display'] = true;
		$all_bookings = $this->load->view('workshop/all_bookings', $content_booking, true);
		
		$result = array('status' => 'ok', 'sessions' => $all_sessions, 'bookings' => $all_bookings);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function phase()
	{
		$center_scheduleid = $this->input->post('center');
		$data = array(
					'booking_application_id'         => $this->input->post('applicant_ID'),
					'booking_user_id'                => $this->session->userdata('active_teacher'),
					'booking_user_type'              => 'Faculty',
					'booking_phase_level'            => $this->input->post('phase_level'),
					'booking_schedule_id'       => $this->input->post('schedule'),
					'booking_schedule_centerid' => $center_scheduleid,
					'booking_date'                   => date("Y-m-d H:i:s"),
					'booking_status'                 => 1,
				);
		$this->Booking_model->save_phaseschedule_booking($data);
		
		//update center maximum sit
		$center_maximum_sit = $this->Booking_model->get_centermaximum_sit($center_scheduleid);
		$minus_sit = $center_maximum_sit['centerschdl_maximum_sit'] - 1;
		$cnt_data = array(
						'centerschdl_maximum_sit' => $minus_sit,
					);
		$this->Booking_model->update_maximum_sit($center_scheduleid, $cnt_data);
		
		//get instant center schedule details
		$content_session['display'] = true;
		$all_sessions = $this->load->view('phase/all_sessions', $content_session, true);
		
		$content_booking['display'] = true;
		$all_bookings = $this->load->view('phase/all_bookings', $content_booking, true);
		
		$result = array('status' => 'ok', 'sessions' => $all_sessions, 'bookings' => $all_bookings);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function eceexam()
	{
		$center_scheduleid = $this->input->post('center');
		$data = array(
					'booking_user_id'                => $this->session->userdata('active_teacher'),
					'booking_user_type'              => 'Faculty',
					'booking_schedule_id'            => $this->input->post('schedule'),
					'booking_schedule_centerid'      => $center_scheduleid,
					'booking_date'                   => date("Y-m-d H:i:s"),
					'booking_status'                 => 1,
				);
		$insid = $this->Booking_model->save_eceschedule_booking($data);
		$ece_booking_id = $this->db->insert_id($insid);
		
		//update center maximum sit
		$applicant_ID = date("Ym").$ece_booking_id;
		$cnt_data = array(
						'booking_application_id' => $applicant_ID,
					);
		$this->Booking_model->update_ece_booking($ece_booking_id, $cnt_data);
		
		//get instant center schedule details
		$content_session['display'] = true;
		$all_sessions = $this->load->view('ece/all_sessions', $content_session, true);
		
		$content_booking['display'] = true;
		$all_bookings = $this->load->view('ece/all_bookings', $content_booking, true);
		
		$result = array('status' => 'ok', 'sessions' => $all_sessions, 'bookings' => $all_bookings);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function ftwof_frmsubmission()
	{
		$data['schedule_id'] = $this->input->post('schedule');
		$data['phase_level'] = $this->input->post('phase_level');
		$content = $this->load->view('session/ftwof', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function phase_frmsubmission()
	{
		$data['schedule_id'] = $this->input->post('schedule');
		$data['phase_level'] = $this->input->post('phase_level');
		$content = $this->load->view('phase/ftwof', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function ece_frmsubmission()
	{
		$data['schedule_id'] = $this->input->post('schedule');
		$content = $this->load->view('ece/ftwof', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function sdt_frmsubmission()
	{
		$data['schedule_id'] = $this->input->post('schedule');
		$data['phase_level'] = $this->input->post('phase_level');
		$content = $this->load->view('sdt/ftwof', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function workshop_frmsubmission()
	{
		$data['schedule_id'] = $this->input->post('schedule');
		$data['phase_level'] = $this->input->post('phase_level');
		$content = $this->load->view('workshop/ftwof', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
}