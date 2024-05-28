<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Schedules extends CI_Controller{
	
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
		$this->load->model('Course_model');
	}
	
	public function index()
	{
		$this->load->view('schedules');
	}
	
	public function ftwof()
	{
		$this->load->view('ftwof_session');
	}
	
	public function phase()
	{
		if(isset($_GET['level']) && $_GET['level'] === 'A'){
			$data['phase_level'] = 1;
			$data['phase_title'] = 'Phase A';
			$this->load->view('phase_schedules', $data);
		}elseif(isset($_GET['level']) && $_GET['level'] === 'B'){
			$data['phase_level'] = 2;
			$data['phase_title'] = 'Phase B';
			$this->load->view('phase_schedules', $data);
		}elseif(isset($_GET['level']) && $_GET['level'] === 'C'){
			$data['phase_level'] = 3;
			$data['phase_title'] = 'Phase C';
			$this->load->view('phase_schedules', $data);
		}else
		{
			redirect('not-found');
		}
	}
	public function ece()
	{
		$this->load->view('ece_schedules');
	}
	public function sdt()
	{
		$this->load->view('sdt_schedules');
	}
	public function workshop()
	{
		$this->load->view('workshop_schedules');
	}
	
	public function sdtmarks()
	{
		if(isset($_GET['gt_cntr']) && $_GET['gt_cntr'] !== '' && is_numeric($_GET['gt_cntr']) && isset($_GET['sdl']) && $_GET['sdl'] !== '' && is_numeric($_GET['sdl']))
		{
			$data['schedule_id'] = intval(html_escape($_GET['sdl']));
			$data['schedule_centershdl_id'] = intval(html_escape($_GET['gt_cntr']));
			$this->load->view('upmarks/sdt_marks', $data);
		}else
		{
			redirect('faculty/schedules/sdt', 'refresh', true);
		}
	}
	
	public function workshopmarks()
	{
		if(isset($_GET['gt_cntr']) && $_GET['gt_cntr'] !== '' && is_numeric($_GET['gt_cntr']) && isset($_GET['sdl']) && $_GET['sdl'] !== '' && is_numeric($_GET['sdl']))
		{
			$data['schedule_id'] = intval(html_escape($_GET['sdl']));
			$data['schedule_centershdl_id'] = intval(html_escape($_GET['gt_cntr']));
			$this->load->view('upmarks/workshop_marks', $data);
		}else
		{
			redirect('faculty/schedules/sdt', 'refresh', true);
		}
	}
	
	public function ecemarks()
	{
		if(isset($_GET['gt_cntr']) && $_GET['gt_cntr'] !== '' && is_numeric($_GET['gt_cntr']) && isset($_GET['sdl']) && $_GET['sdl'] !== '' && is_numeric($_GET['sdl']))
		{
			$data['schedule_id'] = intval(html_escape($_GET['sdl']));
			$data['schedule_centershdl_id'] = intval(html_escape($_GET['gt_cntr']));
			$this->load->view('upmarks/ece_marks', $data);
		}else
		{
			redirect('faculty/schedules/sdt', 'refresh', true);
		}
	}
	
	public function sdt_mrks_submit()
	{
		$data = array(
					'scrboard_booking_id'          => $this->input->post('booking'),
					'scrboard_student_id'          => $this->input->post('booking_std'),
					'scrboard_score'               => html_escape($this->input->post('score')),
					'scrboard_total_score'         => html_escape($this->input->post('total_score')),
					'scrboard_published_facultyid' => $this->session->userdata('active_teacher'),
					'scrboard_student_attendence'  => $this->input->post('attendance'),
					'scrboard_published_date'      => date("Y-m-d H:i:s"),
				);
		$this->Course_model->save_sdt_scores($data);
		
		$score = html_escape($this->input->post('score'));
		$total_score = html_escape($this->input->post('total_score'));
		$up_btn_dactve = '<span class="upspan-btn" data-completed="0" style="background:#0a0">Completed</span>';
		
		if($this->input->post('attendance') == '1')
		{
			$attendance = '<strong style="color:#0a0">Present</strong>';
		}elseif($this->input->post('attendance') == '2')
		{
			$attendance = '<strong style="color:#F00">Absent</strong>';
		}
		
		$result = array('status' => 'ok', 'score' => $score, 'total_score' => $total_score, 'attendance' => $attendance, 'up_btn_dactve' => $up_btn_dactve);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function workshop_mrks_submit()
	{
		$data = array(
					'scrboard_booking_id'          => $this->input->post('booking'),
					'scrboard_student_id'          => $this->input->post('booking_std'),
					'scrboard_score'               => html_escape($this->input->post('score')),
					'scrboard_total_score'         => html_escape($this->input->post('total_score')),
					'scrboard_published_facultyid' => $this->session->userdata('active_teacher'),
					'scrboard_student_attendence'  => $this->input->post('attendance'),
					'scrboard_published_date'      => date("Y-m-d H:i:s"),
				);
		$this->Course_model->save_workshop_scores($data);
		
		$score = html_escape($this->input->post('score'));
		$total_score = html_escape($this->input->post('total_score'));
		$up_btn_dactve = '<span class="upspan-btn" data-completed="0" style="background:#0a0">Completed</span>';
		
		if($this->input->post('attendance') == '1')
		{
			$attendance = '<strong style="color:#0a0">Present</strong>';
		}elseif($this->input->post('attendance') == '2')
		{
			$attendance = '<strong style="color:#F00">Absent</strong>';
		}
		
		$result = array('status' => 'ok', 'score' => $score, 'total_score' => $total_score, 'attendance' => $attendance, 'up_btn_dactve' => $up_btn_dactve);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
}