<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role_model extends CI_Model {
	
	public function get_all_items()
	{
		$query = $this->db->query("SELECT * FROM starter_admin_role ORDER BY starter_admin_role.role_id DESC");
		return $query->result_array();
	}
	
	public function create($data)
	{
		$this->db->insert('starter_admin_role', $data);
	}
	
	public function update($id, $data)
	{
		$this->db->where('role_id', $id);
		$this->db->update('starter_admin_role', $data);
	}
	
	public function get_info($id)
	{
		$query = $this->db->query("SELECT * FROM starter_admin_role WHERE starter_admin_role.role_id='$id' LIMIT 1");
		return $query->row_array();
	}
	
}
