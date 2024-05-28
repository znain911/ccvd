<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Course_model extends CI_Model{
	
	public function get_lessonsby_module($params=array())
	{
		$module_id = $params['module_id'];
		$query = "SELECT * FROM starter_modules_lessons 
				  WHERE starter_modules_lessons.lesson_module_id='$module_id' 
				  ORDER BY starter_modules_lessons.lesson_position ASC ";
		
		if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
			$start = $params['start'];
			$query .= "LIMIT {$start},{$limit}";
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
            $query .= "LIMIT {$limit} ";
        }
		
		$query = $this->db->query($query);
		return $query->result_array();
	}
	
	public function check_lesson_has_read($module_id, $lesson_id, $user_id)
	{
		$query = $this->db->query("SELECT lessread_id FROM starter_lesson_reading_completed 
								   WHERE starter_lesson_reading_completed.lessread_module_id='$module_id'
								   AND starter_lesson_reading_completed.lessread_lesson_id='$lesson_id'
								   AND starter_lesson_reading_completed.lessread_user_id='$user_id'");
		return $query->row_array();
	}
	
}