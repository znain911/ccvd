<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Questions extends CI_Controller {
	
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
		
		$check_permission = $this->Perm_model->check_permissionby_admin($active_user, 7);
		if($check_permission == true){ echo null; }else{ redirect('not-found'); }
		
		$this->sqtoken = $this->security->get_csrf_token_name();
		$this->sqtoken_hash = $this->security->get_csrf_hash();
		
		$this->load->model('Questions_model');
		$this->load->library('pagination');
	}
	
	public function module()
	{
		$this->load->library('pagination');
		$this->load->view('questions/index');
	}
	
	public function pca()
	{
		$this->load->library('pagination');
		$this->load->view('questions/pca/index');
	}
	public function ece()
	{
		$this->load->library('pagination');
		$this->load->view('questions/ece/index');
	}
	
	public function create()
	{
		$this->load->library('form_validation');
		$data = array(  
					'question_module_id'        => $this->input->post('phs_module'),  
					'question_lesson_id'        => $this->input->post('module_lesson'),  
					'question_module_phase_id'  => $this->input->post('phase_level'),  
					'question_type'             => $this->input->post('question_type'),  
					'question_title'            => $this->input->post('title'),  
					'question_create_date'      => date("Y-m-d H:i:s"),  
					'question_status'           => $this->input->post('status'),  
					'question_created_by'       => $this->session->userdata('active_user'),  
				);
		$validate = array(
						array(
							'field' => 'title', 
							'label' => 'Question Title', 
							'rules' => 'required|trim', 
						),
						array(
							'field' => 'phase_level', 
							'label' => 'Phase level', 
							'rules' => 'required|trim', 
						),
						array(
							'field' => 'phs_module', 
							'label' => 'Module', 
							'rules' => 'required|trim', 
						),array(
							'field' => 'module_lesson', 
							'label' => 'Lesson', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		
		
		/*******MCQ Answer Part******/
		if($this->input->post('question_type') == 'MCQ'){
		
			$answer_number = $this->input->post('answer_row');
			$ans_array = array();
			foreach($answer_number as $number)
			{
				$right_answer = $this->input->post('right_answer_'.$number);
				if(!is_null($right_answer))
				{
					$ans_array[] = $right_answer;
				}
			}
			
			if(empty($ans_array))
			{
				$error = '<div class="alert alert-danger">Please choose the right answer!</div>';
				$result = array('status' => 'error', 'error' => $error);
				$result[$this->sqtoken] = $this->sqtoken_hash;
				echo json_encode($result);
				exit;
			}
		
		/********************/
		
		}elseif($this->input->post('question_type') == 'BLANK'){
		
			/*******Fill in the gaps Answer Part******/
			$answer_number = $this->input->post('answer_row');
			$ans_array = array();
			$ans_array_gap = array();
			foreach($answer_number as $number)
			{
				$right_answer = $this->input->post('right_answer_'.$number);
				$right_answer_gap = $this->input->post('right_answer_gapid_'.$right_answer);
				if($right_answer && $right_answer_gap !== '')
				{
					$ans_array[] = $right_answer;
				}
			}
			
			if(empty($ans_array))
			{
				$error = '<div class="alert alert-danger">Please choose the right answer!</div>';
				$result = array('status' => 'error', 'error' => $error);
				$result[$this->sqtoken] = $this->sqtoken_hash;
				echo json_encode($result);
				exit;
			}
		
		/********************/
		}elseif($this->input->post('question_type') == 'JUSTIFY'){
			$justify_anser = $this->input->post('justify_answer');
			if(!$justify_anser)
			{
				$error = '<div class="alert alert-danger">Please choose the right answer!</div>';
				$result = array('status' => 'error', 'error' => $error);
				$result[$this->sqtoken] = $this->sqtoken_hash;
				echo json_encode($result);
				exit;
			}	
		}elseif($this->input->post('question_type') == 'MULTIPLE_JUSTIFY')
		{
			$answer_number = $this->input->post('answer_row');
			$ans_array = array();
			foreach($answer_number as $number)
			{
				$right_answer = $this->input->post('right_answer_'.$number);
				if(!is_null($right_answer))
				{
					$ans_array[] = $right_answer;
				}
			}
			
			if(empty($ans_array))
			{
				$error = '<div class="alert alert-danger">Please choose the right answer!</div>';
				$result = array('status' => 'error', 'error' => $error);
				$result[$this->sqtoken] = $this->sqtoken_hash;
				echo json_encode($result);
				exit;
			}
		}
		
		if($this->form_validation->run() == true)
		{
			//save
			$insert_id = $this->Questions_model->create($data);
			$question_id = $this->db->insert_id($insert_id);
			
			
			//save answers
			if($this->input->post('question_type') == 'MCQ'){
				
				$answer_number = $this->input->post('answer_row');
				$right_ans_array = array();
				foreach($answer_number as $number)
				{
					$answer_title = html_escape($this->input->post('answer_'.$number));
					$answer_data = array(
										'answer_question_id' => $question_id,
										'answer_title'       => $answer_title
									);
					$ans_insid = $this->Questions_model->save_answers($answer_data);
					$answer_id = $this->db->insert_id($ans_insid);
					$right_answer = $this->input->post('right_answer_'.$number);
					if(!is_null($right_answer))
					{
						$right_ans_array[] = $answer_id;
					}
				}
				
				if(!empty($right_ans_array))
				{
					//update question table with right answer
					$rightans = json_encode($right_ans_array);
					$this->db->where('question_id', $question_id);
					$this->db->update('starter_exam_questions', array('question_right_answerid' => $rightans));
				}
			
			}elseif($this->input->post('question_type') == 'BLANK'){
				$answer_number = $this->input->post('answer_row');
				$right_ans_array = array();
				foreach($answer_number as $number)
				{
					$answer_title = html_escape($this->input->post('answer_'.$number));
					
					$right_answer = $this->input->post('right_answer_'.$number);
					$right_answer_gap = $this->input->post('right_answer_gapid_'.$right_answer);
					
					$answer_data = array(
										'answer_question_id' => $question_id,
										'answer_title'       => $answer_title
									);
					if($right_answer_gap !== '')
					{
						$answer_data['answer_blank_id'] = $right_answer_gap;
					}
					$ans_insid = $this->Questions_model->save_answers($answer_data);
					$answer_id = $this->db->insert_id($ans_insid);
					
					if(!is_null($right_answer))
					{
						$right_ans_array[] = $answer_id;
					}
				}
				
				if(!empty($right_ans_array))
				{
					//update question table with right answer
					$rightans = json_encode($right_ans_array);
					$this->db->where('question_id', $question_id);
					$this->db->update('starter_exam_questions', array('question_right_answerid' => $rightans));
				}
			}elseif($this->input->post('question_type') == 'JUSTIFY'){
				$justify_anser = $this->input->post('justify_answer');
				$this->db->where('question_id', $question_id);
				$this->db->update('starter_exam_questions', array('question_justify_answer' => $justify_anser));
			}elseif($this->input->post('question_type') == 'MULTIPLE_JUSTIFY'){
				
				$answer_number = $this->input->post('answer_row');
				$right_ans_array = array();
				foreach($answer_number as $number)
				{
					$answer_title = html_escape($this->input->post('answer_'.$number));
					$answer_data = array(
										'answer_question_id' => $question_id,
										'answer_title'       => $answer_title
									);
					$ans_insid = $this->Questions_model->save_answers($answer_data);
					$answer_id = $this->db->insert_id($ans_insid);
					$right_answer = $this->input->post('right_answer_'.$number);
					if(!is_null($right_answer))
					{
						$right_ans_array[$answer_id] = $right_answer;
					}
				}
				
				if(!empty($right_ans_array))
				{
					//update question table with right answer
					$rightans = json_encode($right_ans_array);
					$this->db->where('question_id', $question_id);
					$this->db->update('starter_exam_questions', array('question_right_answerid' => $rightans));
				}
			}
			
			
			$success = '<div class="alert alert-success">successfully created!</div>';
			$result = array('status' => 'ok', 'success' => $success);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else
		{
			$error = '<div class="alert alert-danger">'.validation_errors().'</div>';
			$result = array('status' => 'error', 'error' => $error);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
	}
	
	public function create_pca()
	{
		$this->load->library('form_validation');
		$data = array(  
					'question_module_id'        => $this->input->post('phs_module'),
					'question_lesson_id'        => $this->input->post('module_lesson'),
					'question_module_phase_id'  => $this->input->post('phase_level'),  
					'question_exam_type'        => 'PCA',  
					'question_type'             => $this->input->post('question_type'),  
					'question_title'            => $this->input->post('title'),  
					'question_create_date'      => date("Y-m-d H:i:s"),  
					'question_status'           => $this->input->post('status'),  
					'question_created_by'       => $this->session->userdata('active_user'), 
					'question_image'       => $this->input->post('recent_photo'),    					
				);
		$validate = array(
						array(
							'field' => 'title', 
							'label' => 'Question Title', 
							'rules' => 'required|trim', 
						),
						array(
							'field' => 'phase_level', 
							'label' => 'Phase level', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		
		
		/*******MCQ Answer Part******/
		if($this->input->post('question_type') == 'MCQ'){
		
			$answer_number = $this->input->post('answer_row');
			$ans_array = array();
			foreach($answer_number as $number)
			{
				$right_answer = $this->input->post('right_answer_'.$number);
				if(!is_null($right_answer))
				{
					$ans_array[] = $right_answer;
				}
			}
			
			if(empty($ans_array))
			{
				$error = '<div class="alert alert-danger">Please choose the right answer!</div>';
				$result = array('status' => 'error', 'error' => $error);
				$result[$this->sqtoken] = $this->sqtoken_hash;
				echo json_encode($result);
				exit;
			}
		
		/********************/
		
		}elseif($this->input->post('question_type') == 'BLANK'){
		
			/*******Fill in the gaps Answer Part******/
			$answer_number = $this->input->post('answer_row');
			$ans_array = array();
			$ans_array_gap = array();
			foreach($answer_number as $number)
			{
				$right_answer = $this->input->post('right_answer_'.$number);
				$right_answer_gap = $this->input->post('right_answer_gapid_'.$right_answer);
				if($right_answer && $right_answer_gap !== '')
				{
					$ans_array[] = $right_answer;
				}
			}
			
			if(empty($ans_array))
			{
				$error = '<div class="alert alert-danger">Please choose the right answer!</div>';
				$result = array('status' => 'error', 'error' => $error);
				$result[$this->sqtoken] = $this->sqtoken_hash;
				echo json_encode($result);
				exit;
			}
		
		/********************/
		}elseif($this->input->post('question_type') == 'JUSTIFY'){
			$justify_anser = $this->input->post('justify_answer');
			if(!$justify_anser)
			{
				$error = '<div class="alert alert-danger">Please choose the right answer!</div>';
				$result = array('status' => 'error', 'error' => $error);
				$result[$this->sqtoken] = $this->sqtoken_hash;
				echo json_encode($result);
				exit;
			}	
		}elseif($this->input->post('question_type') == 'MULTIPLE_JUSTIFY')
		{
			$answer_number = $this->input->post('answer_row');
			$ans_array = array();
			foreach($answer_number as $number)
			{
				$right_answer = $this->input->post('right_answer_'.$number);
				if(!is_null($right_answer))
				{
					$ans_array[] = $right_answer;
				}
			}
			
			if(empty($ans_array))
			{
				$error = '<div class="alert alert-danger">Please choose the right answer!</div>';
				$result = array('status' => 'error', 'error' => $error);
				$result[$this->sqtoken] = $this->sqtoken_hash;
				echo json_encode($result);
				exit;
			}
		}
		
		if($this->form_validation->run() == true)
		{
			//save
			$insert_id = $this->Questions_model->create($data);
			$question_id = $this->db->insert_id($insert_id);
			
			//save answers
			if($this->input->post('question_type') == 'MCQ'){
				
				$answer_number = $this->input->post('answer_row');
				$right_ans_array = array();
				foreach($answer_number as $number)
				{
					$answer_title = html_escape($this->input->post('answer_'.$number));
					$answer_data = array(
										'answer_question_id' => $question_id,
										'answer_title'       => $answer_title
									);
					$ans_insid = $this->Questions_model->save_answers($answer_data);
					$answer_id = $this->db->insert_id($ans_insid);
					$right_answer = $this->input->post('right_answer_'.$number);
					if(!is_null($right_answer))
					{
						$right_ans_array[] = $answer_id;
					}
				}
				
				if(!empty($right_ans_array))
				{
					//update question table with right answer
					$rightans = json_encode($right_ans_array);
					$this->db->where('question_id', $question_id);
					$this->db->update('starter_exam_questions', array('question_right_answerid' => $rightans));
				}
			
			}elseif($this->input->post('question_type') == 'BLANK'){
				$answer_number = $this->input->post('answer_row');
				$right_ans_array = array();
				foreach($answer_number as $number)
				{
					$answer_title = html_escape($this->input->post('answer_'.$number));
					
					$right_answer = $this->input->post('right_answer_'.$number);
					$right_answer_gap = $this->input->post('right_answer_gapid_'.$right_answer);
					
					$answer_data = array(
										'answer_question_id' => $question_id,
										'answer_title'       => $answer_title
									);
					if($right_answer_gap !== '')
					{
						$answer_data['answer_blank_id'] = $right_answer_gap;
					}
					$ans_insid = $this->Questions_model->save_answers($answer_data);
					$answer_id = $this->db->insert_id($ans_insid);
					
					if(!is_null($right_answer))
					{
						$right_ans_array[] = $answer_id;
					}
				}
				
				if(!empty($right_ans_array))
				{
					//update question table with right answer
					$rightans = json_encode($right_ans_array);
					$this->db->where('question_id', $question_id);
					$this->db->update('starter_exam_questions', array('question_right_answerid' => $rightans));
				}
			}elseif($this->input->post('question_type') == 'JUSTIFY'){
				$justify_anser = $this->input->post('justify_answer');
				$this->db->where('question_id', $question_id);
				$this->db->update('starter_exam_questions', array('question_justify_answer' => $justify_anser));
			}elseif($this->input->post('question_type') == 'MULTIPLE_JUSTIFY'){
				
				$answer_number = $this->input->post('answer_row');
				$right_ans_array = array();
				foreach($answer_number as $number)
				{
					$answer_title = html_escape($this->input->post('answer_'.$number));
					$answer_data = array(
										'answer_question_id' => $question_id,
										'answer_title'       => $answer_title
									);
					$ans_insid = $this->Questions_model->save_answers($answer_data);
					$answer_id = $this->db->insert_id($ans_insid);
					$right_answer = $this->input->post('right_answer_'.$number);
					if(!is_null($right_answer))
					{
						$right_ans_array[$answer_id] = $right_answer;
					}
				}
				
				if(!empty($right_ans_array))
				{
					//update question table with right answer
					$rightans = json_encode($right_ans_array);
					$this->db->where('question_id', $question_id);
					$this->db->update('starter_exam_questions', array('question_right_answerid' => $rightans));
				}
			}
			
			$success = '<div class="alert alert-success">successfully created!</div>';
			$result = array('status' => 'ok', 'success' => $success);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else
		{
			$error = '<div class="alert alert-danger">'.validation_errors().'</div>';
			$result = array('status' => 'error', 'error' => $error);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
	}
	// create ece
	public function create_ece()
	{
		$this->load->library('form_validation');
		$data = array(  
					'question_module_id'        => $this->input->post('phs_module'),
					'question_lesson_id'        => $this->input->post('module_lesson'),
					'question_module_phase_id'  => $this->input->post('phase_level'),  
					'question_exam_type'        => 'ece',  
					'question_type'             => $this->input->post('question_type'),  
					'question_title'            => $this->input->post('title'),  
					'question_create_date'      => date("Y-m-d H:i:s"),  
					'question_status'           => $this->input->post('status'),  
					'question_created_by'       => $this->session->userdata('active_user'), 
					'question_image'       => $this->input->post('recent_photo'),    					
				);
		$validate = array(
						array(
							'field' => 'title', 
							'label' => 'Question Title', 
							'rules' => 'required|trim', 
						),
						array(
							'field' => 'phase_level', 
							'label' => 'Phase level', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		
		
		/*******MCQ Answer Part******/
		if($this->input->post('question_type') == 'MCQ'){
		
			$answer_number = $this->input->post('answer_row');
			$ans_array = array();
			foreach($answer_number as $number)
			{
				$right_answer = $this->input->post('right_answer_'.$number);
				if(!is_null($right_answer))
				{
					$ans_array[] = $right_answer;
				}
			}
			
			if(empty($ans_array))
			{
				$error = '<div class="alert alert-danger">Please choose the right answer!</div>';
				$result = array('status' => 'error', 'error' => $error);
				$result[$this->sqtoken] = $this->sqtoken_hash;
				echo json_encode($result);
				exit;
			}
		
		/********************/
		
		}elseif($this->input->post('question_type') == 'BLANK'){
		
			/*******Fill in the gaps Answer Part******/
			$answer_number = $this->input->post('answer_row');
			$ans_array = array();
			$ans_array_gap = array();
			foreach($answer_number as $number)
			{
				$right_answer = $this->input->post('right_answer_'.$number);
				$right_answer_gap = $this->input->post('right_answer_gapid_'.$right_answer);
				if($right_answer && $right_answer_gap !== '')
				{
					$ans_array[] = $right_answer;
				}
			}
			
			if(empty($ans_array))
			{
				$error = '<div class="alert alert-danger">Please choose the right answer!</div>';
				$result = array('status' => 'error', 'error' => $error);
				$result[$this->sqtoken] = $this->sqtoken_hash;
				echo json_encode($result);
				exit;
			}
		
		/********************/
		}elseif($this->input->post('question_type') == 'JUSTIFY'){
			$justify_anser = $this->input->post('justify_answer');
			if(!$justify_anser)
			{
				$error = '<div class="alert alert-danger">Please choose the right answer!</div>';
				$result = array('status' => 'error', 'error' => $error);
				$result[$this->sqtoken] = $this->sqtoken_hash;
				echo json_encode($result);
				exit;
			}	
		}elseif($this->input->post('question_type') == 'MULTIPLE_JUSTIFY')
		{
			$answer_number = $this->input->post('answer_row');
			$ans_array = array();
			foreach($answer_number as $number)
			{
				$right_answer = $this->input->post('right_answer_'.$number);
				if(!is_null($right_answer))
				{
					$ans_array[] = $right_answer;
				}
			}
			
			if(empty($ans_array))
			{
				$error = '<div class="alert alert-danger">Please choose the right answer!</div>';
				$result = array('status' => 'error', 'error' => $error);
				$result[$this->sqtoken] = $this->sqtoken_hash;
				echo json_encode($result);
				exit;
			}
		}
		
		if($this->form_validation->run() == true)
		{
			//save
			$insert_id = $this->Questions_model->create($data);
			$question_id = $this->db->insert_id($insert_id);
			
			//save answers
			if($this->input->post('question_type') == 'MCQ'){
				
				$answer_number = $this->input->post('answer_row');
				$right_ans_array = array();
				foreach($answer_number as $number)
				{
					$answer_title = html_escape($this->input->post('answer_'.$number));
					$answer_data = array(
										'answer_question_id' => $question_id,
										'answer_title'       => $answer_title
									);
					$ans_insid = $this->Questions_model->save_answers($answer_data);
					$answer_id = $this->db->insert_id($ans_insid);
					$right_answer = $this->input->post('right_answer_'.$number);
					if(!is_null($right_answer))
					{
						$right_ans_array[] = $answer_id;
					}
				}
				
				if(!empty($right_ans_array))
				{
					//update question table with right answer
					$rightans = json_encode($right_ans_array);
					$this->db->where('question_id', $question_id);
					$this->db->update('starter_exam_questions', array('question_right_answerid' => $rightans));
				}
			
			}elseif($this->input->post('question_type') == 'BLANK'){
				$answer_number = $this->input->post('answer_row');
				$right_ans_array = array();
				foreach($answer_number as $number)
				{
					$answer_title = html_escape($this->input->post('answer_'.$number));
					
					$right_answer = $this->input->post('right_answer_'.$number);
					$right_answer_gap = $this->input->post('right_answer_gapid_'.$right_answer);
					
					$answer_data = array(
										'answer_question_id' => $question_id,
										'answer_title'       => $answer_title
									);
					if($right_answer_gap !== '')
					{
						$answer_data['answer_blank_id'] = $right_answer_gap;
					}
					$ans_insid = $this->Questions_model->save_answers($answer_data);
					$answer_id = $this->db->insert_id($ans_insid);
					
					if(!is_null($right_answer))
					{
						$right_ans_array[] = $answer_id;
					}
				}
				
				if(!empty($right_ans_array))
				{
					//update question table with right answer
					$rightans = json_encode($right_ans_array);
					$this->db->where('question_id', $question_id);
					$this->db->update('starter_exam_questions', array('question_right_answerid' => $rightans));
				}
			}elseif($this->input->post('question_type') == 'JUSTIFY'){
				$justify_anser = $this->input->post('justify_answer');
				$this->db->where('question_id', $question_id);
				$this->db->update('starter_exam_questions', array('question_justify_answer' => $justify_anser));
			}elseif($this->input->post('question_type') == 'MULTIPLE_JUSTIFY'){
				
				$answer_number = $this->input->post('answer_row');
				$right_ans_array = array();
				foreach($answer_number as $number)
				{
					$answer_title = html_escape($this->input->post('answer_'.$number));
					$answer_data = array(
										'answer_question_id' => $question_id,
										'answer_title'       => $answer_title
									);
					$ans_insid = $this->Questions_model->save_answers($answer_data);
					$answer_id = $this->db->insert_id($ans_insid);
					$right_answer = $this->input->post('right_answer_'.$number);
					if(!is_null($right_answer))
					{
						$right_ans_array[$answer_id] = $right_answer;
					}
				}
				
				if(!empty($right_ans_array))
				{
					//update question table with right answer
					$rightans = json_encode($right_ans_array);
					$this->db->where('question_id', $question_id);
					$this->db->update('starter_exam_questions', array('question_right_answerid' => $rightans));
				}
			}
			
			$success = '<div class="alert alert-success">successfully created!</div>';
			$result = array('status' => 'ok', 'success' => $success);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else
		{
			$error = '<div class="alert alert-danger">'.validation_errors().'</div>';
			$result = array('status' => 'error', 'error' => $error);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
	}
	
	public function create_question()
	{
		$data['display'] = TRUE;
		$data['phase_id'] = $this->input->post('phase_id');
		$content = $this->load->view('questions/create_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function create_question_ece()
	{
		$data['display'] = TRUE;
		$data['phase_id'] = $this->input->post('phase_id');
		$content = $this->load->view('questions/ece/create_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function edit()
	{
		$data['id'] = $this->input->post('id');
		$data['question_type'] = $this->input->post('q_type');
		$data['exam_type'] = $this->input->post('q_exam_type');
		$content = $this->load->view('questions/edit_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function edit_ece()
	{
		$data['id'] = $this->input->post('id');
		$data['question_type'] = $this->input->post('q_type');
		$data['exam_type'] = $this->input->post('q_exam_type');
		$content = $this->load->view('questions/ece/edit_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	public function edit_pca()
	{
		$data['id'] = $this->input->post('id');
		$data['question_type'] = $this->input->post('q_type');
		$data['exam_type'] = $this->input->post('q_exam_type');
		$content = $this->load->view('questions/pca/edit_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	public function update()
	{
		$this->load->library('form_validation');
		$question_id = $this->input->post('id');
		$data = array(  
					'question_module_id'        => $this->input->post('phs_module'),  
					'question_lesson_id'        => $this->input->post('module_lesson'),  
					'question_module_phase_id'  => $this->input->post('phase_level'),  
					'question_type'             => $this->input->post('question_type'),  
					'question_title'            => $this->input->post('title'),
					'question_status'           => $this->input->post('status'),    
				);
		$validate = array(
						array(
							'field' => 'title', 
							'label' => 'Question Title', 
							'rules' => 'required|trim', 
						),
						array(
							'field' => 'phase_level', 
							'label' => 'Phase level', 
							'rules' => 'required|trim', 
						),
						array(
							'field' => 'phs_module', 
							'label' => 'Module', 
							'rules' => 'required|trim', 
						),array(
							'field' => 'module_lesson', 
							'label' => 'Lesson', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		
		
		/*******MCQ Answer Part******/
		if($this->input->post('question_type') == 'MCQ'){
		
			$answer_number = $this->input->post('answer_row');
			$ans_array = array();
			foreach($answer_number as $number)
			{
				$right_answer = $this->input->post('right_answer_'.$number);
				if(!is_null($right_answer))
				{
					$ans_array[] = $right_answer;
				}
			}
			
			if(empty($ans_array))
			{
				$error = '<div class="alert alert-danger">Please choose the right answer!</div>';
				$result = array('status' => 'error', 'error' => $error);
				$result[$this->sqtoken] = $this->sqtoken_hash;
				echo json_encode($result);
				exit;
			}
		
		/********************/
		
		}elseif($this->input->post('question_type') == 'BLANK'){
		
			/*******Fill in the gaps Answer Part******/
			$answer_number = $this->input->post('answer_row');
			$ans_array = array();
			$ans_array_gap = array();
			foreach($answer_number as $number)
			{
				$right_answer = $this->input->post('right_answer_'.$number);
				$right_answer_gap = $this->input->post('right_answer_gapid_'.$right_answer);
				if($right_answer && $right_answer_gap !== '')
				{
					$ans_array[] = $right_answer;
				}
			}
			
			if(empty($ans_array))
			{
				$error = '<div class="alert alert-danger">Please choose the right answer!</div>';
				$result = array('status' => 'error', 'error' => $error);
				$result[$this->sqtoken] = $this->sqtoken_hash;
				echo json_encode($result);
				exit;
			}
		
		/********************/
		}elseif($this->input->post('question_type') == 'JUSTIFY'){
			$justify_anser = $this->input->post('justify_answer');
			if(!$justify_anser)
			{
				$error = '<div class="alert alert-danger">Please choose the right answer!</div>';
				$result = array('status' => 'error', 'error' => $error);
				$result[$this->sqtoken] = $this->sqtoken_hash;
				echo json_encode($result);
				exit;
			}	
		}elseif($this->input->post('question_type') == 'MULTIPLE_JUSTIFY'){
			
			$answer_number = $this->input->post('answer_row');
			$ans_array = array();
			foreach($answer_number as $number)
			{
				$right_answer = $this->input->post('right_answer_'.$number);
				if(!is_null($right_answer))
				{
					$ans_array[] = $right_answer;
				}
			}
			
			if(empty($ans_array))
			{
				$error = '<div class="alert alert-danger">Please choose the right answer!</div>';
				$result = array('status' => 'error', 'error' => $error);
				$result[$this->sqtoken] = $this->sqtoken_hash;
				echo json_encode($result);
				exit;
			}
		}
		
		if($this->form_validation->run() == true)
		{
			//save
			$this->Questions_model->update($question_id, $data);
			
			//delete questions old answer
			$this->db->where('answer_question_id', $question_id);
			$this->db->delete('starter_questions_answers');
			
			//save answers
			if($this->input->post('question_type') == 'MCQ'){
				
				$answer_number = $this->input->post('answer_row');
				$right_ans_array = array();
				foreach($answer_number as $number)
				{
					$answer_title = html_escape($this->input->post('answer_'.$number));
					$answer_data = array(
										'answer_question_id' => $question_id,
										'answer_title'       => $answer_title
									);
					$ans_insid = $this->Questions_model->save_answers($answer_data);
					$answer_id = $this->db->insert_id($ans_insid);
					$right_answer = $this->input->post('right_answer_'.$number);
					if(!is_null($right_answer))
					{
						$right_ans_array[] = $answer_id;
					}
				}
				
				if(!empty($right_ans_array))
				{
					//update question table with right answer
					$rightans = json_encode($right_ans_array);
					$this->db->where('question_id', $question_id);
					$this->db->update('starter_exam_questions', array('question_right_answerid' => $rightans));
				}
			
			}elseif($this->input->post('question_type') == 'BLANK'){
				$answer_number = $this->input->post('answer_row');
				$right_ans_array = array();
				foreach($answer_number as $number)
				{
					$answer_title = html_escape($this->input->post('answer_'.$number));
					
					$right_answer = $this->input->post('right_answer_'.$number);
					$right_answer_gap = $this->input->post('right_answer_gapid_'.$right_answer);
					
					$answer_data = array(
										'answer_question_id' => $question_id,
										'answer_title'       => $answer_title
									);
					if($right_answer_gap !== '')
					{
						$answer_data['answer_blank_id'] = $right_answer_gap;
					}
					$ans_insid = $this->Questions_model->save_answers($answer_data);
					$answer_id = $this->db->insert_id($ans_insid);
					
					if(!is_null($right_answer))
					{
						$right_ans_array[] = $answer_id;
					}
				}
				
				if(!empty($right_ans_array))
				{
					//update question table with right answer
					$rightans = json_encode($right_ans_array);
					$this->db->where('question_id', $question_id);
					$this->db->update('starter_exam_questions', array('question_right_answerid' => $rightans));
				}
			}elseif($this->input->post('question_type') == 'JUSTIFY'){
				$justify_anser = $this->input->post('justify_answer');
				$this->db->where('question_id', $question_id);
				$this->db->update('starter_exam_questions', array('question_justify_answer' => $justify_anser));
			}elseif($this->input->post('question_type') == 'MULTIPLE_JUSTIFY')
			{
				$answer_number = $this->input->post('answer_row');
				$right_ans_array = array();
				foreach($answer_number as $number)
				{
					$answer_title = html_escape($this->input->post('answer_'.$number));
					$answer_data = array(
										'answer_question_id' => $question_id,
										'answer_title'       => $answer_title
									);
					$ans_insid = $this->Questions_model->save_answers($answer_data);
					$answer_id = $this->db->insert_id($ans_insid);
					$right_answer = $this->input->post('right_answer_'.$number);
					if(!is_null($right_answer))
					{
						$right_ans_array[$answer_id] = $right_answer;
					}
				}
				
				if(!empty($right_ans_array))
				{
					//update question table with right answer
					$rightans = json_encode($right_ans_array);
					$this->db->where('question_id', $question_id);
					$this->db->update('starter_exam_questions', array('question_right_answerid' => $rightans));
				}
			}
			
			
			$success = '<div class="alert alert-success">The question has been successfully updated!</div>';
			$result = array('status' => 'ok', 'success' => $success);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else
		{
			$error = '<div class="alert alert-danger">'.validation_errors().'</div>';
			$result = array('status' => 'error', 'error' => $error);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
	}
	//update ece
	public function update_ece()
	{
		$this->load->library('form_validation');
		$question_id = $this->input->post('id');
		$data = array(  
					'question_module_id'        => $this->input->post('phs_module'),
					'question_lesson_id'        => $this->input->post('module_lesson'),
					'question_module_phase_id'  => $this->input->post('phase_level'),  
					'question_type'             => $this->input->post('question_type'),  
					'question_title'            => $this->input->post('title'),
					'question_status'           => $this->input->post('status'),
					'question_image'       		=> $this->input->post('recent_photo'),
				);
		$validate = array(
						array(
							'field' => 'title', 
							'label' => 'Question Title', 
							'rules' => 'required|trim', 
						),
						array(
							'field' => 'phase_level', 
							'label' => 'Phase level', 
							'rules' => 'required|trim', 
						),
						array(
							'field' => 'phs_module', 
							'label' => 'Module', 
							'rules' => 'required|trim', 
						)
					);
		$this->form_validation->set_rules($validate);
		
		
		/*******MCQ Answer Part******/
		if($this->input->post('question_type') == 'MCQ'){
		
			$answer_number = $this->input->post('answer_row');
			$ans_array = array();
			foreach($answer_number as $number)
			{
				$right_answer = $this->input->post('right_answer_'.$number);
				if(!is_null($right_answer))
				{
					$ans_array[] = $right_answer;
				}
			}
			
			if(empty($ans_array))
			{
				$error = '<div class="alert alert-danger">Please choose the right answer!</div>';
				$result = array('status' => 'error', 'error' => $error);
				$result[$this->sqtoken] = $this->sqtoken_hash;
				echo json_encode($result);
				exit;
			}
		
		/********************/
		
		}elseif($this->input->post('question_type') == 'BLANK'){
		
			/*******Fill in the gaps Answer Part******/
			$answer_number = $this->input->post('answer_row');
			$ans_array = array();
			$ans_array_gap = array();
			foreach($answer_number as $number)
			{
				$right_answer = $this->input->post('right_answer_'.$number);
				$right_answer_gap = $this->input->post('right_answer_gapid_'.$right_answer);
				if($right_answer && $right_answer_gap !== '')
				{
					$ans_array[] = $right_answer;
				}
			}
			
			if(empty($ans_array))
			{
				$error = '<div class="alert alert-danger">Please choose the right answer!</div>';
				$result = array('status' => 'error', 'error' => $error);
				$result[$this->sqtoken] = $this->sqtoken_hash;
				echo json_encode($result);
				exit;
			}
		
		/********************/
		}elseif($this->input->post('question_type') == 'JUSTIFY'){
			$justify_anser = $this->input->post('justify_answer');
			if(!$justify_anser)
			{
				$error = '<div class="alert alert-danger">Please choose the right answer!</div>';
				$result = array('status' => 'error', 'error' => $error);
				$result[$this->sqtoken] = $this->sqtoken_hash;
				echo json_encode($result);
				exit;
			}	
		}elseif($this->input->post('question_type') == 'MULTIPLE_JUSTIFY'){
			$answer_number = $this->input->post('answer_row');
			$ans_array = array();
			foreach($answer_number as $number)
			{
				$right_answer = $this->input->post('right_answer_'.$number);
				if(!is_null($right_answer))
				{
					$ans_array[] = $right_answer;
				}
			}
			
			if(empty($ans_array))
			{
				$error = '<div class="alert alert-danger">Please choose the right answer!</div>';
				$result = array('status' => 'error', 'error' => $error);
				$result[$this->sqtoken] = $this->sqtoken_hash;
				echo json_encode($result);
				exit;
			}
		}
		
		if($this->form_validation->run() == true)
		{
			//save
			$this->Questions_model->update($question_id, $data);
			
			//delete questions old answer
			$this->db->where('answer_question_id', $question_id);
			$this->db->delete('starter_questions_answers');
			
			//save answers
			if($this->input->post('question_type') == 'MCQ'){
				
				$answer_number = $this->input->post('answer_row');
				$right_ans_array = array();
				foreach($answer_number as $number)
				{
					$answer_title = html_escape($this->input->post('answer_'.$number));
					$answer_data = array(
										'answer_question_id' => $question_id,
										'answer_title'       => $answer_title
									);
					$ans_insid = $this->Questions_model->save_answers($answer_data);
					$answer_id = $this->db->insert_id($ans_insid);
					$right_answer = $this->input->post('right_answer_'.$number);
					if(!is_null($right_answer))
					{
						$right_ans_array[] = $answer_id;
					}
				}
				
				if(!empty($right_ans_array))
				{
					//update question table with right answer
					$rightans = json_encode($right_ans_array);
					$this->db->where('question_id', $question_id);
					$this->db->update('starter_exam_questions', array('question_right_answerid' => $rightans));
				}
			
			}elseif($this->input->post('question_type') == 'BLANK'){
				$answer_number = $this->input->post('answer_row');
				$right_ans_array = array();
				foreach($answer_number as $number)
				{
					$answer_title = html_escape($this->input->post('answer_'.$number));
					
					$right_answer = $this->input->post('right_answer_'.$number);
					$right_answer_gap = $this->input->post('right_answer_gapid_'.$right_answer);
					
					$answer_data = array(
										'answer_question_id' => $question_id,
										'answer_title'       => $answer_title
									);
					if($right_answer_gap !== '')
					{
						$answer_data['answer_blank_id'] = $right_answer_gap;
					}
					$ans_insid = $this->Questions_model->save_answers($answer_data);
					$answer_id = $this->db->insert_id($ans_insid);
					
					if(!is_null($right_answer))
					{
						$right_ans_array[] = $answer_id;
					}
				}
				
				if(!empty($right_ans_array))
				{
					//update question table with right answer
					$rightans = json_encode($right_ans_array);
					$this->db->where('question_id', $question_id);
					$this->db->update('starter_exam_questions', array('question_right_answerid' => $rightans));
				}
			}elseif($this->input->post('question_type') == 'JUSTIFY'){
				$justify_anser = $this->input->post('justify_answer');
				$this->db->where('question_id', $question_id);
				$this->db->update('starter_exam_questions', array('question_justify_answer' => $justify_anser));
			}elseif($this->input->post('question_type') == 'MULTIPLE_JUSTIFY'){
				$answer_number = $this->input->post('answer_row');
				$right_ans_array = array();
				foreach($answer_number as $number)
				{
					$answer_title = html_escape($this->input->post('answer_'.$number));
					$answer_data = array(
										'answer_question_id' => $question_id,
										'answer_title'       => $answer_title
									);
					$ans_insid = $this->Questions_model->save_answers($answer_data);
					$answer_id = $this->db->insert_id($ans_insid);
					$right_answer = $this->input->post('right_answer_'.$number);
					if(!is_null($right_answer))
					{
						$right_ans_array[$answer_id] = $right_answer;
					}
				}
				
				if(!empty($right_ans_array))
				{
					//update question table with right answer
					$rightans = json_encode($right_ans_array);
					$this->db->where('question_id', $question_id);
					$this->db->update('starter_exam_questions', array('question_right_answerid' => $rightans));
				}
			}
			
			
			$success = '<div class="alert alert-success">The question has been successfully updated!</div>';
			$result = array('status' => 'ok', 'success' => $success);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else
		{
			$error = '<div class="alert alert-danger">'.validation_errors().'</div>';
			$result = array('status' => 'error', 'error' => $error);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
	}
	//end update ece
	public function update_pca()
	{
		$this->load->library('form_validation');
		$question_id = $this->input->post('id');
		$data = array(  
					'question_module_id'        => $this->input->post('phs_module'),
					'question_lesson_id'        => $this->input->post('module_lesson'),
					'question_module_phase_id'  => $this->input->post('phase_level'),  
					'question_type'             => $this->input->post('question_type'),  
					'question_title'            => $this->input->post('title'),
					'question_status'           => $this->input->post('status'),
					'question_image'       		=> $this->input->post('recent_photo'),
				);
		$validate = array(
						array(
							'field' => 'title', 
							'label' => 'Question Title', 
							'rules' => 'required|trim', 
						),
						array(
							'field' => 'phase_level', 
							'label' => 'Phase level', 
							'rules' => 'required|trim', 
						),
						array(
							'field' => 'phs_module', 
							'label' => 'Module', 
							'rules' => 'required|trim', 
						)
					);
		$this->form_validation->set_rules($validate);
		
		
		/*******MCQ Answer Part******/
		if($this->input->post('question_type') == 'MCQ'){
		
			$answer_number = $this->input->post('answer_row');
			$ans_array = array();
			foreach($answer_number as $number)
			{
				$right_answer = $this->input->post('right_answer_'.$number);
				if(!is_null($right_answer))
				{
					$ans_array[] = $right_answer;
				}
			}
			
			if(empty($ans_array))
			{
				$error = '<div class="alert alert-danger">Please choose the right answer!</div>';
				$result = array('status' => 'error', 'error' => $error);
				$result[$this->sqtoken] = $this->sqtoken_hash;
				echo json_encode($result);
				exit;
			}
		
		/********************/
		
		}elseif($this->input->post('question_type') == 'BLANK'){
		
			/*******Fill in the gaps Answer Part******/
			$answer_number = $this->input->post('answer_row');
			$ans_array = array();
			$ans_array_gap = array();
			foreach($answer_number as $number)
			{
				$right_answer = $this->input->post('right_answer_'.$number);
				$right_answer_gap = $this->input->post('right_answer_gapid_'.$right_answer);
				if($right_answer && $right_answer_gap !== '')
				{
					$ans_array[] = $right_answer;
				}
			}
			
			if(empty($ans_array))
			{
				$error = '<div class="alert alert-danger">Please choose the right answer!</div>';
				$result = array('status' => 'error', 'error' => $error);
				$result[$this->sqtoken] = $this->sqtoken_hash;
				echo json_encode($result);
				exit;
			}
		
		/********************/
		}elseif($this->input->post('question_type') == 'JUSTIFY'){
			$justify_anser = $this->input->post('justify_answer');
			if(!$justify_anser)
			{
				$error = '<div class="alert alert-danger">Please choose the right answer!</div>';
				$result = array('status' => 'error', 'error' => $error);
				$result[$this->sqtoken] = $this->sqtoken_hash;
				echo json_encode($result);
				exit;
			}	
		}elseif($this->input->post('question_type') == 'MULTIPLE_JUSTIFY'){
			$answer_number = $this->input->post('answer_row');
			$ans_array = array();
			foreach($answer_number as $number)
			{
				$right_answer = $this->input->post('right_answer_'.$number);
				if(!is_null($right_answer))
				{
					$ans_array[] = $right_answer;
				}
			}
			
			if(empty($ans_array))
			{
				$error = '<div class="alert alert-danger">Please choose the right answer!</div>';
				$result = array('status' => 'error', 'error' => $error);
				$result[$this->sqtoken] = $this->sqtoken_hash;
				echo json_encode($result);
				exit;
			}
		}
		
		if($this->form_validation->run() == true)
		{
			//save
			$this->Questions_model->update($question_id, $data);
			
			//delete questions old answer
			$this->db->where('answer_question_id', $question_id);
			$this->db->delete('starter_questions_answers');
			
			//save answers
			if($this->input->post('question_type') == 'MCQ'){
				
				$answer_number = $this->input->post('answer_row');
				$right_ans_array = array();
				foreach($answer_number as $number)
				{
					$answer_title = html_escape($this->input->post('answer_'.$number));
					$answer_data = array(
										'answer_question_id' => $question_id,
										'answer_title'       => $answer_title
									);
					$ans_insid = $this->Questions_model->save_answers($answer_data);
					$answer_id = $this->db->insert_id($ans_insid);
					$right_answer = $this->input->post('right_answer_'.$number);
					if(!is_null($right_answer))
					{
						$right_ans_array[] = $answer_id;
					}
				}
				
				if(!empty($right_ans_array))
				{
					//update question table with right answer
					$rightans = json_encode($right_ans_array);
					$this->db->where('question_id', $question_id);
					$this->db->update('starter_exam_questions', array('question_right_answerid' => $rightans));
				}
			
			}elseif($this->input->post('question_type') == 'BLANK'){
				$answer_number = $this->input->post('answer_row');
				$right_ans_array = array();
				foreach($answer_number as $number)
				{
					$answer_title = html_escape($this->input->post('answer_'.$number));
					
					$right_answer = $this->input->post('right_answer_'.$number);
					$right_answer_gap = $this->input->post('right_answer_gapid_'.$right_answer);
					
					$answer_data = array(
										'answer_question_id' => $question_id,
										'answer_title'       => $answer_title
									);
					if($right_answer_gap !== '')
					{
						$answer_data['answer_blank_id'] = $right_answer_gap;
					}
					$ans_insid = $this->Questions_model->save_answers($answer_data);
					$answer_id = $this->db->insert_id($ans_insid);
					
					if(!is_null($right_answer))
					{
						$right_ans_array[] = $answer_id;
					}
				}
				
				if(!empty($right_ans_array))
				{
					//update question table with right answer
					$rightans = json_encode($right_ans_array);
					$this->db->where('question_id', $question_id);
					$this->db->update('starter_exam_questions', array('question_right_answerid' => $rightans));
				}
			}elseif($this->input->post('question_type') == 'JUSTIFY'){
				$justify_anser = $this->input->post('justify_answer');
				$this->db->where('question_id', $question_id);
				$this->db->update('starter_exam_questions', array('question_justify_answer' => $justify_anser));
			}elseif($this->input->post('question_type') == 'MULTIPLE_JUSTIFY'){
				$answer_number = $this->input->post('answer_row');
				$right_ans_array = array();
				foreach($answer_number as $number)
				{
					$answer_title = html_escape($this->input->post('answer_'.$number));
					$answer_data = array(
										'answer_question_id' => $question_id,
										'answer_title'       => $answer_title
									);
					$ans_insid = $this->Questions_model->save_answers($answer_data);
					$answer_id = $this->db->insert_id($ans_insid);
					$right_answer = $this->input->post('right_answer_'.$number);
					if(!is_null($right_answer))
					{
						$right_ans_array[$answer_id] = $right_answer;
					}
				}
				
				if(!empty($right_ans_array))
				{
					//update question table with right answer
					$rightans = json_encode($right_ans_array);
					$this->db->where('question_id', $question_id);
					$this->db->update('starter_exam_questions', array('question_right_answerid' => $rightans));
				}
			}
			
			
			$success = '<div class="alert alert-success">The question has been successfully updated!</div>';
			$result = array('status' => 'ok', 'success' => $success);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else
		{
			$error = '<div class="alert alert-danger">'.validation_errors().'</div>';
			$result = array('status' => 'error', 'error' => $error);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
	}
	
	public function delete()
	{
		$id = $this->input->post('id');
		
		//Delete from answer table
		$this->db->where('answer_question_id', $id);
		$this->db->delete('starter_questions_answers');
		
		//Delete from module table
		$this->db->where('question_id', $id);
		$this->db->delete('starter_exam_questions');
		
		$data['id'] = $id;
		$content = $this->load->view('questions/create_form', $data, true);
		
		$result = array("status" => "ok", "content" => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function delete_ece()
	{
		$id = $this->input->post('id');
		
		//Delete from answer table
		$this->db->where('answer_question_id', $id);
		$this->db->delete('starter_questions_answers');
		
		//Delete from module table
		$this->db->where('question_id', $id);
		$this->db->delete('starter_exam_questions');
		
		$data['id'] = $id;
		$content = $this->load->view('questions/create_form', $data, true);
		
		$result = array("status" => "ok", "content" => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	public function delete_pca()
	{
		$id = $this->input->post('id');
		
		//Delete from answer table
		$this->db->where('answer_question_id', $id);
		$this->db->delete('starter_questions_answers');
		
		//Delete from module table
		$this->db->where('question_id', $id);
		$this->db->delete('starter_exam_questions');
		
		$data['id'] = $id;
		$content = $this->load->view('questions/create_form', $data, true);
		
		$result = array("status" => "ok", "content" => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function get_modules()
	{
		$phase_id = $this->input->post('phase_level');
		$get_modules = $this->Questions_model->get_phase_modules($phase_id);
		$content = '';
		$x = 1;
		$content .= '<div class="form-group">';
			$content .= '<label class="col-md-8 control-label">Module</label>';
			$content .= '<div class="col-md-4" id="dependentModule">';
		foreach($get_modules as $module):
			$content .= '<label><input type="checkbox" name="module_'.$x.'" value="'.$module['module_id'].'" />&nbsp; '.$module['module_name'].'</label>&nbsp;&nbsp;
						<input type="hidden" name="mdl_row[]" value="'.$x.'" />';
		$x++;
		endforeach;
			$content .= '</div>';
		$content .= '</div>';
		
		$result = array("status" => "ok", "content" => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function get_list_modules()
	{
		$phase_id = $this->input->post('phase_level');
		$get_modules = $this->Questions_model->get_phase_modules($phase_id);
		$content = '';
		$content .= '<div class="form-group">';
			$content .= '<label class="col-md-8 control-label">Module</label>';
			$content .= '<div class="col-md-4">
							<select name="phs_module" id="selectedModule" class="form-control">
							<option value="" selected="selected">Select Module</option>
						';
		foreach($get_modules as $module):
			$content .= '<option value="'.$module['module_id'].'">'.$module['module_name'].'</option>';
		endforeach;
			$content .= '</select></div>';
		$content .= '</div>';
		
		$result = array("status" => "ok", "content" => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function get_lessons()
	{
		$module_id = $this->input->post('module');
		$get_lessons = $this->Questions_model->get_module_lessons($module_id);
		$content = '';
		$content .= '<div class="form-group">';
			$content .= '<label class="col-md-8 control-label">Lesson</label>';
			$content .= '<div class="col-md-4">
							<select name="module_lesson" class="form-control">
						';
		foreach($get_lessons as $lesson):
			$content .= '<option value="'.$lesson['lesson_id'].'">'.$lesson['lesson_title'].'</option>';
		endforeach;
			$content .= '</select></div>';
		$content .= '</div>';
		
		$result = array("status" => "ok", "content" => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function get_answer_type()
	{
		$question_type = $this->input->post('qtype');
		$data['shw'] = TRUE;
		if($question_type === 'MCQ'){
			$content = $this->load->view('questions/mcq', $data, true);
		}elseif($question_type === 'BLANK'){
			$content = $this->load->view('questions/blanks', $data, true);
		}elseif($question_type === 'JUSTIFY'){
			$content = $this->load->view('questions/justify', $data, true);
		}elseif($question_type === 'MULTIPLE_JUSTIFY'){
			$content = $this->load->view('questions/multiple_justify', $data, true);
		}else{
			$content = '';
		}
		
		$result = array("status" => "ok", "content" => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function view()
	{
		$question_id = $this->input->post('question_id');
		$question_type = $this->input->post('q_type');
		$question_exam_type = $this->input->post('q_exam_type');
		$row_info = $this->Questions_model->get_info($question_id, $question_exam_type);
		$gaps = array(
				'0' => 'a',
				'1' => 'b',
				'2' => 'c',
				'3' => 'd',
				'4' => 'e',
				'5' => 'f',
				'6' => 'g',
				'7' => 'h',
				'8' => 'i',
				'9' => 'j',
			);
		if($question_type == 'MCQ'){
			
			$content = '<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h4 class="modal-title">'.$row_info['question_title'].' ('.$row_info['phase_name'].', '.$row_info['module_name'].')</h4>
						</div>
						<div class="modal-body">
							<table class="table table-bordered table-striped">
						';
			
			$str = str_replace('[', '', $row_info['question_right_answerid']);
			$str = str_replace(']', '', $str);
			$str_array = explode(',', $str);
			
			$get_answers = $this->Questions_model->get_answersby_question($row_info['question_id']);
			$ans_count = 1;
			foreach($get_answers as $answer):
			
			if(in_array($answer['answer_id'], $str_array))
			{
				$right_ans = '<span style="color:#0B0">True</span>';
			}else
			{
				$right_ans = '<span style="color:#F00">False</span>';
			}
			
			$content .= '<tr>
							<th><strong>'.$ans_count.'</strong></th>
							<td style="padding:10px 15px;"><span>'.$answer['answer_title'].'</span></td>
							<th class="text-center">'.$right_ans.'</th>
						</tr>';
			$ans_count++;
			endforeach;
						
			$content .=		'</table>
						</div>
						';
			
		}elseif($question_type == 'BLANK'){
			
			$content = '<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h4 class="modal-title">'.$row_info['question_title'].' ('.$row_info['phase_name'].', '.$row_info['module_name'].')</h4>
						</div>
						<div class="modal-body">
							<table class="table table-bordered table-striped">
						';
			
			$str = str_replace('[', '', $row_info['question_right_answerid']);
			$str = str_replace(']', '', $str);
			$str_array = explode(',', $str);
			
			$get_answers = $this->Questions_model->get_answersby_question($row_info['question_id']);
			$ans_count = 1;
			foreach($get_answers as $answer):
			
			if(in_array($answer['answer_id'], $str_array))
			{
				$right_ans = '<span style="color:#0B0">True</span>';
			}else
			{
				$right_ans = '<span style="color:#F00">False</span>';
			}
			
			if($answer['answer_blank_id'] !== null)
			{
				$blankid = $gaps[$answer['answer_blank_id']];
			}else
			{
				$blankid = '';
			}
			
			$content .= '<tr>
							<td style="padding:10px 15px;"><span>'.$answer['answer_title'].'</span></td>
							<th class="text-center">'.$blankid.'</th>
						</tr>';
			$ans_count++;
			endforeach;
						
			$content .=		'</table>
						</div>
						';
			
		}elseif($question_type == 'JUSTIFY'){
			
			if($row_info['question_justify_answer'] == 'TRUE')
			{
				$right_answer = '<strong style="color:#0A0">TRUE</strong>';
			}else{
				$right_answer = '<strong style="color:#F00">FALSE</strong>';
			}
			
			$content = '<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h4 class="modal-title"> Question from ('.$row_info['phase_name'].', '.$row_info['module_name'].')</h4>
						</div>
						<div class="modal-body">
							<p><strong>Question : </strong>'.$row_info['question_title'].'</p>
							<strong>Answer : '.$right_answer.'</strong>
						';
						
			$content .=	'</div>';
			
		}elseif($question_type == 'MULTIPLE_JUSTIFY'){
			
			$content = '<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h4 class="modal-title">'.$row_info['question_title'].' ('.$row_info['phase_name'].', '.$row_info['module_name'].')</h4>
						</div>
						<div class="modal-body">
							<table class="table table-bordered table-striped">
						';
			
			$str = str_replace('[', '', $row_info['question_right_answerid']);
			$str = str_replace(']', '', $str);
			
			$right_answer = json_decode($row_info['question_right_answerid'], true);
			
			$get_answers = $this->Questions_model->get_answersby_question($row_info['question_id']);
			$ans_count = 1;
			foreach($get_answers as $answer):
			
			if(array_key_exists($answer['answer_id'], $right_answer) && $right_answer[$answer['answer_id']] == '1')
			{
				$right_ans = '<span style="color:#0B0">True</span>';
			}else
			{
				$right_ans = '<span style="color:#F00">False</span>';
			}
			
			$content .= '<tr>
							<th><strong>'.$ans_count.'</strong></th>
							<td style="padding:10px 15px;"><span>'.$answer['answer_title'].'</span></td>
							<th class="text-center">'.$right_ans.'</th>
						</tr>';
			$ans_count++;
			endforeach;
						
			$content .=		'</table>
						</div>
						';
		}
		
		$result = array("status" => "ok", "content" => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
}