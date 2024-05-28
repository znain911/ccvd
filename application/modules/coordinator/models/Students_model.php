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
			$query .= "LIMIT {$limit},{$start} ";
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
			$query .= "LIMIT {$limit},{$start} ";
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
            $query .= "LIMIT {$limit} ";
        }
		
		$result = $this->db->query($query);
		return $result->result_array();
        
    }
	
	function update_pass_email(){
		
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
		$query .= "WHERE student_status=1 AND student_enrolled = 1 ";
		
		$query .= "ORDER BY student_id DESC ";
		
		$result = $this->db->query($query);
		return $result->result_array();
        
    }
	
	function update_pass($id){
		      $query = $this->db->query("update starter_students set student_password = '7c4a8d09ca3762af61e59520943dc26494f8941b' where student_id = $id ");
			  if ($this->db->affected_rows() > 0)
				{
				  return TRUE;
				}
				else
				{
				  return FALSE;
				}
    }
	
	function update_email($id , $newEmail){
		      $query = $this->db->query("update starter_students set student_email = '$newEmail' where student_id = $id ");
			  if ($this->db->affected_rows() > 0)
				{
					$this->db->query("update starter_students_personalinfo set spinfo_email = '$newEmail' where spinfo_student_id = $id ");
				  return TRUE;
				}
				else
				{
				  return FALSE;
				}
    }
	
	function update_phone($id , $phone){
		      $query = $this->db->query("update starter_students_personalinfo set spinfo_personal_phone = '$phone' where spinfo_student_id = $id ");
			  if ($this->db->affected_rows() > 0)
				{
					
				  return TRUE;
				}
				else
				{
				  return FALSE;
				}
    }

    function get_enrolled_students_csv(){
		
		$query = "SELECT 
				  starter_students.*,
				  starter_students_personalinfo.spinfo_first_name,
				  starter_students_personalinfo.spinfo_middle_name,
				  starter_students_personalinfo.spinfo_last_name,
				  starter_students_personalinfo.spinfo_photo,
				  starter_students_personalinfo.spinfo_personal_phone,
				  starter_students_personalinfo.spinfo_gender,
				  starter_students_personalinfo.spinfo_birth_date,
				  starter_students_professionalinfo.spsinfo_bmanddc_number,
				  starter_students_professionalinfo.spsinfo_designation,
				  starter_students_professionalinfo.spsinfo_organization,
				  starter_students_professionalinfo.spsinfo_organization_address,
				  starter_students_professionalinfo.spsinfo_typeof_practice,
				  starter_students_professionalinfo.spsinfo_sinceyear_mbbs,
				  starter_students_professionalinfo.spsinfo_experience,
				  starter_students_personalinfo.spinfo_national_id,
				  districts.name,
				  pd.name as pdis,
				  starter_students_professionalinfo.spsinfo_bmanddc_number,
				  starter_students_professionalinfo.spsinfo_designation,
				  starter_students_professionalinfo.spsinfo_organization,
				  starter_students_professionalinfo.spsinfo_typeof_practice,
				  starter_students_professionalinfo.spsinfo_sinceyear_mbbs,
				  starter_students_professionalinfo.spsinfo_experience
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
		
		$result = $this->db->query($query);
		return $result->result_array();
        
    }

    function get_enrolled_students_csvbatch($batchid){
		
		$query = "SELECT 
				  starter_students.*,
				  starter_students_personalinfo.spinfo_first_name,
				  starter_students_personalinfo.spinfo_middle_name,
				  starter_students_personalinfo.spinfo_last_name,
				  starter_students_personalinfo.spinfo_photo,
				  starter_students_personalinfo.spinfo_personal_phone,
				  starter_students_personalinfo.spinfo_gender,
				  starter_students_personalinfo.spinfo_birth_date,
				  starter_students_professionalinfo.spsinfo_bmanddc_number,
				  starter_students_professionalinfo.spsinfo_designation,
				  starter_students_professionalinfo.spsinfo_organization,
				  starter_students_professionalinfo.spsinfo_organization_address,
				  starter_students_professionalinfo.spsinfo_typeof_practice,
				  starter_students_professionalinfo.spsinfo_sinceyear_mbbs,
				  starter_students_professionalinfo.spsinfo_experience,
				  starter_students_personalinfo.spinfo_national_id,
				  districts.name,
				  pd.name as pdis,
				  starter_students_professionalinfo.spsinfo_bmanddc_number,
				  starter_students_professionalinfo.spsinfo_designation,
				  starter_students_professionalinfo.spsinfo_organization,
				  starter_students_professionalinfo.spsinfo_typeof_practice,
				  starter_students_professionalinfo.spsinfo_sinceyear_mbbs,
				  starter_students_professionalinfo.spsinfo_experience
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
		$query .= "WHERE student_status=1 AND student_enrolled = 1 AND batch_name='$batchid' ";
		
		$result = $this->db->query($query);
		return $result->result_array();
        
    }

    function get_payment_csv(){
		
		$query = "SELECT 
				  starter_students.*,
				  starter_students_personalinfo.spinfo_first_name,
				  starter_students_personalinfo.spinfo_middle_name,
				  starter_students_personalinfo.spinfo_last_name,
				  starter_students_personalinfo.spinfo_photo,
				  starter_students_personalinfo.spinfo_personal_phone,
				  starter_students_personalinfo.spinfo_gender,
				  starter_students_personalinfo.spinfo_birth_date,
				  starter_students_professionalinfo.spsinfo_bmanddc_number,
				  starter_students_professionalinfo.spsinfo_designation,
				  starter_students_professionalinfo.spsinfo_organization,
				  starter_students_professionalinfo.spsinfo_organization_address,
				  starter_students_professionalinfo.spsinfo_typeof_practice,
				  starter_students_professionalinfo.spsinfo_sinceyear_mbbs,
				  starter_students_professionalinfo.spsinfo_experience,
				  starter_students_personalinfo.spinfo_national_id,
				  districts.name,
				  pd.name as pdis,
				  starter_students_professionalinfo.spsinfo_bmanddc_number,
				  starter_students_professionalinfo.spsinfo_designation,
				  starter_students_professionalinfo.spsinfo_organization,
				  starter_students_professionalinfo.spsinfo_typeof_practice,
				  starter_students_professionalinfo.spsinfo_sinceyear_mbbs,
				  starter_students_professionalinfo.spsinfo_experience
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
		$query .= "WHERE student_status=1 ";
		
		$result = $this->db->query($query);
		return $result->result_array();
        
    }

    function get_payment_csvbatch($batchid){
		
		$query = "SELECT 
				  starter_students.*,
				  starter_students_personalinfo.spinfo_first_name,
				  starter_students_personalinfo.spinfo_middle_name,
				  starter_students_personalinfo.spinfo_last_name,
				  starter_students_personalinfo.spinfo_photo,
				  starter_students_personalinfo.spinfo_personal_phone,
				  starter_students_personalinfo.spinfo_gender,
				  starter_students_personalinfo.spinfo_birth_date,
				  starter_students_professionalinfo.spsinfo_bmanddc_number,
				  starter_students_professionalinfo.spsinfo_designation,
				  starter_students_professionalinfo.spsinfo_organization,
				  starter_students_professionalinfo.spsinfo_organization_address,
				  starter_students_professionalinfo.spsinfo_typeof_practice,
				  starter_students_professionalinfo.spsinfo_sinceyear_mbbs,
				  starter_students_professionalinfo.spsinfo_experience,
				  starter_students_personalinfo.spinfo_national_id,
				  districts.name,
				  pd.name as pdis,
				  starter_students_professionalinfo.spsinfo_bmanddc_number,
				  starter_students_professionalinfo.spsinfo_designation,
				  starter_students_professionalinfo.spsinfo_organization,
				  starter_students_professionalinfo.spsinfo_typeof_practice,
				  starter_students_professionalinfo.spsinfo_sinceyear_mbbs,
				  starter_students_professionalinfo.spsinfo_experience
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
		$query .= "WHERE student_status=1 AND batch_name='$batchid' ";
		
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
			$query .= "LIMIT {$limit},{$start} ";
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
            $query .= "LIMIT {$limit} ";
        }
		
		$result = $this->db->query($query);
		return $result->result_array();
        
    }

    function get_approve_students_csv(){
		
		$query = "SELECT 
				  starter_students.*,
				  starter_students_personalinfo.spinfo_first_name,
				  starter_students_personalinfo.spinfo_middle_name,
				  starter_students_personalinfo.spinfo_last_name,
				  starter_students_personalinfo.spinfo_photo,
				  starter_students_personalinfo.spinfo_personal_phone,
				  starter_students_personalinfo.spinfo_gender,
				  starter_students_personalinfo.spinfo_birth_date,
				  starter_students_professionalinfo.spsinfo_bmanddc_number,
				  starter_students_professionalinfo.spsinfo_designation,
				  starter_students_professionalinfo.spsinfo_organization,
				  starter_students_professionalinfo.spsinfo_organization_address,
				  starter_students_professionalinfo.spsinfo_typeof_practice,
				  starter_students_professionalinfo.spsinfo_sinceyear_mbbs,
				  starter_students_professionalinfo.spsinfo_experience
				  FROM starter_students 
				  LEFT JOIN starter_students_personalinfo ON
				  starter_students_personalinfo.spinfo_student_id=starter_students.student_id
				  LEFT JOIN starter_students_professionalinfo ON
				  starter_students_professionalinfo.spsinfo_student_id=starter_students.student_id
				  ";
		$query .= "WHERE student_status=1 AND student_enrolled = 0 ";		
		$query .= "ORDER BY student_id DESC ";
		$result = $this->db->query($query);
		return $result->result_array();
        
    }

    function get_approve_students_csvbybatch($batch_id){
		
		$query = "SELECT 
				  starter_students.*,
				  starter_students_personalinfo.spinfo_first_name,
				  starter_students_personalinfo.spinfo_middle_name,
				  starter_students_personalinfo.spinfo_last_name,
				  starter_students_personalinfo.spinfo_photo,
				  starter_students_personalinfo.spinfo_personal_phone,
				  starter_students_personalinfo.spinfo_gender,
				  starter_students_personalinfo.spinfo_birth_date,
				  starter_students_professionalinfo.spsinfo_bmanddc_number,
				  starter_students_professionalinfo.spsinfo_designation,
				  starter_students_professionalinfo.spsinfo_organization,
				  starter_students_professionalinfo.spsinfo_organization_address,
				  starter_students_professionalinfo.spsinfo_typeof_practice,
				  starter_students_professionalinfo.spsinfo_sinceyear_mbbs,
				  starter_students_professionalinfo.spsinfo_experience
				  FROM starter_students 
				  LEFT JOIN starter_students_personalinfo ON
				  starter_students_personalinfo.spinfo_student_id=starter_students.student_id
				  LEFT JOIN starter_students_professionalinfo ON
				  starter_students_professionalinfo.spsinfo_student_id=starter_students.student_id
				  ";
		$query .= "WHERE starter_students.student_status=1 AND starter_students.student_enrolled = 0 AND starter_students.batch_name = '$batch_id' ";		
		$query .= "ORDER BY student_id DESC ";
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
			$query .= "LIMIT {$limit},{$start} ";
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
            $query .= "LIMIT {$limit} ";
        }
		
		$result = $this->db->query($query);
		return $result->result_array();
        
    }

    function get_waiting_students_csv(){
		
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
			$query .= "LIMIT {$limit},{$start} ";
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
            $query .= "LIMIT {$limit} ";
        }
		
		$result = $this->db->query($query);
		return $result->result_array();
        
    }

    function get_sort_students_csv(){
		
		$query = "SELECT 
				  starter_students.*,
				  starter_students_personalinfo.spinfo_first_name,
				  starter_students_personalinfo.spinfo_middle_name,
				  starter_students_personalinfo.spinfo_last_name,
				  starter_students_personalinfo.spinfo_photo,
				  starter_students_personalinfo.spinfo_personal_phone,
				  starter_students_personalinfo.spinfo_gender,
				  starter_students_personalinfo.spinfo_birth_date,
				  starter_students_professionalinfo.spsinfo_bmanddc_number,
				  starter_students_professionalinfo.spsinfo_designation,
				  starter_students_professionalinfo.spsinfo_organization,
				  starter_students_professionalinfo.spsinfo_organization_address,
				  starter_students_professionalinfo.spsinfo_typeof_practice,
				  starter_students_professionalinfo.spsinfo_sinceyear_mbbs,
				  starter_students_professionalinfo.spsinfo_experience
				  FROM starter_students 
				  LEFT JOIN starter_students_personalinfo ON
				  starter_students_personalinfo.spinfo_student_id=starter_students.student_id
				  LEFT JOIN starter_students_professionalinfo ON
				  starter_students_professionalinfo.spsinfo_student_id=starter_students.student_id
				  ";
		$query .= "WHERE student_status=4 ";
		
		$result = $this->db->query($query);
		return $result->result_array();
        
    }


    function get_sort_students_csvbatch($batch){
		
		$query = "SELECT 
				  starter_students.*,
				  starter_students_personalinfo.spinfo_first_name,
				  starter_students_personalinfo.spinfo_middle_name,
				  starter_students_personalinfo.spinfo_last_name,
				  starter_students_personalinfo.spinfo_photo,
				  starter_students_personalinfo.spinfo_personal_phone,
				  starter_students_personalinfo.spinfo_gender,
				  starter_students_personalinfo.spinfo_birth_date,
				  starter_students_professionalinfo.spsinfo_bmanddc_number,
				  starter_students_professionalinfo.spsinfo_designation,
				  starter_students_professionalinfo.spsinfo_organization,
				  starter_students_professionalinfo.spsinfo_organization_address,
				  starter_students_professionalinfo.spsinfo_typeof_practice,
				  starter_students_professionalinfo.spsinfo_sinceyear_mbbs,
				  starter_students_professionalinfo.spsinfo_experience
				  FROM starter_students 
				  LEFT JOIN starter_students_personalinfo ON
				  starter_students_personalinfo.spinfo_student_id=starter_students.student_id
				  LEFT JOIN starter_students_professionalinfo ON
				  starter_students_professionalinfo.spsinfo_student_id=starter_students.student_id
				  ";
		$query .= "WHERE student_status=4 AND batch_name = '$batch' ";
		
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
			$query .= "LIMIT {$limit},{$start} ";
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
            $query .= "LIMIT {$limit} ";
        }
		
		$result = $this->db->query($query);
		return $result->result_array();
        
    }

    function get_reject_students_csv(){
		
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
		$query .= "ORDER BY student_id DESC LIMIT 15";
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
	
	public function get_student_contactinfo($student_id)
	{
		$query = $this->db->query("SELECT * FROM starter_students 
								   LEFT JOIN starter_students_personalinfo ON
								   starter_students_personalinfo.spinfo_student_id=starter_students.student_id
								   WHERE starter_students.student_id='$student_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_student_entryid($student_id)
	{
		$query = $this->db->query("SELECT student_entryid FROM starter_students WHERE starter_students.student_id='$student_id' LIMIT 1");
		$result = $query->row_array();
		return $result['student_entryid'];
	}
	
	public function get_specializations($student_id)
	{
		$query = $this->db->query("SELECT
								  *
								  FROM starter_students_specializations
								  WHERE starter_students_specializations.ss_student_id='$student_id'
								  ORDER BY starter_students_specializations.ss_id ASC
								  "); 
		return $query->result_array();
	}
	
	public function get_specialization_name($specialize_id)
	{
		$query = $this->db->query("SELECT specialize_name FROM starter_specialization WHERE starter_specialization.specialize_id='$specialize_id' LIMIT 1");
		$result = $query->row_array();
		return $result['specialize_name'];
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
	
	public function get_active_module($phase=1)
	{
		$query = $this->db->query("SELECT MIN(module_id) AS active_module FROM starter_modules WHERE starter_modules.module_phase_id='$phase' LIMIT 1");
		$result = $query->row_array();
		return $result['active_module'];
	}
	
	public function get_onlinepayment_info($student_entryid)
	{
		$query = $this->db->query("SELECT * FROM starter_online_payments WHERE starter_online_payments.onpay_student_entryid='$student_entryid' ORDER BY onpay_id ASC");
		return $query->first_row();
	}
	
	public function get_depositpayment_info($student_entryid)
	{
		$query = $this->db->query("SELECT * FROM starter_deposit_payments WHERE starter_deposit_payments.deposit_student_entryid='$student_entryid' ORDER BY deposit_id ASC");
		return $query->first_row();
	}

	function get_pending_students_csv(){
		
		$query = "SELECT 
				  starter_students.*,
				  starter_students_personalinfo.spinfo_first_name,
				  starter_students_personalinfo.spinfo_middle_name,
				  starter_students_personalinfo.spinfo_last_name,
				  starter_students_personalinfo.spinfo_photo,
				  starter_students_personalinfo.spinfo_personal_phone,
				  starter_students_personalinfo.spinfo_gender,
				  starter_students_personalinfo.spinfo_birth_date,
				  starter_students_professionalinfo.spsinfo_bmanddc_number,
				  starter_students_professionalinfo.spsinfo_designation,
				  starter_students_professionalinfo.spsinfo_organization,
				  starter_students_professionalinfo.spsinfo_organization_address,
				  starter_students_professionalinfo.spsinfo_typeof_practice,
				  starter_students_professionalinfo.spsinfo_sinceyear_mbbs,
				  starter_students_professionalinfo.spsinfo_experience
				  FROM starter_students 
				  LEFT JOIN starter_students_personalinfo ON
				  starter_students_personalinfo.spinfo_student_id=starter_students.student_id
				  LEFT JOIN starter_students_professionalinfo ON
				  starter_students_professionalinfo.spsinfo_student_id=starter_students.student_id
				  ";
		$query .= "WHERE starter_students.student_status=0 AND starter_students.info_status = 1 ";		
		$query .= "ORDER BY student_id DESC ";
		$result = $this->db->query($query);
		return $result->result_array();
        
    }

    function get_pending_students_csvbybatch($batch_id){
		
		$query = "SELECT 
				  starter_students.*,
				  starter_students_personalinfo.spinfo_first_name,
				  starter_students_personalinfo.spinfo_middle_name,
				  starter_students_personalinfo.spinfo_last_name,
				  starter_students_personalinfo.spinfo_photo,
				  starter_students_personalinfo.spinfo_personal_phone,
				  starter_students_personalinfo.spinfo_gender,
				  starter_students_personalinfo.spinfo_birth_date,
				  starter_students_professionalinfo.spsinfo_bmanddc_number,
				  starter_students_professionalinfo.spsinfo_designation,
				  starter_students_professionalinfo.spsinfo_organization,
				  starter_students_professionalinfo.spsinfo_organization_address,
				  starter_students_professionalinfo.spsinfo_typeof_practice,
				  starter_students_professionalinfo.spsinfo_sinceyear_mbbs,
				  starter_students_professionalinfo.spsinfo_experience
				  FROM starter_students 
				  LEFT JOIN starter_students_personalinfo ON
				  starter_students_personalinfo.spinfo_student_id=starter_students.student_id
				  LEFT JOIN starter_students_professionalinfo ON
				  starter_students_professionalinfo.spsinfo_student_id=starter_students.student_id
				  ";
		$query .= "WHERE starter_students.student_status=0 AND starter_students.info_status = 1 and starter_students.batch_name = '$batch_id' ";		
		$query .= "ORDER BY student_id DESC ";
		$result = $this->db->query($query);
		return $result->result_array();
        
    }

    public function getStudentSpe($id)
	{
		$this -> db -> select('t2.specialize_name');
		$this -> db -> from('starter_students_specializations t1');
		$this -> db -> join('starter_specialization t2','t2.specialize_id = t1.ss_specilzation_id');
		$this -> db -> where('t1.ss_student_id', $id);
		$query = $this->db->get();
		return $query->result();
	}

    public function getStudentAcademy($id)
	{
		$this -> db -> select('*');
		$this -> db -> from('starter_students_academicinfo');
		$this -> db -> where('sacinfo_student_id', $id);
		$this -> db -> order_by('sacinfo_year', 'ASC');
		$this -> db -> limit(3);
		$query = $this->db->get();
		return $query->result();
	}

	public function getStudentAcademyList($id)
	{
		$this -> db -> select('*');
		$this -> db -> from('starter_students_academicinfo');
		$this -> db -> where('sacinfo_student_id', $id);
		$this -> db -> order_by('sacinfo_year', 'ASC');
		$this -> db -> limit(3);
		$query = $this->db->get();
		return $query->result();
	}
	
	public function getBatch()
	{
		$this -> db -> select('*');
		$this -> db -> from('ccvd_batch');
		$this -> db -> order_by('batch_name', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}


	
}
