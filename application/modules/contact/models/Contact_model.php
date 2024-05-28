<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact_model extends CI_Model {
	
	public function send($data)
	{
		$this->db->insert('starter_contacts', $data);
	}
	
	public function get_ticket()
	{
		$query = $this->db->query("SELECT contact_id FROM starter_contacts");
		return $query->num_rows()+1;
		/*return 10000+$query->num_rows()+1;*/
	}
	
	public function contact_infos()
	{
		$query = $this->db->query("SELECT * FROM starter_contact_info WHERE starter_contact_info.config_key='One_Time' LIMIT 1");
		return $query->row_array();
	}
	
}
