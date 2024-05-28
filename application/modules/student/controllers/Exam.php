<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exam extends CI_Controller{
	
	private $sqtoken;
	private $sqtoken_hash;
	
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Dhaka');
		$this->sqtoken = $this->security->get_csrf_token_name();
		$this->sqtoken_hash = $this->security->get_csrf_hash();
		
		$active_student = $this->session->userdata('active_student');
		$studentLogin = $this->session->userdata('studentLogin');
		if($active_student === NULL && $studentLogin !== TRUE)
		{
			redirect('student/login', 'refresh', true);
		}
		
		$this->load->model('Exam_model');
	}
	
	public function exstart($param1, $param2, $param3)
	{
		$exam_activated = $this->session->userdata('exam_activated');
		if($exam_activated == TRUE)
		{
			if(isset($param1) && isset($param2) && isset($param3) )
			{
				if($param2 === 'Phase-A'){
					$this->load->view('start_pca_one');
				}elseif($param2 === 'Phase-B'){
					$this->load->view('start_pca_two');
				}elseif($param2 === 'Phase-C'){
					$this->load->view('start_pca_three');
				}
				elseif($param2 === 'Phase-D'){
					$this->load->view('start_ece_exam');
				}
			}else
			{
				redirect('not-found');
			}
		}else
		{
			redirect('student/dashboard');
		}
	}
	
	public function index_finished($param1, $param2, $param3)
	{
		$this->load->view('exam_time_over');
	}
	
	public function index($param1, $param2, $param3)
	{
		$exam_activated = $this->session->userdata('exam_activated');
		if($exam_activated == TRUE)
		{
			if(isset($param1) && isset($param2) && isset($param3)) 
			{
				if($param2 === 'Phase-A')
				{
					$this->session->unset_userdata('ex_hour');
					$this->session->unset_userdata('ex_minute');
					$this->session->unset_userdata('ex_second');
					
					$sess['set_phaselevel_1'] = 1;
					$this->session->set_userdata($sess);
					
					//save pca exam
					$pcaexmdata = array(
									'examcnt_student_id' => $this->session->userdata('active_student'),
									'examcnt_phase_level' => 1,
									'examcnt_date' => date("Y-m-d H:i:s"),
								);
					$check_retake = $this->Exam_model->check_retake_exam($phase=1);
					if($check_retake == true)
					{
						$pcaexmdata['examcnt_exam_type'] = 'RETAKE';
					}
					$insexm = $this->Exam_model->save_pcaexam($pcaexmdata);
					$exm_id = $this->db->insert_id($insexm);
					$this->db->where('student_id', $this->session->userdata('active_student'));
					$this->db->update('starter_students', array('student_pcaexam_id' => $exm_id));
					
					$content_data['phase_level'] = $this->session->userdata('set_phaselevel_1');
					
					$get_marksconfig = $this->Exam_model->get_marksconfig();
					$content_data['question_type'] = json_decode($get_marksconfig['mrkconfig_question_type'], true);
					$content_data['limit'] = $get_marksconfig['mrkconfig_exam_totalquestion'];
					$content_data['exam_time'] = $get_marksconfig['mrkconfig_exam_time'];
					
					$phase_level = 1;
					
					$total_questions = $get_marksconfig['mrkconfig_exam_totalquestion'];
					$exm_id = $this->Exam_model->get_exmid();
					$total_right_answers = $this->Exam_model->get_right_answers($phase_level, $exm_id);
					$total_wrong_answers = $this->Exam_model->get_wrong_answers($phase_level, $exm_id);
					$total_score = $total_right_answers * $get_marksconfig['mrkconfig_question_mark'];
					$total_passing_score = $get_marksconfig['mrkconfig_exmpass_mark'];
					if($total_score < $total_passing_score)
					{
						$result_shw = '<span class="result-shw-failed">Failed</span>';
					}else
					{
						$result_shw = '<span class="result-shw-pass">Passed</span>';
					}
					
					$content_data['total_questions']     = $content_data['limit'];
					$content_data['total_right_answers'] = $total_right_answers;
					$content_data['total_wrong_answers'] = $total_wrong_answers;
					$content_data['total_score']         = $total_score;
					$content_data['total_passing_score'] = $total_passing_score;
					$content_data['result_shw']          = $result_shw;
					$content_data['exm_id']              = $exm_id;
					
					$this->load->view('exam', $content_data);
					
				}elseif($param2 === 'Phase-B'){
					
					$this->session->unset_userdata('ex_hour');
					$this->session->unset_userdata('ex_minute');
					$this->session->unset_userdata('ex_second');
					
					$sess['set_phaselevel_2'] = 2;
					$this->session->set_userdata($sess);
					
					//save pca exam
					$pcaexmdata = array(
									'examcnt_student_id' => $this->session->userdata('active_student'),
									'examcnt_phase_level' => 2,
									'examcnt_date' => date("Y-m-d H:i:s"),
								);
					$check_retake = $this->Exam_model->check_retake_exam($phase=2);
					if($check_retake == true)
					{
						$pcaexmdata['examcnt_exam_type'] = 'RETAKE';
					}
					$insexm = $this->Exam_model->save_pcaexam($pcaexmdata);
					$exm_id = $this->db->insert_id($insexm);
					$this->db->where('student_id', $this->session->userdata('active_student'));
					$this->db->update('starter_students', array('student_pcaexam_id' => $exm_id));
					
					$content_data['phase_level'] = $this->session->userdata('set_phaselevel_2');
					
					$get_marksconfig = $this->Exam_model->get_marksconfig();
					$content_data['question_type'] = json_decode($get_marksconfig['mrkconfig_pcatwo_question_type'], true);
					$content_data['limit'] = $get_marksconfig['mrkconfig_pcatwo_exam_totalquestion'];
					$content_data['exam_time'] = $get_marksconfig['mrkconfig_pcatwo_exam_time'];
					
					$phase_level = 2;
					
					$total_questions = $content_data['limit'];
					$exm_id = $this->Exam_model->get_exmid();
					$total_right_answers = $this->Exam_model->get_right_answers($phase_level, $exm_id);
					$total_wrong_answers = $this->Exam_model->get_wrong_answers($phase_level, $exm_id);
					$total_score = $total_right_answers * $get_marksconfig['mrkconfig_pcatwo_question_mark'];
					$total_passing_score = $get_marksconfig['mrkconfig_pcatwo_exmpass_mark'];
					if($total_score < $total_passing_score)
					{
						$result_shw = '<span class="result-shw-failed">Failed</span>';
					}else
					{
						$result_shw = '<span class="result-shw-pass">Passed</span>';
					}
					
					$content_data['total_questions']     = $total_questions;
					$content_data['total_right_answers'] = $total_right_answers;
					$content_data['total_wrong_answers'] = $total_wrong_answers;
					$content_data['total_score']         = $total_score;
					$content_data['total_passing_score'] = $total_passing_score;
					$content_data['result_shw']          = $result_shw;
					$content_data['exm_id']              = $exm_id;
					
					$this->load->view('exam', $content_data);
					
				}elseif($param2 === 'Phase-C'){
					
					$this->session->unset_userdata('ex_hour');
					$this->session->unset_userdata('ex_minute');
					$this->session->unset_userdata('ex_second');
					
					$sess['set_phaselevel_3'] = 3;
					$this->session->set_userdata($sess);
					
					//save pca exam
					$pcaexmdata = array(
									'examcnt_student_id' => $this->session->userdata('active_student'),
									'examcnt_phase_level' => 3,
									'examcnt_date' => date("Y-m-d H:i:s"),
								);
					$check_retake = $this->Exam_model->check_retake_exam($phase=30);
					if($check_retake == true)
					{
						$pcaexmdata['examcnt_exam_type'] = 'RETAKE';
					}
					$insexm = $this->Exam_model->save_pcaexam($pcaexmdata);
					$exm_id = $this->db->insert_id($insexm);
					$this->db->where('student_id', $this->session->userdata('active_student'));
					$this->db->update('starter_students', array('student_pcaexam_id' => $exm_id));
					
					$content_data['phase_level'] = $this->session->userdata('set_phaselevel_3');
					
					$get_marksconfig = $this->Exam_model->get_marksconfig();
					$content_data['question_type'] = json_decode($get_marksconfig['mrkconfig_pcathree_question_type'], true);
					$content_data['limit'] = $get_marksconfig['mrkconfig_pcathree_exam_totalquestion'];
					$content_data['exam_time'] = $get_marksconfig['mrkconfig_pcathree_exam_time'];
					
					$phase_level = 3;
					
					$total_questions = $content_data['limit'];
					$exm_id = $this->Exam_model->get_exmid();
					$total_right_answers = $this->Exam_model->get_right_answers($phase_level, $exm_id);
					$total_wrong_answers = $this->Exam_model->get_wrong_answers($phase_level, $exm_id);
					$total_score = $total_right_answers * $get_marksconfig['mrkconfig_pcathree_question_mark'];
					$total_passing_score = $get_marksconfig['mrkconfig_pcathree_exmpass_mark'];
					if($total_score < $total_passing_score)
					{
						$result_shw = '<span class="result-shw-failed">Failed</span>';
					}else
					{
						$result_shw = '<span class="result-shw-pass">Passed</span>';
					}
					
					$content_data['total_questions']     = $total_questions;
					$content_data['total_right_answers'] = $total_right_answers;
					$content_data['total_wrong_answers'] = $total_wrong_answers;
					$content_data['total_score']         = $total_score;
					$content_data['total_passing_score'] = $total_passing_score;
					$content_data['result_shw']          = $result_shw;
					$content_data['exm_id']              = $exm_id;
					
					$this->load->view('exam', $content_data);
					
				}elseif($param2 === 'Phase-D'){
					$this->session->unset_userdata('ex_hour');
					$this->session->unset_userdata('ex_minute');
					$this->session->unset_userdata('ex_second');
					
					$sess['set_phaselevel_4'] = 4;
					$this->session->set_userdata($sess);
					
					//save pca exam
					$ece_exmdata = array(
									'eceexmcount_student_id' =>$this->session->userdata('active_student'),
									'eceexamcnt_phase_level' => 4,
									'eceexmcount_date' => date("Y-m-d H:i:s"),
								);
								
					$check_retake = $this->Exam_model->check_retake_exam_ece($phase=4);
					if($check_retake == true)
					{
						$ece_exmdata['eceexmcount_exm_type'] = 'RETAKE';
					}
					$inserteceexm = $this->Exam_model->save_ece_exam($ece_exmdata);
					$exm_id = $this->db->insert_id($inserteceexm);
					$this->db->where('student_id', $this->session->userdata('active_student'));
					$this->db->update('starter_students', array('student_ece_exam_id' => $exm_id));
					
					$content_data['phase_level'] = $this->session->userdata('set_phaselevel_4');
					
					$get_marksconfig = $this->Exam_model->get_marksconfig();
					$content_data['question_type'] = json_decode($get_marksconfig['mrkconfig_ece_question_type'], true);
					$content_data['limit'] = $get_marksconfig['mrkconfig_ece_exam_totalquestion'];
					$content_data['exam_time'] = $get_marksconfig['mrkconfig_ece_exam_time'];
					
					$phase_level = 4;
					
					$total_questions = $content_data['limit'];
					$exm_id = $this->Exam_model->get_exmid();
					$total_right_answers = $this->Exam_model->get_right_answers($phase_level, $exm_id);
					$total_wrong_answers = $this->Exam_model->get_wrong_answers($phase_level, $exm_id);
					$total_score = $total_right_answers * $get_marksconfig['mrkconfig_ece_question_mark'];
					$total_passing_score = $get_marksconfig['mrkconfig_ece_exmpass_mark'];
					if($total_score < $total_passing_score)
					{
						$result_shw = '<span class="result-shw-failed">Failed</span>';
					}else
					{
						$result_shw = '<span class="result-shw-pass">Passed</span>';
					}
					
					$content_data['total_questions']     = $total_questions;
					$content_data['total_right_answers'] = $total_right_answers;
					$content_data['total_wrong_answers'] = $total_wrong_answers;
					$content_data['total_score']         = $total_score;
					$content_data['total_passing_score'] = $total_passing_score;
					$content_data['result_shw']          = $result_shw;
					$content_data['exm_id']              = $exm_id;
					
					$this->load->view('exam_phase_4', $content_data);
				
				}
				
				else
				{
					redirect('not-found');
				}
			}else
			{
				redirect('not-found');
			}
		}else
		{
			redirect('student/dashboard');
		}
	}
	
	public function answersubmit()
	{
		//check answer
		/******Start-Point of question submission********/
		$question_rows = $this->input->post('question_row');
		$phase_level = $this->input->post('active_phase');
		$exm_id = $this->Exam_model->get_exmid();
		foreach($question_rows as $row):
		$question_id = $this->input->post('question_row_value_'.$row);
		$question_type = $this->input->post('q_type_row_'.$row);
		if($question_type == 'MCQ'){
			$right_ans_ids = $this->Exam_model->get_right_answersids($question_id, $exm_id);
			$right_answer_string = str_replace('[', '', $right_ans_ids['question_right_answerid']);
			$right_answer_string = str_replace(']', '', $right_answer_string);
			$right_answer_string = explode(',', $right_answer_string);
			$answer_array = $right_answer_string;
			
			$has_multyiple_answer = $this->input->post('has_multiple_answer_row_'.$row);
			if($has_multyiple_answer == '1')
			{
				$question_answer_id = $this->input->post('q_answer_row_'.$row.'_row');
				if(is_array($question_answer_id))
				{
					$check_ans = array_diff($answer_array, $question_answer_id);
				}else
				{
					$check_ans = array_diff($answer_array, array());
				}
				$create_n_aray = $check_ans;
				if(count($create_n_aray) !== 0)
				{
					$check_answer = false;
				}else
				{
					$check_answer = true;
				}
				$right_ansto_db  = $question_answer_id;
			}else
			{
				$question_answer_id = $this->input->post('q_answer_row_'.$row);
				if(in_array($question_answer_id, $answer_array))
				{
					$check_answer = true;
				}else
				{
					$check_answer = false;
				}
				$right_ansto_db  = array($question_answer_id);
			}
			
			if($question_answer_id)
			{
				if($check_answer == true)
				{
					$answer_staus = 1;
				}else
				{
					$answer_staus = 0;
				}
				
				$data = array(
							'answer_student_id'        => $this->session->userdata('active_student'),
							'answer_exam_id'           => $exm_id,
							'answer_phase_id'          => $phase_level,
							'answer_question_id'       => $question_id,
							'answer_question_answerid' => json_encode($right_ansto_db),
							'answer_status'            => $answer_staus,
							'answer_create_date'       => date("Y-m-d H:i:s"),
						);
				$this->Exam_model->save_answer($data);
			}
			
		}elseif($question_type == 'BLANK'){
			$input_blank_answers = $this->input->post('blank_ans_field_'.$row.'_row');
			$check_input_blank_answers = array();
			foreach($input_blank_answers as $val){
				if($val == '')
				{
					continue;
				}
				$check_input_blank_answers[] = $val;
			}
			if(count($check_input_blank_answers) !== 0)
			{
				$right_ans_ids = $this->Exam_model->get_right_answersids($question_id, $exm_id);
				$right_answer_string = str_replace('[', '', $right_ans_ids['question_right_answerid']);
				$right_answer_string = str_replace(']', '', $right_answer_string);
				$right_answer_string = explode(',', $right_answer_string);
				$answer_array = $right_answer_string;
				
				$ans_array = array();
				$blank_answer_list = $this->input->post('q_blank_'.$row.'_ans');
				foreach($blank_answer_list as $answer)
				{
					$ans_array[] = trim($answer);
				}
				$escap_array = array();
				foreach($input_blank_answers as $key => $ans)
				{
					$the_ans_key = array_search(trim($ans), $ans_array);
					$escap_array[$the_ans_key] = html_escape(trim($ans));
				}
				
				$blank_ans_array = array();
				$blank_n_array = array();
				foreach($answer_array as $key)
				{
					//check blank
					$blank_check = $this->Exam_model->check_blank_answer($key);
					if($blank_check == true)
					{
						if(array_key_exists($blank_check['answer_blank_id'], $escap_array))
						{
							$blnkid = $escap_array[$blank_check['answer_blank_id']];
						}else
						{
							$blnkid = '';
						}
						$blank_ans_array[$blank_check['answer_blank_id']] = trim($blank_check['answer_title']);
						$blank_n_array[$blank_check['answer_blank_id']] = $blnkid;
					}
				}
				
				$check_the_right = array_diff_assoc($blank_n_array, $blank_ans_array);
				
				if(count($check_the_right) == 0)
				{
					$answer_staus = 1;
				}else
				{
					$answer_staus = 0;
				}
				
				$data = array(
							'answer_student_id'        => $this->session->userdata('active_student'),
							'answer_exam_id'           => $exm_id,
							'answer_phase_id'          => $phase_level,
							'answer_question_id'       => $question_id,
							'answer_question_answerid' => json_encode($answer_array),
							'answer_status'            => $answer_staus,
							'answer_create_date'       => date("Y-m-d H:i:s"),
						);
				$this->Exam_model->save_answer($data);
			}
		}elseif($question_type == 'JUSTIFY'){
			$justify_answer = $this->input->post('q_answer_row_'.$row);
			if($justify_answer == '1')
			{
				$ans_txt = 'TRUE';
				$check_answer = $this->Exam_model->check_justify_answer($question_id, $ans_txt);
				if($check_answer == true)
				{
					$answer_staus = 1;
				}else{
					$answer_staus = 0;
				}
				
				$data = array(
							'answer_student_id'        => $this->session->userdata('active_student'),
							'answer_exam_id'           => $exm_id,
							'answer_phase_id'          => $phase_level,
							'answer_question_id'       => $question_id,
							'answer_status'            => $answer_staus,
							'answer_create_date'       => date("Y-m-d H:i:s"),
						);
				$this->Exam_model->save_answer($data);
			}elseif($justify_answer == '0'){
				$ans_txt = 'FALSE';
				$check_answer = $this->Exam_model->check_justify_answer($question_id, $ans_txt);
				if($check_answer == true)
				{
					$answer_staus = 1;
				}else{
					$answer_staus = 0;
				}
				
				$data = array(
							'answer_student_id'        => $this->session->userdata('active_student'),
							'answer_exam_id'           => $exm_id,
							'answer_phase_id'          => $phase_level,
							'answer_question_id'       => $question_id,
							'answer_status'            => $answer_staus,
							'answer_create_date'       => date("Y-m-d H:i:s"),
						);
				$this->Exam_model->save_answer($data);
			}
		}elseif($question_type == 'MULTIPLE_JUSTIFY'){
			
			$right_ans_ids = $this->Exam_model->get_right_answersids($question_id, $exm_id);
			$answer_array = json_decode($right_ans_ids['question_right_answerid'], true);
			
			$question_answer_ids = $this->input->post('q_answer_row_'.$row.'_row');
			$submited_justify_answer = array();
			foreach($question_answer_ids as $ansId)
			{
				$answer_justify = $this->input->post('q_answer_'.$row.'_'.$ansId);
				$submited_justify_answer[$ansId] = $answer_justify;
			}
			$check_ans = array_diff($answer_array, $submited_justify_answer);
			$create_n_aray = $check_ans;
			if(count($create_n_aray) !== 0)
			{
				$check_answer = false;
			}else
			{
				$check_answer = true;
			}
			$right_ansto_db  = $submited_justify_answer;
			
			if($question_answer_ids)
			{
				if($check_answer == true)
				{
					$answer_staus = 1;
				}else
				{
					$answer_staus = 0;
				}
				
				$data = array(
							'answer_student_id'        => $this->session->userdata('active_student'),
							'answer_exam_id'           => $exm_id,
							'answer_phase_id'          => $phase_level,
							'answer_question_id'       => $question_id,
							'answer_question_answerid' => json_encode($right_ansto_db),
							'answer_status'            => $answer_staus,
							'answer_create_date'       => date("Y-m-d H:i:s"),
						);
				$this->Exam_model->save_answer($data);
			}
		}
		endforeach;
		/******End-Point of question submission********/
		
		$marks_config = $this->Exam_model->get_marks_config();
		if($phase_level == '1'){
			
			$total_questions = $marks_config['mrkconfig_exam_totalquestion'];
			$total_right_answers = $this->Exam_model->get_right_answers($phase_level, $exm_id);
			$total_wrong_answers = $this->Exam_model->get_wrong_answers($phase_level, $exm_id);
			$no_answer = 0;
			$total_score = $total_right_answers * $marks_config['mrkconfig_question_mark'];
			$total_passing_score = $marks_config['mrkconfig_exmpass_mark'];
			$total_exm_score = $marks_config['mrkconfig_exmtotal_mark'];
			
			if($total_score < $total_passing_score)
			{
				$this->session->unset_userdata('exam_activated');
				$result_shw = '<span class="result-shw-failed">Failed</span>';
				$rslt = 0;
			}else
			{
				$this->session->unset_userdata('exam_activated');
				$result_shw = '<span class="result-shw-pass">Passed</span>';
				$rslt = 1;
				
				//update student progress
				$active_module = $this->Exam_model->get_active_module(2);
				$this->session->set_userdata(array('active_module' => $active_module, 'active_phase' => 2));
				$progress = array(
								'student_phaselevel_id' => 2,
								'student_active_module' => $active_module,
							);
				$this->Exam_model->update_student_progress($progress);
			}
			
		}elseif($phase_level == '2'){
			
			$total_questions = $marks_config['mrkconfig_pcatwo_exam_totalquestion'];
			$total_right_answers = $this->Exam_model->get_right_answers($phase_level, $exm_id);
			$total_wrong_answers = $this->Exam_model->get_wrong_answers($phase_level, $exm_id);
			$no_answer = 0;
			$total_score = $total_right_answers * $marks_config['mrkconfig_pcatwo_question_mark'];
			$total_passing_score = $marks_config['mrkconfig_pcatwo_exmpass_mark'];
			$total_exm_score = $marks_config['mrkconfig_pcatwo_exmtotal_mark'];
			
			if($total_score < $total_passing_score)
			{
				$this->session->unset_userdata('exam_activated');
				$result_shw = '<span class="result-shw-failed">Failed</span>';
				$rslt = 0;
			}else
			{
				$this->session->unset_userdata('exam_activated');
				$result_shw = '<span class="result-shw-pass">Passed</span>';
				$rslt = 1;
				
				//update student progress
				$active_module = $this->Exam_model->get_active_module(3);
				$this->session->set_userdata(array('active_module' => $active_module, 'active_phase' => 3));
				$progress = array(
								'student_phaselevel_id' => 3,
								'student_active_module' => $active_module,
							);
				$this->Exam_model->update_student_progress($progress);
			}

		}elseif($phase_level == '3'){
			
			$total_questions = $marks_config['mrkconfig_pcathree_exam_totalquestion'];
			$total_right_answers = $this->Exam_model->get_right_answers($phase_level, $exm_id);
			$total_wrong_answers = $this->Exam_model->get_wrong_answers($phase_level, $exm_id);
			$no_answer = 0;
			$total_score = $total_right_answers * $marks_config['mrkconfig_pcathree_question_mark'];
			$total_passing_score = $marks_config['mrkconfig_pcathree_exmpass_mark'];
			$total_exm_score = $marks_config['mrkconfig_pcathree_exmtotal_mark'];
			
			
			if($total_score < $total_passing_score)
			{
				$this->session->unset_userdata('exam_activated');
				$result_shw = '<span class="result-shw-failed">Failed</span>';
				$rslt = 0;
			}else
			{
				$this->session->unset_userdata('exam_activated');
				$result_shw = '<span class="result-shw-pass">Passed</span>';
				$rslt = 1;
				
				//update student progress
				$progress = array(
								'student_phaselevel_id' => 0,
								'student_ece_status' => 1,
							);
				$this->Exam_model->update_student_progress($progress);
			}

		}
		elseif($phase_level == '4'){
			
			$total_questions = $marks_config['mrkconfig_ece_exam_totalquestion'];
			$total_right_answers = $this->Exam_model->get_right_answers($phase_level, $exm_id);
			
			$total_right_answers_ospe = $this->Exam_model->get_right_answers_ece_osp($phase_level, $exm_id);
			$total_right_answers_others = $this->Exam_model->get_right_answers_ece_others($phase_level, $exm_id);

			$total_wrong_answers = $this->Exam_model->get_wrong_answers($phase_level, $exm_id);
			$no_answer = 0;

			$others_qsn_score = $total_right_answers_others * $marks_config['mrkconfig_ece_question_mark'];
			$osp_score = $total_right_answers_ospe * 2.5;

			$total_score = $others_qsn_score + $osp_score;


			/*$total_score = $total_right_answers * $marks_config['mrkconfig_ece_question_mark'];*/
			$total_passing_score = $marks_config['mrkconfig_ece_exmpass_mark'];
			$total_exm_score = $marks_config['mrkconfig_ece_exmtotal_mark'];
			
			
			if($total_score < $total_passing_score)
			{
				$this->session->unset_userdata('exam_activated');
				$result_shw = '<span class="result-shw-failed">Failed</span>';
				$rslt = 0;
			}else
			{
				$this->session->unset_userdata('exam_activated');
				$result_shw = '<span class="result-shw-pass">Passed</span>';
				$rslt = 1;
				
				//update student progress
				$progress = array(
								'student_phaselevel_id' => 0,
								'student_ece_status' => 1,
							);
				$this->Exam_model->update_student_progress($progress);
			}

		}
	
		//save module progress
		$progress_data = array(
							'cmreport_phase_id'    => $phase_level,
							'cmreport_student_id'  => $this->session->userdata('active_student'),
							'cmreport_status'      => $rslt,
							'cmreport_create_date' => date("Y-m-d H:i:s"),
						);
		$get_ins_id = $this->Exam_model->save_progress_data($progress_data);
		$cmreport_id = $this->db->insert_id($get_ins_id);
		
		//save module marks
		$marks_data = array(
							'mdlmark_cmreport_id' => $cmreport_id,
							'mdlmark_number' => $total_score,
							'mdlmark_passing_number' => $total_passing_score,
							'mdlmark_total_marks' => $total_exm_score,
							'mdlmark_right_answer' => $total_right_answers,
							'mdlmark_wrong_answer' => $total_wrong_answers,
						);
		$this->Exam_model->save_marks_data($marks_data);
		
		$content_data['total_questions']     = $total_questions;
		$content_data['total_right_answers'] = $total_right_answers;
		$content_data['total_wrong_answers'] = $total_wrong_answers;
		$content_data['total_score']         = $total_score;
		$content_data['total_passing_score'] = $total_passing_score;
		$content_data['result_shw']          = $result_shw;
		
		$res_array = array('1' => 'Passed', '0' => 'Failed');
		/*Alert student via sms and email*/
		$get_studentinfo = $this->Exam_model->get_student_info();
		/******Send SMS*******/
		$phone_number = $get_studentinfo['spinfo_personal_phone'];
		$name = $get_studentinfo['spinfo_first_name'].' '.$get_studentinfo['spinfo_middle_name'].' '.$get_studentinfo['spinfo_last_name'];
$message ='Dear '.$name.',
The result of your ECE exam score is '.$total_right_answers.' Correct Answers '.$total_wrong_answers.' Incorrect Answers '.$no_answer.' No Answers. You have '.$res_array[$rslt].' ECE exam.
';
		sendsms($phone_number, $message);	
		
		/******Send Email*******/
		$mail_body_data['name'] = $name;
		$mail_body_data['content'] = '<p>The result of you CCA '.$phase_level.' is '.$total_right_answers.' Correct Answers '.$total_wrong_answers.' Incorrect Answers '.$no_answer.' No Answers. You have '.$res_array[$rslt].' CCA '.$phase_level.'.</p>';
		
		$to = $get_studentinfo['student_email'];
		$subject = 'CCD CCA '.$phase_level.' examination result.';
		$body = $this->load->view('emails/dynamic_email', $mail_body_data, true);
		if ($_SERVER['HTTP_HOST']=='education.dldchc-badas.org.bd') {
			send_dynamic_email($to, $subject, $body);
		}
		
		/*End of alert*/
		
		$content = $this->load->view('result_of_pca', $content_data, true);
		$end_exam = 1;
		$result = array('status' => 'ok', 'content' => $content, 'end_of_exam' => $end_exam);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function prcstart($param1, $param2, $param3)
	{
		if(isset($param1) && isset($param2) && isset($param3) && isset($_GET['module']) && is_numeric($_GET['module']) && isset($_GET['lesson']) && is_numeric($_GET['lesson']))
		{
			if($param2 === 'Phase-A'){
				$data['strt_exam'] = base_url('student/exam/practice/End-Lesson/'.$param2.'/START?module='.$_GET['module'].'&lesson='.$_GET['lesson'].'&type=practice');
				$this->load->view('start_practice_exm', $data);
			}elseif($param2 === 'Phase-B'){
				$data['strt_exam'] = base_url('student/exam/practice/End-Lesson/'.$param2.'/START?module='.$_GET['module'].'&lesson='.$_GET['lesson'].'&type=practice');
				$this->load->view('start_practice_exm', $data);
			}elseif($param2 === 'Phase-C'){
				$data['strt_exam'] = base_url('student/exam/practice/End-Lesson/'.$param2.'/START?module='.$_GET['module'].'&lesson='.$_GET['lesson'].'&type=practice');
				$this->load->view('start_practice_exm', $data);
			}
			elseif($param2 === 'Phase-D'){
				$data['strt_exam'] = base_url('student/exam/practice/End-Lesson/'.$param2.'/START?module='.$_GET['module'].'&lesson='.$_GET['lesson'].'&type=practice');
				$this->load->view('start_practice_exm', $data);
			}
		}else
		{
			redirect('not-found');
		}
	}
	
	public function practice($param1, $param2, $param3)
	{
		if(isset($param1) && isset($param2) && isset($param3) && isset($_GET['module']) && is_numeric($_GET['module']) && isset($_GET['lesson']) && is_numeric($_GET['lesson']))
		{
			if($param2 === 'Phase-A')
			{
				$this->session->unset_userdata('ex_hour');
				$this->session->unset_userdata('ex_minute');
				$this->session->unset_userdata('ex_second');
				
				//save practice exam information
				$exam_practice_data = array(
										'examcnt_student_id'  => $this->session->userdata('active_student'),
										'examcnt_phase_level' => 1,
										'examcnt_module_id'   => $_GET['module'],
										'examcnt_lesson_id'   => $_GET['lesson'],
										'examcnt_date'        => date("Y-m-d H:i:s"),
									  );
				$practice_insert_id = $this->Exam_model->save_practice_exam_info($exam_practice_data);
				$practice_exam_id = $this->db->insert_id($practice_insert_id);
				$sess['practice_exam_id'] = $practice_exam_id;
				
				$sess['set_phaselevel_1'] = 1;
				$this->session->set_userdata($sess);
				
				$content_data['phase_level'] = $this->session->userdata('set_phaselevel_1');
				
				$get_marksconfig = $this->Exam_model->get_marksconfig();
				$content_data['question_type'] = json_decode($get_marksconfig['mrkconfig_practice_question_type'], true);
				$content_data['limit'] = $get_marksconfig['mrkconfig_practice_exam_totalquestion'];
				$content_data['exam_time'] = $get_marksconfig['mrkconfig_practice_exam_time'];
				
				$phase_level = 1;
				
				$module_id = intval($_GET['module']);
				$lesson_id = intval($_GET['lesson']);
				
				//delete old practice
				$this->Exam_model->delete_old_practice($phase_level, $module_id, $lesson_id);
				
				$content_data['module_id'] = $module_id;
				$content_data['lesson_id'] = $lesson_id;
				$total_questions = $this->Exam_model->get_lesson_total_question($phase_level, $module_id, $lesson_id);
				$total_right_answers = $this->Exam_model->get_lesson_right_answers($practice_exam_id, $phase_level, $module_id, $lesson_id);
				$total_wrong_answers = $this->Exam_model->get_lesson_wrong_answers($practice_exam_id, $phase_level, $module_id, $lesson_id);
				
				$total_score = $total_right_answers * $get_marksconfig['mrkconfig_practice_question_mark'];
				$total_passing_score = $get_marksconfig['mrkconfig_practice_exmpass_mark'];
				if($total_score < $total_passing_score)
				{
					$result_shw = '<span class="result-shw-failed">Failed</span>';
				}else
				{
					$result_shw = '<span class="result-shw-pass">Passed</span>';
				}
				
				$content_data['total_questions']     = $content_data['limit'];
				$content_data['total_right_answers'] = $total_right_answers;
				$content_data['total_wrong_answers'] = $total_wrong_answers;
				$content_data['total_score']         = $total_score;
				$content_data['total_passing_score'] = $total_passing_score;
				$content_data['result_shw']          = $result_shw;
				
				$this->load->view('practice_exam_new', $content_data);
				
			}elseif($param2 === 'Phase-B'){
				
				$this->session->unset_userdata('ex_hour');
				$this->session->unset_userdata('ex_minute');
				$this->session->unset_userdata('ex_second');
				
				//save practice exam information
				$exam_practice_data = array(
										'examcnt_student_id'  => $this->session->userdata('active_student'),
										'examcnt_phase_level' => 2,
										'examcnt_module_id'   => $_GET['module'],
										'examcnt_lesson_id'   => $_GET['lesson'],
										'examcnt_date'        => date("Y-m-d H:i:s"),
									  );
				$practice_insert_id = $this->Exam_model->save_practice_exam_info($exam_practice_data);
				$practice_exam_id = $this->db->insert_id($practice_insert_id);
				$sess['practice_exam_id'] = $practice_exam_id;
				
				$sess['set_phaselevel_2'] = 2;
				$this->session->set_userdata($sess);
				
				$content_data['phase_level'] = $this->session->userdata('set_phaselevel_2');
				
				$get_marksconfig = $this->Exam_model->get_marksconfig();
				$content_data['question_type'] = json_decode($get_marksconfig['mrkconfig_practice_question_type'], true);
				$content_data['limit'] = $get_marksconfig['mrkconfig_practice_exam_totalquestion'];
				$content_data['exam_time'] = $get_marksconfig['mrkconfig_practice_exam_time'];
				
				$phase_level = 2;
				
				$module_id = intval($_GET['module']);
				$lesson_id = intval($_GET['lesson']);
				$content_data['module_id'] = $module_id;
				$content_data['lesson_id'] = $lesson_id;
				$total_questions = $this->Exam_model->get_lesson_total_question($phase_level, $module_id, $lesson_id);
				$total_right_answers = $this->Exam_model->get_lesson_right_answers($practice_exam_id, $phase_level, $module_id, $lesson_id);
				$total_wrong_answers = $this->Exam_model->get_lesson_wrong_answers($practice_exam_id, $phase_level, $module_id, $lesson_id);
				
				$total_score = $total_right_answers * $get_marksconfig['mrkconfig_practice_question_mark'];
				$total_passing_score = $get_marksconfig['mrkconfig_practice_exmpass_mark'];
				if($total_score < $total_passing_score)
				{
					$result_shw = '<span class="result-shw-failed">Failed</span>';
				}else
				{
					$result_shw = '<span class="result-shw-pass">Passed</span>';
				}
				
				$content_data['total_questions']     = $content_data['limit'];
				$content_data['total_right_answers'] = $total_right_answers;
				$content_data['total_wrong_answers'] = $total_wrong_answers;
				$content_data['total_score']         = $total_score;
				$content_data['total_passing_score'] = $total_passing_score;
				$content_data['result_shw']          = $result_shw;
				
				$this->load->view('practice_exam_new', $content_data);
				
			}elseif($param2 === 'Phase-C'){
				
				$this->session->unset_userdata('ex_hour');
				$this->session->unset_userdata('ex_minute');
				$this->session->unset_userdata('ex_second');
				
				//save practice exam information
				$exam_practice_data = array(
										'examcnt_student_id'  => $this->session->userdata('active_student'),
										'examcnt_phase_level' => 3,
										'examcnt_module_id'   => $_GET['module'],
										'examcnt_lesson_id'   => $_GET['lesson'],
										'examcnt_date'        => date("Y-m-d H:i:s"),
									  );
				$practice_insert_id = $this->Exam_model->save_practice_exam_info($exam_practice_data);
				$practice_exam_id = $this->db->insert_id($practice_insert_id);
				$sess['practice_exam_id'] = $practice_exam_id;
				
				$sess['set_phaselevel_3'] = 3;
				$this->session->set_userdata($sess);
				
				$content_data['phase_level'] = $this->session->userdata('set_phaselevel_3');
				
				$get_marksconfig = $this->Exam_model->get_marksconfig();
				$content_data['question_type'] = json_decode($get_marksconfig['mrkconfig_practice_question_type'], true);
				$content_data['limit'] = $get_marksconfig['mrkconfig_practice_exam_totalquestion'];
				$content_data['exam_time'] = $get_marksconfig['mrkconfig_practice_exam_time'];
				
				$phase_level = 3;
				
				$module_id = intval($_GET['module']);
				$lesson_id = intval($_GET['lesson']);
				$content_data['module_id'] = $module_id;
				$content_data['lesson_id'] = $lesson_id;
				$total_questions = $this->Exam_model->get_lesson_total_question($phase_level, $module_id, $lesson_id);
				$total_right_answers = $this->Exam_model->get_lesson_right_answers($practice_exam_id, $phase_level, $module_id, $lesson_id);
				$total_wrong_answers = $this->Exam_model->get_lesson_wrong_answers($practice_exam_id, $phase_level, $module_id, $lesson_id);
				
				$total_score = $total_right_answers * $get_marksconfig['mrkconfig_practice_question_mark'];
				$total_passing_score = $get_marksconfig['mrkconfig_practice_exmpass_mark'];
				if($total_score < $total_passing_score)
				{
					$result_shw = '<span class="result-shw-failed">Failed</span>';
				}else
				{
					$result_shw = '<span class="result-shw-pass">Passed</span>';
				}
				
				$content_data['total_questions']     = $content_data['limit'];
				$content_data['total_right_answers'] = $total_right_answers;
				$content_data['total_wrong_answers'] = $total_wrong_answers;
				$content_data['total_score']         = $total_score;
				$content_data['total_passing_score'] = $total_passing_score;
				$content_data['result_shw']          = $result_shw;
				
				$this->load->view('practice_exam_new', $content_data);
				
			}elseif($param2 === 'Phase-D'){
				
				$this->session->unset_userdata('ex_hour');
				$this->session->unset_userdata('ex_minute');
				$this->session->unset_userdata('ex_second');
				
				//save practice exam information
				$exam_practice_data = array(
										'eceexmcount_id'  => $this->session->userdata('active_student'),
										'examcnt_phase_level' => 4,
										'examcnt_module_id'   => $_GET['module'],
										'examcnt_lesson_id'   => $_GET['lesson'],
										'examcnt_date'        => date("Y-m-d H:i:s"),
									  );
				$practice_insert_id = $this->Exam_model->save_practice_exam_info($exam_practice_data);
				$practice_exam_id = $this->db->insert_id($practice_insert_id);
				$sess['practice_exam_id'] = $practice_exam_id;
				
				$sess['set_phaselevel_4'] = 4;
				$this->session->set_userdata($sess);
				
				$content_data['phase_level'] = $this->session->userdata('set_phaselevel_4');
				
				$get_marksconfig = $this->Exam_model->get_marksconfig();
				$content_data['question_type'] = json_decode($get_marksconfig['mrkconfig_practice_question_type'], true);
				$content_data['limit'] = $get_marksconfig['mrkconfig_practice_exam_totalquestion'];
				$content_data['exam_time'] = $get_marksconfig['mrkconfig_practice_exam_time'];
				
				$phase_level = 4;
				
				$module_id = intval($_GET['module']);
				$lesson_id = intval($_GET['lesson']);
				$content_data['module_id'] = $module_id;
				$content_data['lesson_id'] = $lesson_id;
				$total_questions = $this->Exam_model->get_lesson_total_question($phase_level, $module_id, $lesson_id);
				$total_right_answers = $this->Exam_model->get_lesson_right_answers($practice_exam_id, $phase_level, $module_id, $lesson_id);
				$total_wrong_answers = $this->Exam_model->get_lesson_wrong_answers($practice_exam_id, $phase_level, $module_id, $lesson_id);
				
				$total_score = $total_right_answers * $get_marksconfig['mrkconfig_practice_question_mark'];
				$total_passing_score = $get_marksconfig['mrkconfig_practice_exmpass_mark'];
				if($total_score < $total_passing_score)
				{
					$result_shw = '<span class="result-shw-failed">Failed</span>';
				}else
				{
					$result_shw = '<span class="result-shw-pass">Passed</span>';
				}
				
				$content_data['total_questions']     = $content_data['limit'];
				$content_data['total_right_answers'] = $total_right_answers;
				$content_data['total_wrong_answers'] = $total_wrong_answers;
				$content_data['total_score']         = $total_score;
				$content_data['total_passing_score'] = $total_passing_score;
				$content_data['result_shw']          = $result_shw;
				
				$this->load->view('practice_exam_new', $content_data);
				
			}
			else
			{
				redirect('not-found');
			}
		}else
		{
			redirect('not-found');
		}
	}
	
	public function practice_answersubmit()
	{
		$module_id = $this->input->post('module');
		$lesson_id = $this->input->post('lesson');
		//check answer
		/******Start-Point of question submission********/
		$question_rows = $this->input->post('question_row');
		$phase_level = $this->input->post('active_phase');
		if(count($question_rows) !== 0):
		foreach($question_rows as $row):
		$question_id = $this->input->post('question_row_value_'.$row);
		$question_type = $this->input->post('q_type_row_'.$row);
		if($question_type == 'MCQ'){
			$right_ans_ids = $this->Exam_model->get_right_answersids($question_id);
			$right_answer_string = str_replace('[', '', $right_ans_ids['question_right_answerid']);
			$right_answer_string = str_replace(']', '', $right_answer_string);
			$right_answer_string = explode(',', $right_answer_string);
			$answer_array = $right_answer_string;
			
			$has_multyiple_answer = $this->input->post('has_multiple_answer_row_'.$row);
			if($has_multyiple_answer == '1')
			{
				$question_answer_id = $this->input->post('q_answer_row_'.$row.'_row');
				$check_ans = array_diff($answer_array, $question_answer_id);
				$create_n_aray = $check_ans;
				if(count($create_n_aray) !== 0)
				{
					$check_answer = false;
				}else
				{
					$check_answer = true;
				}
				$right_ansto_db  = $question_answer_id;
			}else
			{
				$question_answer_id = $this->input->post('q_answer_row_'.$row);
				if(in_array($question_answer_id, $answer_array))
				{
					$check_answer = true;
				}else
				{
					$check_answer = false;
				}
				$right_ansto_db  = array($question_answer_id);
			}
			
			if($question_answer_id)
			{
				if($check_answer == true)
				{
					$answer_staus = 1;
				}else
				{
					$answer_staus = 0;
				}
				
				$data = array(
							'answer_exam_id'           => $this->session->userdata('practice_exam_id'),
							'answer_student_id'        => $this->session->userdata('active_student'),
							'answer_phase_id'          => $phase_level,
							'answer_module_id'         => $module_id,
							'answer_lesson_id'         => $lesson_id,
							'answer_question_id'       => $question_id,
							'answer_question_answerid' => json_encode($right_ansto_db),
							'answer_status'            => $answer_staus,
							'answer_create_date'       => date("Y-m-d H:i:s"),
						);
				$this->Exam_model->save_practice_answer($data);
			}
			
		}elseif($question_type == 'BLANK'){
			$input_blank_answers = $this->input->post('blank_ans_field_'.$row.'_row');
			$check_input_blank_answers = array();
			foreach($input_blank_answers as $val){
				if($val == '')
				{
					continue;
				}
				$check_input_blank_answers[] = $val;
			}
			if(count($check_input_blank_answers) !== 0)
			{
				$right_ans_ids = $this->Exam_model->get_right_answersids($question_id);
				$right_answer_string = str_replace('[', '', $right_ans_ids['question_right_answerid']);
				$right_answer_string = str_replace(']', '', $right_answer_string);
				$right_answer_string = explode(',', $right_answer_string);
				$answer_array = $right_answer_string;
				
				$ans_array = array();
				$blank_answer_list = $this->input->post('q_blank_'.$row.'_ans');
				foreach($blank_answer_list as $answer)
				{
					$ans_array[] = trim($answer);
				}
				$escap_array = array();
				foreach($input_blank_answers as $key => $ans)
				{
					$the_ans_key = array_search(trim($ans), $ans_array);
					$escap_array[$the_ans_key] = html_escape(trim($ans));
				}
				
				$blank_ans_array = array();
				$blank_n_array = array();
				foreach($answer_array as $key)
				{
					//check blank
					$blank_check = $this->Exam_model->check_blank_answer($key);
					if($blank_check == true)
					{
						if(array_key_exists($blank_check['answer_blank_id'], $escap_array))
						{
							$blnkid = $escap_array[$blank_check['answer_blank_id']];
						}else
						{
							$blnkid = '';
						}
						$blank_ans_array[$blank_check['answer_blank_id']] = trim($blank_check['answer_title']);
						$blank_n_array[$blank_check['answer_blank_id']] = $blnkid;
					}
				}
				
				$check_the_right = array_diff_assoc($blank_n_array, $blank_ans_array);
				
				if(count($check_the_right) == 0)
				{
					$answer_staus = 1;
				}else
				{
					$answer_staus = 0;
				}
				
				$data = array(
							'answer_exam_id'           => $this->session->userdata('practice_exam_id'),
							'answer_student_id'        => $this->session->userdata('active_student'),
							'answer_phase_id'          => $phase_level,
							'answer_module_id'         => $module_id,
							'answer_lesson_id'         => $lesson_id,
							'answer_question_id'       => $question_id,
							'answer_question_answerid' => json_encode($answer_array),
							'answer_status'            => $answer_staus,
							'answer_create_date'       => date("Y-m-d H:i:s"),
						);
				$this->Exam_model->save_practice_answer($data);
			}
		}elseif($question_type == 'JUSTIFY'){
			$justify_answer = $this->input->post('q_answer_row_'.$row);
			if($justify_answer == '1')
			{
				$ans_txt = 'TRUE';
				$check_answer = $this->Exam_model->check_justify_answer($question_id, $ans_txt);
				if($check_answer == true)
				{
					$answer_staus = 1;
				}else
				{
					$answer_staus = 0;
				}
				
				$data = array(
							'answer_exam_id'           => $this->session->userdata('practice_exam_id'),
							'answer_student_id'        => $this->session->userdata('active_student'),
							'answer_phase_id'          => $phase_level,
							'answer_module_id'         => $module_id,
							'answer_lesson_id'         => $lesson_id,
							'answer_question_id'       => $question_id,
							'answer_status'            => $answer_staus,
							'answer_create_date'       => date("Y-m-d H:i:s"),
						);
				$this->Exam_model->save_practice_answer($data);
			}elseif($justify_answer == '0'){
				$ans_txt = 'FALSE';
				$check_answer = $this->Exam_model->check_justify_answer($question_id, $ans_txt);
				if($check_answer == true)
				{
					$answer_staus = 1;
				}else
				{
					$answer_staus = 0;
				}
				
				$data = array(
							'answer_exam_id'           => $this->session->userdata('practice_exam_id'),
							'answer_student_id'        => $this->session->userdata('active_student'),
							'answer_phase_id'          => $phase_level,
							'answer_module_id'         => $module_id,
							'answer_lesson_id'         => $lesson_id,
							'answer_question_id'       => $question_id,
							'answer_status'            => $answer_staus,
							'answer_create_date'       => date("Y-m-d H:i:s"),
						);
				$this->Exam_model->save_practice_answer($data);
			}
		}elseif($question_type == 'MULTIPLE_JUSTIFY'){
			$right_ans_ids = $this->Exam_model->get_right_answersids($question_id);
			$answer_array = json_decode($right_ans_ids['question_right_answerid'], true);
			
			$question_answer_ids = $this->input->post('q_answer_row_'.$row.'_row');
			$submited_justify_answer = array();
			foreach($question_answer_ids as $ansId)
			{
				$answer_justify = $this->input->post('q_answer_'.$row.'_'.$ansId);
				$submited_justify_answer[$ansId] = $answer_justify;
			}
			$check_ans = array_diff($answer_array, $submited_justify_answer);
			$create_n_aray = $check_ans;
			if(count($create_n_aray) !== 0)
			{
				$check_answer = false;
			}else
			{
				$check_answer = true;
			}
			$right_ansto_db  = $submited_justify_answer;
			
			if($question_answer_ids)
			{
				if($check_answer == true)
				{
					$answer_staus = 1;
				}else
				{
					$answer_staus = 0;
				}
				
				$data = array(
							'answer_exam_id'           => $this->session->userdata('practice_exam_id'),
							'answer_student_id'        => $this->session->userdata('active_student'),
							'answer_phase_id'          => $phase_level,
							'answer_module_id'         => $module_id,
							'answer_lesson_id'         => $lesson_id,
							'answer_question_id'       => $question_id,
							'answer_question_answerid' => json_encode($right_ansto_db),
							'answer_status'            => $answer_staus,
							'answer_create_date'       => date("Y-m-d H:i:s"),
						);
				$this->Exam_model->save_practice_answer($data);
			}
		}
		endforeach;
		endif;
		/******End-Point of question submission********/
		
		$get_marksconfig = $this->Exam_model->get_marksconfig();
		$content_data['limit'] = $get_marksconfig['mrkconfig_practice_exam_totalquestion'];
		
		$total_questions = $this->Exam_model->get_lesson_total_question($phase_level, $module_id, $lesson_id);
		$total_right_answers = $this->Exam_model->get_lesson_right_answers($this->session->userdata('practice_exam_id'), $phase_level, $module_id, $lesson_id);
		$total_wrong_answers = $this->Exam_model->get_lesson_wrong_answers($this->session->userdata('practice_exam_id'), $phase_level, $module_id, $lesson_id);
		$no_answer = 0;
		
		$total_score = $total_right_answers * $get_marksconfig['mrkconfig_practice_question_mark'];
		$total_passing_score = $get_marksconfig['mrkconfig_practice_exmpass_mark'];
		if($total_score < $total_passing_score)
		{
			$result_shw = '<span class="result-shw-failed">Failed</span>';
		}else
		{
			$result_shw = '<span class="result-shw-pass">Passed</span>';
		}
		
		$content_data['total_questions']     = $content_data['limit'];
		$content_data['total_right_answers'] = $total_right_answers;
		$content_data['total_wrong_answers'] = $total_wrong_answers;
		$content_data['total_score']         = $total_score;
		$content_data['total_passing_score'] = $total_passing_score;
		$content_data['result_shw']          = $result_shw;
		
		/*Alert student via sms and email*/
		$get_studentinfo = $this->Exam_model->get_student_info();
		$module_name = $this->Exam_model->get_module_name($module_id);
		$lesson_name = $this->Exam_model->get_lesson_name($lesson_id);
		/******Send SMS*******/
		$phone_number = $get_studentinfo['spinfo_personal_phone'];
		$name = $get_studentinfo['spinfo_first_name'].' '.$get_studentinfo['spinfo_middle_name'].' '.$get_studentinfo['spinfo_last_name'];
$message ='Dear '.$name.',
The results of your Practice-Based Study for '.$module_name.'. Lesson : '.$lesson_name.' is '.$total_right_answers.' Correct Answers and '.$total_wrong_answers.' Incorrect Answers and '.$no_answer.' No Answers.
';
		sendsms($phone_number, $message);	
		
		/******Send Email*******/
		$mail_body_data['name'] = $name;
		$mail_body_data['content'] = '<p>You have completed your Practice-Based Study for '.$module_name.'. Lesson: '.$lesson_name.' is '.$total_right_answers.' Correct Answers and '.$total_wrong_answers.' Incorrect Answers and '.$no_answer.' No Answers.</p>';
		
		$to = $get_studentinfo['student_email'];
		$subject = 'CCD practice based examination result.';
		$body = $this->load->view('emails/dynamic_email', $mail_body_data, true);
		if ($_SERVER['HTTP_HOST']=='education.dldchc-badas.org.bd') {
			send_dynamic_email($to, $subject, $body);
		}
		
		/*End of alert*/
		
		
		$content = $this->load->view('result_of_practice', $content_data, true);
		$end_exam = 1;
		$result = array('status' => 'ok', 'content' => $content, 'end_of_exam' => $end_exam);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function checktime()
	{
		$hour = $this->input->post('hour');
		$minute = $this->input->post('minute');
		$second = $this->input->post('second');
		
		$sess['ex_hour']   = $hour;
		$sess['ex_minute'] = $minute;
		$sess['ex_second'] = $second;
		$this->session->set_userdata($sess);
		
		$result = array('status' => 'ok');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
		
	}
	
}