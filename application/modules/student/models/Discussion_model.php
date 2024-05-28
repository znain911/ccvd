<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Discussion_model extends CI_Model {
	
	public function get_coordinators()
	{
		$query = $this->db->query("SELECT * FROM starter_owner ORDER BY starter_owner.owner_id ASC");
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
	
	public function send_message_tocoordinator($data)
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