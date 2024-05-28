<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Evaluation_model extends CI_Model {
	
	public function get_all_evaluation($user_type)
	{
		$query = $this->db->query("SELECT * FROM starter_user_evaluations WHERE starter_user_evaluations.evaluation_user_type='$user_type' ORDER BY starter_user_evaluations.evaluation_id DESC");
		return $query->result_array();
	}
	
	public function get_student_infos($student_id)
	{
		$query = $this->db->query("SELECT 
								  starter_students.student_entryid,
								  starter_students.student_username,
								  starter_students_personalinfo.spinfo_first_name,
								  starter_students_personalinfo.spinfo_middle_name,
								  starter_students_personalinfo.spinfo_last_name,
								  starter_students_personalinfo.spinfo_photo
								  FROM starter_students 
								  LEFT JOIN starter_students_personalinfo ON
								  starter_students_personalinfo.spinfo_student_id=starter_students.student_id
								  WHERE starter_students.student_id='$student_id'
								  LIMIT 1
								  ");
		return $query->row_array();
	}
	
	public function get_teacher_infos($teacher_id)
	{
		$query = $this->db->query("SELECT 
								  starter_teachers.teacher_entryid,
								  starter_teachers.teacher_username,
								  starter_teachers_personalinfo.tpinfo_first_name,
								  starter_teachers_personalinfo.tpinfo_middle_name,
								  starter_teachers_personalinfo.tpinfo_last_name,
								  starter_teachers_personalinfo.tpinfo_photo
								  FROM starter_teachers
								  LEFT JOIN starter_teachers_personalinfo ON
								  starter_teachers_personalinfo.tpinfo_teacher_id=starter_teachers.teacher_id
								  WHERE starter_teachers.teacher_id='$teacher_id'
								  LIMIT 1
								  ");
		return $query->row_array();
	}
	
	public function get_evaluationby_id($evaluation_id)
	{
		$query = $this->db->query("SELECT * FROM starter_user_evaluations WHERE starter_user_evaluations.evaluation_id='$evaluation_id'");
		return $query->row_array();
	}
	
	public function get_ratingsby_evaluation($evaluation_id)
	{
		$query = $this->db->query("SELECT * FROM starter_evaluation_ratings WHERE starter_evaluation_ratings.rating_evaluation_id='$evaluation_id' ORDER BY starter_evaluation_ratings.rating_id ASC");
		return $query->result_array();
	}
	
	public function count_evaluations_by_studentid()
	{
		$query = $this->db->query("SELECT evaluation_id FROM starter_evaluations_by_students");
		return $query->num_rows();
	}
	
	public function get_evaluations_by_studentid($params=array())
	{
		if(!empty($params['limit']))
		{
			$limit = $params['limit'];
		}else
		{
			$limit = 10;
		}
		$query = $this->db->query("SELECT * 
								   FROM starter_evaluations_by_students 
								   LEFT JOIN starter_teachers_personalinfo ON
								   starter_teachers_personalinfo.tpinfo_teacher_id=starter_evaluations_by_students.evaluation_faculty_id
								   LEFT JOIN starter_teachers ON
								   starter_teachers.teacher_id=starter_evaluations_by_students.evaluation_faculty_id
								   LEFT JOIN starter_students_personalinfo ON
								   starter_students_personalinfo.spinfo_student_id=starter_evaluations_by_students.evaluation_by
								   LEFT JOIN starter_students ON
								   starter_students.student_id=starter_evaluations_by_students.evaluation_by
								   ORDER BY evaluation_id ASC LIMIT $limit");
		return $query->result_array();
	}
	
	public function count_evaluations_by_faculties()
	{
		$query = $this->db->query("SELECT evaluation_id FROM starter_evaluations_by_faculties");
		return $query->num_rows();
	}
	
	public function get_evaluations_by_faculties($params=array())
	{
		if(!empty($params['limit']))
		{
			$limit = $params['limit'];
		}else
		{
			$limit = 10;
		}
		$query = $this->db->query("SELECT * 
								   FROM starter_evaluations_by_faculties 
								   LEFT JOIN starter_teachers_personalinfo ON
								   starter_teachers_personalinfo.tpinfo_teacher_id=starter_evaluations_by_faculties.evaluation_by
								   LEFT JOIN starter_teachers ON
								   starter_teachers.teacher_id=starter_evaluations_by_faculties.evaluation_by
								   LEFT JOIN starter_students_personalinfo ON
								   starter_students_personalinfo.spinfo_student_id=starter_evaluations_by_faculties.evaluation_student_id 
								   LEFT JOIN starter_students ON
								   starter_students.student_id=starter_evaluations_by_faculties.evaluation_student_id
								   ORDER BY evaluation_id ASC LIMIT $limit");
		return $query->result_array();
	}
	
	public function get_faculty_evaluations_by_id($evl_id)
	{
		$query = $this->db->query("SELECT starter_evaluations_by_faculties.*, starter_students_personalinfo.spinfo_first_name, starter_students_personalinfo.spinfo_middle_name, starter_students_personalinfo.spinfo_last_name, starter_students.student_entryid FROM starter_evaluations_by_faculties 
								   LEFT JOIN starter_students_personalinfo ON
								   starter_students_personalinfo.spinfo_student_id=starter_evaluations_by_faculties.evaluation_student_id
								   LEFT JOIN starter_students ON
								   starter_students.student_id=starter_evaluations_by_faculties.evaluation_student_id
								   WHERE evaluation_id='$evl_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_faculties_ratingsby_evaluationid($evaluation_id)
	{
		$query = $this->db->query("SELECT * 
								   FROM starter_students_evaluation_ratings
								   LEFT JOIN starter_faculties_evaluations ON
								   starter_faculties_evaluations.eval_id=starter_students_evaluation_ratings.rating_eval_id
								   WHERE rating_evaluation_id='$evaluation_id'
								   ORDER BY rating_id ASC");
		return $query->result_array();
	}
	
	public function get_evaluations_by_id($evl_id)
	{
		$query = $this->db->query("SELECT starter_evaluations_by_students.*, starter_teachers_personalinfo.tpinfo_first_name, starter_teachers_personalinfo.tpinfo_middle_name, starter_teachers_personalinfo.tpinfo_last_name FROM starter_evaluations_by_students 
								   LEFT JOIN starter_teachers_personalinfo ON
								   starter_teachers_personalinfo.tpinfo_teacher_id=starter_evaluations_by_students.evaluation_faculty_id
								   WHERE evaluation_id='$evl_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_ratingsby_evaluationid($evaluation_id)
	{
		$query = $this->db->query("SELECT * 
								   FROM starter_faculties_evaluation_ratings
								   LEFT JOIN starter_evaluations ON
								   starter_evaluations.eval_id=starter_faculties_evaluation_ratings.rating_eval_id
								   WHERE rating_evaluation_id='$evaluation_id'
								   ORDER BY rating_id ASC");
		return $query->result_array();
	}
	
}
