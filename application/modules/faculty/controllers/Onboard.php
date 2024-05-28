<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Onboard extends CI_Controller{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Registration_model');
	}
	
	public function index()
	{
		redirect(base_url('faculty/onboard/account'), 'refresh', true);
	}
	
	public function account()
	{
		if($this->session->userdata('account_completed_teacher') === TRUE)
		{
			redirect('faculty/onboard/personal', 'refresh', true);
		}else{
			$data['template'] = 'account';
			$this->load->view('registration', $data);
		}
	}
	
	public function personal()
	{
		if($this->session->userdata('account_completed_teacher') === TRUE)
		{
			if($this->session->userdata('personal_completed_teacher') === TRUE)
			{
				redirect('faculty/onboard/academic', 'refresh', true);
			}else
			{
				$data['template'] = 'personal';
				$this->load->view('registration', $data);
			}
		}else
		{
			redirect('faculty/onboard/account', 'refresh', true);
		}
	}
	
	public function academic()
	{
		if($this->session->userdata('personal_completed_teacher') === TRUE)
		{
			if($this->session->userdata('academic_completed_teacher') === TRUE)
			{
				redirect('faculty/onboard/approval', 'refresh', true);
			}else{
				$data['template'] = 'academic';
				$this->load->view('registration', $data);
			}
		}else
		{
			redirect('faculty/onboard/personal', 'refresh', true);
		}
	}
	
	public function approval()
	{
		if($this->session->userdata('academic_completed_teacher') === TRUE)
		{
			//unset session data
			$this->session->unset_userdata('wizard_username_teacher');
			$this->session->unset_userdata('wizard_teacher_id');
			$this->session->unset_userdata('account_completed_teacher');
			$this->session->unset_userdata('personal_completed_teacher');
			$this->session->unset_userdata('academic_completed_teacher');
			
			$data['template'] = 'approval';
			$this->load->view('registration', $data);
		}else
		{
			redirect('faculty/onboard/academic', 'refresh', true);
		}
	}
	
}