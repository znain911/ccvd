<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class F2fschedule_model extends CI_Model {
	
	public function get_schedules()
	{
		$query = $this->db->query("SELECT starter_ftwof_schedule.*, starter_phases.phase_name 
								   FROM starter_ftwof_schedule
								   LEFT JOIN starter_phases ON
								   starter_phases.phase_id=starter_ftwof_schedule.endmschedule_phase_id
								   ORDER BY starter_ftwof_schedule.endmschedule_id DESC");
		return $query->result_array();
	}
	
	public function get_phases()
	{
		$query = $this->db->query("SELECT * FROM starter_phases ORDER BY starter_phases.phase_id ASC");
		return $query->result_array();
	}
	
	public function create_schedule($data)
	{
		$this->db->insert('starter_ftwof_schedule', $data);
	}
	
	public function get_schedule_info($schedule_id)
	{
		$query = $this->db->query("SELECT * FROM starter_ftwof_schedule WHERE starter_ftwof_schedule.endmschedule_id='$schedule_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function update_schedule($schedule_id, $data)
	{
		$this->db->where('endmschedule_id', $schedule_id);
		$this->db->update('starter_ftwof_schedule', $data);
	}
	
	public function get_center_schedules($schedule_id)
	{
		$query = $this->db->query("SELECT * FROM starter_ftwo_centerschdl 
								   LEFT JOIN starter_centers ON
								   starter_centers.center_id=starter_ftwo_centerschdl.centerschdl_center_id
								   WHERE starter_ftwo_centerschdl.centerschdl_parentschdl_id='$schedule_id' 
								   ORDER BY starter_ftwo_centerschdl.centerschdl_id DESC");
		return $query->result_array();
	}
	
	public function get_center_lists()
	{
		$query = $this->db->query("SELECT * FROM starter_centers ORDER BY starter_centers.center_id ASC");
		return $query->result_array();
	}
	
	public function get_schedule_title($schedule_id)
	{
		$query = $this->db->query("SELECT endmschedule_title FROM starter_ftwof_schedule WHERE starter_ftwof_schedule.endmschedule_id='$schedule_id' LIMIT 1");
		$result = $query->row_array();
		if($result['endmschedule_title'])
		{
			$title = $result['endmschedule_title'];
		}else
		{
			$title = null;
		}
		
		return $title;
	}
	
	public function get_phase_title($schedule_id)
	{
		$query = $this->db->query("SELECT endmschedule_title FROM starter_ftwof_schedule WHERE starter_ftwof_schedule.endmschedule_id='$schedule_id' LIMIT 1");
		$result = $query->row_array();
		if($result['endmschedule_title'])
		{
			$title = $result['endmschedule_title'];
		}else
		{
			$title = null;
		}
		
		return $title;
	}
	
	public function create_center_schedule($data)
	{
		$this->db->insert('starter_ftwo_centerschdl', $data);
	}
	
	public function update_center_schedule($center_id, $data)
	{
		$this->db->where('centerschdl_id', $center_id);
		$this->db->update('starter_ftwo_centerschdl', $data);
	}
	
	public function get_centerschedule_info($schedule_id)
	{
		$query = $this->db->query("SELECT * FROM starter_ftwo_centerschdl WHERE starter_ftwo_centerschdl.centerschdl_id='$schedule_id'");
		return $query->row_array();
	}
	
}
