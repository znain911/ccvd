<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Footermenu_model extends CI_Model {
	
	public function get_all_items()
	{
		$query = $this->db->query("SELECT * FROM starter_common_info WHERE starter_common_info.type='social' ORDER BY starter_common_info.id DESC");
		return $query->result_array();
	}
	
	public function create($data)
	{
		$this->db->insert('starter_common_info', $data);
	}
	
	public function update($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('starter_common_info', $data);
	}
	
	public function get_info($id)
	{
		$query = $this->db->query("SELECT * FROM starter_common_info WHERE starter_common_info.id='$id' LIMIT 1");
		return $query->row_array();
	}
	
}
