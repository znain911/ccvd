<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model{
	
	public function get_teacher_information()
	{
		$teacher_id = $this->session->userdata('active_teacher');
		$query = $this->db->query("SELECT 
								   * 
								   FROM starter_teachers
								   LEFT JOIN starter_teachers_personalinfo ON
								   starter_teachers_personalinfo.tpinfo_teacher_id=starter_teachers.teacher_id
								   WHERE starter_teachers.teacher_id='$teacher_id'
								   ");
		return $query->row_array();
	}
	
	public function get_dahboard_notifications()
	{
		$query = $this->db->query("SELECT * FROM starter_schedule_notification ORDER BY notif_id DESC");
		return $query->result_array();
	}
	
	public function get_sdt_schedule_dates()
	{
		$query = $this->db->query("SELECT endmschedule_title, endmschedule_from_date, endmschedule_to_date FROM starter_sdt_schedule WHERE starter_sdt_schedule.endmschedule_status=1");
		return $query->result_array();
	}
	
	public function get_workshop_schedule_dates()
	{
		$query = $this->db->query("SELECT endmschedule_title, endmschedule_from_date, endmschedule_to_date FROM starter_workshop_schedule WHERE starter_workshop_schedule.endmschedule_status=1");
		return $query->result_array();
	}
	
	public function get_ece_schedule_dates()
	{
		$query = $this->db->query("SELECT endmschedule_title, endmschedule_from_date, endmschedule_to_date FROM starter_ece_exschedule WHERE starter_ece_exschedule.endmschedule_status=1");
		return $query->result_array();
	}
	
}