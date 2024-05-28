<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coordinator_model extends CI_Model {
	
	public function get_all_items()
	{
		$query = $this->db->query("SELECT starter_owner.*,
								   starter_admin_role.role_title
							       FROM starter_owner 
								   LEFT JOIN starter_admin_role ON
								   starter_admin_role.role_id=starter_owner.owner_role_id
								   ORDER BY starter_owner.owner_id DESC");
		return $query->result_array();
	}
	
	public function create($data)
	{
		$this->db->insert('starter_owner', $data);
	}
	
	public function update($id, $data)
	{
		$this->db->where('owner_id', $id);
		$this->db->update('starter_owner', $data);
	}
	
	public function get_info($id)
	{
		$query = $this->db->query("SELECT * FROM starter_owner WHERE starter_owner.owner_id='$id' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_roles()
	{
		$query = $this->db->query("SELECT * FROM starter_admin_role ORDER BY starter_admin_role.role_id ASC");
		return $query->result_array();
	}
	
	public function get_admin_manages()
	{
		$query = $this->db->query("SELECT * FROM starter_manges ORDER BY starter_manges.manage_id ASC");
		return $query->result_array();
	}
	
	public function get_permissions_byid($admin_id, $permission_id)
	{
		$query = $this->db->query("SELECT * FROM starter_admin_permission WHERE starter_admin_permission.permission_adminid='$admin_id' AND starter_admin_permission.permission_permission_id='$permission_id' ");
		return $query->row_array();
	}
	
	public function save_permissions($data)
	{
		$this->db->insert('starter_admin_permission', $data);
	}
}
