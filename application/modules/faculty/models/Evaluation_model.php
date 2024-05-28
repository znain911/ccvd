<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Evaluation_model extends CI_Model{
	
	public function generate_evaluation_id()
	{
		$query = $this->db->query('SELECT evaluation_id FROM starter_user_evaluations');
		return 10000+$query->num_rows()+1;
	}
	
	public function get_eval_labels()
	{
		$query = $this->db->query("SELECT * FROM starter_evaluations ORDER BY starter_evaluations.eval_id ASC");
		return $query->result_array();
	}
	
	public function save_evaluation_info($data)
	{
		$this->db->insert('starter_evaluations_by_faculties', $data);
	}
	
	public function save_evaluation_ratings_info($data)
	{
		$this->db->insert('starter_students_evaluation_ratings', $data);
	}
	
	public function count_evaluations_by_facultyid()
	{
		$teacher_id = $this->session->userdata('active_teacher');
		$query = $this->db->query("SELECT evaluation_id FROM starter_evaluations_by_faculties 
								   WHERE evaluation_by='$teacher_id' AND evaluation_status=1");
		return $query->num_rows();
	}
	
	public function get_evaluations_by_facultyid($params=array())
	{
		if(!empty($params['limit']))
		{
			$limit = $params['limit'];
		}else
		{
			$limit = 10;
		}
		$teacher_id = $this->session->userdata('active_teacher');
		$query = $this->db->query("SELECT starter_evaluations_by_faculties.*, starter_students_personalinfo.spinfo_first_name, starter_students_personalinfo.spinfo_middle_name, starter_students_personalinfo.spinfo_last_name FROM starter_evaluations_by_faculties 
								   LEFT JOIN starter_students_personalinfo ON
								   starter_students_personalinfo.spinfo_student_id=starter_evaluations_by_faculties.evaluation_student_id
								   WHERE evaluation_by='$teacher_id' AND evaluation_status=1 ORDER BY evaluation_id ASC LIMIT $limit");
		return $query->result_array();
	}
	
	public function get_students($q)
	{
		$query = $this->db->query("SELECT 
								   spinfo_student_id, 
								   spinfo_first_name, 
								   spinfo_middle_name, 
								   spinfo_last_name 
								   FROM starter_students_personalinfo WHERE (spinfo_first_name LIKE '%$q%' OR spinfo_middle_name LIKE '%$q%' OR spinfo_last_name LIKE '%$q%') LIMIT 10");
		return $query->result_array();
	}
	
	public function get_ratings()
	{
		$query = $this->db->query("SELECT * FROM starter_faculties_evaluations ORDER BY eval_id ASC");
		return $query->result_array();
	}
	
}