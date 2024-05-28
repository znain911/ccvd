<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Specialization_model extends CI_Model {
	
	public function get_all_items()
	{
		$query = $this->db->query("SELECT * FROM starter_specialization ORDER BY starter_specialization.specialize_id DESC");
		return $query->result_array();
	}
	
	public function create($data)
	{
		$this->db->insert('starter_specialization', $data);
	}
	
	public function update($id, $data)
	{
		$this->db->where('specialize_id', $id);
		$this->db->update('starter_specialization', $data);
	}
	
	public function get_info($id)
	{
		$query = $this->db->query("SELECT * FROM starter_specialization WHERE starter_specialization.specialize_id='$id' LIMIT 1");
		return $query->row_array();
	}
	
}
