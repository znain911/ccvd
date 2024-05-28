<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contacts_model extends CI_Model {
	
	public function get_all_contacts()
	{
		$query = $this->db->query("SELECT * FROM starter_contacts ORDER BY starter_contacts.contact_id DESC");
		return $query->result_array();
	}
	
	public function get_contactby_id($contact_id)
	{
		$query = $this->db->query("SELECT * FROM starter_contacts WHERE starter_contacts.contact_id='$contact_id' LIMIT 1");
		return $query->row_array();
	}
	
}
