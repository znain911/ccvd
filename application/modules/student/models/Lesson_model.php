<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lesson_model extends CI_Model {
	
	public function get_lessonby_id($lesson_id)
	{
		$query = $this->db->query("SELECT * FROM starter_modules_lessons 
								   LEFT JOIN starter_modules ON
								   starter_modules.module_id=starter_modules_lessons.lesson_module_id
								   WHERE starter_modules_lessons.lesson_id='$lesson_id' 
								   LIMIT 1");
		return $query->row_array();
	}
	
	public function get_student_phone($student_id)
	{
		$query = $this->db->query("SELECT spinfo_personal_phone FROM starter_students_personalinfo WHERE starter_students_personalinfo.spinfo_student_id='$student_id'");
		$result = $query->row_array();
		return $result['spinfo_personal_phone'];
	}
	
	public function get_max_mdl($module_id, $phase_id)
	{
		$query = $this->db->query("SELECT module_id FROM starter_modules WHERE starter_modules.module_phase_id='$phase_id' AND starter_modules.module_id > '$module_id' LIMIT 1");
		$result = $query->row_array();
		if($result['module_id'])
		{
			$value = $result['module_id'];
		}else
		{
			$value = 0;
		}
		
		return $value;
	}
	
	public function get_active_phase($student_id)
	{
		$query = $this->db->query("SELECT student_phaselevel_id FROM starter_students WHERE starter_students.student_id='$student_id' LIMIT 1");
		$result = $query->row_array();
		if($result['student_phaselevel_id'])
		{
			$value = $result['student_phaselevel_id'];
		}else
		{
			$value = 0;
		}
		
		return $value;
	}
	
}
