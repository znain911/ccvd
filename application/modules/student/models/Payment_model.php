<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_model extends CI_Model{
	
	public function get_student_payments()
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT * FROM starter_ipn WHERE starter_ipn.ipn_student_id='$student_id' ORDER BY starter_ipn.ipn_id ASC");
		return $query->result_array();
	}
	
}