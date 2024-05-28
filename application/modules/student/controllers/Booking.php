<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends CI_Controller{
	
	private $sqtoken;
	private $sqtoken_hash;
	
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
		
		$this->load->model('Booking_model');
		$this->load->model('Course_model');
	}
	
	public function ftwof()
	{
		$center_scheduleid = $this->input->post('center');
		$data = array(
					'booking_application_id'         => $this->input->post('applicant_ID'),
					'booking_user_id'                => $this->session->userdata('active_student'),
					'booking_user_type'              => 'Student',
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
		$scheduleID = $this->input->post('schedule');
		$check_already_booked = $this->Booking_model->check_students_booking($this->input->post('phase_level'), $scheduleID);
		
		if($check_already_booked == true)
		{
			$details_content = '<strong style="color:#F00">You have already booked in this schedule!</strong>';
			$result = array('status' => 'booked', 'details_content' => $details_content);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else
		{
			$center_scheduleid = $this->input->post('center');
			$data = array(
						'booking_user_id'                => $this->session->userdata('active_student'),
						'booking_user_type'              => 'Student',
						'booking_phase_level'            => $this->input->post('phase_level'),
						'booking_schedule_id'            => $this->input->post('schedule'),
						'booking_schedule_centerid'      => $center_scheduleid,
						'booking_date'                   => date("Y-m-d H:i:s"),
						'booking_status'                 => 1,
					);
			$insbkkd_id = $this->Booking_model->save_sdtschedule_booking($data);
			$booked_id = $this->db->insert_id($insbkkd_id);
			$applicant_ID = date("Ym").$booked_id;
			$this->db->where('booking_id', $booked_id);
			$this->db->update('starter_sdt_booking', array('booking_application_id' => $applicant_ID));
			
			//update center maximum sit
			$center_maximum_sit = $this->Booking_model->get_sdtcentermaximum_sit($center_scheduleid);
			$minus_sit = $center_maximum_sit['centerschdl_maximum_sit'] - 1;
			$cnt_data = array(
							'centerschdl_maximum_sit' => $minus_sit,
						);
			$this->Booking_model->update_sdtmaximum_sit($center_scheduleid, $cnt_data);
			
			$get_booking_details = $this->Booking_model->get_sdt_already_booked_details($this->input->post('phase_level'));
			$details_content = '';
			foreach($get_booking_details as $booking):
			$details_content .= '<tr>
									<td class="text-center">'.$booking['endmschedule_title'].'</td>
									<td class="text-center">'.$booking['booking_application_id'].'</td>
									<td class="text-center">'.$booking['center_location'].'</td>
									<td class="text-center">'.date("d F, Y", strtotime($booking['centerschdl_to_date'])).' '.$booking['centerschdl_to_time'].'</td>
									<td class="text-center">'.date("d F, Y", strtotime($booking['booking_date'])).'</td>
								</tr>
							   ';
			endforeach;
			
			$result = array('status' => 'ok', 'details_content' => $details_content);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
	}
	
	public function workshop()
	{
		$scheduleID = $this->input->post('schedule');
		$check_already_booked = $this->Booking_model->check_workshop_students_booking($this->input->post('phase_level'), $scheduleID);
		
		if($check_already_booked == true)
		{
			$details_content = '<strong style="color:#F00">You have already booked in this schedule!</strong>';
			$result = array('status' => 'booked', 'details_content' => $details_content);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else
		{
			$center_scheduleid = $this->input->post('center');
			$data = array(
						'booking_user_id'                => $this->session->userdata('active_student'),
						'booking_user_type'              => 'Student',
						'booking_phase_level'            => $this->input->post('phase_level'),
						'booking_schedule_id'            => $this->input->post('schedule'),
						'booking_schedule_centerid'      => $center_scheduleid,
						'booking_date'                   => date("Y-m-d H:i:s"),
						'booking_status'                 => 1,
					);
			
			$insbkkd_id = $this->Booking_model->save_workshopschedule_booking($data);
			$booked_id = $this->db->insert_id($insbkkd_id);
			$applicant_ID = date("Ym").$booked_id;
			$this->db->where('booking_id', $booked_id);
			$this->db->update('starter_workshop_booking', array('booking_application_id' => $applicant_ID));
			
			//update center maximum sit
			$center_maximum_sit = $this->Booking_model->get_workshopcentermaximum_sit($center_scheduleid);
			$minus_sit = $center_maximum_sit['centerschdl_maximum_sit'] - 1;
			$cnt_data = array(
							'centerschdl_maximum_sit' => $minus_sit,
						);
			$this->Booking_model->update_workshopmaximum_sit($center_scheduleid, $cnt_data);
			
			$get_booking_details = $this->Booking_model->get_workshop_already_booked_details($this->input->post('phase_level'));
			$details_content = '';
			foreach($get_booking_details as $booking):
			$details_content .= '<tr>
									<td class="text-center">'.$booking['endmschedule_title'].'</td>
									<td class="text-center">'.$booking['booking_application_id'].'</td>
									<td class="text-center">'.$booking['center_location'].'</td>
									<td class="text-center">'.date("d F, Y", strtotime($booking['centerschdl_to_date'])).' '.$booking['centerschdl_to_time'].'</td>
									<td class="text-center">'.date("d F, Y", strtotime($booking['booking_date'])).'</td>
								</tr>
							   ';
			endforeach;
			
			$result = array('status' => 'ok', 'details_content' => $details_content);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
	}
	
	public function eceexam()
	{
		$scheduleID = $this->input->post('schedule');
		$check_already_booked = $this->Booking_model->check_ece_students_booking($scheduleID);
		
		if($check_already_booked == true)
		{
			$details_content = '<strong style="color:#F00">You have already booked in this schedule!</strong>';
			$result = array('status' => 'booked', 'details_content' => $details_content);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else
		{
			$center_scheduleid = $this->input->post('center');
			$data = array(
						'booking_user_id'                => $this->session->userdata('active_student'),
						'booking_user_type'              => 'Student',
						'booking_schedule_id'            => $this->input->post('schedule'),
						'booking_schedule_centerid'      => $center_scheduleid,
						'booking_date'                   => date("Y-m-d H:i:s"),
						'booking_status'                 => 1,
					);
			
			$insbkkd_id = $this->Booking_model->save_eceschedule_booking($data);
			$booked_id = $this->db->insert_id($insbkkd_id);
			$applicant_ID = date("Ym").$booked_id;
			$this->db->where('booking_id', $booked_id);
			$this->db->update('starter_eceexam_booking', array('booking_application_id' => $applicant_ID));
			
			//update center maximum sit
			$center_maximum_sit = $this->Booking_model->get_ececentermaximum_sit($center_scheduleid);
			$minus_sit = $center_maximum_sit['centerschdl_maximum_sit'] - 1;
			$cnt_data = array(
							'centerschdl_maximum_sit' => $minus_sit,
						);
			$this->Booking_model->update_ecemaximum_sit($center_scheduleid, $cnt_data);
			
			$get_booking_details = $this->Booking_model->get_ece_already_booked_details();
			$details_content = '';
			foreach($get_booking_details as $booking):
			$details_content .= '<tr>
									<td class="text-center">'.$booking['endmschedule_title'].'</td>
									<td class="text-center">'.$booking['booking_application_id'].'</td>
									<td class="text-center">'.$booking['center_location'].'</td>
									<td class="text-center">'.date("d F, Y", strtotime($booking['centerschdl_to_date'])).' '.$booking['centerschdl_to_time'].'</td>
									<td class="text-center">'.date("d F, Y", strtotime($booking['booking_date'])).'</td>
								</tr>
							   ';
			endforeach;
			
			$result = array('status' => 'ok', 'details_content' => $details_content);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
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
	
	public function cntrsdl_details()
	{
		$centersdl_id = $this->input->post('cntr_id');
		echo $this->__get_centersdl_details($centersdl_id);
	}
	
	public function __get_centersdl_details($centersdl_id)
	{
		$center_schedule_info = $this->Course_model->get_center_schedule_info($centersdl_id);
		$content = '<div class="cntr-dt-bx">
						<h5>Center Details</h5>
						<table style="font-size: 12px; width: 100%;">
							<tr>
								<td class="text-left"><strong>Date : </strong></td>
								<td class="text-left">'.date("d F, Y", strtotime($center_schedule_info['centerschdl_to_date'])).'</td>
							</tr>
							<tr>
								<td class="text-left"><strong>Time : </strong></td>
								<td class="text-left">'.$center_schedule_info['centerschdl_to_time'].'</td>
							</tr>
							<tr>
								<td class="text-left"><strong>Available Sit : </strong></td>
								<td class="text-left">'.$center_schedule_info['centerschdl_maximum_sit'].'</td>
							</tr>
						</table>
					</div>
					';
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		return json_encode($result);
		exit;
	}
	
	public function workshop_cntrsdl_details()
	{
		$centersdl_id = $this->input->post('cntr_id');
		echo $this->__get_workshop_centersdl_details($centersdl_id);
	}
	
	public function __get_workshop_centersdl_details($centersdl_id)
	{
		$center_schedule_info = $this->Course_model->get_workshop_center_schedule_info($centersdl_id);
		$content = '<div class="cntr-dt-bx">
						<h5>Center Details</h5>
						<table style="font-size: 12px; width: 100%;">
							<tr>
								<td class="text-left"><strong>Date : </strong></td>
								<td class="text-left">'.date("d F, Y", strtotime($center_schedule_info['centerschdl_to_date'])).'</td>
							</tr>
							<tr>
								<td class="text-left"><strong>Time : </strong></td>
								<td class="text-left">'.$center_schedule_info['centerschdl_to_time'].'</td>
							</tr>
							<tr>
								<td class="text-left"><strong>Available Sit : </strong></td>
								<td class="text-left">'.$center_schedule_info['centerschdl_maximum_sit'].'</td>
							</tr>
						</table>
					</div>
					';
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		return json_encode($result);
		exit;
	}
	
	public function ece_cntrsdl_details()
	{
		$centersdl_id = $this->input->post('cntr_id');
		echo $this->__get_ece_centersdl_details($centersdl_id);
	}
	
	public function __get_ece_centersdl_details($centersdl_id)
	{
		$center_schedule_info = $this->Course_model->get_ece_center_schedule_info($centersdl_id);
		$content = '<div class="cntr-dt-bx">
						<h5>Center Details</h5>
						<table style="font-size: 12px; width: 100%;">
							<tr>
								<td class="text-left"><strong>Date : </strong></td>
								<td class="text-left">'.date("d F, Y", strtotime($center_schedule_info['centerschdl_to_date'])).'</td>
							</tr>
							<tr>
								<td class="text-left"><strong>Time : </strong></td>
								<td class="text-left">'.$center_schedule_info['centerschdl_to_time'].'</td>
							</tr>
							<tr>
								<td class="text-left"><strong>Available Sit : </strong></td>
								<td class="text-left">'.$center_schedule_info['centerschdl_maximum_sit'].'</td>
							</tr>
						</table>
					</div>
					';
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		return json_encode($result);
		exit;
	}
	
}