<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {
	
	public function check_credential($email, $password)
	{
		$this->db->select('owner_id, owner_role_id, owner_name, owner_photo, owner_last_login, owner_activate');
		$this->db->where('owner_email', $email);
		$this->db->where('owner_password', $password);
		$this->db->from('starter_owner');
		$result = $this->db->get();
		return $result->row();
	}
	
	public function update_admin($admin_id, $data)
	{
		$this->db->where('owner_id', $admin_id);
		$this->db->update('starter_owner', $data);
	}
	
	public function update_reset_code($owner_id, $data)
	{
		$this->db->where('owner_id', $owner_id);
		$this->db->update('starter_owner', $data);
	}
	
	public function check_exist_email($email)
	{
		$query = $this->db->query("SELECT owner_id, owner_email FROM starter_owner WHERE starter_owner.owner_email='$email' ");
		return $query->row();
	}
	
	public function check_resetcode($reset_code, $owner_id)
	{
		$query = $this->db->query("SELECT owner_id FROM starter_owner WHERE starter_owner.owner_passwrd_resetcd='$reset_code' AND starter_owner.owner_id='$owner_id' ");
		return $query->row();
	}
	
	public function update_password($owner_id, $data)
	{
		$this->db->where('owner_id', $owner_id);
		$this->db->update('starter_owner', $data);
	}
	
}
