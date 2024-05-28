<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faqs_model extends CI_Model {
	
	public function get_all_faqs($type="Website")
	{
		$query = $this->db->query("SELECT * FROM starter_faqs 
								   WHERE starter_faqs.faq_status=1 
								   AND starter_faqs.faq_type='$type' 
								   ORDER BY starter_faqs.faq_id ASC");
		return $query->result_array();
	}
	
}
