<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Evaluation_model extends CI_Model{
	
	public function count_evaluations_by_studentid()
	{
		$student_id = $this->session->userdata('active_student');
		$query = "SELECT 
				  evaluation_id 
				  FROM starter_evaluations_by_students 
				  LEFT JOIN starter_teachers_personalinfo ON
				  starter_teachers_personalinfo.tpinfo_teacher_id=starter_evaluations_by_students.evaluation_faculty_id ";
		$query .= "WHERE evaluation_status=1 AND evaluation_by='$student_id' ";
		
		if(!empty($params['search']['month']) && !empty($params['search']['year']))
		{
			$month = $params['search']['month'];
			$year = $params['search']['year'];
			$make_date = $year.'-'.$month.'-';
			$query .= "AND evaluation_create_date LIKE '%$make_date%' ";
		}else if(!empty($params['search']['month']) && empty($params['search']['year'])){
			$month = $params['search']['month'];
			$make_date = '-'.$month.'-';
			$query .= "AND evaluation_create_date LIKE '%$make_date%' ";
		}else if(empty($params['search']['month']) && !empty($params['search']['year'])){
			$year = $params['search']['year'];
			$make_date = $year.'-';
			$query .= "AND evaluation_create_date LIKE '%$make_date%' ";
		}
		
		if(!empty($params['search']['keywords'])){
			$search_term = $params['search']['keywords'];
			$query .= "AND (tpinfo_first_name LIKE '%$search_term%' ";
			$query .= "OR evaluation_title LIKE '%$search_term%' ";
			$query .= "OR tpinfo_middle_name LIKE '%$search_term%' ";
			$query .= "OR tpinfo_last_name LIKE '%$search_term%') ";
        }
		
		$result = $this->db->query($query);
		return $result->num_rows();
	}
	
	public function count_coordinator_evaluations_by_studentid()
	{
		$query = "SELECT 
				  evaluation_id 
				  FROM starter_evaluations_by_students 
				  LEFT JOIN starter_teachers_personalinfo ON
				  starter_teachers_personalinfo.tpinfo_teacher_id=starter_evaluations_by_students.evaluation_faculty_id 
				  LEFT JOIN starter_students_personalinfo ON
				  starter_students_personalinfo.spinfo_student_id=starter_evaluations_by_students.evaluation_by ";
		$query .= "WHERE evaluation_status=1 ";
		if(!empty($params['search']['month']) && !empty($params['search']['year']))
		{
			$month = $params['search']['month'];
			$year = $params['search']['year'];
			$make_date = $year.'-'.$month.'-';
			$query .= "AND evaluation_create_date LIKE '%$make_date%' ";
		}else if(!empty($params['search']['month']) && empty($params['search']['year'])){
			$month = $params['search']['month'];
			$make_date = '-'.$month.'-';
			$query .= "AND evaluation_create_date LIKE '%$make_date%' ";
		}else if(empty($params['search']['month']) && !empty($params['search']['year'])){
			$year = $params['search']['year'];
			$make_date = $year.'-';
			$query .= "AND evaluation_create_date LIKE '%$make_date%' ";
		}
		
		if(!empty($params['search']['keywords'])){
			$search_term = $params['search']['keywords'];
			$query .= "AND (tpinfo_first_name LIKE '%$search_term%' ";
			$query .= "OR evaluation_title LIKE '%$search_term%' ";
			$query .= "OR tpinfo_middle_name LIKE '%$search_term%' ";
			$query .= "OR tpinfo_last_name LIKE '%$search_term%') ";
        }
		
		$result = $this->db->query($query);
		return $result->num_rows();
	}
	
	function get_evaluations_by_studentid($params = array()){
		$student_id = $this->session->userdata('active_student');
		$query = "SELECT 
				  starter_evaluations_by_students.*, 
				  starter_teachers_personalinfo.tpinfo_first_name, 
				  starter_teachers_personalinfo.tpinfo_middle_name, 
				  starter_teachers_personalinfo.tpinfo_last_name 
				  FROM starter_evaluations_by_students 
				  LEFT JOIN starter_teachers_personalinfo ON
				  starter_teachers_personalinfo.tpinfo_teacher_id=starter_evaluations_by_students.evaluation_faculty_id ";
		$query .= "WHERE evaluation_status=1 AND evaluation_by='$student_id' ";
		
		if(!empty($params['search']['month']) && !empty($params['search']['year']))
		{
			$month = $params['search']['month'];
			$year = $params['search']['year'];
			$make_date = $year.'-'.$month.'-';
			$query .= "AND evaluation_create_date LIKE '%$make_date%' ";
		}else if(!empty($params['search']['month']) && empty($params['search']['year'])){
			$month = $params['search']['month'];
			$make_date = '-'.$month.'-';
			$query .= "AND evaluation_create_date LIKE '%$make_date%' ";
		}else if(empty($params['search']['month']) && !empty($params['search']['year'])){
			$year = $params['search']['year'];
			$make_date = $year.'-';
			$query .= "AND evaluation_create_date LIKE '%$make_date%' ";
		}
		
		if(!empty($params['search']['keywords'])){
			$search_term = $params['search']['keywords'];
			$query .= "AND (tpinfo_first_name LIKE '%$search_term%' ";
			$query .= "OR evaluation_title LIKE '%$search_term%' ";
			$query .= "OR tpinfo_middle_name LIKE '%$search_term%' ";
			$query .= "OR tpinfo_last_name LIKE '%$search_term%') ";
        }
		if(!empty($params['search']['sortby'])){
			$sortby = $params['search']['sortby'];
			$query .= "ORDER BY evaluation_id $sortby ";
		}else
		{
			$query .= "ORDER BY evaluation_id DESC ";
		}
		if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
			$start = $params['start'];
			$query .= "LIMIT {$start},{$limit} ";
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
            $query .= "LIMIT {$limit} ";
        }
		
		$result = $this->db->query($query);
		return $result->result_array();
        
    }
	
	function get_coordinator_evaluations_by_studentid($params = array()){
		$query = "SELECT 
				  * 
				  FROM starter_evaluations_by_students 
				  LEFT JOIN starter_teachers_personalinfo ON
				  starter_teachers_personalinfo.tpinfo_teacher_id=starter_evaluations_by_students.evaluation_faculty_id 
				  LEFT JOIN starter_students_personalinfo ON
				  starter_students_personalinfo.spinfo_student_id=starter_evaluations_by_students.evaluation_by
				  LEFT JOIN starter_teachers ON
				  starter_teachers.teacher_id=starter_evaluations_by_students.evaluation_faculty_id 
				  LEFT JOIN starter_students ON
				  starter_students.student_id=starter_evaluations_by_students.evaluation_by ";
		$query .= "WHERE evaluation_status=1 ";
		if(!empty($params['search']['month']) && !empty($params['search']['year']))
		{
			$month = $params['search']['month'];
			$year = $params['search']['year'];
			$make_date = $year.'-'.$month.'-';
			$query .= "AND evaluation_create_date LIKE '%$make_date%' ";
		}else if(!empty($params['search']['month']) && empty($params['search']['year'])){
			$month = $params['search']['month'];
			$make_date = '-'.$month.'-';
			$query .= "AND evaluation_create_date LIKE '%$make_date%' ";
		}else if(empty($params['search']['month']) && !empty($params['search']['year'])){
			$year = $params['search']['year'];
			$make_date = $year.'-';
			$query .= "AND evaluation_create_date LIKE '%$make_date%' ";
		}
		
		if(!empty($params['search']['keywords'])){
			$search_term = $params['search']['keywords'];
			$query .= "AND (tpinfo_first_name LIKE '%$search_term%' ";
			$query .= "OR evaluation_title LIKE '%$search_term%' ";
			$query .= "OR tpinfo_middle_name LIKE '%$search_term%' ";
			$query .= "OR tpinfo_last_name LIKE '%$search_term%') ";
        }
		if(!empty($params['search']['sortby'])){
			$sortby = $params['search']['sortby'];
			$query .= "ORDER BY evaluation_id $sortby ";
		}else
		{
			$query .= "ORDER BY evaluation_id DESC ";
		}
		if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
			$start = $params['start'];
			$query .= "LIMIT {$start},{$limit} ";
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
            $query .= "LIMIT {$limit} ";
        }
		
		$result = $this->db->query($query);
		return $result->result_array();
        
    }
	
	public function count_evaluations_by_facultyid()
	{
		$teacher_id = $this->session->userdata('active_teacher');
		$query = "SELECT 
				  evaluation_id 
				  FROM starter_evaluations_by_faculties 
				  LEFT JOIN starter_students_personalinfo ON
				  starter_students_personalinfo.spinfo_student_id=starter_evaluations_by_faculties.evaluation_student_id ";
		$query .= "WHERE evaluation_status=1 AND evaluation_by='$teacher_id' ";
		
		if(!empty($params['search']['month']) && !empty($params['search']['year']))
		{
			$month = $params['search']['month'];
			$year = $params['search']['year'];
			$make_date = $year.'-'.$month.'-';
			$query .= "AND evaluation_create_date LIKE '%$make_date%' ";
		}else if(!empty($params['search']['month']) && empty($params['search']['year'])){
			$month = $params['search']['month'];
			$make_date = '-'.$month.'-';
			$query .= "AND evaluation_create_date LIKE '%$make_date%' ";
		}else if(empty($params['search']['month']) && !empty($params['search']['year'])){
			$year = $params['search']['year'];
			$make_date = $year.'-';
			$query .= "AND evaluation_create_date LIKE '%$make_date%' ";
		}
		
		if(!empty($params['search']['keywords'])){
			$search_term = $params['search']['keywords'];
			$query .= "AND (spinfo_first_name LIKE '%$search_term%' ";
			$query .= "OR evaluation_title LIKE '%$search_term%' ";
			$query .= "OR spinfo_middle_name LIKE '%$search_term%' ";
			$query .= "OR spinfo_last_name LIKE '%$search_term%') ";
        }
		
		$result = $this->db->query($query);
		return $result->num_rows();
	}
	
	public function count_coordinator_evaluations_by_facultyid()
	{
		$teacher_id = $this->session->userdata('active_teacher');
		$query = "SELECT 
				  evaluation_id 
				  FROM starter_evaluations_by_faculties
				  LEFT JOIN starter_teachers_personalinfo ON
				  starter_teachers_personalinfo.tpinfo_teacher_id=starter_evaluations_by_faculties.evaluation_by 
				  LEFT JOIN starter_students_personalinfo ON
				  starter_students_personalinfo.spinfo_student_id=starter_evaluations_by_faculties.evaluation_student_id
				  LEFT JOIN starter_teachers ON
				  starter_teachers.teacher_id=starter_evaluations_by_faculties.evaluation_by 
				  LEFT JOIN starter_students ON
				  starter_students.student_id=starter_evaluations_by_faculties.evaluation_student_id ";
		$query .= "WHERE evaluation_status=1 ";
		
		if(!empty($params['search']['month']) && !empty($params['search']['year']))
		{
			$month = $params['search']['month'];
			$year = $params['search']['year'];
			$make_date = $year.'-'.$month.'-';
			$query .= "AND evaluation_create_date LIKE '%$make_date%' ";
		}else if(!empty($params['search']['month']) && empty($params['search']['year'])){
			$month = $params['search']['month'];
			$make_date = '-'.$month.'-';
			$query .= "AND evaluation_create_date LIKE '%$make_date%' ";
		}else if(empty($params['search']['month']) && !empty($params['search']['year'])){
			$year = $params['search']['year'];
			$make_date = $year.'-';
			$query .= "AND evaluation_create_date LIKE '%$make_date%' ";
		}
		
		if(!empty($params['search']['keywords'])){
			$search_term = $params['search']['keywords'];
			$query .= "AND (spinfo_first_name LIKE '%$search_term%' ";
			$query .= "OR evaluation_title LIKE '%$search_term%' ";
			$query .= "OR spinfo_middle_name LIKE '%$search_term%' ";
			$query .= "OR spinfo_last_name LIKE '%$search_term%') ";
        }
		
		$result = $this->db->query($query);
		return $result->num_rows();
	}
	
	function get_evaluations_by_facultyid($params = array()){
		$teacher_id = $this->session->userdata('active_teacher');
		$query = "SELECT 
				  starter_evaluations_by_faculties.*, 
				  starter_students_personalinfo.spinfo_first_name, 
				  starter_students_personalinfo.spinfo_middle_name, 
				  starter_students_personalinfo.spinfo_last_name 
				  FROM starter_evaluations_by_faculties 
				  LEFT JOIN starter_students_personalinfo ON
				  starter_students_personalinfo.spinfo_student_id=starter_evaluations_by_faculties.evaluation_student_id ";
		$query .= "WHERE evaluation_status=1 AND evaluation_by='$teacher_id' ";
		
		if(!empty($params['search']['month']) && !empty($params['search']['year']))
		{
			$month = $params['search']['month'];
			$year = $params['search']['year'];
			$make_date = $year.'-'.$month.'-';
			$query .= "AND evaluation_create_date LIKE '%$make_date%' ";
		}else if(!empty($params['search']['month']) && empty($params['search']['year'])){
			$month = $params['search']['month'];
			$make_date = '-'.$month.'-';
			$query .= "AND evaluation_create_date LIKE '%$make_date%' ";
		}else if(empty($params['search']['month']) && !empty($params['search']['year'])){
			$year = $params['search']['year'];
			$make_date = $year.'-';
			$query .= "AND evaluation_create_date LIKE '%$make_date%' ";
		}
		
		if(!empty($params['search']['keywords'])){
			$search_term = $params['search']['keywords'];
			$query .= "AND (spinfo_first_name LIKE '%$search_term%' ";
			$query .= "OR evaluation_title LIKE '%$search_term%' ";
			$query .= "OR spinfo_middle_name LIKE '%$search_term%' ";
			$query .= "OR spinfo_last_name LIKE '%$search_term%') ";
        }
		if(!empty($params['search']['sortby'])){
			$sortby = $params['search']['sortby'];
			$query .= "ORDER BY evaluation_id $sortby ";
		}else
		{
			$query .= "ORDER BY evaluation_id DESC ";
		}
		if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
			$start = $params['start'];
			$query .= "LIMIT {$start},{$limit} ";
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
            $query .= "LIMIT {$limit} ";
        }
		
		$result = $this->db->query($query);
		return $result->result_array();
        
    }
	
	function get_coordinator_evaluations_by_facultyid($params = array()){
		$teacher_id = $this->session->userdata('active_teacher');
		$query = "SELECT 
				  *
				  FROM starter_evaluations_by_faculties 
				  LEFT JOIN starter_teachers_personalinfo ON
				  starter_teachers_personalinfo.tpinfo_teacher_id=starter_evaluations_by_faculties.evaluation_by 
				  LEFT JOIN starter_students_personalinfo ON
				  starter_students_personalinfo.spinfo_student_id=starter_evaluations_by_faculties.evaluation_student_id
				  LEFT JOIN starter_teachers ON
				  starter_teachers.teacher_id=starter_evaluations_by_faculties.evaluation_by 
				  LEFT JOIN starter_students ON
				  starter_students.student_id=starter_evaluations_by_faculties.evaluation_student_id ";
		$query .= "WHERE evaluation_status=1 ";
		
		if(!empty($params['search']['month']) && !empty($params['search']['year']))
		{
			$month = $params['search']['month'];
			$year = $params['search']['year'];
			$make_date = $year.'-'.$month.'-';
			$query .= "AND evaluation_create_date LIKE '%$make_date%' ";
		}else if(!empty($params['search']['month']) && empty($params['search']['year'])){
			$month = $params['search']['month'];
			$make_date = '-'.$month.'-';
			$query .= "AND evaluation_create_date LIKE '%$make_date%' ";
		}else if(empty($params['search']['month']) && !empty($params['search']['year'])){
			$year = $params['search']['year'];
			$make_date = $year.'-';
			$query .= "AND evaluation_create_date LIKE '%$make_date%' ";
		}
		
		if(!empty($params['search']['keywords'])){
			$search_term = $params['search']['keywords'];
			$query .= "AND (spinfo_first_name LIKE '%$search_term%' ";
			$query .= "OR evaluation_title LIKE '%$search_term%' ";
			$query .= "OR spinfo_middle_name LIKE '%$search_term%' ";
			$query .= "OR spinfo_last_name LIKE '%$search_term%') ";
        }
		if(!empty($params['search']['sortby'])){
			$sortby = $params['search']['sortby'];
			$query .= "ORDER BY evaluation_id $sortby ";
		}else
		{
			$query .= "ORDER BY evaluation_id DESC ";
		}
		if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
			$start = $params['start'];
			$query .= "LIMIT {$start},{$limit} ";
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
            $query .= "LIMIT {$limit} ";
        }
		
		$result = $this->db->query($query);
		return $result->result_array();
        
    }
	
	public function get_ratings()
	{
		$query = $this->db->query("SELECT * FROM starter_evaluations ORDER BY eval_id ASC");
		return $query->result_array();
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
	
}