<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page_model extends CI_Model{
	
	public function get_single_page($slug)
	{
		$query = $this->db->query("SELECT * FROM starter_pages WHERE starter_pages.page_slug='$slug' ");
		return $query->row_array();
	}
	
}
