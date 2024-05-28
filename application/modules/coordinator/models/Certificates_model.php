<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Certificates_model extends CI_Model {
	
	public function get_all_items()
	{
		$query = $this->db->query("SELECT 
									starter_certificates.*,
									starter_students.student_entryid,
									starter_students_personalinfo.spinfo_first_name,
									starter_students_personalinfo.spinfo_middle_name,
									starter_students_personalinfo.spinfo_last_name
									FROM starter_certificates 
									LEFT JOIN starter_students ON
									starter_students.student_id=starter_certificates.certificate_student_id
									LEFT JOIN starter_students_personalinfo ON
									starter_students_personalinfo.spinfo_student_id=starter_certificates.certificate_student_id
									ORDER BY starter_certificates.certificate_id DESC");
		return $query->result_array();
	}
	
	public function create($data)
	{
		$this->db->insert('starter_certificates', $data);
	}
	
	public function update($id, $data)
	{
		$this->db->where('certificate_id', $id);
		$this->db->update('starter_certificates', $data);
	}
	
	public function get_info($id)
	{
		$query = $this->db->query("SELECT 
								   starter_certificates.*,
								   starter_students.student_id,  
								   starter_students.student_entryid,  
								   starter_students_personalinfo.spinfo_first_name,
								   starter_students_personalinfo.spinfo_middle_name,
								   starter_students_personalinfo.spinfo_last_name
							       FROM starter_certificates
								   LEFT JOIN starter_students ON
								   starter_students.student_id=starter_certificates.certificate_student_id
								   LEFT JOIN starter_students_personalinfo ON
								   starter_students_personalinfo.spinfo_student_id=starter_certificates.certificate_student_id
								   WHERE starter_certificates.certificate_id='$id' 
								   LIMIT 1
								  ");
		return $query->row_array();
	}
	
	public function get_students_ids($ece, $certified)
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
								   WHERE starter_students.student_course_status='$ece'
								   AND starter_students.student_get_certified='$certified'
								   ORDER BY starter_students.student_id ASC
								  ");
		return $query->result_array();
	}
	
	public function get_student_info($id)
	{
		$query = $this->db->query("SELECT student_entryid FROM starter_students WHERE starter_students.student_id='$id' LIMIT 1");
		return $query->row_array();
	}
	
	public function update_ece_coursestatus($id, $data)
	{
		$this->db->where('student_id', $id);
		$this->db->update('starter_students', $data);
	}
	
	public function get_certificate_info($id)
	{
		$query = $this->db->query("SELECT * FROM starter_certificates WHERE starter_certificates.certificate_id='$id' LIMIT 1");
		return $query->row_array();
	}
	
}
