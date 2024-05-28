<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Students_model extends CI_Model {
	
	function get_pending_students($params = array()){
		
		$query = "SELECT 
				  starter_students.*,
				  starter_students_personalinfo.spinfo_first_name,
				  starter_students_personalinfo.spinfo_middle_name,
				  starter_students_personalinfo.spinfo_last_name,
				  starter_students_personalinfo.spinfo_photo,
				  starter_students_personalinfo.spinfo_personal_phone
				  FROM starter_students 
				  LEFT JOIN starter_students_personalinfo ON
				  starter_students_personalinfo.spinfo_student_id=starter_students.student_id
				  ";
		$query .= "WHERE starter_students.student_status=0 AND starter_students.info_status = 1 ";
		if(!empty($params['search']['from_date']) && !empty($params['search']['to_date'])){
			$from_date = $params['search']['from_date'];
			$to_date = $params['search']['to_date'];
			$query .= "AND student_regdate>='$from_date' AND student_regdate <='$to_date' ";
        }
		if(!empty($params['search']['month']) && !empty($params['search']['year']))
		{
			$month = $params['search']['month'];
			$year = $params['search']['year'];
			$make_date = $year.'-'.$month.'-';
			$query .= "AND student_regdate LIKE '%$make_date%' ";
		}else if(!empty($params['search']['month']) && empty($params['search']['year'])){
			$month = $params['search']['month'];
			$make_date = '-'.$month.'-';
			$query .= "AND student_regdate LIKE '%$make_date%' ";
		}else if(empty($params['search']['month']) && !empty($params['search']['year'])){
			$year = $params['search']['year'];
			$make_date = $year.'-';
			$query .= "AND student_regdate LIKE '%$make_date%' ";
		}
		if(!empty($params['search']['keywords'])){
			$search_term = $params['search']['keywords'];
			$query .= "AND (student_entryid LIKE '%$search_term%' ";
			$query .= "OR student_username LIKE '%$search_term%' ";
			$query .= "OR student_email LIKE '%$search_term%') ";
        }
		if(!empty($params['search']['keywords'])){
			$search_term = $params['search']['keywords'];
			$query .= "AND (student_entryid LIKE '%$search_term%' ";
			$query .= "OR student_username LIKE '%$search_term%' ";
			$query .= "OR student_email LIKE '%$search_term%') ";
        }
		if(!empty($params['search']['batch'])){
			$batchno = $params['search']['batch'] ;
			$query .= " AND batch_name=$batchno " ;
		}
		if(!empty($params['search']['sortby'])){
			$sortby = $params['search']['sortby'];
			$query .= "ORDER BY student_id $sortby ";
		}
		else
		{
			$query .= "ORDER BY student_id DESC ";
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
	
	function get_enrolled_students($params = array()){
		
		$query = "SELECT 
				  starter_students.*,
				  starter_students_personalinfo.spinfo_first_name,
				  starter_students_personalinfo.spinfo_middle_name,
				  starter_students_personalinfo.spinfo_last_name,
				  starter_students_personalinfo.spinfo_photo,
				  starter_students_personalinfo.spinfo_personal_phone,
				  districts.name,
				  pd.name as pdis,
				  starter_students_professionalinfo.spsinfo_bmanddc_number,
				  starter_students_professionalinfo.spsinfo_designation
				  FROM starter_students 
				  LEFT JOIN starter_students_personalinfo ON
				  starter_students_personalinfo.spinfo_student_id=starter_students.student_id
				  LEFT JOIN districts ON
				  districts.id=starter_students_personalinfo.spinfo_current_district
				  LEFT JOIN districts as pd ON
				  pd.id=starter_students_personalinfo.spinfo_permanent_district
				  LEFT JOIN starter_students_professionalinfo ON
				  starter_students_professionalinfo.spsinfo_student_id=starter_students.student_id
				  ";
		$query .= "WHERE student_status=1 AND student_enrolled = 1 ";
		if(!empty($params['search']['from_date']) && !empty($params['search']['to_date'])){
			$from_date = $params['search']['from_date'];
			$to_date = $params['search']['to_date'];
			$query .= "AND student_regdate>='$from_date' AND student_regdate <='$to_date' ";
        }
		if(!empty($params['search']['month']) && !empty($params['search']['year']))
		{
			$month = $params['search']['month'];
			$year = $params['search']['year'];
			$make_date = $year.'-'.$month.'-';
			$query .= "AND student_regdate LIKE '%$make_date%' ";
		}else if(!empty($params['search']['month']) && empty($params['search']['year'])){
			$month = $params['search']['month'];
			$make_date = '-'.$month.'-';
			$query .= "AND student_regdate LIKE '%$make_date%' ";
		}else if(empty($params['search']['month']) && !empty($params['search']['year'])){
			$year = $params['search']['year'];
			$make_date = $year.'-';
			$query .= "AND student_regdate LIKE '%$make_date%' ";
		}
		if(!empty($params['search']['keywords'])){
			$search_term = $params['search']['keywords'];
			$query .= "AND (student_entryid LIKE '%$search_term%' ";
			$query .= "OR student_username LIKE '%$search_term%' ";
			$query .= "OR student_email LIKE '%$search_term%') ";
        }
        if(!empty($params['search']['batch'])){
			$batchno = $params['search']['batch'] ;
			$query .= " AND batch_name=$batchno " ;
		}
		
		if(!empty($params['search']['sortby'])){
			$sortby = $params['search']['sortby'];
			$query .= "ORDER BY student_id $sortby ";
		}else
		{
			$query .= "ORDER BY student_id DESC ";
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

    function get_approved_students($params = array()){
		
		$query = "SELECT 
				  starter_students.*,
				  starter_students_personalinfo.spinfo_first_name,
				  starter_students_personalinfo.spinfo_middle_name,
				  starter_students_personalinfo.spinfo_last_name,
				  starter_students_personalinfo.spinfo_photo,
				  starter_students_personalinfo.spinfo_personal_phone,
				  districts.name,
				  pd.name as pdis,
				  starter_students_professionalinfo.spsinfo_bmanddc_number,
				  starter_students_professionalinfo.spsinfo_designation
				  FROM starter_students 
				  LEFT JOIN starter_students_personalinfo ON
				  starter_students_personalinfo.spinfo_student_id=starter_students.student_id
				  LEFT JOIN districts ON
				  districts.id=starter_students_personalinfo.spinfo_current_district
				  LEFT JOIN districts as pd ON
				  pd.id=starter_students_personalinfo.spinfo_permanent_district
				  LEFT JOIN starter_students_professionalinfo ON
				  starter_students_professionalinfo.spsinfo_student_id=starter_students.student_id
				  ";
		$query .= "WHERE student_status=1 AND student_enrolled = 0 ";
		if(!empty($params['search']['from_date']) && !empty($params['search']['to_date'])){
			$from_date = $params['search']['from_date'];
			$to_date = $params['search']['to_date'];
			$query .= "AND student_regdate>='$from_date' AND student_regdate <='$to_date' ";
        }
		if(!empty($params['search']['month']) && !empty($params['search']['year']))
		{
			$month = $params['search']['month'];
			$year = $params['search']['year'];
			$make_date = $year.'-'.$month.'-';
			$query .= "AND student_regdate LIKE '%$make_date%' ";
		}else if(!empty($params['search']['month']) && empty($params['search']['year'])){
			$month = $params['search']['month'];
			$make_date = '-'.$month.'-';
			$query .= "AND student_regdate LIKE '%$make_date%' ";
		}else if(empty($params['search']['month']) && !empty($params['search']['year'])){
			$year = $params['search']['year'];
			$make_date = $year.'-';
			$query .= "AND student_regdate LIKE '%$make_date%' ";
		}
		if(!empty($params['search']['keywords'])){
			$search_term = $params['search']['keywords'];
			$query .= "AND (student_entryid LIKE '%$search_term%' ";
			$query .= "OR student_username LIKE '%$search_term%' ";
			$query .= "OR student_email LIKE '%$search_term%') ";
        }
        if(!empty($params['search']['batch'])){
			$batchno = $params['search']['batch'] ;
			$query .= " AND batch_name=$batchno " ;
		}
		
		if(!empty($params['search']['sortby'])){
			$sortby = $params['search']['sortby'];
			$query .= "ORDER BY student_id $sortby ";
		}else
		{
			$query .= "ORDER BY student_id DESC ";
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

    function get_waiting_students($params = array()){
		
		$query = "SELECT 
				  starter_students.*,
				  starter_students_personalinfo.spinfo_first_name,
				  starter_students_personalinfo.spinfo_middle_name,
				  starter_students_personalinfo.spinfo_last_name,
				  starter_students_personalinfo.spinfo_photo,
				  starter_students_personalinfo.spinfo_personal_phone,
				  districts.name,
				  pd.name as pdis,
				  starter_students_professionalinfo.spsinfo_bmanddc_number,
				  starter_students_professionalinfo.spsinfo_designation
				  FROM starter_students 
				  LEFT JOIN starter_students_personalinfo ON
				  starter_students_personalinfo.spinfo_student_id=starter_students.student_id
				  LEFT JOIN districts ON
				  districts.id=starter_students_personalinfo.spinfo_current_district
				  LEFT JOIN districts as pd ON
				  pd.id=starter_students_personalinfo.spinfo_permanent_district
				  LEFT JOIN starter_students_professionalinfo ON
				  starter_students_professionalinfo.spsinfo_student_id=starter_students.student_id
				  ";
		$query .= "WHERE student_status=2 ";
		if(!empty($params['search']['from_date']) && !empty($params['search']['to_date'])){
			$from_date = $params['search']['from_date'];
			$to_date = $params['search']['to_date'];
			$query .= "AND student_regdate>='$from_date' AND student_regdate <='$to_date' ";
        }
		if(!empty($params['search']['month']) && !empty($params['search']['year']))
		{
			$month = $params['search']['month'];
			$year = $params['search']['year'];
			$make_date = $year.'-'.$month.'-';
			$query .= "AND student_regdate LIKE '%$make_date%' ";
		}else if(!empty($params['search']['month']) && empty($params['search']['year'])){
			$month = $params['search']['month'];
			$make_date = '-'.$month.'-';
			$query .= "AND student_regdate LIKE '%$make_date%' ";
		}else if(empty($params['search']['month']) && !empty($params['search']['year'])){
			$year = $params['search']['year'];
			$make_date = $year.'-';
			$query .= "AND student_regdate LIKE '%$make_date%' ";
		}
		if(!empty($params['search']['keywords'])){
			$search_term = $params['search']['keywords'];
			$query .= "AND (student_entryid LIKE '%$search_term%' ";
			$query .= "OR student_username LIKE '%$search_term%' ";
			$query .= "OR student_email LIKE '%$search_term%') ";
        }
		
		if(!empty($params['search']['sortby'])){
			$sortby = $params['search']['sortby'];
			$query .= "ORDER BY student_id $sortby ";
		}else
		{
			$query .= "ORDER BY student_id DESC ";
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

    function get_sort_students($params = array()){
		
		$query = "SELECT 
				  starter_students.*,
				  starter_students_personalinfo.spinfo_first_name,
				  starter_students_personalinfo.spinfo_middle_name,
				  starter_students_personalinfo.spinfo_last_name,
				  starter_students_personalinfo.spinfo_photo,
				  starter_students_personalinfo.spinfo_personal_phone,
				  districts.name,
				  pd.name as pdis,
				  starter_students_professionalinfo.spsinfo_bmanddc_number,
				  starter_students_professionalinfo.spsinfo_designation
				  FROM starter_students 
				  LEFT JOIN starter_students_personalinfo ON
				  starter_students_personalinfo.spinfo_student_id=starter_students.student_id
				  LEFT JOIN districts ON
				  districts.id=starter_students_personalinfo.spinfo_current_district
				  LEFT JOIN districts as pd ON
				  pd.id=starter_students_personalinfo.spinfo_permanent_district
				  LEFT JOIN starter_students_professionalinfo ON
				  starter_students_professionalinfo.spsinfo_student_id=starter_students.student_id
				  ";
		$query .= "WHERE student_status=4 ";
		if(!empty($params['search']['from_date']) && !empty($params['search']['to_date'])){
			$from_date = $params['search']['from_date'];
			$to_date = $params['search']['to_date'];
			$query .= "AND student_regdate>='$from_date' AND student_regdate <='$to_date' ";
        }
		if(!empty($params['search']['month']) && !empty($params['search']['year']))
		{
			$month = $params['search']['month'];
			$year = $params['search']['year'];
			$make_date = $year.'-'.$month.'-';
			$query .= "AND student_regdate LIKE '%$make_date%' ";
		}else if(!empty($params['search']['month']) && empty($params['search']['year'])){
			$month = $params['search']['month'];
			$make_date = '-'.$month.'-';
			$query .= "AND student_regdate LIKE '%$make_date%' ";
		}else if(empty($params['search']['month']) && !empty($params['search']['year'])){
			$year = $params['search']['year'];
			$make_date = $year.'-';
			$query .= "AND student_regdate LIKE '%$make_date%' ";
		}
		if(!empty($params['search']['keywords'])){
			$search_term = $params['search']['keywords'];
			$query .= "AND (student_entryid LIKE '%$search_term%' ";
			$query .= "OR student_username LIKE '%$search_term%' ";
			$query .= "OR student_email LIKE '%$search_term%') ";
        }
        if(!empty($params['search']['batch'])){
			$batchno = $params['search']['batch'] ;
			$query .= " AND batch_name=$batchno " ;
		}
		
		if(!empty($params['search']['sortby'])){
			$sortby = $params['search']['sortby'];
			$query .= "ORDER BY student_id $sortby ";
		}else
		{
			$query .= "ORDER BY student_id DESC ";
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


	function get_reject_students($params = array()){
		
		$query = "SELECT 
				  starter_students.*,
				  starter_students_personalinfo.spinfo_first_name,
				  starter_students_personalinfo.spinfo_middle_name,
				  starter_students_personalinfo.spinfo_last_name,
				  starter_students_personalinfo.spinfo_photo,
				  starter_students_personalinfo.spinfo_personal_phone,
				  districts.name,
				  pd.name as pdis,
				  starter_students_professionalinfo.spsinfo_bmanddc_number,
				  starter_students_professionalinfo.spsinfo_designation
				  FROM starter_students 
				  LEFT JOIN starter_students_personalinfo ON
				  starter_students_personalinfo.spinfo_student_id=starter_students.student_id
				  LEFT JOIN districts ON
				  districts.id=starter_students_personalinfo.spinfo_current_district
				  LEFT JOIN districts as pd ON
				  pd.id=starter_students_personalinfo.spinfo_permanent_district
				  LEFT JOIN starter_students_professionalinfo ON
				  starter_students_professionalinfo.spsinfo_student_id=starter_students.student_id
				  ";
		$query .= "WHERE student_status=5 ";
		if(!empty($params['search']['from_date']) && !empty($params['search']['to_date'])){
			$from_date = $params['search']['from_date'];
			$to_date = $params['search']['to_date'];
			$query .= "AND student_regdate>='$from_date' AND student_regdate <='$to_date' ";
        }
		if(!empty($params['search']['month']) && !empty($params['search']['year']))
		{
			$month = $params['search']['month'];
			$year = $params['search']['year'];
			$make_date = $year.'-'.$month.'-';
			$query .= "AND student_regdate LIKE '%$make_date%' ";
		}else if(!empty($params['search']['month']) && empty($params['search']['year'])){
			$month = $params['search']['month'];
			$make_date = '-'.$month.'-';
			$query .= "AND student_regdate LIKE '%$make_date%' ";
		}else if(empty($params['search']['month']) && !empty($params['search']['year'])){
			$year = $params['search']['year'];
			$make_date = $year.'-';
			$query .= "AND student_regdate LIKE '%$make_date%' ";
		}
		if(!empty($params['search']['keywords'])){
			$search_term = $params['search']['keywords'];
			$query .= "AND (student_entryid LIKE '%$search_term%' ";
			$query .= "OR student_username LIKE '%$search_term%' ";
			$query .= "OR student_email LIKE '%$search_term%') ";
        }
		
		if(!empty($params['search']['sortby'])){
			$sortby = $params['search']['sortby'];
			$query .= "ORDER BY student_id $sortby ";
		}else
		{
			$query .= "ORDER BY student_id DESC ";
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

	
	function get_changed_phone_numbers($params = array()){
		
		$query = "SELECT 
				  starter_students.*,
				  starter_students_personalinfo.spinfo_first_name,
				  starter_students_personalinfo.spinfo_middle_name,
				  starter_students_personalinfo.spinfo_last_name,
				  starter_students_personalinfo.spinfo_photo,
				  starter_students_personalinfo.spinfo_personal_phone,
				  starter_students_personalinfo.spinfo_personal_phone_updaterqst,
				  starter_students_personalinfo.spinfo_personal_phone_updated
				  FROM starter_students 
				  LEFT JOIN starter_students_personalinfo ON
				  starter_students_personalinfo.spinfo_student_id=starter_students.student_id ";
		$query .= "WHERE student_status=1 AND starter_students_personalinfo.spinfo_personal_phone_updaterqst='YES' ";
		if(!empty($params['search']['month']) && !empty($params['search']['year']))
		{
			$month = $params['search']['month'];
			$year = $params['search']['year'];
			$make_date = $year.'-'.$month.'-';
			$query .= "AND student_regdate LIKE '%$make_date%' ";
		}else if(!empty($params['search']['month']) && empty($params['search']['year'])){
			$month = $params['search']['month'];
			$make_date = '-'.$month.'-';
			$query .= "AND student_regdate LIKE '%$make_date%' ";
		}else if(empty($params['search']['month']) && !empty($params['search']['year'])){
			$year = $params['search']['year'];
			$make_date = $year.'-';
			$query .= "AND student_regdate LIKE '%$make_date%' ";
		}
		if(!empty($params['search']['keywords'])){
			$search_term = $params['search']['keywords'];
			$query .= "AND (student_entryid LIKE '%$search_term%' ";
			$query .= "OR student_username LIKE '%$search_term%' ";
			$query .= "OR student_email LIKE '%$search_term%') ";
        }
		
		$query .= "ORDER BY student_id DESC ";
		
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
	
	public function get_student_info($student_id)
	{
		$query = $this->db->query("SELECT *
								   FROM starter_students
								   LEFT JOIN starter_students_academicinfo ON
								   starter_students_academicinfo.sacinfo_student_id=starter_students.student_id
								   LEFT JOIN starter_students_personalinfo ON
								   starter_students_personalinfo.spinfo_student_id=starter_students.student_id
								   LEFT JOIN starter_students_professionalinfo ON
								   starter_students_professionalinfo.spsinfo_student_id=starter_students.student_id
								   LEFT JOIN starter_countries ON
								   starter_countries.country_id=starter_students_personalinfo.spinfo_nationality
								   WHERE starter_students.student_id='$student_id'
								   LIMIT 1
								  ");
		return $query->row_array();
	}
	
	public function get_student_username($student_id)
	{
		$query = $this->db->query("SELECT student_username FROM starter_students WHERE starter_students.student_id='$student_id' LIMIT 1");
		$result = $query->row_array();
		return $result['student_username'];
	}
	
	public function get_specializations($student_id)
	{
		$query = $this->db->query("SELECT
								  *
								  FROM starter_students_specializations
								  LEFT JOIN starter_specialization ON
								  starter_specialization.specialize_id=starter_students_specializations.ss_specilzation_id
								  WHERE starter_students_specializations.ss_student_id='$student_id'
								  ORDER BY starter_students_specializations.ss_id ASC
								  "); 
		return $query->result_array();
	}
	
	public function get_dlp_categories($student_id)
	{
		$query = $this->db->query("SELECT
								   *
								   FROM starter_students_dlpcategories
								   LEFT JOIN starter_dlp_categories ON
								   starter_dlp_categories.category_id=starter_students_dlpcategories.sdc_category_id
								   WHERE starter_students_dlpcategories.sdc_student_id='$student_id'
								   ORDER BY starter_students_dlpcategories.sdc_id ASC
								  ");
		return $query->result_array();
	}
	
	public function get_academicinformation($student_id)
	{
		$query = $this->db->query("SELECT
								   *
								   FROM starter_students_academicinfo
								   WHERE starter_students_academicinfo.sacinfo_student_id='$student_id'
								   ORDER BY starter_students_academicinfo.sacinfo_id ASC
								  ");
		return $query->result_array();
	}

	public function getStudentAcademyList($id)
	{
		$this -> db -> select('*');
		$this -> db -> from('starter_students_academicinfo');
		$this -> db -> where('sacinfo_student_id', $id);
		$this -> db -> order_by('sacinfo_year', 'ASC');
		$this -> db -> limit(2);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_onlinepayment_info($student_entryid)
	{
		$query = $this->db->query("SELECT * FROM starter_online_payments WHERE starter_online_payments.onpay_student_entryid='$student_entryid' ORDER BY onpay_id ASC");
		return $query->result_array();
	}
	
	public function get_depositpayment_info($student_entryid)
	{
		$query = $this->db->query("SELECT * FROM starter_deposit_payments WHERE starter_deposit_payments.deposit_student_entryid='$student_entryid' ORDER BY deposit_id ASC");
		return $query->result_array();
	}
	
}
