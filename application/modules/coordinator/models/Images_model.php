<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Images_model extends CI_Model {
	
	public function get_all_items()
	{
		$query = $this->db->query("SELECT *
							       FROM starter_images 
								   ORDER BY starter_images.create_date DESC");
		return $query->result_array();
	}
	
	public function create($data)
	{
		$this->db->insert('starter_images', $data);
	}
	
	public function update($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('starter_images', $data);
	}
	
	public function get_info($id)
	{
		$query = $this->db->query("SELECT * FROM starter_images WHERE starter_images.id='$id' LIMIT 1");
		return $query->row_array();
	}
	
	public function count_total_organograms()
	{
		$query = $this->db->query("SELECT id FROM starter_images");
		return $query->num_rows()+1;
	}
}

