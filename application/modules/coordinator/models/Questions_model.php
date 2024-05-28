<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Questions_model extends CI_Model {
	
	public function count_module_questions()
	{
		$query = $this->db->query("SELECT * FROM starter_exam_questions WHERE starter_exam_questions.question_status=1");
		return $query->num_rows();
	}
	
	public function create($data)
	{
		$this->db->insert('starter_exam_questions', $data);
	}
	
	public function update($id, $data)
	{
		$this->db->where('question_id', $id);
		$this->db->update('starter_exam_questions', $data);
	}
	
	public function get_info($id, $question_exam_type)
	{
		$query = $this->db->query("SELECT * 
								   FROM starter_exam_questions
								   LEFT JOIN starter_phases ON
								   starter_phases.phase_id=starter_exam_questions.question_module_phase_id
								   LEFT JOIN starter_modules ON
								   starter_modules.module_id=starter_exam_questions.question_module_id
								   WHERE starter_exam_questions.question_id='$id'
								   AND starter_exam_questions.question_exam_type='$question_exam_type' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_phases()
	{
		$query = $this->db->query("SELECT * FROM starter_phases ORDER BY starter_phases.phase_id ASC");
		return $query->result_array();
	}
	
	public function get_phase_modules($phase_id)
	{
		$query = $this->db->query("SELECT 
								   * 
								   FROM starter_modules
								   WHERE starter_modules.module_phase_id='$phase_id' 
								   ORDER BY starter_modules.module_id ASC
								  ");
		return $query->result_array();
	}
	
	public function save_answers($data)
	{
		$this->db->insert('starter_questions_answers', $data);
	}
	
	public function get_answersby_question($question_id)
	{
		$query = $this->db->query("SELECT * FROM starter_questions_answers WHERE starter_questions_answers.answer_question_id='$question_id' ORDER BY answer_id ASC");
		return $query->result_array();
	}
	
	public function update_answers($anwer_id, $question_id, $data)
	{
		$this->db->where('answer_id', $anwer_id);
		$this->db->where('answer_question_id', $question_id);
		$this->db->update('starter_questions_answers', $data);
	}
	
	public function count_questions($src, $phaseLevel, $questionType)
	{
		$query = "SELECT * FROM starter_exam_questions ";
		if($src !== null)
		{
			$query .= "WHERE question_title LIKE '%$src%' AND starter_exam_questions.question_exam_type='Lesson' ";
		}else
		{
			$query .= "WHERE starter_exam_questions.question_exam_type='Lesson' ";
		}
		
		if($phaseLevel !== null)
		{
			if($phaseLevel !== 'All')
			{
				$query .= "AND starter_exam_questions.question_module_phase_id='$phaseLevel' ";
			}
		}
		
		if($questionType !== null)
		{
			if($questionType !== 'All')
			{
				$query .= "AND starter_exam_questions.question_type='$questionType' ";
			}
		}
		$result = $this->db->query($query);
		return $result->num_rows();
	}
	
	public function get_modules_questions($src, $sorting, $sortType='DESC', $phaseLevel, $questionType, $offset, $limit)
	{
		$query = "SELECT * FROM starter_exam_questions
				   LEFT JOIN starter_phases ON
				   starter_phases.phase_id=starter_exam_questions.question_module_phase_id
				   LEFT JOIN starter_modules ON
				   starter_modules.module_id=starter_exam_questions.question_module_id
				   LEFT JOIN starter_modules_lessons ON
				   starter_modules_lessons.lesson_id=starter_exam_questions.question_lesson_id
				   LEFT JOIN starter_owner ON
				   starter_owner.owner_id=starter_exam_questions.question_created_by ";
		
		if($src !== null)
		{
			$query .= "WHERE question_title LIKE '%$src%' AND starter_exam_questions.question_exam_type='Lesson' ";
		}else
		{
			$query .= "WHERE starter_exam_questions.question_exam_type='Lesson' ";
		}
		
		if($phaseLevel !== null)
		{
			if($phaseLevel !== 'All')
			{
				$query .= "AND starter_exam_questions.question_module_phase_id='$phaseLevel' ";
			}
		}
		
		if($questionType !== null)
		{
			if($questionType !== 'All')
			{
				$query .= "AND starter_exam_questions.question_type='$questionType' ";
			}
		}
		
		if($sortType !== 'DESC' || $sortType !== 'ASC')
		{
			$sortType = 'DESC';
		}
		
		if($sorting !== null)
		{
			if($sorting == 'title')
			{
				$query .= "ORDER BY starter_exam_questions.question_title $sortType ";
			}elseif($sorting == 'module')
			{
				$query .= "ORDER BY starter_exam_questions.question_module_id $sortType ";
			}elseif($sorting == 'phase')
			{
				$query .= "ORDER BY starter_exam_questions.question_module_phase_id $sortType ";
			}
		}else
		{
			$query .= "ORDER BY starter_exam_questions.question_id $sortType ";
		}
		
		$query .= "LIMIT {$offset},{$limit}";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	public function count_pca_questions($src, $phaseLevel, $questionType)
	{
		$query = "SELECT * FROM starter_exam_questions ";
		if($src !== null)
		{
			$query .= "WHERE question_title LIKE '%$src%' AND starter_exam_questions.question_exam_type='PCA' ";
		}else
		{
			$query .= "WHERE starter_exam_questions.question_exam_type='PCA' ";
		}
		
		if($phaseLevel !== null)
		{
			if($phaseLevel !== 'All')
			{
				$query .= "AND starter_exam_questions.question_module_phase_id='$phaseLevel' ";
			}
		}
		
		if($questionType !== null)
		{
			if($questionType !== 'All')
			{
				$query .= "AND starter_exam_questions.question_type='$questionType' ";
			}
		}
		$result = $this->db->query($query);
		return $result->num_rows();
	}
	
	public function get_pca_questions($src, $sorting, $sortType='DESC', $phaseLevel, $questionType, $offset, $limit)
	{
		$query = "SELECT * FROM starter_exam_questions
				   LEFT JOIN starter_phases ON
				   starter_phases.phase_id=starter_exam_questions.question_module_phase_id
				   LEFT JOIN starter_modules ON
				   starter_modules.module_id=starter_exam_questions.question_module_id
				   LEFT JOIN starter_modules_lessons ON
				   starter_modules_lessons.lesson_id=starter_exam_questions.question_lesson_id
				   LEFT JOIN starter_owner ON
				   starter_owner.owner_id=starter_exam_questions.question_created_by ";
		
		if($src !== null)
		{
			$query .= "WHERE question_title LIKE '%$src%' AND starter_exam_questions.question_exam_type='PCA' ";
		}else
		{
			$query .= "WHERE starter_exam_questions.question_exam_type='PCA' ";
		}
		
		if($phaseLevel !== null)
		{
			if($phaseLevel !== 'All')
			{
				$query .= "AND starter_exam_questions.question_module_phase_id='$phaseLevel' ";
			}
		}
		
		if($questionType !== null)
		{
			if($questionType !== 'All')
			{
				$query .= "AND starter_exam_questions.question_type='$questionType' ";
			}
		}
		
		if($sortType !== 'DESC' || $sortType !== 'ASC')
		{
			$sortType = 'DESC';
		}
		
		if($sorting !== null)
		{
			if($sorting == 'title')
			{
				$query .= "ORDER BY starter_exam_questions.question_title $sortType ";
			}elseif($sorting == 'module')
			{
				$query .= "ORDER BY starter_exam_questions.question_module_id $sortType ";
			}elseif($sorting == 'phase')
			{
				$query .= "ORDER BY starter_exam_questions.question_module_phase_id $sortType ";
			}
		}else
		{
			$query .= "ORDER BY starter_exam_questions.question_id $sortType ";
		}
		
		$query .= "LIMIT {$offset},{$limit}";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	/*----- ECE questions---------*/
	public function count_ece_questions($src, $phaseLevel, $questionType)
	{
		$query = "SELECT * FROM starter_exam_questions ";
		if($src !== null)
		{
			$query .= "WHERE question_title LIKE '%$src%' AND starter_exam_questions.question_exam_type='ece' ";
		}else
		{
			$query .= "WHERE starter_exam_questions.question_exam_type='ece' ";
		}
		
		if($phaseLevel !== null)
		{
			if($phaseLevel !== 'All')
			{
				$query .= "AND starter_exam_questions.question_module_phase_id='$phaseLevel' ";
			}
		}
		
		if($questionType !== null)
		{
			if($questionType !== 'All')
			{
				$query .= "AND starter_exam_questions.question_type='$questionType' ";
			}
		}
		$result = $this->db->query($query);
		return $result->num_rows();
	}
	public function get_ece_questions($src, $sorting, $sortType='DESC', $phaseLevel, $questionType, $offset, $limit)
	{
		$query = "SELECT * FROM starter_exam_questions
				   LEFT JOIN starter_phases ON
				   starter_phases.phase_id=starter_exam_questions.question_module_phase_id
				   LEFT JOIN starter_modules ON
				   starter_modules.module_id=starter_exam_questions.question_module_id
				   LEFT JOIN starter_modules_lessons ON
				   starter_modules_lessons.lesson_id=starter_exam_questions.question_lesson_id
				   LEFT JOIN starter_owner ON
				   starter_owner.owner_id=starter_exam_questions.question_created_by ";
		
		if($src !== null)
		{
			$query .= "WHERE question_title LIKE '%$src%' AND starter_exam_questions.question_exam_type='ece' ";
		}else
		{
			$query .= "WHERE starter_exam_questions.question_exam_type='ece' ";
		}
		
		if($phaseLevel !== null)
		{
			if($phaseLevel !== 'All')
			{
				$query .= "AND starter_exam_questions.question_module_phase_id='$phaseLevel' ";
			}
		}
		
		if($questionType !== null)
		{
			if($questionType !== 'All')
			{
				$query .= "AND starter_exam_questions.question_type='$questionType' ";
			}
		}
		
		if($sortType !== 'DESC' || $sortType !== 'ASC')
		{
			$sortType = 'DESC';
		}
		
		if($sorting !== null)
		{
			if($sorting == 'title')
			{
				$query .= "ORDER BY starter_exam_questions.question_title $sortType ";
			}elseif($sorting == 'module')
			{
				$query .= "ORDER BY starter_exam_questions.question_module_id $sortType ";
			}elseif($sorting == 'phase')
			{
				$query .= "ORDER BY starter_exam_questions.question_module_phase_id $sortType ";
			}
		}else
		{
			$query .= "ORDER BY starter_exam_questions.question_id $sortType ";
		}
		
		$query .= "LIMIT {$offset},{$limit}";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	public function get_module_lessons($module_id)
	{
		$query = $this->db->query("SELECT lesson_id, lesson_title FROM starter_modules_lessons WHERE starter_modules_lessons.lesson_module_id='$module_id' ORDER BY lesson_id ASC");
		return $query->result_array();
	}
	
	
}