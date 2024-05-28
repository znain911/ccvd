<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faculties extends CI_Controller {
	
	private $sqtoken;
	private $sqtoken_hash;
	
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Dhaka');
		
		$active_user = $this->session->userdata('active_user');
		$userLogin = $this->session->userdata('userLogin');
		if($active_user === NULL && $userLogin !== TRUE)
		{
			redirect('coordinator/login', 'refresh', true);
		}
		
		$check_permission = $this->Perm_model->check_permissionby_admin($active_user, 2);
		if($check_permission == true){ echo null; }else{ redirect('not-found'); }
		
		$this->sqtoken = $this->security->get_csrf_token_name();
		$this->sqtoken_hash = $this->security->get_csrf_hash();
		$this->perPage = 15;
		
		$this->load->model('Faculties_model');
		$this->load->library('ajax_pagination');
		$this->load->helper('custom_string');
	}
	
	public function pending()
	{
		$data = array();
        
        //total rows count
        $totalRec = count($this->Faculties_model->get_pending_teachers());
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'facultyfilter/get_pending_faculty';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //get the posts data
        $data['get_items'] = $this->Faculties_model->get_pending_teachers(array('limit'=>$this->perPage));
		
		$this->load->view('faculties/pending', $data);
	}
	
	public function enrolled()
	{
		$data = array();
        
        //total rows count
        $totalRec = count($this->Faculties_model->get_enrolled_teachers());
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'filter/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //get the posts data
        $data['get_items'] = $this->Faculties_model->get_enrolled_teachers(array('limit'=>$this->perPage));
		
		$this->load->view('faculties/enrolled', $data);
	}
	
	public function approve()
	{
		$teacher_id = $this->input->post('teacher_id');
		$data = array(
					'teacher_status' => 1,
				);
		$this->db->where('teacher_id', $teacher_id);
		$this->db->update('starter_teachers', $data);
		$result = array('status' => 'ok');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function declined()
	{
		$teacher_id = $this->input->post('teacher_id');
		$data = array(
					'teacher_status' => 0,
				);
		$this->db->where('teacher_id', $teacher_id);
		$this->db->update('starter_teachers', $data);
		
		$result = array('status' => 'ok');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public static function delete_dir($dirPath) {
		if (! is_dir($dirPath)) {
			throw new InvalidArgumentException("$dirPath must be a directory");
		}
		if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
			$dirPath .= '/';
		}
		$files = glob($dirPath . '*', GLOB_MARK);
		foreach ($files as $file) {
			if (is_dir($file)) {
				self::deleteDir($file);
			} else {
				unlink($file);
			}
		}
		rmdir($dirPath);
	}
	
	public function delete()
	{
		$teacher_id = $this->input->post('teacher_id');
		$teacher_username = $this->Faculties_model->get_teacher_username($teacher_id);
		
		//delete from academic information
		$this->db->where('tacinfo_teacher_id', $teacher_id);
		$this->db->delete('starter_teachers_academicinfo');
		
		//delete from dlp categories
		$this->db->where('tdc_teacher_id', $teacher_id);
		$this->db->delete('starter_teachers_dlpcategories');
		
		//delete from personal information
		$this->db->where('tpinfo_teacher_id', $teacher_id);
		$this->db->delete('starter_teachers_personalinfo');
		
		//delete from professional information
		$this->db->where('tpsinfo_teacher_id', $teacher_id);
		$this->db->delete('starter_teachers_professionalinfo');
		
		//delete from specializations
		$this->db->where('ts_teacher_id', $teacher_id);
		$this->db->delete('starter_teachers_specializations');
		
		//delete student directory
		$dir = $_SERVER['DOCUMENT_ROOT'].'/attachments/faculties/'.$teacher_username;
		if(file_exists($dir))
		{
			$this->delete_dir($dir);
		}
		
		//delete from student table
		$this->db->where('teacher_id', $teacher_id);
		$this->db->delete('starter_teachers');
		
		$result = array('status' => 'ok');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function view()
	{
		$teacher_id = $this->input->post('teacher_id');
		$data['item'] = $this->Faculties_model->get_teacher_info($teacher_id);
		$content = $this->load->view('faculties/view_details', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
}