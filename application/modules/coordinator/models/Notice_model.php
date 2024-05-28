<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notice_model extends CI_Model {
	
	public function get_all_items()
	{
		$query = $this->db->query("SELECT *
							       FROM starter_notice 
								   ORDER BY starter_notice.create_date DESC");
		return $query->result_array();
	}
	
	public function create($data)
	{
		$this->db->insert('starter_notice', $data);
	}
	
	public function update($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('starter_notice', $data);
	}
	
	public function get_info($id)
	{
		$query = $this->db->query("SELECT * FROM starter_notice WHERE starter_notice.id='$id' LIMIT 1");
		return $query->row_array();
	}
	
	public function count_total_organograms()
	{
		$query = $this->db->query("SELECT id FROM starter_notice");
		return $query->num_rows()+1;
	}
}

