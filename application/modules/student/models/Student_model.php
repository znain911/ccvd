<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_model extends CI_Model{
	
	public function get_student_info()
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT *
								   FROM starter_students
								   LEFT JOIN starter_students_academicinfo ON
								   starter_students_academicinfo.sacinfo_student_id=starter_students.student_id
								   LEFT JOIN starter_students_personalinfo ON
								   starter_students_personalinfo.spinfo_student_id=starter_students.student_id
								   LEFT JOIN starter_students_professionalinfo ON
								   starter_students_professionalinfo.spsinfo_student_id=starter_students.student_id
								   LEFT JOIN starter_countries ON
								   starter_countries.country_id=starter_students_personalinfo.spinfo_nationality
								   WHERE starter_students.student_id='$student_id'
								   LIMIT 1
								  ");
		return $query->row_array();
	}
	
	public function get_academicinformation()
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT
								   *
								   FROM starter_students_academicinfo
								   LEFT JOIN starter_students ON
								   starter_students.student_id=starter_students_academicinfo.sacinfo_student_id
								   WHERE starter_students_academicinfo.sacinfo_student_id='$student_id'
								   ORDER BY starter_students_academicinfo.sacinfo_id ASC
								  ");
		return $query->result_array();
	}
	
	public function get_specializations()
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT
								  *
								  FROM starter_students_specializations
								  WHERE starter_students_specializations.ss_student_id='$student_id'
								  ORDER BY starter_students_specializations.ss_id ASC
								  "); 
		return $query->result_array();
	}
	
	public function get_specialization_name($specialize_id)
	{
		$query = $this->db->query("SELECT specialize_name FROM starter_specialization WHERE starter_specialization.specialize_id='$specialize_id' LIMIT 1");
		$result = $query->row_array();
		return $result['specialize_name'];
	}
	
	public function get_dlp_categories()
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT
								   *
								   FROM starter_students_dlpcategories
								   LEFT JOIN starter_dlp_categories ON
								   starter_dlp_categories.category_id=starter_students_dlpcategories.sdc_category_id
								   WHERE starter_students_dlpcategories.sdc_student_id='$student_id'
								   ORDER BY starter_students_dlpcategories.sdc_id ASC
								  ");
		return $query->result_array();
	}
	
	public function get_all_dlp_categories()
	{
		$query = $this->db->query("SELECT category_id, category_name FROM starter_dlp_categories ORDER BY starter_dlp_categories.category_id ASC");
		return $query->result_array();
	}
	
	public function get_personal_info()
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT * FROM starter_students_personalinfo
								   LEFT JOIN starter_students ON
								   starter_students.student_id=starter_students_personalinfo.spinfo_student_id
								   WHERE starter_students_personalinfo.spinfo_student_id='$student_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_professional_info()
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT * FROM starter_students_professionalinfo WHERE starter_students_professionalinfo.spsinfo_student_id='$student_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_academic_info()
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT * FROM starter_students_academicinfo WHERE starter_students_academicinfo.sacinfo_student_id='$student_id' LIMIT 1");
		return $query->result_array();
	}
	
	public function get_all_countries()
	{
		$query = $this->db->query("SELECT country_id, country_name FROM starter_countries WHERE starter_countries.country_status=1 ORDER BY starter_countries.country_id ASC");
		return $query->result_array();
	}
	
	public function get_all_specializations()
	{
		$query = $this->db->query("SELECT specialize_id, specialize_name FROM starter_specialization ORDER BY starter_specialization.specialize_id ASC");
		return $query->result_array();
	}
	
	public function update_personal_info($student_id, $data)
	{
		$this->db->where('spinfo_student_id', $student_id);
		$this->db->update('starter_students_personalinfo', $data);
	}
	
	public function update_professional_info($student_id, $data)
	{
		$this->db->where('spsinfo_student_id', $student_id);
		$this->db->update('starter_students_professionalinfo', $data);
	}
	
	public function save_specialization_info($data)
	{
		$this->db->insert('starter_students_specializations', $data);
	}
	
	public function save_categories_info($data)
	{
		$this->db->insert('starter_students_dlpcategories', $data);
	}
	
	public function save_academic_info($data)
	{
		$this->db->insert('starter_students_academicinfo', $data);
	}
	
	public function get_certificate_row($student_id, $item_id)
	{
		$query = $this->db->query("SELECT 
									starter_students_academicinfo.sacinfo_certificate ,
									starter_students.student_entryid
								   FROM starter_students_academicinfo 
								   LEFT JOIN starter_students ON
								   starter_students.student_id=starter_students_academicinfo.sacinfo_student_id
								   WHERE starter_students_academicinfo.sacinfo_student_id ='$student_id' AND starter_students_academicinfo.sacinfo_id='$item_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function update_password($student_id, $data)
	{
		$this->db->where('student_id', $student_id);
		$this->db->update('starter_students', $data);
	}
	
	public function save_contactinfo($data)
	{
		$this->db->insert('starter_users_contacts', $data);
	}
	
	public function get_onlinepayment_info($student_entryid)
	{
		$query = $this->db->query("SELECT * FROM starter_online_payments WHERE starter_online_payments.onpay_student_entryid='$student_entryid' ORDER BY onpay_id ASC");
		return $query->result_array();
	}
	
	public function get_depositpayment_info($student_entryid)
	{
		$query = $this->db->query("SELECT * FROM starter_deposit_payments WHERE starter_deposit_payments.deposit_student_entryid='$student_entryid' ORDER BY deposit_id ASC");
		return $query->result_array();
	}
	
	public function get_entryid()
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT student_entryid FROM starter_students WHERE starter_students.student_id='$student_id' LIMIT 1");
		$result = $query->row_array();
		return $result['student_entryid'];
	}
	
	public function check_exm_result($student_id, $phase)
	{
		$query = $this->db->query("SELECT cmreport_status, cmreport_create_date FROM starter_module_progress WHERE starter_module_progress.cmreport_phase_id='$phase' AND starter_module_progress.cmreport_student_id='$student_id'");
		return $query->row_array();
	}

	public function contact_infos()
	{
		$query = $this->db->query("SELECT * FROM starter_contact_info WHERE starter_contact_info.config_key='One_Time' LIMIT 1");
		return $query->row_array();
	}
	
}