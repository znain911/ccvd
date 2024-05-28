<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Course_model extends CI_Model {
	
	public function get_phase_modules($phase_id)
	{
		$query = $this->db->query("SELECT 
								   * 
								   FROM starter_modules
								   LEFT JOIN starter_phases ON
								   starter_phases.phase_id=starter_modules.module_phase_id
								   WHERE starter_modules.module_phase_id='$phase_id' 
								   ORDER BY starter_modules.module_id ASC
								  ");
		return $query->result_array();
	}
	
	public function create_module($data)
	{
		$this->db->insert('starter_modules', $data);
	}
	
	public function get_module_info($module_id)
	{
		$query = $this->db->query("SELECT 
								   starter_modules.*,
								   starter_phases.phase_name
								   FROM starter_modules 
								   LEFT JOIN starter_phases ON
								   starter_phases.phase_id=starter_modules.module_phase_id
								   WHERE starter_modules.module_id='$module_id' 
								   LIMIT 1");
		return $query->row_array();
	}
	
	public function update_module($module_id, $data)
	{
		$this->db->where('module_id', $module_id);
		$this->db->update('starter_modules', $data);
	}
	
	public function get_lessonsby_module($module_id)
	{
		$query = $this->db->query("SELECT 
								   starter_modules_lessons.*,
								   starter_modules.module_id,
								   starter_modules.module_title,
								   starter_modules.module_phase_id,
								   starter_owner.owner_name
								   FROM starter_modules_lessons
								   LEFT JOIN starter_modules ON
								   starter_modules.module_id=starter_modules_lessons.lesson_module_id
								   LEFT JOIN starter_owner ON
								   starter_owner.owner_id=starter_modules_lessons.lesson_created_by
								   WHERE starter_modules_lessons.lesson_module_id='$module_id'
								   ORDER BY starter_modules_lessons.lesson_position ASC
								   ");
		return $query->result_array();
	}
	
	public function  lesson_position($module_id)
	{
		$query = $this->db->query("SELECT lesson_id FROM starter_modules_lessons WHERE starter_modules_lessons.lesson_module_id='$module_id'");
		return $query->num_rows()+1;
	}
	
	public function create_module_lesson($data)
	{
		$this->db->insert('starter_modules_lessons', $data);
	}
	
	public function get_lessonby_id($lesson_id)
	{
		$query = $this->db->query("SELECT * FROM starter_modules_lessons WHERE starter_modules_lessons.lesson_id='$lesson_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function update_module_lesson($lesson_id, $data)
	{
		$this->db->where('lesson_id', $lesson_id);
		$this->db->update('starter_modules_lessons', $data);
	}
	
}
