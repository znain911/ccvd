<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exambutton_model extends CI_Model {
	
	public function get_all_items()
	{
		$query = $this->db->query("SELECT *
							       FROM starter_exam_button 
								   ORDER BY starter_exam_button.btn_id DESC");
		return $query->result_array();
	}
	
	public function create($data)
	{
		$this->db->insert('starter_exam_button', $data);
	}
	
	public function update($id, $data)
	{
		$this->db->where('btn_id', $id);
		$this->db->update('starter_exam_button', $data);
	}
	
	public function get_info($id)
	{
		$query = $this->db->query("SELECT * FROM starter_exam_button WHERE starter_exam_button.btn_id='$id' LIMIT 1");
		return $query->row_array();
	}
	
	public function count_total_organograms()
	{
		$query = $this->db->query("SELECT btn_id FROM starter_exam_button");
		return $query->num_rows()+1;
	}

	public function get_all_batch()
	{
		$query = $this->db->query("SELECT *
							       FROM ccvd_batch 
								   ORDER BY ccvd_batch.batch_name ASC");
		return $query->result_array();
	}
}

