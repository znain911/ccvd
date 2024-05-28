<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registration_model extends CI_Model{
	
	public function get_all_countries()
	{
		$query = $this->db->query("SELECT country_id, country_name FROM starter_countries WHERE starter_countries.country_status=1 ORDER BY starter_countries.country_id ASC");
		return $query->result_array();
	}
	
	public function save_account($data)
	{
		$this->db->insert('starter_teachers', $data);
	}
	
	public function update_account($teacher_id, $data)
	{
		$this->db->where('teacher_id', $teacher_id);
		$this->db->update('starter_teachers', $data);
	}
	
	public function total_teachers()
	{
		$query = $this->db->query("SELECT teacher_id FROM starter_teachers");
		return $query->num_rows()+1;
	}
	
	public function save_personal_info($data)
	{
		$this->db->insert('starter_teachers_personalinfo', $data);
	}
	
	public function update_personal_info($teacher_id, $data)
	{
		$this->db->where('tpinfo_teacher_id', $teacher_id);
		$this->db->update('starter_teachers_personalinfo', $data);
	}
	
	public function get_all_specializations()
	{
		$query = $this->db->query("SELECT specialize_id, specialize_name FROM starter_specialization ORDER BY starter_specialization.specialize_id ASC");
		return $query->result_array();
	}
	
	public function get_dlp_categories()
	{
		$query = $this->db->query("SELECT category_id, category_name FROM starter_dlp_categories ORDER BY starter_dlp_categories.category_id ASC");
		return $query->result_array();
	}
	
	public function save_professional_info($data)
	{
		$this->db->insert('starter_teachers_professionalinfo', $data);
	}
	public function save_specialization_info($data)
	{
		$this->db->insert('starter_teachers_specializations', $data);
	}
	public function save_academic_info($data)
	{
		$this->db->insert('starter_teachers_academicinfo', $data);
	}
	public function save_categories_info($data)
	{
		$this->db->insert('starter_teachers_dlpcategories', $data);
	}
	
	public function get_teacher_info($teacher_id)
	{
		$query = $this->db->query("SELECT * 
								   FROM starter_teachers 
								   LEFT JOIN starter_teachers_personalinfo ON
								   starter_teachers_personalinfo.tpinfo_teacher_id=starter_teachers.teacher_id
								   WHERE tpinfo_teacher_id='$teacher_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function teacher_basic_info($teacher_portid)
	{
		$query = $this->db->query("SELECT * 
								   FROM starter_teachers 
								   LEFT JOIN starter_teachers_personalinfo ON
								   starter_teachers_personalinfo.tpinfo_teacher_id=starter_teachers.teacher_id
								   WHERE starter_teachers.teacher_portid='$teacher_portid' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_account_info($teacher_id)
	{
		$query = $this->db->query("SELECT * FROM starter_teachers WHERE starter_teachers.teacher_id='$teacher_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function check_email($email)
	{
		$query = $this->db->query("SELECT * FROM starter_teachers WHERE starter_teachers.teacher_email='$email' LIMIT 1");
		return $query->row_array();
	}
	
	public function check_student_email($email)
	{
		$query = $this->db->query("SELECT * FROM starter_students WHERE starter_students.student_email='$email' LIMIT 1");
		return $query->row_array();
	}
	
	public function check_mobile($mobile)
	{
		$query = $this->db->query("SELECT * FROM starter_teachers_personalinfo WHERE starter_teachers_personalinfo.tpinfo_personal_phone='$mobile' LIMIT 1");
		return $query->row_array();
	}
	
	public function check_student_mobile($mobile)
	{
		$query = $this->db->query("SELECT * FROM starter_students_personalinfo WHERE starter_students_personalinfo.spinfo_personal_phone='$mobile' LIMIT 1");
		return $query->row_array();
	}
	
	public function check_username($username)
	{
		$query = $this->db->query("SELECT * FROM starter_teachers WHERE starter_teachers.teacher_username='$username' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_personal_info($teacher_id)
	{
		$query = $this->db->query("SELECT * FROM starter_teachers_personalinfo WHERE starter_teachers_personalinfo.tpinfo_teacher_id='$teacher_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_payment_config()
	{
		$query = $this->db->query("SELECT pconfig_course_fee FROM starter_payment_config WHERE starter_payment_config.pconfig_key='One_Time' LIMIT 1");
		return $query->row_array();
	}
	
}