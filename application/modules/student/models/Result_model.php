<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Result_model extends CI_Model {
	
	public function get_module_results()
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT 
								   starter_module_progress.*, 
								   starter_module_marks.*,
								   starter_phases.phase_id
								   FROM starter_module_progress
								   LEFT JOIN starter_module_marks ON
								   starter_module_marks.mdlmark_cmreport_id=starter_module_progress.cmreport_id
								   LEFT JOIN starter_students ON
								   starter_students.student_id=starter_module_progress.cmreport_student_id
								   LEFT JOIN starter_students_personalinfo ON
								   starter_students_personalinfo.spinfo_student_id=starter_module_progress.cmreport_student_id
								   LEFT JOIN starter_phases ON
								   starter_phases.phase_id=starter_module_progress.cmreport_phase_id
								   WHERE starter_module_progress.cmreport_student_id='$student_id'
								   ORDER BY starter_module_progress.cmreport_id ASC
								  ");
		return $query->result_array();
	}
	//for ece result
	public function get_ece_results()
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT 
								   starter_module_progress.*, 
								   starter_module_marks.*, 
								   starter_students.student_entryid as id,
								   starter_students_personalinfo.spinfo_first_name,
								   starter_students_personalinfo.spinfo_middle_name,
								   starter_students_personalinfo.spinfo_last_name,
								   starter_phases.phase_name
								   FROM starter_module_progress
								   LEFT JOIN starter_module_marks ON
								   starter_module_marks.mdlmark_cmreport_id=starter_module_progress.cmreport_id
								   LEFT JOIN starter_students ON
								   starter_students.student_id=starter_module_progress.cmreport_student_id
								   LEFT JOIN starter_students_personalinfo ON
								   starter_students_personalinfo.spinfo_student_id=starter_module_progress.cmreport_student_id
								   LEFT JOIN starter_phases ON
								   starter_phases.phase_id=starter_module_progress.cmreport_phase_id
								   WHERE starter_module_progress.cmreport_student_id='$student_id' 
								   AND starter_module_progress.cmreport_phase_id = 4 
								   ORDER BY starter_module_progress.cmreport_id DESC
								  ");
		return $query->result_array();
	}
	
	
	public function count_retaketimes_pca($phase_id)
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT examcnt_id FROM starter_pcaexam_counter 
								   WHERE starter_pcaexam_counter.examcnt_student_id='$student_id' 
								   AND starter_pcaexam_counter.examcnt_phase_level='$phase_id'
								   AND starter_pcaexam_counter.examcnt_exam_type='RETAKE'
								   ");
		return $query->num_rows();
	}
	public function count_retaketimes_ece()
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT eceexmcount_id FROM starter_eceexam_counter 
								   WHERE starter_eceexam_counter.eceexmcount_student_id='$student_id' 
								   AND starter_eceexam_counter.eceexamcnt_phase_level='4'
								   AND starter_eceexam_counter.eceexmcount_exm_type='RETAKE'
								   ");
		return $query->num_rows();
	}
	
	public function get_all_items()
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT 
								   starter_phase_progress.*,  
								   starter_phases.phase_name
								   FROM starter_phase_progress
								   LEFT JOIN starter_phases ON
								   starter_phases.phase_id=starter_phase_progress.cpreport_phase_id
								   WHERE starter_phase_progress.cpreport_student_id='$student_id'
								   ORDER BY starter_phase_progress.cpreport_id ASC
								  ");
		return $query->result_array();
	}
	
	public function count_total_marks($cpreport_id)
	{
		$query = $this->db->query("SELECT SUM(pmark_number) AS total_marks FROM starter_phase_marks WHERE starter_phase_marks.pmark_cpreport_id='$cpreport_id'");
		$result = $query->row_array();
		if($result['total_marks'])
		{
			$marks = $result['total_marks'];
		}else
		{
			$marks = 0;
		}
		return $marks;
	}
	
	public function count_total_ecemarks($cpreport_id)
	{
		$query = $this->db->query("SELECT SUM(pmark_number) AS total_marks FROM starter_ece_marks WHERE starter_ece_marks.pmark_cpreport_id='$cpreport_id'");
		$result = $query->row_array();
		if($result['total_marks'])
		{
			$marks = $result['total_marks'];
		}else
		{
			$marks = 0;
		}
		return $marks;
	}
	
	public function get_eceall_items()
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT 
								   *
								   FROM starter_ece_progress
								   WHERE starter_ece_progress.cpreport_student_id='$student_id'
								   LIMIT 1
								  ");
		return $query->row_array();
	}
	
	public function get_sdt_scores()
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT 
								   *
								   FROM starter_sdt_scoreboard
								   LEFT JOIN starter_sdt_booking ON
								   starter_sdt_booking.booking_id=starter_sdt_scoreboard.scrboard_booking_id
								   LEFT JOIN starter_sdt_schedule ON
								   starter_sdt_schedule.endmschedule_id=starter_sdt_booking.booking_schedule_id
								   WHERE starter_sdt_scoreboard.scrboard_student_id='$student_id'
								   ORDER BY scrboard_id ASC
								  ");
		return $query->result_array();
	}
	
	public function get_workshop_scores()
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT 
								   *
								   FROM starter_workshop_scoreboard
								   LEFT JOIN starter_workshop_booking ON
								   starter_workshop_booking.booking_id=starter_workshop_scoreboard.scrboard_booking_id
								   LEFT JOIN starter_workshop_schedule ON
								   starter_workshop_schedule.endmschedule_id=starter_workshop_booking.booking_schedule_id
								   WHERE starter_workshop_scoreboard.scrboard_student_id='$student_id'
								   ORDER BY scrboard_id ASC
								  ");
		return $query->result_array();
	}
	
	public function get_ece_result()
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT * FROM starter_ece_progress 
								   WHERE starter_ece_progress.cpreport_student_id='$student_id'
								   AND starter_ece_progress.cpreport_exam_status=1
								");
		return $query->row_array();
	}
	
	public function get_label_marks($ece_id)
	{
		$query = $this->db->query("SELECT * FROM starter_ece_marks WHERE starter_ece_marks.pmark_cpreport_id='$ece_id' ORDER BY pmark_id ASC");
		return $query->result_array();
	}
}
