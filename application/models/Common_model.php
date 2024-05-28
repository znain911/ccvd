<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common_model extends CI_Model{
	
	public function get_pages($location)
	{
		$query = $this->db->query("SELECT * FROM starter_pages WHERE starter_pages.page_action=1 AND starter_pages.page_location='$location' ORDER BY starter_pages.page_id ASC");
		return $query->result_array();
	}
	
	public function short_descby_slug($slug)
	{
		$query = $this->db->query("SELECT page_short_description FROM starter_pages WHERE starter_pages.page_slug='$slug'");
		$result = $query->row_array();
		return $result['page_short_description'];
	}
	
	public function get_student_information()
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT 
								   * 
								   FROM starter_students
								   LEFT JOIN starter_students_personalinfo ON
								   starter_students_personalinfo.spinfo_student_id=starter_students.student_id
								   LEFT JOIN starter_phases ON
								   starter_phases.phase_id=starter_students.student_phaselevel_id
								   WHERE starter_students.student_id='$student_id'
								   ");
		return $query->row_array();
	}
	
	public function get_teacher_information()
	{
		$teacher_id = $this->session->userdata('active_teacher');
		$query = $this->db->query("SELECT 
								   * 
								   FROM starter_teachers
								   LEFT JOIN starter_teachers_personalinfo ON
								   starter_teachers_personalinfo.tpinfo_teacher_id=starter_teachers.teacher_id
								   WHERE starter_teachers.teacher_id='$teacher_id'
								   ");
		return $query->row_array();
	}
	
	public function get_coordinator()
	{
		$query = $this->db->query("SELECT owner_name, owner_photo
							       FROM starter_owner
								   WHERE starter_owner.owner_show_at_landing='1'
								   ORDER BY starter_owner.owner_id DESC");
		return $query->result_array();
	}
	
	public function get_option_banners()
	{
		$query = $this->db->query("SELECT * FROM starter_options_panel WHERE option_key='BANNERS'");
		return $query->row_array();
	}

	public function get_footerinfo()
	{
		$query = $this->db->query("SELECT * FROM starter_contact_info WHERE starter_contact_info.config_key='footer_info' LIMIT 1");
		return $query->row_array();
	}

	public function get_footermenulink()
	{
		$this -> db -> select('*');
		$this -> db -> where('type','footermenu');
		$this -> db -> where('status',1);
		$this -> db -> order_by('ordering','ASC');
		$this -> db -> from('starter_common_info');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_implink()
	{
		$this -> db -> select('*');
		$this -> db -> where('type','importantlink');
		$this -> db -> where('status',1);
		$this -> db -> order_by('ordering','ASC');
		$this -> db -> from('starter_common_info');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_footersociallink()
	{
		$this -> db -> select('*');
		$this -> db -> where('type','social');
		$this -> db -> where('status',1);
		$this -> db -> order_by('ordering','ASC');
		$this -> db -> from('starter_common_info');
		$query = $this->db->get();
		return $query->result();
	}
	
}
