<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking_model extends CI_Model {
	
	public function get_phase_applicants($type)
	{
		$query = $this->db->query("SELECT 
									* 
								   FROM starter_phaseexam_booking
								   LEFT JOIN starter_phase_exschedule ON
								   starter_phase_exschedule.endmschedule_id=starter_phaseexam_booking.booking_schedule_id
								   LEFT JOIN starter_phase_centerschdl ON
								   starter_phase_centerschdl.centerschdl_id=starter_phaseexam_booking.booking_schedule_centerid
								   LEFT JOIN starter_phases ON
								   starter_phases.phase_id=starter_phaseexam_booking.booking_phase_level
								   WHERE starter_phaseexam_booking.booking_user_type='$type'
								   ORDER BY starter_phaseexam_booking.booking_id DESC
								 ");
		return $query->result_array();
	}
	
	public function get_workshop_applicants($type)
	{
		$query = $this->db->query("SELECT 
									* 
								   FROM starter_workshop_booking
								   LEFT JOIN starter_phase_exschedule ON
								   starter_phase_exschedule.endmschedule_id=starter_workshop_booking.booking_schedule_id
								   LEFT JOIN starter_workshop_centerschdl ON
								   starter_workshop_centerschdl.centerschdl_id=starter_workshop_booking.booking_schedule_centerid
								   LEFT JOIN starter_phases ON
								   starter_phases.phase_id=starter_workshop_booking.booking_phase_level
								   WHERE starter_workshop_booking.booking_user_type='$type'
								   ORDER BY starter_workshop_booking.booking_id DESC
								 ");
		return $query->result_array();
	}
	
	public function get_sdt_applicants($type)
	{
		$query = $this->db->query("SELECT 
									* 
								   FROM starter_sdt_booking
								   LEFT JOIN starter_sdt_schedule ON
								   starter_sdt_schedule.endmschedule_id=starter_sdt_booking.booking_schedule_id
								   LEFT JOIN starter_sdt_centerschdl ON
								   starter_sdt_centerschdl.centerschdl_id=starter_sdt_booking.booking_schedule_centerid
								   LEFT JOIN starter_phases ON
								   starter_phases.phase_id=starter_sdt_booking.booking_phase_level
								   WHERE starter_sdt_booking.booking_user_type='$type'
								   ORDER BY starter_sdt_booking.booking_id DESC
								 ");
		return $query->result_array();
	}
	
	public function get_ftwof_applicants($type)
	{
		$query = $this->db->query("SELECT 
									* 
								   FROM starter_ftwof_booking
								   LEFT JOIN starter_ftwof_schedule ON
								   starter_ftwof_schedule.endmschedule_id=starter_ftwof_booking.booking_schedule_id
								   LEFT JOIN starter_ftwo_centerschdl ON
								   starter_ftwo_centerschdl.centerschdl_id=starter_ftwof_booking.booking_schedule_centerid
								   LEFT JOIN starter_phases ON
								   starter_phases.phase_id=starter_ftwof_booking.booking_phase_level
								   WHERE starter_ftwof_booking.booking_user_type='$type'
								   ORDER BY starter_ftwof_booking.booking_id DESC
								 ");
		return $query->result_array();
	}
	
	public function get_ece_applicants($type)
	{
		$query = $this->db->query("SELECT 
									* 
								   FROM starter_eceexam_booking
								   LEFT JOIN starter_ece_exschedule ON
								   starter_ece_exschedule.endmschedule_id=starter_eceexam_booking.booking_schedule_id
								   LEFT JOIN starter_ece_centerschdl ON
								   starter_ece_centerschdl.centerschdl_id=starter_eceexam_booking.booking_schedule_centerid
								   WHERE starter_eceexam_booking.booking_user_type='$type'
								   ORDER BY starter_eceexam_booking.booking_id DESC
								 ");
		return $query->result_array();
	}
	
	public function get_student_infos($student_id)
	{
		$query = $this->db->query("SELECT 
								  starter_students.student_entryid,
								  starter_students_personalinfo.spinfo_first_name,
								  starter_students_personalinfo.spinfo_middle_name,
								  starter_students_personalinfo.spinfo_last_name
								  FROM starter_students 
								  LEFT JOIN starter_students_personalinfo ON
								  starter_students_personalinfo.spinfo_student_id=starter_students.student_id
								  WHERE starter_students.student_id='$student_id'
								  LIMIT 1
								  ");
		return $query->row_array();
	}
	
	public function get_teacher_infos($teacher_id)
	{
		$query = $this->db->query("SELECT 
								  starter_teachers.teacher_entryid,
								  starter_teachers_personalinfo.tpinfo_first_name,
								  starter_teachers_personalinfo.tpinfo_middle_name,
								  starter_teachers_personalinfo.tpinfo_last_name
								  FROM starter_teachers
								  LEFT JOIN starter_teachers_personalinfo ON
								  starter_teachers_personalinfo.tpinfo_teacher_id=starter_teachers.teacher_id
								  WHERE starter_teachers.teacher_id='$teacher_id'
								  LIMIT 1
								  ");
		return $query->row_array();
	}
	
	public function get_center_location($center_id)
	{
		$query = $this->db->query("SELECT center_location FROM starter_centers WHERE starter_centers.center_id='$center_id'");
		return $query->row_array();
	}
	
	public function check_sdtbooking_status($booking_id, $teacher_id)
	{
		$query = $this->db->query("SELECT programme_status FROM starter_sdt_programme 
								   WHERE starter_sdt_programme.programme_bookingid='$booking_id'
								   AND starter_sdt_programme.programme_facultyid='$teacher_id'
								   LIMIT 1
								   ");
		return $query->row_array();
	}
	
	public function check_workshopbooking_status($booking_id, $teacher_id)
	{
		$query = $this->db->query("SELECT programme_status FROM starter_workshop_programme 
								   WHERE starter_workshop_programme.programme_bookingid='$booking_id'
								   AND starter_workshop_programme.programme_facultyid='$teacher_id'
								   LIMIT 1
								   ");
		return $query->row_array();
	}
	
	public function check_ecebooking_status($booking_id, $teacher_id)
	{
		$query = $this->db->query("SELECT programme_status FROM starter_ece_programme 
								   WHERE starter_ece_programme.programme_bookingid='$booking_id'
								   AND starter_ece_programme.programme_facultyid='$teacher_id'
								   LIMIT 1
								   ");
		return $query->row_array();
	}
	
	public function save_sdt_programme($data)
	{
		$this->db->insert('starter_sdt_programme', $data);
	}
	
	public function save_workshop_programme($data)
	{
		$this->db->insert('starter_workshop_programme', $data);
	}
	
	public function save_ece_programme($data)
	{
		$this->db->insert('starter_ece_programme', $data);
	}
	
	public function check_sdt_alreadysaved($booking_id, $faculty_id)
	{
		$query = $this->db->query("SELECT programme_id FROM starter_sdt_programme 
								   WHERE starter_sdt_programme.programme_bookingid='$booking_id'
								   AND starter_sdt_programme.programme_facultyid='$faculty_id'
								   LIMIT 1
								   ");
		return $query->row_array();
	}
	
	public function check_workshop_alreadysaved($booking_id, $faculty_id)
	{
		$query = $this->db->query("SELECT programme_id FROM starter_workshop_programme 
								   WHERE starter_workshop_programme.programme_bookingid='$booking_id'
								   AND starter_workshop_programme.programme_facultyid='$faculty_id'
								   LIMIT 1
								   ");
		return $query->row_array();
	}
	
	public function check_ece_alreadysaved($booking_id, $faculty_id)
	{
		$query = $this->db->query("SELECT programme_id FROM starter_ece_programme 
								   WHERE starter_ece_programme.programme_bookingid='$booking_id'
								   AND starter_ece_programme.programme_facultyid='$faculty_id'
								   LIMIT 1
								   ");
		return $query->row_array();
	}
	
}
