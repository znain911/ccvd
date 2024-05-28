<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Course_model extends CI_Model{
	
	public function phaseexam_available_schedule($phase_id)
	{
		$query = $this->db->query("SELECT * FROM starter_phase_exschedule 
								   WHERE starter_phase_exschedule.endmschedule_phase_id='$phase_id' 
								   AND starter_phase_exschedule.endmschedule_status=1 
								   ORDER BY starter_phase_exschedule.endmschedule_id DESC LIMIT 1");
		return $query->row_array();
	}
	
	public function sdt_available_schedule($phase_id)
	{
		$query = $this->db->query("SELECT * FROM starter_sdt_schedule 
								   WHERE starter_sdt_schedule.endmschedule_phase_id='$phase_id' 
								   AND starter_sdt_schedule.endmschedule_status=1 
								   ORDER BY starter_sdt_schedule.endmschedule_id DESC LIMIT 1");
		return $query->row_array();
	}
	
	public function ece_available_schedule()
	{
		$query = $this->db->query("SELECT * FROM starter_ece_exschedule  
								   WHERE starter_ece_exschedule.endmschedule_status=1 
								   ORDER BY starter_ece_exschedule.endmschedule_id DESC LIMIT 1");
		return $query->row_array();
	}
	
	public function get_sdt_centerschedules($endmschedule_id)
	{
		$query = $this->db->query("SELECT * FROM starter_sdt_centerschdl 
								   LEFT JOIN starter_centers ON
								   starter_centers.center_id=starter_sdt_centerschdl.centerschdl_center_id
								   WHERE starter_sdt_centerschdl.centerschdl_parentschdl_id='$endmschedule_id'
								   AND starter_sdt_centerschdl.centerschdl_maximum_sit<>'0'
								   ORDER BY starter_sdt_centerschdl.centerschdl_id ASC
								   ");
		return $query->result_array();
	}
	
	public function get_centerschedules($endmschedule_id)
	{
		$query = $this->db->query("SELECT * FROM starter_phase_centerschdl 
								   LEFT JOIN starter_centers ON
								   starter_centers.center_id=starter_phase_centerschdl.centerschdl_center_id
								   WHERE starter_phase_centerschdl.centerschdl_parentschdl_id='$endmschedule_id'
								   AND starter_phase_centerschdl.centerschdl_maximum_sit<>'0'
								   ORDER BY starter_phase_centerschdl.centerschdl_id ASC
								   ");
		return $query->result_array();
	}
	
	public function get_ece_centerschedules($endmschedule_id)
	{
		$query = $this->db->query("SELECT * FROM starter_ece_centerschdl 
								   LEFT JOIN starter_centers ON
								   starter_centers.center_id=starter_ece_centerschdl.centerschdl_center_id
								   WHERE starter_ece_centerschdl.centerschdl_parentschdl_id='$endmschedule_id'
								   AND starter_ece_centerschdl.centerschdl_maximum_sit<>'0'
								   ORDER BY starter_ece_centerschdl.centerschdl_id ASC
								   ");
		return $query->result_array();
	}
	
	public function get_total_applications()
	{
		$query = $this->db->query("SELECT booking_id FROM starter_phaseexam_booking");
		return 10000+$query->num_rows()+1;
	}
	
	public function get_total_sdtapplications()
	{
		$query = $this->db->query("SELECT booking_id FROM starter_sdt_booking");
		return 10000+$query->num_rows()+1;
	}
	
	public function get_total_eceapplications()
	{
		$query = $this->db->query("SELECT booking_id FROM starter_eceexam_booking");
		return 10000+$query->num_rows()+1;
	}
	
	public function check_phase_alrbooked($from_date, $to_date, $phase_id)
	{
		$teacher_id = $this->session->userdata('active_teacher');
		$query = $this->db->query("SELECT * FROM starter_phaseexam_booking
								   WHERE starter_phaseexam_booking.booking_user_id='$teacher_id'
								   AND starter_phaseexam_booking.booking_user_type='Student'
								   AND starter_phaseexam_booking.booking_phase_level='$phase_id'
								   AND starter_phaseexam_booking.booking_date <= '$to_date'
								   AND starter_phaseexam_booking.booking_date >= '$from_date'
								 ");
		return $query->row_array();
	}
	
	public function check_sdt_alrbooked($from_date, $to_date, $phase_id)
	{
		$teacher_id = $this->session->userdata('active_teacher');
		$query = $this->db->query("SELECT * FROM starter_sdt_booking
								   WHERE starter_sdt_booking.booking_user_id='$teacher_id'
								   AND starter_sdt_booking.booking_user_type='Student'
								   AND starter_sdt_booking.booking_phase_level='$phase_id'
								   AND starter_sdt_booking.booking_date <= '$to_date'
								   AND starter_sdt_booking.booking_date >= '$from_date'
								 ");
		return $query->row_array();
	}
	
	public function check_ece_alrbooked($from_date, $to_date)
	{
		$teacher_id = $this->session->userdata('active_teacher');
		$query = $this->db->query("SELECT * FROM starter_eceexam_booking
								   WHERE starter_eceexam_booking.booking_user_id='$teacher_id'
								   AND starter_eceexam_booking.booking_user_type='Student'
								   AND starter_eceexam_booking.booking_date <= '$to_date'
								   AND starter_eceexam_booking.booking_date >= '$from_date'
								 ");
		return $query->row_array();
	}
	
	public function get_center_location($centerschdl_id)
	{
		$query = $this->db->query("SELECT 
									starter_phase_centerschdl.*, 
									starter_centers.center_location 
									FROM starter_phase_centerschdl
									LEFT JOIN starter_centers ON
									starter_centers.center_id=starter_phase_centerschdl.centerschdl_center_id
									WHERE starter_phase_centerschdl.centerschdl_id='$centerschdl_id'
									LIMIT 1
								  ");
		return $query->row_array();
	}
	
	public function get_sdtcenter_location($centerschdl_id)
	{
		$query = $this->db->query("SELECT 
									starter_sdt_centerschdl.*, 
									starter_centers.center_location 
									FROM starter_sdt_centerschdl
									LEFT JOIN starter_centers ON
									starter_centers.center_id=starter_sdt_centerschdl.centerschdl_center_id
									WHERE starter_sdt_centerschdl.centerschdl_id='$centerschdl_id'
									LIMIT 1
								  ");
		return $query->row_array();
	}
	
	public function get_ececenter_location($centerschdl_id)
	{
		$query = $this->db->query("SELECT 
									starter_ece_centerschdl.*, 
									starter_centers.center_location 
									FROM starter_ece_centerschdl
									LEFT JOIN starter_centers ON
									starter_centers.center_id=starter_ece_centerschdl.centerschdl_center_id
									WHERE starter_ece_centerschdl.centerschdl_id='$centerschdl_id'
									LIMIT 1
								  ");
		return $query->row_array();
	}
	
	
	/****************/
	/*****START WORKSHOP SCHEDULE******/
	/****************/
	
	public function workshop_available_schedule($phase_id)
	{
		$query = $this->db->query("SELECT * FROM starter_workshop_schedule 
								   WHERE starter_workshop_schedule.endmschedule_phase_id='$phase_id' 
								   AND starter_workshop_schedule.endmschedule_status=1 
								   ORDER BY starter_workshop_schedule.endmschedule_id DESC LIMIT 1");
		return $query->row_array();
	}
	
	public function get_workshop_centerschedules($endmschedule_id)
	{
		$query = $this->db->query("SELECT * FROM starter_workshop_centerschdl 
								   LEFT JOIN starter_centers ON
								   starter_centers.center_id=starter_workshop_centerschdl.centerschdl_center_id
								   WHERE starter_workshop_centerschdl.centerschdl_parentschdl_id='$endmschedule_id'
								   AND starter_workshop_centerschdl.centerschdl_maximum_sit<>'0'
								   ORDER BY starter_workshop_centerschdl.centerschdl_id ASC
								   ");
		return $query->result_array();
	}
	
	public function get_total_workshopapplications()
	{
		$query = $this->db->query("SELECT booking_id FROM starter_workshop_booking");
		return 10000+$query->num_rows()+1;
	}
	
	public function check_workshop_alrbooked($from_date, $to_date, $phase_id)
	{
		$teacher_id = $this->session->userdata('active_teacher');
		$query = $this->db->query("SELECT * FROM starter_workshop_booking
								   WHERE starter_workshop_booking.booking_user_id='$teacher_id'
								   AND starter_workshop_booking.booking_user_type='Student'
								   AND starter_workshop_booking.booking_phase_level='$phase_id'
								   AND starter_workshop_booking.booking_date <= '$to_date'
								   AND starter_workshop_booking.booking_date >= '$from_date'
								 ");
		return $query->row_array();
	}
	
	public function get_workshopcenter_location($centerschdl_id)
	{
		$query = $this->db->query("SELECT 
									starter_workshop_centerschdl.*, 
									starter_centers.center_location 
									FROM starter_workshop_centerschdl
									LEFT JOIN starter_centers ON
									starter_centers.center_id=starter_workshop_centerschdl.centerschdl_center_id
									WHERE starter_workshop_centerschdl.centerschdl_id='$centerschdl_id'
									LIMIT 1
								  ");
		return $query->row_array();
	}
	
	/****************/
	/*****START WORKSHOP SCHEDULE******/
	/****************/
	
	
	/****************/
	/*****START F2F SCHEDULE******/
	/****************/
	
	public function get_ftwof_sessions()
	{
		$now_date = date("Y-m-d");
		$query = $this->db->query("SELECT * FROM starter_ftwof_schedule
								   LEFT JOIN starter_phases ON
								   starter_phases.phase_id=starter_ftwof_schedule.endmschedule_phase_id
								   WHERE starter_ftwof_schedule.endmschedule_status=1 
								   AND starter_ftwof_schedule.endmschedule_from_date <= '$now_date' 
								   AND starter_ftwof_schedule.endmschedule_to_date >= '$now_date' 
								   ORDER BY starter_ftwof_schedule.endmschedule_id DESC");
		return $query->result_array();
	}
	
	public function get_phase_schedules($phase_id)
	{
		$now_date = date("Y-m-d");
		$query = $this->db->query("SELECT * FROM starter_phase_exschedule
								   LEFT JOIN starter_phases ON
								   starter_phases.phase_id=starter_phase_exschedule.endmschedule_phase_id
								   WHERE starter_phase_exschedule.endmschedule_phase_id='$phase_id'
								   AND starter_phase_exschedule.endmschedule_status=1 
								   AND starter_phase_exschedule.endmschedule_from_date <= '$now_date' 
								   AND starter_phase_exschedule.endmschedule_to_date >= '$now_date' 
								   ORDER BY starter_phase_exschedule.endmschedule_id DESC
								   ");
		return $query->result_array();
	}
	
	public function get_ece_schedules()
	{
		$now_date = date("Y-m-d");
		$query = $this->db->query("SELECT * FROM starter_ece_exschedule
								   WHERE starter_ece_exschedule.endmschedule_status=1 
								   AND starter_ece_exschedule.endmschedule_from_date > '$now_date'
								   ORDER BY starter_ece_exschedule.endmschedule_id DESC
								   ");
		return $query->result_array();
	}
	
	public function get_sdt_schedules()
	{
		$now_date = date("Y-m-d");
		$query = $this->db->query("SELECT * FROM starter_sdt_schedule
								   LEFT JOIN starter_phases ON
								   starter_phases.phase_id=starter_sdt_schedule.endmschedule_phase_id
								   WHERE starter_sdt_schedule.endmschedule_status=1 
								   AND starter_sdt_schedule.endmschedule_from_date > '$now_date'  
								   ORDER BY starter_sdt_schedule.endmschedule_id DESC
								   ");
		return $query->result_array();
	}
	
	public function get_workshop_schedules()
	{
		$now_date = date("Y-m-d");
		$query = $this->db->query("SELECT * FROM starter_workshop_schedule
								   LEFT JOIN starter_phases ON
								   starter_phases.phase_id=starter_workshop_schedule.endmschedule_phase_id
								   WHERE starter_workshop_schedule.endmschedule_status=1 
								   AND starter_workshop_schedule.endmschedule_from_date > '$now_date' 
								   ORDER BY starter_workshop_schedule.endmschedule_id DESC
								   ");
		return $query->result_array();
	}
	
	public function get_ftwof_centerschedules($endmschedule_id)
	{
		$query = $this->db->query("SELECT * FROM starter_ftwo_centerschdl 
								   LEFT JOIN starter_centers ON
								   starter_centers.center_id=starter_ftwo_centerschdl.centerschdl_center_id
								   WHERE starter_ftwo_centerschdl.centerschdl_parentschdl_id='$endmschedule_id'
								   AND starter_ftwo_centerschdl.centerschdl_maximum_sit<>'0'
								   ORDER BY starter_ftwo_centerschdl.centerschdl_id ASC
								   ");
		return $query->result_array();
	}
	
	public function get_total_ftwofapplications()
	{
		$query = $this->db->query("SELECT booking_id FROM starter_ftwof_booking");
		return 10000+$query->num_rows()+1;
	}
	
	public function check_ftwof_alrbooked($from_date, $to_date, $phase_id)
	{
		$teacher_id = $this->session->userdata('active_teacher');
		$query = $this->db->query("SELECT * FROM starter_ftwof_booking
								   WHERE starter_ftwof_booking.booking_user_id='$teacher_id'
								   AND starter_ftwof_booking.booking_user_type='Student'
								   AND starter_ftwof_booking.booking_phase_level='$phase_id'
								   AND starter_ftwof_booking.booking_date <= '$to_date'
								   AND starter_ftwof_booking.booking_date >= '$from_date'
								 ");
		return $query->row_array();
	}
	
	public function get_ftwofcenter_location($centerschdl_id)
	{
		$query = $this->db->query("SELECT 
									starter_ftwo_centerschdl.*, 
									starter_centers.center_location 
									FROM starter_ftwo_centerschdl
									LEFT JOIN starter_centers ON
									starter_centers.center_id=starter_ftwo_centerschdl.centerschdl_center_id
									WHERE starter_ftwo_centerschdl.centerschdl_id='$centerschdl_id'
									LIMIT 1
								  ");
		return $query->row_array();
	}
	
	public function teacherinfo()
	{
		$teacher_id = $this->session->userdata('active_teacher');
		$query = $this->db->query("SELECT * FROM starter_teachers WHERE starter_teachers.teacher_id='$teacher_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_ftwof_booked()
	{
		$teacher_id = $this->session->userdata('active_teacher');
		$query = $this->db->query("SELECT 
								   starter_ftwof_booking.*, 
								   starter_phases.phase_name, 
								   starter_ftwof_schedule.endmschedule_title
								   FROM starter_ftwof_booking
								   LEFT JOIN starter_phases ON
								   starter_phases.phase_id=starter_ftwof_booking.booking_phase_level
								   LEFT JOIN starter_ftwof_schedule ON
								   starter_ftwof_schedule.endmschedule_id=starter_ftwof_booking.booking_schedule_id
								   WHERE starter_ftwof_booking.booking_user_id='$teacher_id'
								   AND starter_ftwof_booking.booking_user_type='Faculty'
								 ");
		return $query->result_array();
	}
	
	public function get_phase_booked($phase_id)
	{
		$teacher_id = $this->session->userdata('active_teacher');
		$query = $this->db->query("SELECT 
								   starter_phaseexam_booking.*, 
								   starter_phases.phase_name, 
								   starter_phase_exschedule.endmschedule_title
								   FROM starter_phaseexam_booking
								   LEFT JOIN starter_phases ON
								   starter_phases.phase_id=starter_phaseexam_booking.booking_phase_level
								   LEFT JOIN starter_phase_exschedule ON
								   starter_phase_exschedule.endmschedule_id=starter_phaseexam_booking.booking_schedule_id
								   WHERE starter_phaseexam_booking.booking_user_id='$teacher_id'
								   AND starter_phaseexam_booking.booking_user_type='Faculty'
								   AND starter_phaseexam_booking.booking_phase_level='$phase_id'
								 ");
		return $query->result_array();
	}
	
	public function get_sdt_booked()
	{
		$teacher_id = $this->session->userdata('active_teacher');
		$query = $this->db->query("SELECT 
								   starter_sdt_booking.*, 
								   starter_phases.phase_name, 
								   starter_sdt_schedule.endmschedule_title
								   FROM starter_sdt_booking
								   LEFT JOIN starter_phases ON
								   starter_phases.phase_id=starter_sdt_booking.booking_phase_level
								   LEFT JOIN starter_sdt_schedule ON
								   starter_sdt_schedule.endmschedule_id=starter_sdt_booking.booking_schedule_id
								   WHERE starter_sdt_booking.booking_user_id='$teacher_id'
								   AND starter_sdt_booking.booking_user_type='Faculty'
								 ");
		return $query->result_array();
	}
	
	public function get_workshop_booked()
	{
		$teacher_id = $this->session->userdata('active_teacher');
		$query = $this->db->query("SELECT 
								   starter_workshop_booking.*, 
								   starter_phases.phase_name, 
								   starter_workshop_schedule.endmschedule_title
								   FROM starter_workshop_booking
								   LEFT JOIN starter_phases ON
								   starter_phases.phase_id=starter_workshop_booking.booking_phase_level
								   LEFT JOIN starter_workshop_schedule ON
								   starter_workshop_schedule.endmschedule_id=starter_workshop_booking.booking_schedule_id
								   WHERE starter_workshop_booking.booking_user_id='$teacher_id'
								   AND starter_workshop_booking.booking_user_type='Faculty'
								 ");
		return $query->result_array();
	}
	
	public function get_ece_booked()
	{
		$teacher_id = $this->session->userdata('active_teacher');
		$query = $this->db->query("SELECT 
								   starter_eceexam_booking.*,  
								   starter_ece_exschedule.endmschedule_title
								   FROM starter_eceexam_booking
								   LEFT JOIN starter_ece_exschedule ON
								   starter_ece_exschedule.endmschedule_id=starter_eceexam_booking.booking_schedule_id
								   WHERE starter_eceexam_booking.booking_user_id='$teacher_id'
								   AND starter_eceexam_booking.booking_user_type='Faculty'
								 ");
		return $query->result_array();
	}
	
	/****************/
	/*****START F2F SCHEDULE******/
	/****************/
	
	
	public function my_sdt_programmes()
	{
		$teacher_id = $this->session->userdata('active_teacher');
		$query = $this->db->query("SELECT *
								   FROM starter_sdt_programme
								   
								   LEFT JOIN starter_sdt_booking ON
								   starter_sdt_booking.booking_id=starter_sdt_programme.programme_bookingid
								   
								   LEFT JOIN starter_sdt_schedule ON
								   starter_sdt_schedule.endmschedule_id=starter_sdt_booking.booking_schedule_id
								   
								   LEFT JOIN starter_sdt_centerschdl ON
								   starter_sdt_centerschdl.centerschdl_id=starter_sdt_booking.booking_schedule_centerid
								   
								   LEFT JOIN starter_centers ON
								   starter_centers.center_id=starter_sdt_centerschdl.centerschdl_center_id
								   
								   WHERE starter_sdt_programme.programme_facultyid='$teacher_id'
								   AND starter_sdt_programme.programme_status=1
								   ORDER BY programme_id ASC
								  ");
		return $query->result_array();
	}
	
	public function my_workshop_programmes()
	{
		$teacher_id = $this->session->userdata('active_teacher');
		$query = $this->db->query("SELECT *
								   FROM starter_workshop_programme
								   
								   LEFT JOIN starter_workshop_booking ON
								   starter_workshop_booking.booking_id=starter_workshop_programme.programme_bookingid
								   
								   LEFT JOIN starter_workshop_schedule ON
								   starter_workshop_schedule.endmschedule_id=starter_workshop_booking.booking_schedule_id
								   
								   LEFT JOIN starter_workshop_centerschdl ON
								   starter_workshop_centerschdl.centerschdl_id=starter_workshop_booking.booking_schedule_centerid
								   
								   LEFT JOIN starter_centers ON
								   starter_centers.center_id=starter_workshop_centerschdl.centerschdl_center_id
								   
								   WHERE starter_workshop_programme.programme_facultyid='$teacher_id'
								   AND starter_workshop_programme.programme_status=1
								   ORDER BY programme_id ASC
								  ");
		return $query->result_array();
	}
	
	public function my_ece_programmes()
	{
		$teacher_id = $this->session->userdata('active_teacher');
		$query = $this->db->query("SELECT *
								   FROM starter_ece_programme
								   
								   LEFT JOIN starter_eceexam_booking ON
								   starter_eceexam_booking.booking_id=starter_ece_programme.programme_bookingid
								   
								   LEFT JOIN starter_ece_exschedule ON
								   starter_ece_exschedule.endmschedule_id=starter_eceexam_booking.booking_schedule_id
								   
								   LEFT JOIN starter_ece_centerschdl ON
								   starter_ece_centerschdl.centerschdl_id=starter_eceexam_booking.booking_schedule_centerid
								   
								   LEFT JOIN starter_centers ON
								   starter_centers.center_id=starter_ece_centerschdl.centerschdl_center_id
								   
								   WHERE starter_ece_programme.programme_facultyid='$teacher_id'
								   AND starter_ece_programme.programme_status=1
								   ORDER BY programme_id ASC
								  ");
		return $query->result_array();
	}
	
	public function check_sdtbooking_status($booking_id)
	{
		$teacher_id = $this->session->userdata('active_teacher');
		$query = $this->db->query("SELECT programme_status FROM starter_sdt_programme 
								   WHERE starter_sdt_programme.programme_bookingid='$booking_id'
								   AND starter_sdt_programme.programme_facultyid='$teacher_id'
								   LIMIT 1
								   ");
		return $query->row_array();
	}
	
	public function check_workshopbooking_status($booking_id)
	{
		$teacher_id = $this->session->userdata('active_teacher');
		$query = $this->db->query("SELECT programme_status FROM starter_workshop_programme 
								   WHERE starter_workshop_programme.programme_bookingid='$booking_id'
								   AND starter_workshop_programme.programme_facultyid='$teacher_id'
								   LIMIT 1
								   ");
		return $query->row_array();
	}
	
	public function check_ecebooking_status($booking_id)
	{
		$teacher_id = $this->session->userdata('active_teacher');
		$query = $this->db->query("SELECT programme_status FROM starter_ece_programme 
								   WHERE starter_ece_programme.programme_bookingid='$booking_id'
								   AND starter_ece_programme.programme_facultyid='$teacher_id'
								   LIMIT 1
								   ");
		return $query->row_array();
	}
	
	public function get_sdt_applied_students($schedule_id, $schedule_centershdl_id)
	{
		$query = $this->db->query("SELECT *
								   FROM starter_sdt_booking
								   LEFT JOIN starter_sdt_scoreboard ON
								   starter_sdt_scoreboard.scrboard_booking_id=starter_sdt_booking.booking_id
								   LEFT JOIN starter_students ON
								   starter_students.student_id=starter_sdt_booking.booking_user_id
								   LEFT JOIN starter_students_personalinfo ON
								   starter_students_personalinfo.spinfo_student_id=starter_sdt_booking.booking_user_id
								   LEFT JOIN starter_sdt_centerschdl ON
								   starter_sdt_centerschdl.centerschdl_id=starter_sdt_booking.booking_schedule_centerid
								   LEFT JOIN starter_centers ON
								   starter_centers.center_id=starter_sdt_centerschdl.centerschdl_center_id
								   WHERE starter_sdt_booking.booking_schedule_id='$schedule_id'
								   AND starter_sdt_booking.booking_schedule_centerid='$schedule_centershdl_id'
								   AND starter_sdt_booking.booking_user_type='Student'
								   AND starter_sdt_booking.booking_status=1
								   ORDER BY starter_sdt_booking.booking_id ASC
								  ");
		return $query->result_array();
	}
	
	public function get_workshop_applied_students($schedule_id, $schedule_centershdl_id)
	{
		$query = $this->db->query("SELECT *
								   FROM starter_workshop_booking
								   LEFT JOIN starter_workshop_scoreboard ON
								   starter_workshop_scoreboard.scrboard_booking_id=starter_workshop_booking.booking_id
								   LEFT JOIN starter_students ON
								   starter_students.student_id=starter_workshop_booking.booking_user_id
								   LEFT JOIN starter_students_personalinfo ON
								   starter_students_personalinfo.spinfo_student_id=starter_workshop_booking.booking_user_id
								   LEFT JOIN starter_workshop_centerschdl ON
								   starter_workshop_centerschdl.centerschdl_id=starter_workshop_booking.booking_schedule_centerid
								   LEFT JOIN starter_centers ON
								   starter_centers.center_id=starter_workshop_centerschdl.centerschdl_center_id
								   WHERE starter_workshop_booking.booking_schedule_id='$schedule_id'
								   AND starter_workshop_booking.booking_schedule_centerid='$schedule_centershdl_id'
								   AND starter_workshop_booking.booking_user_type='Student'
								   AND starter_workshop_booking.booking_status=1
								   ORDER BY starter_workshop_booking.booking_id ASC
								  ");
		return $query->result_array();
	}
	
	public function save_sdt_scores($data)
	{
		$this->db->insert('starter_sdt_scoreboard', $data);
	}
	
	public function save_workshop_scores($data)
	{
		$this->db->insert('starter_workshop_scoreboard', $data);
	}
	
}