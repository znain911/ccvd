<?php
defined('BASEPATH') OR EXIT('no access allowed');

class Paymentapi extends CI_Controller{
	
	private $sqtoken;
	private $sqtoken_hash;
	
	public function __construct()
	{
		parent::__construct();
		$this->sqtoken = $this->security->get_csrf_token_name();
		$this->sqtoken_hash = $this->security->get_csrf_hash();
		
		$this->load->library('ajax_pagination');
		$this->load->model('Paymentapi_model');
		$this->perPage = 15;
	}
	
	public function online(){
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
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		$limit = $this->input->post('limit');
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$batch = $this->input->post('batch');
        if($keywords){
            $conditions['search']['keywords'] = $keywords;
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
		if($batch){
            $conditions['search']['batch'] = $batch;
        }
        
        //total rows count
        $totalRec = $this->Paymentapi_model->count_onlinepayment_info($conditions);
		$total_amount = $this->Paymentapi_model->count_onlinepayment_totalamount($conditions);
        if($limit)
		{
			$per_page = $limit;
		}else
		{
			$per_page = $this->perPage;
		}
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'paymentapi/online';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $per_page;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //set start and limit
        $conditions['start'] = $offset;
		if($limit)
		{
			$conditions['limit'] = $limit;
		}else
		{
			$conditions['limit'] = $this->perPage;
		}
        
        //get posts data
        $data['get_items'] = $this->Paymentapi_model->get_onlinepayment_info($conditions);
        //load the view
        $content = $this->load->view('online', $data, true);
		$result = array('status' => 'ok', 'content' => $content, 'total_rows' => $totalRec, 'total_amount' => $total_amount);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
    }
	
	public function deposit(){
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
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		$limit = $this->input->post('limit');
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$batch = $this->input->post('batch');
        if($keywords){
            $conditions['search']['keywords'] = $keywords;
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
		if($batch){
            $conditions['search']['batch'] = $batch;
        }
        
        //total rows count
        $totalRec = $this->Paymentapi_model->count_depositpayment_info($conditions);
		$total_amount = $this->Paymentapi_model->count_depositpayment_totalamount($conditions);
        if($limit)
		{
			$per_page = $limit;
		}else
		{
			$per_page = $this->perPage;
		}
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'paymentapi/deposit';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $per_page;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //set start and limit
        $conditions['start'] = $offset;
		if($limit)
		{
			$conditions['limit'] = $limit;
		}else
		{
			$conditions['limit'] = $this->perPage;
		}
        
        //get posts data
        $data['get_items'] = $this->Paymentapi_model->get_depositpayment_info($conditions);
        //load the view
        $content = $this->load->view('deposit', $data, true);
		$result = array('status' => 'ok', 'content' => $content, 'total_rows' => $totalRec, 'total_amount' => $total_amount);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
    }
	
}