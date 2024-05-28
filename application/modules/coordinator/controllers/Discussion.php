<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Discussion extends CI_Controller {
	
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
		
		$check_permission = $this->Perm_model->check_permissionby_admin($active_user, 6);
		if($check_permission == true){ echo null; }else{ redirect('not-found'); }
		
		$this->sqtoken = $this->security->get_csrf_token_name();
		$this->sqtoken_hash = $this->security->get_csrf_hash();
		
		$this->load->model('Discussion_model');
	}
	
	/**************************/
	/*******START FACULTIES CHAT********/
	/**************************/
	
	public function withfaculty()
	{
		$this->load->view('discussion/withfaculty');
	}
	
	public function sendtofaculty()
	{
		//send message to faculty
		$send_data = array(
						'ctof_chat_id' => $this->input->post('selected_chat'),
						'ctof_user_type' => 'Coordinator',
						'ctof_messages' => html_escape($this->input->post('cnv_text')),
						'ctof_date' => date("Y-m-d H:i:s"),
					 );
		$this->Discussion_model->send_message_tofaculty($send_data);
		
		$sess['selchat'] = $this->input->post('selected_chat');
		$this->session->set_userdata($sess);
		echo $this->conversation_between_candf();
		exit;
	}
	
	public function withstudent()
	{
		$this->load->view('discussion/withstudent');
	}
	
	public function get_conversationby_faculty()
	{
		$faculty_id = $this->input->post('faculty');
		$coordinator_id = $this->session->userdata('active_user');
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
		$content = $this->load->view('discussion/faculties_chat', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function get_conversationby_student()
	{
		$data['teacher_id'] = $this->input->post('faculty');
		$data['dsp_conversation'] = TRUE;
		$content = $this->load->view('discussion/faculties_chat', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
}
