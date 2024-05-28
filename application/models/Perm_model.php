<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perm_model extends CI_Model{
	
	public function check_permissionby_admin($admin_id, $permission_id)
	{
		$query = $this->db->query("SELECT permission_id FROM starter_admin_permission 
		                           WHERE starter_admin_permission.permission_adminid='$admin_id' 
		                           AND starter_admin_permission.permission_permission_id='$permission_id' 
								   ");
		return $query->row_array();
	}
	
	public function get_sdt_schedules($phase_id)
	{
		$query = $this->db->query("SELECT * FROM starter_sdt_schedule WHERE starter_sdt_schedule.endmschedule_phase_id='$phase_id' ORDER BY endmschedule_id ASC");
		return $query->result_array();
	}
	
	public function get_workshop_schedules($phase_id)
	{
		$query = $this->db->query("SELECT * FROM starter_workshop_schedule WHERE starter_workshop_schedule.endmschedule_phase_id='$phase_id' ORDER BY endmschedule_id ASC");
		return $query->result_array();
	}
	
	public function check_student_ece_status()
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT * FROM starter_students 
								   WHERE starter_students.student_phaselevel_id='0' 
								   AND starter_students.student_ece_status=1 
								   AND starter_students.student_id='$student_id' 
								   LIMIT 1");
		return $query->row_array();
	}
	
	public function check_ece_schedule()
	{
		$current_date = date("Y-m-d");
		$query = $this->db->query("SELECT * FROM starter_ece_exschedule WHERE endmschedule_from_date > '$current_date'");
		return $query->row_array();
	}
	
	public function total_phone_change_request()
	{
		$query = $this->db->query("SELECT spinfo_id FROM starter_students_personalinfo WHERE starter_students_personalinfo.spinfo_personal_phone_updaterqst='YES'");
		return $query->num_rows();
	}
	
	
	
}
