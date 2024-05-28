<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {
	
	public function get_all_items()
	{
		$query = $this->db->query("SELECT * FROM starter_dlp_categories ORDER BY starter_dlp_categories.category_id DESC");
		return $query->result_array();
	}
	
	public function create($data)
	{
		$this->db->insert('starter_dlp_categories', $data);
	}
	
	public function update($id, $data)
	{
		$this->db->where('category_id', $id);
		$this->db->update('starter_dlp_categories', $data);
	}
	
	public function get_info($id)
	{
		$query = $this->db->query("SELECT * FROM starter_dlp_categories WHERE starter_dlp_categories.category_id='$id' LIMIT 1");
		return $query->row_array();
	}
	
}
