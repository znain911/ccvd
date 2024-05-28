<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher_model extends CI_Model{
	
	public function get_teacher_info()
	{
		$teacher_id = $this->session->userdata('active_teacher');
		$query = $this->db->query("SELECT *
								   FROM starter_teachers
								   LEFT JOIN starter_teachers_academicinfo ON
								   starter_teachers_academicinfo.tacinfo_teacher_id=starter_teachers.teacher_id
								   LEFT JOIN starter_teachers_personalinfo ON
								   starter_teachers_personalinfo.tpinfo_teacher_id=starter_teachers.teacher_id
								   LEFT JOIN starter_teachers_professionalinfo ON
								   starter_teachers_professionalinfo.tpsinfo_teacher_id=starter_teachers.teacher_id
								   LEFT JOIN starter_countries ON
								   starter_countries.country_id=starter_teachers_personalinfo.tpinfo_nationality
								   WHERE starter_teachers.teacher_id='$teacher_id'
								   LIMIT 1
								  ");
		return $query->row_array();
	}
	
	public function get_academicinformation()
	{
		$teacher_id = $this->session->userdata('active_teacher');
		$query = $this->db->query("SELECT
								   *
								   FROM starter_teachers_academicinfo
								   LEFT JOIN starter_teachers ON
								   starter_teachers.teacher_id=starter_teachers_academicinfo.tacinfo_teacher_id
								   WHERE starter_teachers_academicinfo.tacinfo_teacher_id='$teacher_id'
								   ORDER BY starter_teachers_academicinfo.tacinfo_id ASC
								  ");
		return $query->result_array();
	}
	
	public function get_specializations()
	{
		$teacher_id = $this->session->userdata('active_teacher');
		$query = $this->db->query("SELECT
								  *
								  FROM starter_teachers_specializations
								  WHERE starter_teachers_specializations.ts_teacher_id='$teacher_id'
								  ORDER BY starter_teachers_specializations.ts_id ASC
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
		$teacher_id = $this->session->userdata('active_teacher');
		$query = $this->db->query("SELECT
								   *
								   FROM starter_teachers_dlpcategories
								   LEFT JOIN starter_dlp_categories ON
								   starter_dlp_categories.category_id=starter_teachers_dlpcategories.tdc_category_id
								   WHERE starter_teachers_dlpcategories.tdc_teacher_id='$teacher_id'
								   ORDER BY starter_teachers_dlpcategories.tdc_id ASC
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
		$teacher_id = $this->session->userdata('active_teacher');
		$query = $this->db->query("SELECT * FROM starter_teachers_personalinfo
								   LEFT JOIN starter_teachers ON
								   starter_teachers.teacher_id=starter_teachers_personalinfo.tpinfo_teacher_id
								   WHERE starter_teachers_personalinfo.tpinfo_teacher_id='$teacher_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_professional_info()
	{
		$teacher_id = $this->session->userdata('active_teacher');
		$query = $this->db->query("SELECT * FROM starter_teachers_professionalinfo WHERE starter_teachers_professionalinfo.tpsinfo_teacher_id='$teacher_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_academic_info()
	{
		$teacher_id = $this->session->userdata('active_teacher');
		$query = $this->db->query("SELECT * FROM starter_teachers_academicinfo WHERE starter_teachers_academicinfo.tacinfo_teacher_id='$teacher_id' LIMIT 1");
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
	
	public function update_personal_info($teacher_id, $data)
	{
		$this->db->where('tpinfo_teacher_id', $teacher_id);
		$this->db->update('starter_teachers_personalinfo', $data);
	}
	
	public function update_professional_info($teacher_id, $data)
	{
		$this->db->where('tpsinfo_teacher_id', $teacher_id);
		$this->db->update('starter_teachers_professionalinfo', $data);
	}
	
	public function save_specialization_info($data)
	{
		$this->db->insert('starter_teachers_specializations', $data);
	}
	
	public function save_categories_info($data)
	{
		$this->db->insert('starter_teachers_dlpcategories', $data);
	}
	
	public function save_academic_info($data)
	{
		$this->db->insert('starter_teachers_academicinfo', $data);
	}
	
	public function get_certificate_row($teacher_id, $item_id)
	{
		$query = $this->db->query("SELECT 
									starter_teachers_academicinfo.tacinfo_certificate ,
									starter_teachers.teacher_entryid
								   FROM starter_teachers_academicinfo 
								   LEFT JOIN starter_teachers ON
								   starter_teachers.teacher_id=starter_teachers_academicinfo.tacinfo_teacher_id
								   WHERE starter_teachers_academicinfo.tacinfo_teacher_id ='$teacher_id' AND starter_teachers_academicinfo.tacinfo_id='$item_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function update_password($teacher_id, $data)
	{
		$this->db->where('teacher_id', $teacher_id);
		$this->db->update('starter_teachers', $data);
	}
	
}