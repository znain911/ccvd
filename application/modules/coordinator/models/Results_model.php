<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Results_model extends CI_Model {
	
	public function get_module_results()
	{
		$query = $this->db->query("SELECT 
								   starter_module_progress.*, 
								   starter_module_marks.*, 
								   starter_students.student_entryid,
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
								   ORDER BY starter_module_progress.cmreport_id DESC
								  ");
		return $query->result_array();
	}
	
	public function get_module_results1()/* for chapter 1*/
	{
		$query = $this->db->query("SELECT 
								   starter_module_progress.*, 
								   starter_module_marks.*, 
								   starter_students.student_entryid,
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
								   WHERE starter_module_progress.cmreport_phase_id = 1 
								   ORDER BY starter_module_progress.cmreport_id DESC
								  ");
		return $query->result_array();
	}

	public function get_module_results2() /* for chapter 2*/
	{
		$query = $this->db->query("SELECT 
								   starter_module_progress.*, 
								   starter_module_marks.*, 
								   starter_students.student_entryid,
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
								   WHERE starter_module_progress.cmreport_phase_id = 2 
								   ORDER BY starter_module_progress.cmreport_id DESC
								  ");
		return $query->result_array();
	}

	public function get_module_results3() /* for chapter 2*/
	{
		$query = $this->db->query("SELECT 
								   starter_module_progress.*, 
								   starter_module_marks.*, 
								   starter_students.student_entryid,
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
								   WHERE starter_module_progress.cmreport_phase_id = 3 
								   ORDER BY starter_module_progress.cmreport_id DESC
								  ");
		return $query->result_array();
	}

	public function get_module_results_ece() /* for chapter 2*/
	{
		$query = $this->db->query("SELECT 
								   starter_module_progress.*, 
								   starter_module_marks.*, 
								   starter_students.student_entryid,
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
								   WHERE starter_module_progress.cmreport_phase_id = 4 
								   ORDER BY starter_module_progress.cmreport_id DESC
								  ");
		return $query->result_array();
	}
	
	public function getExam($id,$pid) {
        $this -> db -> select('*');
		$this -> db -> from('starter_pcaexam_counter');
		$this -> db -> where('examcnt_student_id', $id);
		$this -> db -> where('examcnt_phase_level', $pid);
		$this -> db -> order_by('examcnt_id', 'DESC');
		$query = $this->db->get();
		return $query->result();
	} // End of function
	
	// get exam ece
	public function getEceExam($id,$pid) {
		$this -> db -> select('*');
		$this -> db -> from('starter_eceexam_counter');
		$this -> db -> where('eceexmcount_student_id', $id);
		$this -> db -> where('eceexamcnt_phase_level', $pid);
		$this -> db -> order_by('eceexmcount_id', 'DESC');
		$query = $this->db->get();
		return $query->result();
	} // End of function

    public function get_right_answers( $exm_id)
	{
		$this -> db -> select('*');
		$this -> db -> from('starter_endmodule_exmanswer');
		$this -> db -> where('answer_exam_id', $exm_id);
		$this -> db -> where('answer_status', 1);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_right_answers_ece($sid)
	{
		$this -> db -> select('*');
		$this -> db -> from('starter_endmodule_exmanswer');
		$this -> db -> where('answer_phase_id', 4);
		$this -> db -> where('answer_student_id', $sid);
		$this -> db -> where('answer_status', 1);
		$query = $this->db->get();
		return $query->result();

		//SELECT * FROM starter_endmodule_exmanswer WHERE answer_phase_id = 4 AND answer_student_id = 19
	}
	

	
	public function get_wrong_answers($exm_id)
	{
		$this -> db -> select('*');
		$this -> db -> from('starter_endmodule_exmanswer');
		$this -> db -> where('answer_exam_id', $exm_id);
		$this -> db -> where('answer_status', 0);
		$query = $this->db->get();
		return $query->result();
	}
	public function get_wrong_answers_ece($sid)
	{
		$this -> db -> select('*');
		$this -> db -> from('starter_endmodule_exmanswer');
		$this -> db -> where('answer_phase_id', 4);
		$this -> db -> where('answer_student_id', $sid);
		$this -> db -> where('answer_status', 0);
		$query = $this->db->get();
		return $query->result();
	}
	// public function get_ece_wrong_answers($ece_id_wrong_ans)
	// {
	// 	$this -> db -> select('*');
	// 	$this -> db -> from('starter_endmodule_exmanswer');
	// 	$this -> db -> where('answer_exam_id', $ece_id_wrong_ans);
	// 	$this -> db -> where('answer_status', 0);
	// 	$query = $this->db->get();
	// 	return $query->result();
	// }

	public function get_all_answers($exm_id)
	{
		$this -> db -> select('*');
		$this -> db -> from('starter_endmodule_exmanswer t1');
		$this -> db -> join('starter_exam_questions t2', 't2.question_id = t1.answer_question_id', 'LEFT');
		$this -> db -> where('t1.answer_exam_id', $exm_id);
		$query = $this->db->get();
		return $query->result();
	}
	public function get_all_answers_ece($sid)
	{
		$this -> db -> select('*');
		$this -> db -> from('starter_endmodule_exmanswer t1');
		$this -> db -> join('starter_exam_questions t2', 't2.question_id = t1.answer_question_id', 'LEFT');
		//$this -> db -> where('t1.answer_exam_id', $exm_id);
		$this -> db -> where('t1.answer_phase_id', 4);
		$this -> db -> where('t1.answer_student_id', $sid);
		$query = $this->db->get();
		return $query->result();
	}

	public function getBatch()
	{
		$this -> db -> select('*');
		$this -> db -> from('ccvd_batch');
		$this -> db -> order_by('batch_name', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_module_result_all($batch_id, $type)/* For all batch*/
	{
		$query = $this->db->query("SELECT 
								   starter_module_progress.*, 
								   starter_module_marks.*, 
								   starter_students.student_entryid,
								   starter_students.batch_name,
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
								   WHERE starter_module_progress.cmreport_phase_id = '$type' AND starter_students.batch_name = '$batch_id'  
								   ORDER BY starter_module_progress.cmreport_id DESC
								  ");
		return $query->result_array();
	}

	public function get_module_result_pass($batch_id, $type)/* For all batch*/
	{
		$query = $this->db->query("SELECT 
								   starter_module_progress.*, 
								   starter_module_marks.*, 
								   starter_students.student_entryid,
								   starter_students.batch_name,
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
								   WHERE starter_module_progress.cmreport_phase_id = '$type' AND starter_module_progress.cmreport_status =1 AND starter_students.batch_name = '$batch_id'  
								   ORDER BY starter_module_progress.cmreport_id DESC
								  ");
		return $query->result_array();
	}

	public function get_module_result_fail($batch_id, $type)/* For all batch*/
	{
		$query = $this->db->query("SELECT 
								   starter_module_progress.*, 
								   starter_module_marks.*, 
								   starter_students.student_entryid,
								   starter_students.batch_name,
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
								   WHERE starter_module_progress.cmreport_phase_id = '$type' AND starter_module_progress.cmreport_status =0 AND starter_students.batch_name = '$batch_id'  
								   ORDER BY starter_module_progress.cmreport_id DESC
								  ");
		return $query->result_array();
	}

	public function get_exam_date()
	{
		/*$query = $this->db->query("SELECT 
								   starter_module_progress.*, 
								   starter_module_marks.*, 
								   starter_students.student_entryid,
								   starter_students.batch_name,
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
								   ORDER BY starter_module_progress.cmreport_id ASC
								  ");
		return $query->result_array();*/
		/*$this->db->distinct('date(t1.cmreport_create_date)');*/
		$this -> db -> select('distinct(date(t1.cmreport_create_date)), distinct(t1.cmreport_student_id)');
		$this -> db -> from('starter_module_progress t1');
		$this -> db -> join('starter_students t2', 't2.student_id = t1.cmreport_student_id', 'LEFT');
		/*$this -> db -> distinct();*/
		
		/*$this -> db -> where('t1.answer_phase_id', 4);
		$this -> db -> where('t1.answer_student_id', $sid);*/
		$query = $this->db->get();
		return $query->result();
	}

	public function get_exam_date2(){
		$this -> db -> select('date(t1.cmreport_create_date) as examdt, t2.batch_name, t3.phase_name');
		$this -> db -> from('starter_module_progress t1');
		$this -> db -> join('starter_students t2', 't2.student_id = t1.cmreport_student_id', 'LEFT');
		$this -> db -> join('starter_phases t3', 't3.phase_id = t1.cmreport_phase_id', 'LEFT');
		$this -> db -> group_by('date(t1.cmreport_create_date)');		
		$query = $this->db->get();
		return $query->result();
	}
	
	public function getstudent($batchid){
		$query = "SELECT 
				  starter_students.*,
				  starter_students_personalinfo.spinfo_first_name,
				  starter_students_personalinfo.spinfo_middle_name,
				  starter_students_personalinfo.spinfo_last_name,
				  starter_students_personalinfo.spinfo_photo,
				  starter_students_personalinfo.spinfo_personal_phone,
				  starter_students_personalinfo.spinfo_gender,
				  starter_students_personalinfo.spinfo_birth_date,
				  starter_students_professionalinfo.spsinfo_bmanddc_number,
				  starter_students_professionalinfo.spsinfo_designation,
				  starter_students_professionalinfo.spsinfo_organization,
				  starter_students_professionalinfo.spsinfo_organization_address,
				  starter_students_professionalinfo.spsinfo_typeof_practice,
				  starter_students_professionalinfo.spsinfo_sinceyear_mbbs,
				  starter_students_professionalinfo.spsinfo_experience,
				  starter_students_personalinfo.spinfo_national_id				 
				  FROM starter_students 
				  LEFT JOIN starter_students_personalinfo ON 
				  starter_students_personalinfo.spinfo_student_id=starter_students.student_id
				  LEFT JOIN starter_students_professionalinfo ON
				  starter_students_professionalinfo.spsinfo_student_id=starter_students.student_id
				  ";
		$query .= "WHERE starter_students.student_status=1 AND starter_students.student_enrolled = 1 AND starter_students.batch_name='$batchid' ";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}

	public function get_resultbystudent($stid,$phaseid){
		$this -> db -> select('t1.*, t2.*');
		$this -> db -> from('starter_module_progress t1');
		$this -> db -> join('starter_module_marks t2', 't2.mdlmark_cmreport_id = t1.cmreport_id', 'LEFT');
		$this -> db -> where('t1.cmreport_student_id', $stid);
		$this -> db -> where('t1.cmreport_phase_id', $phaseid);
		$this -> db -> order_by('t1.cmreport_id', 'DESC');		
		$query = $this->db->get();
		return $query->first_row();
	}

	public function get_batchexam($batch_id, $phaseid)/* For all batch*/
	{
		$query = $this->db->query("SELECT 
								   starter_module_progress.*, 
								   starter_module_marks.*, 
								   starter_students.student_id
								   FROM starter_module_progress
								   LEFT JOIN starter_module_marks ON
								   starter_module_marks.mdlmark_cmreport_id=starter_module_progress.cmreport_id
								   LEFT JOIN starter_students ON
								   starter_students.student_id=starter_module_progress.cmreport_student_id
								   WHERE starter_module_progress.cmreport_phase_id = '$phaseid' AND starter_students.batch_name = '$batch_id'  
								   ORDER BY starter_module_progress.cmreport_id DESC
								  ");
		return $query->result_array();
	}
	
}
