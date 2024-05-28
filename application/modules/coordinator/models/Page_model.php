<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page_model extends CI_Model {
	
	public function get_all_items()
	{
		$query = $this->db->query("SELECT * FROM starter_pages ORDER BY starter_pages.page_id DESC");
		return $query->result_array();
	}
	
	public function create($data)
	{
		$this->db->insert('starter_pages', $data);
	}
	
	public function update($id, $data)
	{
		$this->db->where('page_id', $id);
		$this->db->update('starter_pages', $data);
	}
	
	public function get_info($id)
	{
		$query = $this->db->query("SELECT * FROM starter_pages WHERE starter_pages.page_id='$id' LIMIT 1");
		return $query->row_array();
	}
	
	public function count_pages()
	{
		$query = $this->db->query("SELECT * FROM starter_pages");
		return $query->num_rows();
	}
	
	public function isslug_exist($slug)
	{
		$query = $this->db->query("SELECT * FROM starter_pages WHERE starter_pages.page_slug='$slug' LIMIT 1");
		return $query->row_array();
	}
}
