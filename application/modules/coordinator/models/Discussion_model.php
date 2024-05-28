<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Discussion_model extends CI_Model {
	
	public function get_faculties()
	{
		$query = $this->db->query("SELECT 
								   starter_teachers.teacher_id,
								   starter_teachers.teacher_username,
								   starter_teachers_personalinfo.tpinfo_first_name,
								   starter_teachers_personalinfo.tpinfo_middle_name,
								   starter_teachers_personalinfo.tpinfo_last_name,
								   starter_teachers_personalinfo.tpinfo_photo
								   FROM starter_teachers
								   LEFT JOIN starter_teachers_personalinfo ON
								   starter_teachers_personalinfo.tpinfo_teacher_id=starter_teachers.teacher_id
								   WHERE starter_teachers.teacher_status=1
								   ORDER BY starter_teachers.teacher_id ASC
								  ");
		return $query->result_array();
	}
	
	public function get_chathistory($chat_id)
	{
		$query = $this->db->query("SELECT * FROM starter_ctof_conversation
								   WHERE starter_ctof_conversation.ctof_chat_id='$chat_id'
								   ORDER BY starter_ctof_conversation.ctof_id ASC
								  ");
		return $query->result_array();
	}
	
	public function send_message_tofaculty($data)
	{
		$this->db->insert('starter_ctof_conversation', $data);
	}
	
	public function save_chat_request($data)
	{
		$this->db->insert('starter_ctof_chat', $data);
	}
	
	public function check_chat_request($faculty_id, $coordinator_id)
	{
		$query = $this->db->query("SELECT chat_id FROM starter_ctof_chat WHERE starter_ctof_chat.chat_faculty_id='$faculty_id' AND starter_ctof_chat.chat_coordinator_id='$coordinator_id' LIMIT 1");
		return $query->row_array();
	}
	
}
