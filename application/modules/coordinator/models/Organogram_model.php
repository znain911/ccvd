<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Organogram_model extends CI_Model {
	
	public function get_all_items()
	{
		$query = $this->db->query("SELECT *
							       FROM starter_organogram 
								   ORDER BY starter_organogram.owner_id DESC");
		return $query->result_array();
	}
	
	public function create($data)
	{
		$this->db->insert('starter_organogram', $data);
	}
	
	public function update($id, $data)
	{
		$this->db->where('owner_id', $id);
		$this->db->update('starter_organogram', $data);
	}
	
	public function get_info($id)
	{
		$query = $this->db->query("SELECT * FROM starter_organogram WHERE starter_organogram.owner_id='$id' LIMIT 1");
		return $query->row_array();
	}
	
	public function count_total_organograms()
	{
		$query = $this->db->query("SELECT owner_id FROM starter_organogram");
		return $query->num_rows()+1;
	}
}
