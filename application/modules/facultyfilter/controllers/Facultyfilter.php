<?php
defined('BASEPATH') OR EXIT('no access allowed');

class Facultyfilter extends CI_Controller{
	
	private $sqtoken;
	private $sqtoken_hash;
	
	public function __construct()
	{
		parent::__construct();
		$this->sqtoken = $this->security->get_csrf_token_name();
		$this->sqtoken_hash = $this->security->get_csrf_hash();
		
		$this->load->library('ajax_pagination');
		$this->load->model('Faculties_model');
		$this->perPage = 15;
	}
	
	public function get_pending_faculty(){
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
        if($keywords){
            $conditions['search']['keywords'] = $keywords;
        }
		
		if($sortby){
            $conditions['search']['sortby'] = $sortby;
        }
        
        //total rows count
        $totalRec = count($this->Faculties_model->get_pending_teachers($conditions));
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'facultyfilter/get_pending_faculty';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //set start and limit
        $conditions['start'] = $offset;
		$conditions['limit'] = $this->perPage;
        
        //get posts data
        $data['get_items'] = $this->Faculties_model->get_pending_teachers($conditions);
        //load the view
        $content = $this->load->view('teachers', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
    }
	
	public function get_enrolled_faculty(){
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
        if($keywords){
            $conditions['search']['keywords'] = $keywords;
        }
		if($sortby){
            $conditions['search']['sortby'] = $sortby;
        }
        
        //total rows count
        $totalRec = count($this->Faculties_model->get_enrolled_teachers($conditions));
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'facultyfilter/get_enrolled_faculty';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //set start and limit
        $conditions['start'] = $offset;
		$conditions['limit'] = $this->perPage;
        
        //get posts data
        $data['get_items'] = $this->Faculties_model->get_enrolled_teachers($conditions);
        //load the view
        $content = $this->load->view('teachers', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
    }
	
}