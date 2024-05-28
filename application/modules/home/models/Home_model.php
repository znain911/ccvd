<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model {
	
	public function get_dlp_organograms()
	{
		$query = $this->db->query("SELECT * FROM starter_organogram WHERE owner_activate='1' AND owner_show_at_landing='1' order by owner_position ASC");
		return $query->result_array();
	}

	public function get_dlp_organogramsnew()
	{
		$list_ids = array('Chief Patron', 'Chairman', 'Course Director');       
		$this -> db -> select('*');
		$this -> db -> where_in('owner_type',$list_ids);
		$this -> db -> where('owner_activate',1);
		$this -> db -> where('owner_show_at_landing',1);
		$this -> db -> order_by('owner_position','ASC');
		$this -> db -> from('starter_organogram');
		$query = $this->db->get();
		return $query->result_array();
		/*return $query->result();*/
	}

	public function get_dlp_tech_adviser()
	{
		       
		$this -> db -> select('*');
		$this -> db -> where_in('owner_type','Technical Adviser');
		$this -> db -> where('owner_activate',1);
		$this -> db -> where('owner_show_at_landing',1);
		$this -> db -> order_by('owner_position','ASC');
		$this -> db -> from('starter_organogram');
		$query = $this->db->get();
		return $query->result_array();
		/*return $query->result();*/
	}
	public function get_dlp_acd_adviser()
	{
		       
		$this -> db -> select('*');
		$this -> db -> where_in('owner_type','Academic Advisor');
		$this -> db -> where('owner_activate',1);
		$this -> db -> where('owner_show_at_landing',1);
		$this -> db -> order_by('owner_position','ASC');
		$this -> db -> from('starter_organogram');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_dlp_admin()
	{		       
		$this -> db -> select('*');
		$this -> db -> where_in('owner_type','Administrative Member');
		$this -> db -> where('owner_activate',1);
		$this -> db -> where('owner_show_at_landing',1);
		$this -> db -> order_by('owner_position','ASC');
		$this -> db -> from('starter_organogram');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_dlp_resource()
	{		       
		$this -> db -> select('*');
		$this -> db -> where_in('owner_type','Resource Person');
		$this -> db -> where('owner_activate',1);
		$this -> db -> where('owner_show_at_landing',1);
		$this -> db -> order_by('owner_position','ASC');
		$this -> db -> from('starter_organogram');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_dlp_faculty()
	{		       
		$this -> db -> select('*');
		$this -> db -> where_in('owner_type','Faculties');
		$this -> db -> where('owner_activate',1);
		$this -> db -> where('owner_show_at_landing',1);
		$this -> db -> order_by('owner_position','ASC');
		$this -> db -> from('starter_organogram');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_dlp_int_faculty()
	{		       
		$this -> db -> select('*');
		$this -> db -> where_in('owner_type','International Faculty');
		$this -> db -> where('owner_activate',1);
		$this -> db -> where('owner_show_at_landing',1);
		$this -> db -> order_by('owner_position','ASC');
		$this -> db -> from('starter_organogram');
		$query = $this->db->get();
		return $query->result_array();
	}


	public function get_dlp_course_coordinators()
	{		       
		$this -> db -> select('*');
		$this -> db -> where_in('owner_type','Course Coordinators');
		$this -> db -> where('owner_activate',1);
		$this -> db -> where('owner_show_at_landing',1);
		$this -> db -> order_by('owner_position','ASC');
		$this -> db -> from('starter_organogram');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_video()
	{
		$this -> db -> select('*');
		$this -> db -> where('type','video');
		$this -> db -> where('status',1);
		$this -> db -> order_by('ordering','ASC');
		$this -> db -> from('starter_common_info');
		$query = $this->db->get();
		return $query->result();
	}

	
}
