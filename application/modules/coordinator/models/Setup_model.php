<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup_model extends CI_Model {
	
	public function update_smsconfig($data)
	{
		$this->db->where('sms_key', 'One_Time');
		$this->db->update('starter_sms_config', $data);
	}
	
	public function get_smsconfig()
	{
		$query = $this->db->query("SELECT * FROM starter_sms_config WHERE starter_sms_config.sms_key='One_Time' LIMIT 1");
		return $query->row_array();
	}
	
	public function update_paymentconfig($data)
	{
		$this->db->where('pconfig_key', 'One_Time');
		$this->db->update('starter_payment_config', $data);
	}
	
	public function get_paymentconfig()
	{
		$query = $this->db->query("SELECT * FROM starter_payment_config WHERE starter_payment_config.pconfig_key='One_Time' LIMIT 1");
		return $query->row_array();
	}
	
	public function update_marksconfig($data)
	{
		$this->db->where('mrkconfig_key', 'One_Time');
		$this->db->update('starter_marks_config', $data);
	}
	
	public function update_contactinfo($data)
	{
		$this->db->where('config_key', 'One_Time');
		$this->db->update('starter_contact_info', $data);
	}

	public function update_footerinfo($data)
	{
		$this->db->where('config_key', 'footer_info');
		$this->db->update('starter_contact_info', $data);
	}



	
	public function get_marksconfig()
	{
		$query = $this->db->query("SELECT * FROM starter_marks_config WHERE starter_marks_config.mrkconfig_key='One_Time' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_contactinfo()
	{
		$query = $this->db->query("SELECT * FROM starter_contact_info WHERE starter_contact_info.config_key='One_Time' LIMIT 1");
		return $query->row_array();
	}

	public function get_footerinfo()
	{
		$query = $this->db->query("SELECT * FROM starter_contact_info WHERE starter_contact_info.config_key='footer_info' LIMIT 1");
		return $query->row_array();
	}
	
	
	public function get_all_labels()
	{
		$query = $this->db->query("SELECT * FROM starter_evaluations ORDER BY starter_evaluations.eval_id ASC");
		return $query->result_array();
	}
	
	public function get_all_faculties_labels()
	{
		$query = $this->db->query("SELECT * FROM starter_faculties_evaluations ORDER BY eval_id ASC");
		return $query->result_array();
	}
	
	public function insert_evaluations($data)
	{
		$this->db->insert('starter_evaluations', $data);
	}
	
	public function insert_faculties_evaluations($data)
	{
		$this->db->insert('starter_faculties_evaluations', $data);
	}
	
	public function delete_evaluations()
	{
		$this->db->query('TRUNCATE TABLE starter_evaluations');
	}
	
	public function delete_faculties_evaluations()
	{
		$this->db->query('TRUNCATE TABLE starter_faculties_evaluations');
	}
	
	public function update_options($data)
	{
		$this->db->where('option_key', 'BANNERS');
		$this->db->update('starter_options_panel', $data);
	}
	
	public function get_option_panel($field)
	{
		$query = $this->db->query("SELECT $field FROM starter_options_panel WHERE option_key='BANNERS'");
		return $query->row_array();
	}
	
	public function get_option_banners()
	{
		$query = $this->db->query("SELECT * FROM starter_options_panel WHERE option_key='BANNERS'");
		return $query->row_array();
	}
	
}
