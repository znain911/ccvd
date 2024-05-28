<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {
	
	public function check_credential($email, $password)
	{
		$query = $this->db->query("SELECT 
								   starter_students.student_id,
								   starter_students.student_entryid,
								   starter_students.student_phaselevel_id,
								   starter_students.student_active_module,
								   starter_students.student_username,
								   starter_students.student_last_login,
								   starter_students.student_status,
								   starter_students.student_regdate,
								   starter_students.student_enrolled,
								   starter_students_personalinfo.spinfo_first_name,
								   starter_students_personalinfo.spinfo_middle_name,
								   starter_students_personalinfo.spinfo_last_name
								   FROM starter_students
								   LEFT JOIN starter_students_personalinfo ON
								   starter_students_personalinfo.spinfo_student_id=starter_students.student_id
								   WHERE starter_students.student_email='$email'
								   AND starter_students.student_password='$password'
								   LIMIT 1
								  ");
		return $query->row();
	}
	
	public function check_id_credential($entryid, $password)
	{
		$query = $this->db->query("SELECT 
								   starter_students.student_id,
								   starter_students.student_entryid,
								   starter_students.student_phaselevel_id,
								   starter_students.student_active_module,
								   starter_students.student_username,
								   starter_students.student_last_login,
								   starter_students.student_status,
								   starter_students.student_regdate,
								   starter_students.student_enrolled,
								   starter_students_personalinfo.spinfo_first_name,
								   starter_students_personalinfo.spinfo_middle_name,
								   starter_students_personalinfo.spinfo_last_name
								   FROM starter_students
								   LEFT JOIN starter_students_personalinfo ON
								   starter_students_personalinfo.spinfo_student_id=starter_students.student_id
								   WHERE starter_students.student_entryid='$entryid'
								   AND starter_students.student_password='$password'
								   LIMIT 1
								  ");
		return $query->row();
	}
	
	public function update_student($student_id, $data)
	{
		$this->db->where('student_id', $student_id);
		$this->db->update('starter_students', $data);
	}
	
	public function update_reset_code($student_id, $data)
	{
		$this->db->where('student_id', $student_id);
		$this->db->update('starter_students', $data);
	}
	
	public function check_exist_email($email)
	{
		$query = $this->db->query("SELECT * FROM starter_students 
								   LEFT JOIN starter_students_personalinfo ON
								   starter_students_personalinfo.spinfo_student_id=starter_students.student_id
								   WHERE starter_students.student_email='$email' LIMIT 1");
		return $query->row();
	}
	
	public function check_resetcode($reset_code, $student_id)
	{
		$query = $this->db->query("SELECT student_id FROM starter_students WHERE starter_students.student_password_resetcde='$reset_code' AND starter_students.student_id='$student_id' ");
		return $query->row();
	}
	
	public function update_password($student_id, $data)
	{
		$this->db->where('student_id', $student_id);
		$this->db->update('starter_students', $data);
	}
	
}
