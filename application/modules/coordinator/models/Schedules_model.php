<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Schedules_model extends CI_Model {
	
	public function get_endmodule_schedules()
	{
		$query = $this->db->query("SELECT starter_endmodule_exschedule.*, starter_phases.phase_name 
								   FROM starter_endmodule_exschedule
								   LEFT JOIN starter_phases ON
								   starter_phases.phase_id=starter_endmodule_exschedule.endmschedule_phase_id
								   ORDER BY starter_endmodule_exschedule.endmschedule_id DESC");
		return $query->result_array();
	}
	
	public function get_phases()
	{
		$query = $this->db->query("SELECT * FROM starter_phases ORDER BY starter_phases.phase_id ASC");
		return $query->result_array();
	}
	
	public function create_endmodule_schedule($data)
	{
		$this->db->insert('starter_endmodule_exschedule', $data);
	}
	
	public function get_schedule_info($schedule_id)
	{
		$query = $this->db->query("SELECT * FROM starter_endmodule_exschedule WHERE starter_endmodule_exschedule.endmschedule_id='$schedule_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function update_endmodule_schedule($schedule_id, $data)
	{
		$this->db->where('endmschedule_id', $schedule_id);
		$this->db->update('starter_endmodule_exschedule', $data);
	}
	
	public function get_center_schedules($schedule_id)
	{
		$query = $this->db->query("SELECT * FROM starter_endmdl_centerschdl 
								   LEFT JOIN starter_centers ON
								   starter_centers.center_id=starter_endmdl_centerschdl.centerschdl_center_id
								   WHERE starter_endmdl_centerschdl.centerschdl_parentschdl_id='$schedule_id' 
								   ORDER BY starter_endmdl_centerschdl.centerschdl_id DESC");
		return $query->result_array();
	}
	
	public function get_center_lists()
	{
		$query = $this->db->query("SELECT * FROM starter_centers ORDER BY starter_centers.center_id ASC");
		return $query->result_array();
	}
	
	public function get_schedule_title($schedule_id)
	{
		$query = $this->db->query("SELECT endmschedule_title FROM starter_endmodule_exschedule WHERE starter_endmodule_exschedule.endmschedule_id='$schedule_id' LIMIT 1");
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
		$query = $this->db->query("SELECT endmschedule_title FROM starter_endmodule_exschedule WHERE starter_endmodule_exschedule.endmschedule_id='$schedule_id' LIMIT 1");
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
	
	public function get_students($phase_id)
	{
		$query = $this->db->query("SELECT * 
								   FROM starter_students 
								   LEFT JOIN starter_students_personalinfo ON
								   starter_students_personalinfo.spinfo_student_id=starter_students.student_id
								   WHERE starter_students.student_phaselevel_id ='$phase_id'");
		return $query->result_array();
	}
	
	public function get_ece_students()
	{
		$query = $this->db->query("SELECT * 
								   FROM starter_students 
								   LEFT JOIN starter_students_personalinfo ON
								   starter_students_personalinfo.spinfo_student_id=starter_students.student_id
								   WHERE starter_students.student_ece_status=1");
		return $query->result_array();
	}
	
	public function get_schedule_range($schedule_id, $schedule_type)
	{
		if($schedule_type == 'SDT')
		{
			$sel_table = 'starter_sdt_schedule';
		}elseif($schedule_type == 'WORKSHOP')
		{
			$sel_table = 'starter_workshop_schedule';
		}elseif($schedule_type == 'ECE')
		{
			$sel_table = 'starter_ece_exschedule';
		}
		$query = $this->db->query("SELECT endmschedule_from_date, endmschedule_to_date FROM $sel_table WHERE $sel_table.endmschedule_id='$schedule_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function save_notification($data)
	{
		$this->db->insert('starter_schedule_notification', $data);
	}
	
}