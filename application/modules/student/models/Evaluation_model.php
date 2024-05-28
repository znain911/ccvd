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
	
	public function save_evaluation($data)
	{
		$this->db->insert('starter_user_evaluations', $data);
	}
	
	public function save_ratings($data)
	{
		$this->db->insert('starter_evaluation_ratings', $data);
	}
	
	public function get_faculties($q)
	{
		$query = $this->db->query("SELECT 
								   tpinfo_teacher_id, 
								   tpinfo_first_name, 
								   tpinfo_middle_name, 
								   tpinfo_last_name 
								   FROM starter_teachers_personalinfo WHERE (tpinfo_first_name LIKE '%$q%' OR tpinfo_middle_name LIKE '%$q%' OR tpinfo_last_name LIKE '%$q%') LIMIT 10");
		return $query->result_array();
	}
	
	public function get_ratings()
	{
		$query = $this->db->query("SELECT * FROM starter_evaluations ORDER BY eval_id ASC");
		return $query->result_array();
	}
	
	public function save_evaluation_info($data)
	{
		$this->db->insert('starter_evaluations_by_students', $data);
	}
	
	public function save_evaluation_ratings_info($data)
	{
		$this->db->insert('starter_faculties_evaluation_ratings', $data);
	}
	
	public function count_evaluations_by_studentid()
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT evaluation_id FROM starter_evaluations_by_students 
								   WHERE evaluation_by='$student_id' AND evaluation_status=1");
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
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT starter_evaluations_by_students.*, starter_teachers_personalinfo.tpinfo_first_name, starter_teachers_personalinfo.tpinfo_middle_name, starter_teachers_personalinfo.tpinfo_last_name FROM starter_evaluations_by_students 
								   LEFT JOIN starter_teachers_personalinfo ON
								   starter_teachers_personalinfo.tpinfo_teacher_id=starter_evaluations_by_students.evaluation_faculty_id
								   WHERE evaluation_by='$student_id' AND evaluation_status=1 ORDER BY evaluation_id ASC LIMIT $limit");
		return $query->result_array();
	}
	
}