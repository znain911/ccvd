<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model{
	
	public function get_student_information()
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT 
								   * 
								   FROM starter_students
								   LEFT JOIN starter_students_personalinfo ON
								   starter_students_personalinfo.spinfo_student_id=starter_students.student_id
								   LEFT JOIN starter_phases ON
								   starter_phases.phase_id=starter_students.student_phaselevel_id
								   WHERE starter_students.student_id='$student_id'
								   ");
		return $query->row_array();
	}
	
	public function get_dahboard_notifications()
	{
		$student_id = $this->session->userdata('active_student');
		$get_student = $this->db->query("SELECT student_phaselevel_id, student_ece_status, student_regdate FROM starter_students WHERE starter_students.student_id='$student_id' LIMIT 1");
		$std_result = $get_student->row_array();
		
		$regdate = date("Y-m-d", strtotime($std_result['student_regdate']));
		
		$phase_id = $std_result['student_phaselevel_id'];
		$ece_status = $std_result['student_ece_status'];
		if($phase_id !== '0' && $ece_status == '0')
		{
			$query = $this->db->query("SELECT * FROM starter_schedule_notification WHERE starter_schedule_notification.notif_phase_level='$phase_id' AND notif_create_date >= '$regdate' ORDER BY notif_id DESC");
		}elseif($phase_id == '0' && $ece_status == '1'){
			$query = $this->db->query("SELECT * FROM starter_schedule_notification WHERE starter_schedule_notification.notif_ece_students='$ece_status' AND notif_create_date >= '$regdate' ORDER BY notif_id DESC");
		}
		
		return $query->result_array();
	}
	
	public function get_sdt_schedule_dates()
	{
		$active_phase = $this->session->userdata('active_phase');
		$reg_date = $this->session->userdata('student_reg_date');
		$query = $this->db->query("SELECT endmschedule_title, endmschedule_from_date, endmschedule_to_date 
								   FROM starter_sdt_schedule 
								   WHERE starter_sdt_schedule.endmschedule_status=1 
								   AND starter_sdt_schedule.endmschedule_phase_id='$active_phase'
								   AND endmschedule_create_date >= '$reg_date'
								   ");
		return $query->result_array();
	}
	
	public function get_workshop_schedule_dates()
	{
		$active_phase = $this->session->userdata('active_phase');
		$reg_date = $this->session->userdata('student_reg_date');
		$query = $this->db->query("SELECT endmschedule_title, endmschedule_from_date, endmschedule_to_date 
								   FROM starter_workshop_schedule 
								   WHERE starter_workshop_schedule.endmschedule_status=1 
								   AND starter_workshop_schedule.endmschedule_phase_id='$active_phase'
								   AND endmschedule_create_date >= '$reg_date'
								   ");
		return $query->result_array();
	}
	
	public function get_ece_schedule_dates()
	{
		$active_phase = $this->session->userdata('active_phase');
		$reg_date = $this->session->userdata('student_reg_date');
		$query = $this->db->query("SELECT endmschedule_title, endmschedule_from_date, endmschedule_to_date 
								   FROM starter_ece_exschedule 
								   WHERE starter_ece_exschedule.endmschedule_status=1 
								   AND starter_ece_exschedule.endmschedule_phase_id=''
								   AND endmschedule_create_date >= '$reg_date'
								   ");
		return $query->result_array();
	}
	
}