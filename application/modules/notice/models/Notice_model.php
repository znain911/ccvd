<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notice_model extends CI_Model {
	
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

	public function get_notice() { /*get notice list*/
        $this -> db -> select('*');
		$this -> db -> from('starter_notice');
		$this->db->where('status', 1);
		$this->db->order_by('create_date','DESC');
		//$this->db->limit('20');
		$query = $this->db->get();
		return $query->result();
    } // End of function 

    public function get_noticeDetail($id) { /*get notice information*/
        $this -> db -> select('*');
		$this -> db -> from('starter_notice');
		$this -> db -> where('id', $id);
		$query = $this->db->get();
		return $query->first_row();
    } // End of function
	
}
