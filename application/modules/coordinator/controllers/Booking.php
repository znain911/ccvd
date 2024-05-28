<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends CI_Controller {
	
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
		
		$check_permission = $this->Perm_model->check_permissionby_admin($active_user, 9);
		if($check_permission == true){ echo null; }else{ redirect('not-found'); }
		
		$this->sqtoken = $this->security->get_csrf_token_name();
		$this->sqtoken_hash = $this->security->get_csrf_hash();
		
		$this->load->model('Booking_model');
	}
	
	/****************/
	/*****START F2F APPLICANTS*****/
	/****************/
	
	public function ftwof()
	{
		if(isset($_GET['type']) && $_GET['type'] === 'Faculties')
		{
			
			$this->load->view('booking/ftwof/ftwof_faculties');
			
		}elseif(isset($_GET['type']) && $_GET['type'] === 'Students'){
			
			$this->load->view('booking/ftwof/ftwof_students');
			
		}else
		{
			redirect('not-found');
		}
	}
	
	public function ftwof_delete()
	{
		$booking_id = $this->input->post('id');
		
		//delete
		$this->db->where('booking_id', $booking_id);
		$this->db->delete('starter_ftwof_booking');
		
		$result = array('status' => 'ok');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	/****************/
	/*****END F2F APPLICANTS*****/
	/****************/
	
	
	/****************/
	/*****START SDT APPLICANTS*****/
	/****************/
	
	public function sdt()
	{
		if(isset($_GET['type']) && $_GET['type'] === 'Faculties')
		{
			
			$this->load->view('booking/sdt/sdt_faculties');
			
		}elseif(isset($_GET['type']) && $_GET['type'] === 'Students'){
			
			$this->load->view('booking/sdt/sdt_students');
			
		}else
		{
			redirect('not-found');
		}
	}
	
	public function sdt_delete()
	{
		$booking_id = $this->input->post('id');
		
		//delete
		$this->db->where('booking_id', $booking_id);
		$this->db->delete('starter_sdt_booking');
		
		$result = array('status' => 'ok');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	/****************/
	/*****END SDT APPLICANTS*****/
	/****************/
	
	
	/****************/
	/*****START WORKSHOP APPLICANTS*****/
	/****************/
	
	public function workshop()
	{
		if(isset($_GET['type']) && $_GET['type'] === 'Faculties')
		{
			
			$this->load->view('booking/workshop/workshop_faculties');
			
		}elseif(isset($_GET['type']) && $_GET['type'] === 'Students'){
			
			$this->load->view('booking/workshop/workshop_students');
			
		}else
		{
			redirect('not-found');
		}
	}
	
	public function workshop_delete()
	{
		$booking_id = $this->input->post('id');
		
		//delete
		$this->db->where('booking_id', $booking_id);
		$this->db->delete('starter_workshop_booking');
		
		$result = array('status' => 'ok');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	/****************/
	/*****END WORKSHOP APPLICANTS*****/
	/****************/
	
	
	/****************/
	/*****START PHASE APPLICANTS*****/
	/****************/
	public function phaseexam()
	{
		if(isset($_GET['type']) && $_GET['type'] === 'Faculties')
		{
			
			$this->load->view('booking/phase/phase_faculties');
			
		}elseif(isset($_GET['type']) && $_GET['type'] === 'Students'){
			
			$this->load->view('booking/phase/phase_students');
			
		}else
		{
			redirect('not-found');
		}
	}
	
	public function phase_delete()
	{
		$booking_id = $this->input->post('id');
		
		//delete
		$this->db->where('booking_id', $booking_id);
		$this->db->delete('starter_phaseexam_booking');
		
		$result = array('status' => 'ok');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	/****************/
	/*****END PHASE APPLICANTS*****/
	/****************/
	
	
	/****************/
	/*****START ECE APPLICANTS*****/
	/****************/
	
	public function eceexam()
	{
		if(isset($_GET['type']) && $_GET['type'] === 'Faculties')
		{
			
			$this->load->view('booking/ece/ece_faculties');
			
		}elseif(isset($_GET['type']) && $_GET['type'] === 'Students'){
			
			$this->load->view('booking/ece/ece_students');
			
		}else
		{
			redirect('not-found');
		}
	}
	
	public function ece_delete()
	{
		$booking_id = $this->input->post('id');
		
		//delete
		$this->db->where('booking_id', $booking_id);
		$this->db->delete('starter_eceexam_booking');
		
		$result = array('status' => 'ok');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	/****************/
	/*****END ECE APPLICANTS*****/
	/****************/
	
	public function as_selected()
	{
		$booking_id = $this->input->post('booking_id');
		$faculty_id = $this->input->post('faculty_id');
		
		$check_already_saved = $this->Booking_model->check_sdt_alreadysaved($booking_id, $faculty_id);
		if($check_already_saved == true)
		{
			$data = array(
						'programme_status'      => 1,
					);
			
			$this->db->where('programme_bookingid', $booking_id);
			$this->db->where('programme_facultyid', $faculty_id);
			$this->db->update('starter_sdt_programme', $data);
			
			$status_content = '<span class="btn btn-success btn-xs btn-rounded p-l-10 p-r-10">Selected</span>';
			$action_content = '<button data-id="'.$booking_id.'" data-faculty="'.$faculty_id.'" class="decline-row btn btn-danger btn-xs p-l-10 p-r-10"><i class="fa fa-times"></i> Diselect</button>';
			
			$result = array('status' => 'ok', 'status_content' => $status_content, 'action_content' => $action_content);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else
		{
			$data = array(
						'programme_bookingid'   => $booking_id,
						'programme_facultyid'   => $faculty_id,
						'programme_status'      => 1,
						'programme_create_date' => date("Y-m-d H:i:s"),
					);
			$this->Booking_model->save_sdt_programme($data);
			
			$status_content = '<span class="btn btn-success btn-xs btn-rounded p-l-10 p-r-10">Selected</span>';
			$action_content = '<button data-id="'.$booking_id.'" data-faculty="'.$faculty_id.'" class="decline-row btn btn-danger btn-xs p-l-10 p-r-10"><i class="fa fa-times"></i> Diselect</button>';
			
			$result = array('status' => 'ok', 'status_content' => $status_content, 'action_content' => $action_content);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
	}
	
	public function as_declined()
	{
		$booking_id = $this->input->post('booking_id');
		$faculty_id = $this->input->post('faculty_id');
		
		$data = array(
					'programme_status'      => 0,
				);
		
		$this->db->where('programme_bookingid', $booking_id);
		$this->db->where('programme_facultyid', $faculty_id);
		$this->db->update('starter_sdt_programme', $data);
		
		$status_content = '<span class="btn btn-danger btn-xs btn-rounded p-l-10 p-r-10">Pending</span>';
		$action_content = '<button data-id="'.$booking_id.'" data-faculty="'.$faculty_id.'" class="accept-row btn btn-success btn-xs p-l-10 p-r-10"><i class="fa fa-check"></i> Select</button>';
		
		$result = array('status' => 'ok', 'status_content' => $status_content, 'action_content' => $action_content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function as_workshop_selected()
	{
		$booking_id = $this->input->post('booking_id');
		$faculty_id = $this->input->post('faculty_id');
		
		$check_already_saved = $this->Booking_model->check_workshop_alreadysaved($booking_id, $faculty_id);
		if($check_already_saved == true)
		{
			$data = array(
						'programme_status'      => 1,
					);
			
			$this->db->where('programme_bookingid', $booking_id);
			$this->db->where('programme_facultyid', $faculty_id);
			$this->db->update('starter_workshop_programme', $data);
			
			$status_content = '<span class="btn btn-success btn-xs btn-rounded p-l-10 p-r-10">Selected</span>';
			$action_content = '<button data-id="'.$booking_id.'" data-faculty="'.$faculty_id.'" class="decline-row btn btn-danger btn-xs p-l-10 p-r-10"><i class="fa fa-times"></i> Diselect</button>';
			
			$result = array('status' => 'ok', 'status_content' => $status_content, 'action_content' => $action_content);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else
		{
			$data = array(
						'programme_bookingid'   => $booking_id,
						'programme_facultyid'   => $faculty_id,
						'programme_status'      => 1,
						'programme_create_date' => date("Y-m-d H:i:s"),
					);
			$this->Booking_model->save_workshop_programme($data);
			
			$status_content = '<span class="btn btn-success btn-xs btn-rounded p-l-10 p-r-10">Selected</span>';
			$action_content = '<button data-id="'.$booking_id.'" data-faculty="'.$faculty_id.'" class="decline-row btn btn-danger btn-xs p-l-10 p-r-10"><i class="fa fa-times"></i> Diselect</button>';
			
			$result = array('status' => 'ok', 'status_content' => $status_content, 'action_content' => $action_content);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
	}
	
	public function as_workshop_declined()
	{
		$booking_id = $this->input->post('booking_id');
		$faculty_id = $this->input->post('faculty_id');
		
		$data = array(
					'programme_status'      => 0,
				);
		
		$this->db->where('programme_bookingid', $booking_id);
		$this->db->where('programme_facultyid', $faculty_id);
		$this->db->update('starter_workshop_programme', $data);
		
		$status_content = '<span class="btn btn-danger btn-xs btn-rounded p-l-10 p-r-10">Pending</span>';
		$action_content = '<button data-id="'.$booking_id.'" data-faculty="'.$faculty_id.'" class="accept-row btn btn-success btn-xs p-l-10 p-r-10"><i class="fa fa-check"></i> Select</button>';
		
		$result = array('status' => 'ok', 'status_content' => $status_content, 'action_content' => $action_content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function as_ece_selected()
	{
		$booking_id = $this->input->post('booking_id');
		$faculty_id = $this->input->post('faculty_id');
		
		$check_already_saved = $this->Booking_model->check_ece_alreadysaved($booking_id, $faculty_id);
		if($check_already_saved == true)
		{
			$data = array(
						'programme_status'      => 1,
					);
			
			$this->db->where('programme_bookingid', $booking_id);
			$this->db->where('programme_facultyid', $faculty_id);
			$this->db->update('starter_ece_programme', $data);
			
			$status_content = '<span class="btn btn-success btn-xs btn-rounded p-l-10 p-r-10">Selected</span>';
			$action_content = '<button data-id="'.$booking_id.'" data-faculty="'.$faculty_id.'" class="decline-row btn btn-danger btn-xs p-l-10 p-r-10"><i class="fa fa-times"></i> Diselect</button>';
			
			$result = array('status' => 'ok', 'status_content' => $status_content, 'action_content' => $action_content);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else
		{
			$data = array(
						'programme_bookingid'   => $booking_id,
						'programme_facultyid'   => $faculty_id,
						'programme_status'      => 1,
						'programme_create_date' => date("Y-m-d H:i:s"),
					);
			$this->Booking_model->save_ece_programme($data);
			
			$status_content = '<span class="btn btn-success btn-xs btn-rounded p-l-10 p-r-10">Selected</span>';
			$action_content = '<button data-id="'.$booking_id.'" data-faculty="'.$faculty_id.'" class="decline-row btn btn-danger btn-xs p-l-10 p-r-10"><i class="fa fa-times"></i> Diselect</button>';
			
			$result = array('status' => 'ok', 'status_content' => $status_content, 'action_content' => $action_content);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
	}
	
	public function as_ece_declined()
	{
		$booking_id = $this->input->post('booking_id');
		$faculty_id = $this->input->post('faculty_id');
		
		$data = array(
					'programme_status'      => 0,
				);
		
		$this->db->where('programme_bookingid', $booking_id);
		$this->db->where('programme_facultyid', $faculty_id);
		$this->db->update('starter_ece_programme', $data);
		
		$status_content = '<span class="btn btn-danger btn-xs btn-rounded p-l-10 p-r-10">Pending</span>';
		$action_content = '<button data-id="'.$booking_id.'" data-faculty="'.$faculty_id.'" class="accept-row btn btn-success btn-xs p-l-10 p-r-10"><i class="fa fa-check"></i> Select</button>';
		
		$result = array('status' => 'ok', 'status_content' => $status_content, 'action_content' => $action_content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
}
