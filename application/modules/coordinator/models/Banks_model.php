<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banks_model extends CI_Model {
	
	public function get_all_items()
	{
		$query = $this->db->query("SELECT * FROM starter_config_bank_details ORDER BY starter_config_bank_details.bank_id DESC");
		return $query->result_array();
	}
	
	public function create($data)
	{
		$this->db->insert('starter_config_bank_details', $data);
	}
	
	public function update($id, $data)
	{
		$this->db->where('bank_id', $id);
		$this->db->update('starter_config_bank_details', $data);
	}
	
	public function get_info($id)
	{
		$query = $this->db->query("SELECT * FROM starter_config_bank_details WHERE starter_config_bank_details.bank_id='$id' LIMIT 1");
		return $query->row_array();
	}
	
	public function check_thumbnail($id)
	{
		$query = $this->db->query("SELECT bank_photo_icon FROM starter_config_bank_details WHERE starter_config_bank_details.bank_id='$id' LIMIT 1");
		return $query->row_array();
	}
	
}
