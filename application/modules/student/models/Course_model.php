<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Course_model extends CI_Model{
	
	public function get_modulesby_phase($phase_id)
	{
		$query = $this->db->query("SELECT * FROM starter_modules WHERE starter_modules.module_phase_id='$phase_id' ORDER BY starter_modules.module_id ASC");
		return $query->result_array();
	}
	public function check_pass_fail(){
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT cmreport_id,cmreport_status FROM starter_module_progress 
		WHERE cmreport_student_id='$student_id'
		AND cmreport_phase_id='4'
		LIMIT 1");
		
	
		return $query->result_array();
	}
	public function get_lessonsby_module($params=array())
	{
		$module_id = $params['module_id'];
		$query = "SELECT * FROM starter_modules_lessons 
				  WHERE starter_modules_lessons.lesson_module_id='$module_id' 
				  ORDER BY starter_modules_lessons.lesson_position ASC ";
		
		if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
			$start = $params['start'];
			$query .= "LIMIT {$start},{$limit}";
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
            $query .= "LIMIT {$limit} ";
        }
		
		$query = $this->db->query($query);
		return $query->result_array();
	}
	
	public function check_step()
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT student_phaselevel_id FROM starter_students WHERE starter_students.student_id='$student_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function check_ece()
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT student_phaselevel_id, student_ece_status FROM starter_students WHERE starter_students.student_id='$student_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function endmodule_available_schedule($phase_id)
	{
		$query = $this->db->query("SELECT * FROM starter_endmodule_exschedule 
								   WHERE starter_endmodule_exschedule.endmschedule_phase_id='$phase_id' 
								   AND starter_endmodule_exschedule.endmschedule_status=1 
								   ORDER BY starter_endmodule_exschedule.endmschedule_id DESC LIMIT 1");
		return $query->row_array();
	}
	
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
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT * FROM starter_phaseexam_booking
								   WHERE starter_phaseexam_booking.booking_user_id='$student_id'
								   AND starter_phaseexam_booking.booking_user_type='Student'
								   AND starter_phaseexam_booking.booking_phase_level='$phase_id'
								   AND starter_phaseexam_booking.booking_date <= '$to_date'
								   AND starter_phaseexam_booking.booking_date >= '$from_date'
								 ");
		return $query->row_array();
	}
	
	public function check_sdt_alrbooked($from_date, $to_date, $phase_id)
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT * FROM starter_sdt_booking
								   WHERE starter_sdt_booking.booking_user_id='$student_id'
								   AND starter_sdt_booking.booking_user_type='Student'
								   AND starter_sdt_booking.booking_phase_level='$phase_id'
								   AND starter_sdt_booking.booking_date <= '$to_date'
								   AND starter_sdt_booking.booking_date >= '$from_date'
								 ");
		return $query->row_array();
	}
	
	public function check_ece_alrbooked($from_date, $to_date)
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT * FROM starter_eceexam_booking
								   WHERE starter_eceexam_booking.booking_user_id='$student_id'
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
	
	public function check_endmodule_result($phase_id)
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT * FROM starter_module_progress
								   LEFT JOIN starter_module_marks ON
								   starter_module_marks.mdlmark_cmreport_id=starter_module_progress.cmreport_id
								   WHERE starter_module_progress.cmreport_phase_id='$phase_id'
								   AND starter_module_progress.cmreport_student_id='$student_id'
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
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT * FROM starter_workshop_booking
								   WHERE starter_workshop_booking.booking_user_id='$student_id'
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
	
	public function get_ftwof_sessions($phase_id)
	{
		$now_date = date("Y-m-d");
		$query = $this->db->query("SELECT * FROM starter_ftwof_schedule
								   LEFT JOIN starter_phases ON
								   starter_phases.phase_id=starter_ftwof_schedule.endmschedule_phase_id
								   WHERE starter_ftwof_schedule.endmschedule_phase_id='$phase_id' 
								   AND starter_ftwof_schedule.endmschedule_status=1 
								   AND starter_ftwof_schedule.endmschedule_from_date <= '$now_date' 
								   AND starter_ftwof_schedule.endmschedule_to_date >= '$now_date' 
								   ORDER BY starter_ftwof_schedule.endmschedule_id DESC");
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
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT * FROM starter_ftwof_booking
								   WHERE starter_ftwof_booking.booking_user_id='$student_id'
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
	
	public function studentinfo()
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT * FROM starter_students WHERE starter_students.student_id='$student_id' LIMIT 1");
		return $query->row_array();
	}
	// batch info for retake exam
	public function batchinfo()
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT * FROM starter_students WHERE starter_students.student_id='$student_id' LIMIT 1");
		return $query->result_array();
	}
	public function get_ftwof_booked()
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT 
								   starter_ftwof_booking.*, 
								   starter_phases.phase_name, 
								   starter_ftwof_schedule.endmschedule_title
								   FROM starter_ftwof_booking
								   LEFT JOIN starter_phases ON
								   starter_phases.phase_id=starter_ftwof_booking.booking_phase_level
								   LEFT JOIN starter_ftwof_schedule ON
								   starter_ftwof_schedule.endmschedule_id=starter_ftwof_booking.booking_schedule_id
								   WHERE starter_ftwof_booking.booking_user_id='$student_id'
								   AND starter_ftwof_booking.booking_user_type='Student'
								 ");
		return $query->result_array();
	}
	
	public function check_lesson_has_read($module_id, $lesson_id, $user_id)
	{
		$query = $this->db->query("SELECT lessread_id FROM starter_lesson_reading_completed 
								   WHERE starter_lesson_reading_completed.lessread_module_id='$module_id'
								   AND starter_lesson_reading_completed.lessread_lesson_id='$lesson_id'
								   AND starter_lesson_reading_completed.lessread_user_id='$user_id'");
		return $query->row_array();
	}
	
	/****************/
	/*****START F2F SCHEDULE******/
	/****************/
	
	public function get_sdt_schedules($phase_id)
	{
		$query = $this->db->query("SELECT * FROM starter_sdt_schedule WHERE starter_sdt_schedule.endmschedule_phase_id='$phase_id' ORDER BY endmschedule_id ASC");
		return $query->result_array();
	}
	
	public function get_sdtscheulde_info($schdle_id, $phase_lavel)
	{
		$query = $this->db->query("SELECT * FROM starter_sdt_schedule WHERE starter_sdt_schedule.endmschedule_id='$schdle_id' AND starter_sdt_schedule.endmschedule_phase_id='$phase_lavel' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_workshopscheulde_info($schdle_id, $phase_lavel)
	{
		$query = $this->db->query("SELECT * FROM starter_workshop_schedule WHERE starter_workshop_schedule.endmschedule_id='$schdle_id' AND starter_workshop_schedule.endmschedule_phase_id='$phase_lavel' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_ecescheulde_info($schdle_id)
	{
		$query = $this->db->query("SELECT * FROM starter_ece_exschedule WHERE starter_ece_exschedule.endmschedule_id='$schdle_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_workshop_schedules($phase_id)
	{
		$query = $this->db->query("SELECT * FROM starter_workshop_schedule WHERE starter_workshop_schedule.endmschedule_phase_id='$phase_id' ORDER BY endmschedule_id ASC");
		return $query->result_array();
	}
	
	public function get_center_schedule_info($centersdl_id)
	{
		$query = $this->db->query("SELECT * FROM starter_sdt_centerschdl WHERE starter_sdt_centerschdl.centerschdl_id='$centersdl_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_workshop_center_schedule_info($centersdl_id)
	{
		$query = $this->db->query("SELECT * FROM starter_workshop_centerschdl WHERE starter_workshop_centerschdl.centerschdl_id='$centersdl_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_ece_center_schedule_info($centersdl_id)
	{
		$query = $this->db->query("SELECT * FROM starter_ece_centerschdl WHERE starter_ece_centerschdl.centerschdl_id='$centersdl_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_sdt_available_sit($center_schedule_id, $maximum_sit)
	{
		$booking_schedule_id = $this->get_sdtschdle_idby_centersdlid($center_schedule_id);
		$query = $this->db->query("SELECT booking_id FROM starter_sdt_booking WHERE starter_sdt_booking.booking_schedule_centerid='$center_schedule_id' AND starter_sdt_booking.booking_schedule_id='$booking_schedule_id' ");
		$total_booked = $query->num_rows();
		$available = $maximum_sit - $total_booked;
		return $available;
	}
	
	public function get_sdtschdle_idby_centersdlid($center_schedule_id)
	{
		$query = $this->db->query("SELECT centerschdl_parentschdl_id FROM starter_sdt_centerschdl WHERE starter_sdt_centerschdl.centerschdl_id='center_schedule_id' LIMIT 1");
		$result = $query->row_array();
		return $result['centerschdl_parentschdl_id'];
	}
	
	public function studentinfodata()
	{
		$student_id = $this->session->userdata('active_student');
		$this -> db -> select('batch_name, student_examstatus');
		$this -> db -> from('starter_students');
		$this -> db -> where('student_id', $student_id);
		$query = $this->db->get();
		return $query->first_row();
	}

	public function exambatch($bid, $etype)
	{
		/*$student_id = $this->session->userdata('active_student');*/
		$this -> db -> select('*');
		$this -> db -> from('starter_exam_button');
		$this -> db -> where('exam_type', $etype);
		$this -> db -> where('batch', $bid);
		$this -> db -> where('btn_status', 1);
		$query = $this->db->get();
		return $query->first_row();
	}
	
}