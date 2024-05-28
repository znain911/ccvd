<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Phaseresults_model extends CI_Model {
	
	public function get_all_items()
	{
		$query = $this->db->query("SELECT 
								   starter_phase_progress.*,  
								   starter_phases.phase_name,
								   starter_students.student_entryid,
								   starter_students_personalinfo.spinfo_first_name,
								   starter_students_personalinfo.spinfo_middle_name,
								   starter_students_personalinfo.spinfo_last_name,
								   starter_owner.owner_name
								   FROM starter_phase_progress
								   LEFT JOIN starter_phases ON
								   starter_phases.phase_id=starter_phase_progress.cpreport_phase_id
								   LEFT JOIN starter_students ON
								   starter_students.student_id=starter_phase_progress.cpreport_student_id
								   LEFT JOIN starter_students_personalinfo ON
								   starter_students_personalinfo.spinfo_student_id=starter_phase_progress.cpreport_student_id
								   LEFT JOIN starter_owner ON
								   starter_owner.owner_id=starter_phase_progress.cpreport_created_by
								   ORDER BY starter_phase_progress.cpreport_id DESC
								  ");
		return $query->result_array();
	}
	
	public function create($data)
	{
		$this->db->insert('starter_phase_progress', $data);
	}
	
	public function update($id, $data)
	{
		$this->db->where('cpreport_id', $id);
		$this->db->update('starter_phase_progress', $data);
	}
	
	public function get_info($id)
	{
		$query = $this->db->query("SELECT * FROM starter_phase_progress WHERE starter_phase_progress.cpreport_id='$id' LIMIT 1");
		return $query->row_array();
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
	
	public function get_phases()
	{
		$query = $this->db->query("SELECT * FROM starter_phases ORDER BY starter_phases.phase_id ASC");
		return $query->result_array();
	}
	
	public function get_students_ids($phase_id)
	{
		$query = $this->db->query("SELECT 
								   starter_students.student_id,  
								   starter_students.student_entryid,  
								   starter_students_personalinfo.spinfo_first_name,
								   starter_students_personalinfo.spinfo_middle_name,
								   starter_students_personalinfo.spinfo_last_name
								   FROM starter_students
								   LEFT JOIN starter_students_personalinfo ON
								   starter_students_personalinfo.spinfo_student_id=starter_students.student_id
								   WHERE starter_students.student_phaselevel_id='$phase_id'
								   ORDER BY starter_students.student_id ASC
								  ");
		return $query->result_array();
	}
	
	public function get_students_info($student_id)
	{
		$query = $this->db->query("SELECT 
								   starter_students.student_id,  
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
	
	public function save_phase_marks($data)
	{
		$this->db->insert('starter_phase_marks', $data);
	}
	
	public function update_phase_marks($row, $id, $marks_data)
	{
		$this->db->where('pmark_id', $row);
		$this->db->where('pmark_cpreport_id', $id);
		$this->db->update('starter_phase_marks', $marks_data);
	}
	
	public function check_already_has($phase_level, $student_id)
	{
		$query = $this->db->query("SELECT * FROM starter_phase_progress WHERE starter_phase_progress.cpreport_phase_id='$phase_level' AND starter_phase_progress.cpreport_student_id='$student_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_marksby_progress($cpreport_id)
	{
		$query = $this->db->query("SELECT * FROM starter_phase_marks WHERE starter_phase_marks.pmark_cpreport_id='$cpreport_id' ORDER BY starter_phase_marks.pmark_id ASC");
		return $query->result_array();
	}
	
}
