<?php
defined('BASEPATH') OR EXIT('no access allowed');

class Evalapi extends CI_Controller{
	
	private $sqtoken;
	private $sqtoken_hash;
	
	public function __construct()
	{
		parent::__construct();
		$this->sqtoken = $this->security->get_csrf_token_name();
		$this->sqtoken_hash = $this->security->get_csrf_hash();
		
		$this->load->library('ajax_pagination');
		$this->load->model('Evaluation_model');
		$this->load->helper('custom_string');
		$this->perPage = 10;
	}
	
	public function get_evaluations_by_students(){
        $conditions = array();
        
        //calc offset number
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        
        //set conditions for search
		$keywords = $this->input->post('keywords');
		$sortby = $this->input->post('sortby');
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		$limit = $this->input->post('limit');
		$month = $this->input->post('month');
		$year = $this->input->post('year');
        if($keywords){
            $conditions['search']['keywords'] = $keywords;
        }
		
		if($sortby){
            $conditions['search']['sortby'] = $sortby;
        }
		if($from_date){
            $conditions['search']['from_date'] = $from_date;
        }
		if($to_date){
            $conditions['search']['to_date'] = $to_date;
        }
		if($month){
            $conditions['search']['month'] = $month;
        }
		if($year){
            $conditions['search']['year'] = $year;
        }
		
        
        //total rows count
        $totalRec = $this->Evaluation_model->count_evaluations_by_studentid($conditions);
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'evalapi/get_evaluations_by_students';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //set start and limit
        $conditions['start'] = $offset;
		$conditions['limit'] = $this->perPage;
        
        //get posts data
        $data['get_items'] = $this->Evaluation_model->get_evaluations_by_studentid($conditions);
        //load the view
        $content = $this->load->view('evaluations_lists', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
    }
	
	public function get_coordinator_evaluations_by_students(){
        $conditions = array();
        
        //calc offset number
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        
        //set conditions for search
		$keywords = $this->input->post('keywords');
		$sortby = $this->input->post('sortby');
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		$limit = $this->input->post('limit');
		$month = $this->input->post('month');
		$year = $this->input->post('year');
        if($keywords){
            $conditions['search']['keywords'] = $keywords;
        }
		
		if($sortby){
            $conditions['search']['sortby'] = $sortby;
        }
		if($from_date){
            $conditions['search']['from_date'] = $from_date;
        }
		if($to_date){
            $conditions['search']['to_date'] = $to_date;
        }
		if($month){
            $conditions['search']['month'] = $month;
        }
		if($year){
            $conditions['search']['year'] = $year;
        }
		
        
        //total rows count
        $totalRec = $this->Evaluation_model->count_coordinator_evaluations_by_studentid($conditions);
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'evalapi/get_coordinator_evaluations_by_students';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //set start and limit
        $conditions['start'] = $offset;
		$conditions['limit'] = $this->perPage;
        
        //get posts data
        $data['get_items'] = $this->Evaluation_model->get_coordinator_evaluations_by_studentid($conditions);
        //load the view
        $content = $this->load->view('coordinator_faculties_evaluations_lists', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
    }
	
	public function get_evaluations_by_faculties(){
        $conditions = array();
        
        //calc offset number
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        
        //set conditions for search
		$keywords = $this->input->post('keywords');
		$sortby = $this->input->post('sortby');
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		$limit = $this->input->post('limit');
		$month = $this->input->post('month');
		$year = $this->input->post('year');
        if($keywords){
            $conditions['search']['keywords'] = $keywords;
        }
		
		if($sortby){
            $conditions['search']['sortby'] = $sortby;
        }
		if($from_date){
            $conditions['search']['from_date'] = $from_date;
        }
		if($to_date){
            $conditions['search']['to_date'] = $to_date;
        }
		if($month){
            $conditions['search']['month'] = $month;
        }
		if($year){
            $conditions['search']['year'] = $year;
        }
		
        
        //total rows count
        $totalRec = $this->Evaluation_model->count_evaluations_by_facultyid($conditions);
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'evalapi/get_evaluations_by_faculties';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //set start and limit
        $conditions['start'] = $offset;
		$conditions['limit'] = $this->perPage;
        
        //get posts data
        $data['get_items'] = $this->Evaluation_model->get_evaluations_by_facultyid($conditions);
        //load the view
        $content = $this->load->view('faculties_evaluations_lists', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
    }
	
	public function get_coordinator_evaluations_by_faculties(){
        $conditions = array();
        
        //calc offset number
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        
        //set conditions for search
		$keywords = $this->input->post('keywords');
		$sortby = $this->input->post('sortby');
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		$limit = $this->input->post('limit');
		$month = $this->input->post('month');
		$year = $this->input->post('year');
        if($keywords){
            $conditions['search']['keywords'] = $keywords;
        }
		
		if($sortby){
            $conditions['search']['sortby'] = $sortby;
        }
		if($from_date){
            $conditions['search']['from_date'] = $from_date;
        }
		if($to_date){
            $conditions['search']['to_date'] = $to_date;
        }
		if($month){
            $conditions['search']['month'] = $month;
        }
		if($year){
            $conditions['search']['year'] = $year;
        }
		
        
        //total rows count
        $totalRec = $this->Evaluation_model->count_coordinator_evaluations_by_facultyid($conditions);
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'evalapi/get_coordinator_evaluations_by_faculties';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //set start and limit
        $conditions['start'] = $offset;
		$conditions['limit'] = $this->perPage;
        
        //get posts data
        $data['get_items'] = $this->Evaluation_model->get_coordinator_evaluations_by_facultyid($conditions);
        //load the view
        $content = $this->load->view('coordinator_students_evaluations_lists', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
    }
	
	public function view_student_evaluation()
	{
		$data['evaluation_id'] = $this->input->post('evl_id');
		$content = $this->load->view('view_student_evaluation', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		echo json_encode($result);
		exit;
	}
	
	public function view_faculties_evaluation()
	{
		$data['evaluation_id'] = $this->input->post('evl_id');
		$content = $this->load->view('view_faculties_evaluation', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		echo json_encode($result);
		exit;
	}
	
}