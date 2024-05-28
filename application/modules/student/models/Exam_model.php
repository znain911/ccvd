<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exam_model extends CI_Model {

	public function check_question_exist($question_id)
	{
		$query = $this->db->query("SELECT answer_question_id FROM starter_endmodule_exmanswer 
		                           WHERE starter_endmodule_exmanswer.answer_question_id='$question_id' 
								  LIMIT 1");
		return $query->row_array();
	}
	
	public function get_question($phase_id, $question_type, $limit)
	{
		$query = $this->db->query("SELECT * FROM starter_exam_questions
								   WHERE starter_exam_questions.question_exam_type='PCA'
								   AND starter_exam_questions.question_module_phase_id='$phase_id'
								   ORDER BY RAND()
								   LIMIT $limit");
		return $query->result_array();
	}
	public function get_question_ece($phase_id, $question_type, $limit)
	{
		$query = $this->db->query("SELECT * FROM starter_exam_questions
								   WHERE starter_exam_questions.question_exam_type='ECE'
								   AND starter_exam_questions.question_module_phase_id='$phase_id'
								   ORDER BY RAND()
								   LIMIT $limit");
		return $query->result_array();
	}
	
	public function get_question_new($phase_id, $question_type, $limit)
	{
		$query = $this->db->query("SELECT * FROM starter_exam_questions
								   WHERE starter_exam_questions.question_module_phase_id='$phase_id' ORDER BY RAND()
								   LIMIT $limit");
		return $query->result_array();
	}
	
	public function get_practice_question($phase_id, $module_id, $lesson_id, $question_type, $limit)
	{
		$query = $this->db->query("SELECT * FROM starter_exam_questions  
								   WHERE starter_exam_questions.question_exam_type='Lesson'
								   AND starter_exam_questions.question_module_phase_id='$phase_id'
								   AND starter_exam_questions.question_module_id='$module_id'
								   AND starter_exam_questions.question_lesson_id='$lesson_id' LIMIT $limit");
		return $query->result_array();
	}
	
	public function get_question_answers($question_id)
	{
		$query = $this->db->query("SELECT * FROM starter_questions_answers 
							       WHERE starter_questions_answers.answer_question_id='$question_id'
								   ORDER BY starter_questions_answers.answer_id ASC
								  ");
		return $query->result_array();
	}
	
	public function get_timeby_coordinator()
	{
		$query = $this->db->query("SELECT mrkconfig_exam_time FROM starter_marks_config WHERE starter_marks_config.mrkconfig_key='One_Time' LIMIT 1");
		$result = $query->row_array();
		return $result['mrkconfig_exam_time'];
	}
	
	public function save_answer($data)
	{
		$this->db->insert('starter_endmodule_exmanswer', $data);
	}
	
	public function save_practice_answer($data)
	{
		$this->db->insert('starter_practice_exmanswer', $data);
	}
	
	public function check_answer($question_id, $question_answer_id)
	{
		$query = $this->db->query("SELECT question_id 
								   FROM starter_exam_questions 
								   WHERE starter_exam_questions.question_id='$question_id' 
								   AND starter_exam_questions.question_right_answerid='$question_answer_id'
								   LIMIT 1
								 ");
		return $query->row_array();
	}
	
	public function get_total_items()
	{
		$query = $this->db->query("SELECT mrkconfig_exam_totalquestion FROM starter_marks_config WHERE starter_marks_config.mrkconfig_key='One_Time' LIMIT 1");
		$result = $query->row_array();
		return $result['mrkconfig_exam_totalquestion'];
	}
	
	public function get_current_item($phase_id, $exm_id)
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT answer_id 
								   FROM starter_endmodule_exmanswer
								   WHERE starter_endmodule_exmanswer.answer_student_id='$student_id'
								   AND starter_endmodule_exmanswer.answer_phase_id='$phase_id'
								   AND starter_endmodule_exmanswer.answer_exam_id='$exm_id'");
		$result = $query->num_rows();
		return $result;
	}
	
	/*******For PCA*******/
	public function get_right_answers($phase_id, $exm_id)
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT answer_id 
								   FROM starter_endmodule_exmanswer
								   WHERE starter_endmodule_exmanswer.answer_student_id='$student_id'
								   AND starter_endmodule_exmanswer.answer_phase_id='$phase_id'
								   AND starter_endmodule_exmanswer.answer_exam_id='$exm_id'
								   AND starter_endmodule_exmanswer.answer_status=1
								  ");
		$result = $query->num_rows();
		return $result;
	}

	public function get_right_answers_ece_osp($phase_id, $exm_id)
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT starter_endmodule_exmanswer.answer_id 
								   FROM starter_endmodule_exmanswer
								   LEFT JOIN starter_exam_questions ON starter_endmodule_exmanswer.answer_question_id = starter_exam_questions.question_id
								   WHERE starter_endmodule_exmanswer.answer_student_id='$student_id'
								   AND starter_endmodule_exmanswer.answer_phase_id='$phase_id'
								   AND starter_endmodule_exmanswer.answer_exam_id='$exm_id'
								   AND starter_endmodule_exmanswer.answer_status=1
								   AND starter_exam_questions.ece_type = 1
								  ");
		$result = $query->num_rows();
		return $result;
	}

	public function get_right_answers_ece_others($phase_id, $exm_id)
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT starter_endmodule_exmanswer.answer_id 
								   FROM starter_endmodule_exmanswer
								   LEFT JOIN starter_exam_questions ON starter_endmodule_exmanswer.answer_question_id = starter_exam_questions.question_id
								   WHERE starter_endmodule_exmanswer.answer_student_id='$student_id'
								   AND starter_endmodule_exmanswer.answer_phase_id='$phase_id'
								   AND starter_endmodule_exmanswer.answer_exam_id='$exm_id'
								   AND starter_endmodule_exmanswer.answer_status=1
								   AND starter_exam_questions.ece_type = 0
								  ");
		$result = $query->num_rows();
		return $result;
	}



	
	public function get_wrong_answers($phase_id, $exm_id)
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT answer_id 
								   FROM starter_endmodule_exmanswer
								   WHERE starter_endmodule_exmanswer.answer_student_id='$student_id'
								   AND starter_endmodule_exmanswer.answer_phase_id='$phase_id'
								   AND starter_endmodule_exmanswer.answer_exam_id='$exm_id'
								   AND starter_endmodule_exmanswer.answer_status=0
								  ");
		$result = $query->num_rows();
		return $result;
	}
	
	/******For practice based******/
	public function get_lesson_right_answers($practice_exam_id, $phase_id, $module_id, $lesson_id)
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT answer_id 
								   FROM starter_practice_exmanswer
								   WHERE starter_practice_exmanswer.answer_exam_id='$practice_exam_id'
								   AND starter_practice_exmanswer.answer_student_id='$student_id'
								   AND starter_practice_exmanswer.answer_phase_id='$phase_id'
								   AND starter_practice_exmanswer.answer_module_id='$module_id'
								   AND starter_practice_exmanswer.answer_lesson_id='$lesson_id'
								   AND starter_practice_exmanswer.answer_status=1
								  ");
		$result = $query->num_rows();
		return $result;
	}
	
	public function get_lesson_wrong_answers($practice_exam_id, $phase_id, $module_id, $lesson_id)
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT answer_id 
								   FROM starter_practice_exmanswer
								   WHERE starter_practice_exmanswer.answer_exam_id='$practice_exam_id'
								   AND starter_practice_exmanswer.answer_student_id='$student_id'
								   AND starter_practice_exmanswer.answer_phase_id='$phase_id'
								   AND starter_practice_exmanswer.answer_module_id='$module_id'
								   AND starter_practice_exmanswer.answer_lesson_id='$lesson_id'
								   AND starter_practice_exmanswer.answer_status=0
								  ");
		$result = $query->num_rows();
		return $result;
	}
	
	public function get_lesson_total_question($phase_id, $module_id, $lesson_id)
	{
		$query = $this->db->query("SELECT question_id FROM starter_exam_questions 
								  WHERE starter_exam_questions.question_module_phase_id='$phase_id'
								  AND starter_exam_questions.question_module_id='$module_id'
								  AND starter_exam_questions.question_lesson_id='$lesson_id'
								  ");
		return $query->num_rows();
	}
	
	public function delete_old_practice($phase_id, $module_id, $lesson_id)
	{
		$student_id = $this->session->userdata('active_student');
		$this->db->where('answer_student_id', $student_id);
		$this->db->where('answer_phase_id', $phase_id);
		$this->db->where('answer_module_id', $module_id);
		$this->db->where('answer_lesson_id', $lesson_id);
		$this->db->delete('starter_practice_exmanswer');
	}
	
	public function get_marks_config()
	{
		$query = $this->db->query("SELECT * FROM starter_marks_config WHERE starter_marks_config.mrkconfig_key='One_Time' LIMIT 1");
		return $query->row_array();
	}
	
	public function save_progress_data($data)
	{
		$this->db->insert('starter_module_progress', $data);
	}
	
	public function save_marks_data($data)
	{
		$this->db->insert('starter_module_marks', $data);
	}
	
	public function get_right_answersids($question_id)
	{
		$query = $this->db->query("SELECT question_right_answerid FROM starter_exam_questions WHERE starter_exam_questions.question_id='$question_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function check_justify_answer($question_id, $answer)
	{
		$query = $this->db->query("SELECT question_id FROM starter_exam_questions WHERE starter_exam_questions.question_id='$question_id' AND starter_exam_questions.question_justify_answer='$answer' LIMIT 1");
		return $query->row_array();
	}
	
	public function check_blank_answer($answer_id)
	{
		$query = $this->db->query("SELECT answer_title, answer_blank_id FROM starter_questions_answers 
									WHERE starter_questions_answers.answer_id='$answer_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_marksconfig()
	{
		$query = $this->db->query("SELECT * FROM starter_marks_config WHERE starter_marks_config.mrkconfig_key='One_Time' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_exmid()
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT student_pcaexam_id FROM starter_students WHERE starter_students.student_id='$student_id' LIMIT 1");
		$result = $query->row_array();
		return $result['student_pcaexam_id'];
	}
	public function get_ece_exmid()
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT student_ece_exam_id FROM starter_students WHERE starter_students.student_id='$student_id' LIMIT 1");
		$result = $query->row_array();
		return $result['student_ece_exam_id'];
	}
	
	public function save_pcaexam($data)
	{
		$this->db->insert('starter_pcaexam_counter', $data);
	}
	public function save_ece_exam($data)
	{
		$this->db->insert('starter_eceexam_counter', $data);
	}
	
	public function update_student_progress($data)
	{
		$student_id = $this->session->userdata('active_student');
		$this->db->where('student_id', $student_id);
		$this->db->update('starter_students', $data);
	}
	
	public function get_active_module($phase)
	{
		$query = $this->db->query("SELECT MIN(module_id) AS active_module FROM starter_modules WHERE starter_modules.module_phase_id='$phase' LIMIT 1");
		$result = $query->row_array();
		return $result['active_module'];
	}
	
	public function check_retake_exam($phase)
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT examcnt_id FROM starter_pcaexam_counter WHERE starter_pcaexam_counter.examcnt_student_id='$student_id' AND starter_pcaexam_counter.examcnt_phase_level='$phase' LIMIT 1");
		return $query->row_array();
	}
	public function check_retake_exam_ece($phase)
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT eceexmcount_id  FROM  starter_eceexam_counter WHERE starter_eceexam_counter.eceexmcount_student_id='$student_id' AND starter_eceexam_counter.eceexamcnt_phase_level='$phase' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_student_info()
	{
		$student_id = $this->session->userdata('active_student');
		$query = $this->db->query("SELECT * 
								   FROM starter_students 
								   LEFT JOIN starter_students_personalinfo ON
								   starter_students_personalinfo.spinfo_student_id=starter_students.student_id
								   WHERE spinfo_student_id='$student_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_module_name($module_id)
	{
		$query = $this->db->query("SELECT module_name FROM starter_modules WHERE starter_modules.module_id='$module_id' LIMIT 1");
		$result = $query->row_array();
		return $result['module_name'];
	}
	
	public function get_lesson_name($lesson_id)
	{
		$query = $this->db->query("SELECT lesson_title FROM starter_modules_lessons WHERE starter_modules_lessons.lesson_id='$lesson_id' LIMIT 1");
		$result = $query->row_array();
		return $result['lesson_title'];
	}
	
	public function save_practice_exam_info($data)
	{
		$this->db->insert('starter_practiceexam_counter', $data);
	}
	
	public function get_wrong_answer($exam_id)
	{
		$query = $this->db->query("SELECT * FROM starter_practice_exmanswer 
							       LEFT JOIN starter_exam_questions ON
								   starter_exam_questions.question_id=starter_practice_exmanswer.answer_question_id 
								   WHERE answer_exam_id='$exam_id' AND answer_status='0' ORDER BY answer_id ASC");
		return $query->result_array();
	}
	
	public function get_answer_titleby_id($answer_id)
	{
		$query = $this->db->query("SELECT answer_title FROM starter_questions_answers WHERE answer_id='$answer_id'");
		return $query->row_array();
	}
	
	public function getExamStatus() {
        $this -> db -> select('mrkconfig_exam_active');
		$this -> db -> from('starter_marks_config');
		$this -> db -> where('mrkconfig_key', 'One_Time');
		$query = $this->db->get();
		return $query->first_row();
    } // End of function
	
}
