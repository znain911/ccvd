<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Center_model extends CI_Model {
	
	public function get_all_items()
	{
		$query = $this->db->query("SELECT * FROM starter_centers ORDER BY starter_centers.center_id DESC");
		return $query->result_array();
	}
	
	public function create($data)
	{
		$this->db->insert('starter_centers', $data);
	}
	
	public function update($id, $data)
	{
		$this->db->where('center_id', $id);
		$this->db->update('starter_centers', $data);
	}
	
	public function get_info($id)
	{
		$query = $this->db->query("SELECT * FROM starter_centers WHERE starter_centers.center_id='$id' LIMIT 1");
		return $query->row_array();
	}
	
}
