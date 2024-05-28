<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Websitefaqs_model extends CI_Model {
	
	public function get_all_items()
	{
		$query = $this->db->query("SELECT * FROM starter_faqs WHERE starter_faqs.faq_type='Website' ORDER BY starter_faqs.faq_id DESC");
		return $query->result_array();
	}
	
	public function create($data)
	{
		$this->db->insert('starter_faqs', $data);
	}
	
	public function update($id, $data)
	{
		$this->db->where('faq_id', $id);
		$this->db->update('starter_faqs', $data);
	}
	
	public function get_info($id)
	{
		$query = $this->db->query("SELECT * FROM starter_faqs WHERE starter_faqs.faq_id='$id' LIMIT 1");
		return $query->row_array();
	}
	
}
