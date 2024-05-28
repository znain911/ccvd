<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {
	
	public function get_payment_details($payment_type)
	{
		$query = $this->db->query("SELECT 
								   starter_ipn.*,
								   starter_students.student_entryid,
								   starter_students_personalinfo.spinfo_first_name,
								   starter_students_personalinfo.spinfo_middle_name,
								   starter_students_personalinfo.spinfo_last_name
								   FROM starter_ipn
								   LEFT JOIN starter_students ON
								   starter_students.student_id=starter_ipn.ipn_student_id
								   LEFT JOIN starter_students_personalinfo ON
								   starter_students_personalinfo.spinfo_student_id=starter_ipn.ipn_student_id
								   WHERE starter_ipn.payment_type='$payment_type' 
								   ORDER BY starter_ipn.ipn_id DESC
								   LIMIT 10
								   ");
		return $query->result_array();
	}
	
	public function pending_students()
	{
		$query = $this->db->query("SELECT student_id FROM starter_students WHERE starter_students.student_status=0");
		return $query->num_rows();
	}
	
	public function enrolled_students()
	{
		$query = $this->db->query("SELECT student_id FROM starter_students WHERE starter_students.student_status=1");
		return $query->num_rows();
	}
	
	
	public function pending_faculties()
	{
		$query = $this->db->query("SELECT teacher_id FROM starter_teachers WHERE starter_teachers.teacher_status=0");
		return $query->num_rows();
	}
	
	public function enrolled_faculties()
	{
		$query = $this->db->query("SELECT teacher_id FROM starter_teachers WHERE starter_teachers.teacher_status=1");
		return $query->num_rows();
	}
	
	public function collected_course_fee($year)
	{
		$query = $this->db->query("SELECT SUM(amount) AS total_amount FROM starter_ipn 
						           WHERE starter_ipn.payment_type='COURSE'
						           AND paid_date LIKE '%$year%'
								  ");
		$result = $query->row_array();
		if($result['total_amount'])
		{
			$amount = $result['total_amount'];
		}else
		{
			$amount = 0;
		}
		return $amount;
	}
	
	public function collected_retake_fee($year)
	{
		$query = $this->db->query("SELECT SUM(amount) AS total_amount FROM starter_ipn 
							       WHERE starter_ipn.payment_type='RETAKE'
							       AND paid_date LIKE '%$year%'
								   ");
		$result = $query->row_array();
		if($result['total_amount'])
		{
			$amount = $result['total_amount'];
		}else
		{
			$amount = 0;
		}
		return $amount;
	}
	
	public function total_students_joined($year)
	{
		$query = $this->db->query("SELECT student_id FROM starter_students WHERE student_regdate LIKE '%$year%'");
		return $query->num_rows();
	}
	
	public function total_students_passed($year)
	{
		$query = $this->db->query("SELECT cpreport_id FROM starter_ece_progress 
									WHERE starter_ece_progress.cpreport_status=1
									AND cpreport_create_date LIKE '%$year%'
								  ");
		return $query->num_rows();
	}
	
	public function total_students_failed($year)
	{
		$query = $this->db->query("SELECT cpreport_id FROM starter_ece_progress 
									WHERE starter_ece_progress.cpreport_status=0
									AND cpreport_create_date LIKE '%$year%'
								  ");
		return $query->num_rows();
	}
	
	public function total_students_phase($phase_id)
	{
		$query = $this->db->query("SELECT student_id FROM starter_students 
								   WHERE starter_students.student_phaselevel_id='$phase_id'
								  ");
		return $query->num_rows();
	}
	
	
}
