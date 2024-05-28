<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Evaluation extends CI_Controller{
	
	private $sqtoken;
	private $sqtoken_hash;
	
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Dhaka');
		$this->sqtoken = $this->security->get_csrf_token_name();
		$this->sqtoken_hash = $this->security->get_csrf_hash();
		
		$active_teacher = $this->session->userdata('active_teacher');
		$teacherLogin = $this->session->userdata('teacherLogin');
		if($active_teacher === NULL && $teacherLogin !== TRUE)
		{
			redirect('faculty/login', 'refresh', true);
		}
		$this->perPage = 10;
		$this->load->model('Evaluation_model');
		$this->load->library('ajax_pagination');
		$this->load->helper('custom_string');
	}
	
	public function index()
	{
		$this->load->view('evaluations');
	}
	
	public function lists()
	{
		$data = array();
        
        //total rows count
        $totalRec = $this->Evaluation_model->count_evaluations_by_facultyid();
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'evalapi/get_evaluations_by_faculties';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //get the posts data
        $data['get_items'] = $this->Evaluation_model->get_evaluations_by_facultyid(array('limit'=>$this->perPage));
		$this->load->view('evaluations_lists', $data);
	}
	
	public function submitevaluation()
	{
		//Save evaluation ratings
		$rating_rows = $this->input->post('rating_rows');
		if(count($rating_rows) !== 0)
		{
			//Save evaluation information
			$evaluation_data = array(
									'evaluation_student_id'  => html_escape($this->input->post('student_id')),
									'evaluation_by'          => $this->session->userdata('active_teacher'),
									'evaluation_title'       => html_escape($this->input->post('title')),
									'evaluation_description' => html_escape($this->input->post('description')),
									'evaluation_create_date' => date("Y-m-d H:i:s"),
							   );
			$insert_id = $this->Evaluation_model->save_evaluation_info($evaluation_data);
			$evaluation_id = $this->db->insert_id($insert_id);
			
			foreach($rating_rows as $row){
				$rating_eval_id                 = $this->input->post('eval_id_'.$row);
				$rating_eval_label              = $this->input->post('eval_label_'.$row);
				$colunm                         = $this->input->post('rating_type_colunm_'.$row);
				$rating_eval_rating_type        = $this->input->post('rating_type_'.$colunm.'_'.$row);
				$rating_eval_rating             = $this->input->post('rating_'.$colunm.'_'.$row);
				$rating_data = array(
									'rating_student_id'              => html_escape($this->input->post('student_id')),
									'rating_by'                      => $this->session->userdata('active_teacher'),
									'rating_evaluation_id'           => $evaluation_id,
									'rating_eval_id'                 => $rating_eval_id,
									'rating_eval_label'              => $rating_eval_label,
									'rating_eval_rating_type_colunm' => $colunm,
									'rating_eval_rating_type'        => $rating_eval_rating_type,
									'rating_eval_rating'             => $rating_eval_rating,
							   );
				$this->Evaluation_model->save_evaluation_ratings_info($rating_data);
			}
		}else
		{
			$error_content = '<div class="alert alert-danger">Please select ratings!!!</div>';
			$result = array('status' => 'error', 'error' => $error_content);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
		
		$success_content = '<div role="alert" class="alert alert-success alert-light alert-dismissible">
								<button aria-label="Close" data-dismiss="alert" class="close" type="button"><i class="zmdi zmdi-close"></i></button>
								<strong><i class="zmdi zmdi-check"></i> Success!</strong> Evaluation has been successfully submited!
							</div>';
		$result = array('status' => 'ok', 'success' => $success_content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function get_students()
	{
		$term = html_escape($this->input->get('q'));
		$students = $this->Evaluation_model->get_students($term);
		$content = array();
		foreach($students as $student):
			$full_name = $student['spinfo_first_name'].' '.$student['spinfo_middle_name'].' '.$student['spinfo_last_name'];
			$content[] = array("label" => $full_name, "value" => $student['spinfo_student_id']);
		endforeach;
		echo json_encode(array('content' => $content));
		exit;
	}
	
	
}