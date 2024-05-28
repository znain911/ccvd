<?php
defined('BASEPATH') OR EXIT('no access allowed');

class Lessonfilter extends CI_Controller{
	
	private $sqtoken;
	private $sqtoken_hash;
	private $perPage;
	
	public function __construct()
	{
		parent::__construct();
		$this->sqtoken = $this->security->get_csrf_token_name();
		$this->sqtoken_hash = $this->security->get_csrf_hash();
		$this->load->library('ajax_pagination');
		$this->load->model('Course_model');
	}
	
	public function get_lessons()
	{
		$conditions = array();
        
        //calc offset number
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
		
		$this->perPage = 6;
		$conditions['module_id'] = $this->input->post('active_module');
		$totalRec = count($this->Course_model->get_lessonsby_module($conditions));
		
		$config['target']      = '#postList';
		$config['base_url']    = base_url().'lessonfilter/get_lessons';
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		$config['display_pages'] = FALSE;
		$config['first_link'] = FALSE;
		$config['last_link'] = FALSE;
		$config['anchor_class'] = 'course-lesson-link';
		
		$config['next_tag_open'] = '<span class="next-tg">';
		$config['next_tag_close'] = '</span>';
		
		$config['next_link'] = '<i class="fa fa-angle-right"></i>';
		$config['prev_link'] = '<i class="fa fa-angle-left"></i>';
		
		$config['prev_tag_open'] = '<span class="prev-tg">';
		$config['prev_tag_close'] = '</span>';
		
		$config['show_count']  = false;
		$config['link_func']   = 'getCourseLessons';
		$this->ajax_pagination->initialize($config);
		
		//set start and limit
        $conditions['start'] = $offset;
		$conditions['limit'] = $this->perPage;
		
		$data['items'] = $this->Course_model->get_lessonsby_module($conditions);
		$content = $this->load->view('course', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		echo json_encode($result);
		exit;
	}
	
}