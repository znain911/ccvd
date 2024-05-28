<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {
	
	public function check_credential($email, $password)
	{
		$query = $this->db->query("SELECT 
								   starter_teachers.teacher_id,
								   starter_teachers.teacher_username,
								   starter_teachers.teacher_last_login,
								   starter_teachers.teacher_status,
								   starter_teachers_personalinfo.tpinfo_first_name,
								   starter_teachers_personalinfo.tpinfo_middle_name,
								   starter_teachers_personalinfo.tpinfo_last_name
								   FROM starter_teachers
								   LEFT JOIN starter_teachers_personalinfo ON
								   starter_teachers_personalinfo.tpinfo_teacher_id=starter_teachers.teacher_id
								   WHERE starter_teachers.teacher_email='$email'
								   AND starter_teachers.teacher_password='$password'
								   LIMIT 1
								  ");
		return $query->row();
	}
	
	public function check_id_credential($entryid, $password)
	{
		$query = $this->db->query("SELECT 
								   starter_teachers.teacher_id,
								   starter_teachers.teacher_username,
								   starter_teachers.teacher_last_login,
								   starter_teachers.teacher_status,
								   starter_teachers_personalinfo.tpinfo_first_name,
								   starter_teachers_personalinfo.tpinfo_middle_name,
								   starter_teachers_personalinfo.tpinfo_last_name
								   FROM starter_teachers
								   LEFT JOIN starter_teachers_personalinfo ON
								   starter_teachers_personalinfo.tpinfo_teacher_id=starter_teachers.teacher_id
								   WHERE starter_teachers.teacher_entryid='$entryid'
								   AND starter_teachers.teacher_password='$password'
								   LIMIT 1
								  ");
		return $query->row();
	}
	
	public function update_teacher($teacher_id, $data)
	{
		$this->db->where('teacher_id', $teacher_id);
		$this->db->update('starter_teachers', $data);
	}
	
	public function update_reset_code($teacher_id, $data)
	{
		$this->db->where('teacher_id', $teacher_id);
		$this->db->update('starter_teachers', $data);
	}
	
	public function check_exist_email($email)
	{
		$query = $this->db->query("SELECT * FROM starter_teachers 
								   LEFT JOIN starter_teachers_personalinfo ON
								   starter_teachers_personalinfo.tpinfo_teacher_id=starter_teachers.teacher_id
								   WHERE starter_teachers.teacher_email='$email' LIMIT 1");
		return $query->row();
	}
	
	public function check_resetcode($reset_code, $teacher_id)
	{
		$query = $this->db->query("SELECT teacher_id FROM starter_teachers WHERE starter_teachers.teacher_password_resetcde='$reset_code' AND starter_teachers.teacher_id='$teacher_id' ");
		return $query->row();
	}
	
	public function update_password($teacher_id, $data)
	{
		$this->db->where('teacher_id', $teacher_id);
		$this->db->update('starter_teachers', $data);
	}
	
}
