<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faculties_model extends CI_Model {
	
	function get_pending_teachers($params = array()){
		
		$query = "SELECT 
				  starter_teachers.*,
				  starter_teachers_personalinfo.tpinfo_first_name,
				  starter_teachers_personalinfo.tpinfo_middle_name,
				  starter_teachers_personalinfo.tpinfo_last_name,
				  starter_teachers_personalinfo.tpinfo_photo,
				  starter_teachers_personalinfo.tpinfo_personal_phone
				  FROM starter_teachers 
				  LEFT JOIN starter_teachers_personalinfo ON
				  starter_teachers_personalinfo.tpinfo_teacher_id=starter_teachers.teacher_id
				  ";
		$query .= "WHERE teacher_status=0 ";
		if(!empty($params['search']['keywords'])){
			$search_term = $params['search']['keywords'];
			$query .= "AND (teacher_entryid LIKE '%$search_term%' ";
			$query .= "OR teacher_username LIKE '%$search_term%' ";
			$query .= "OR teacher_email LIKE '%$search_term%') ";
        }
		if(!empty($params['search']['sortby'])){
			$sortby = $params['search']['sortby'];
			$query .= "ORDER BY teacher_id $sortby ";
		}else
		{
			$query .= "ORDER BY teacher_id DESC ";
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
	
	function get_enrolled_teachers($params = array()){
		
		$query = "SELECT 
				  starter_teachers.*,
				  starter_teachers_personalinfo.tpinfo_first_name,
				  starter_teachers_personalinfo.tpinfo_middle_name,
				  starter_teachers_personalinfo.tpinfo_last_name,
				  starter_teachers_personalinfo.tpinfo_photo,
				  starter_teachers_personalinfo.tpinfo_personal_phone
				  FROM starter_teachers 
				  LEFT JOIN starter_teachers_personalinfo ON
				  starter_teachers_personalinfo.tpinfo_teacher_id=starter_teachers.teacher_id
				  ";
		$query .= "WHERE teacher_status=1 ";
		if(!empty($params['search']['keywords'])){
			$search_term = $params['search']['keywords'];
			$query .= "AND (teacher_entryid LIKE '%$search_term%' ";
			$query .= "OR teacher_username LIKE '%$search_term%' ";
			$query .= "OR teacher_email LIKE '%$search_term%') ";
        }
		
		if(!empty($params['search']['sortby'])){
			$sortby = $params['search']['sortby'];
			$query .= "ORDER BY teacher_id $sortby ";
		}else
		{
			$query .= "ORDER BY teacher_id DESC ";
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
	
	public function get_teacher_info($teacher_id)
	{
		$query = $this->db->query("SELECT *
								   FROM starter_teachers
								   LEFT JOIN starter_teachers_academicinfo ON
								   starter_teachers_academicinfo.tacinfo_teacher_id=starter_teachers.teacher_id
								   LEFT JOIN starter_teachers_personalinfo ON
								   starter_teachers_personalinfo.tpinfo_teacher_id=starter_teachers.teacher_id
								   LEFT JOIN starter_teachers_professionalinfo ON
								   starter_teachers_professionalinfo.spsinfo_teacher_id=starter_teachers.teacher_id
								   LEFT JOIN starter_countries ON
								   starter_countries.country_id=starter_teachers_personalinfo.tpinfo_nationality
								   WHERE starter_teachers.teacher_id='$teacher_id'
								   LIMIT 1
								  ");
		return $query->row_array();
	}
	
	public function get_teacher_username($teacher_id)
	{
		$query = $this->db->query("SELECT teacher_username FROM starter_teachers WHERE starter_teachers.teacher_id='$teacher_id' LIMIT 1");
		$result = $query->row_array();
		return $result['teacher_username'];
	}
	
	public function get_specializations($teacher_id)
	{
		$query = $this->db->query("SELECT
								  *
								  FROM starter_teachers_specializations
								  LEFT JOIN starter_specialization ON
								  starter_specialization.specialize_id=starter_teachers_specializations.ts_specilzation_id
								  WHERE starter_teachers_specializations.ts_teacher_id='$teacher_id'
								  ORDER BY starter_teachers_specializations.ts_id ASC
								  "); 
		return $query->result_array();
	}
	
	public function get_dlp_categories($teacher_id)
	{
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
	
	public function get_academicinformation($teacher_id)
	{
		$query = $this->db->query("SELECT
								   *
								   FROM starter_teachers_academicinfo
								   WHERE starter_teachers_academicinfo.tacinfo_teacher_id='$teacher_id'
								   ORDER BY starter_teachers_academicinfo.tacinfo_id ASC
								  ");
		return $query->result_array();
	}
	
}
