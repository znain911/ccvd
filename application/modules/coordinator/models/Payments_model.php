<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payments_model extends CI_Model {
	
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
								   ORDER BY starter_ipn.ipn_id DESC");
		return $query->result_array();
	}
	
	public function count_onlinepayment_info()
	{
		$query = $this->db->query("SELECT onpay_id FROM starter_online_payments");
		return $query->result_array();
	}
	
	/*public function get_onlinepayment_info()
	{
		$query = $this->db->query("SELECT * FROM starter_online_payments GROUP BY onpay_transaction_id ORDER BY onpay_id DESC");
		return $query->result_array();
	}*/

	public function get_onlinepayment_info()
	{
		$this -> db -> select('*');
		$this -> db -> from('starter_online_payments');
		/* $this -> db -> group_by('onpay_transaction_id'); */
		$this -> db -> order_by('onpay_id', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function count_depositpayment_info()
	{
		$query = $this->db->query("SELECT deposit_id FROM starter_deposit_payments");
		return $query->result_array();
	}
	
	public function get_depositpayment_info()
	{
		$query = $this->db->query("SELECT * FROM starter_deposit_payments ORDER BY deposit_id DESC");
		return $query->result_array();
	}
	
	public function student_name($entryid)
	{
		$query = $this->db->query("SELECT 
								   starter_students.student_id,
								   starter_students_personalinfo.spinfo_first_name,
								   starter_students_personalinfo.spinfo_middle_name,
								   starter_students_personalinfo.spinfo_last_name
								   FROM starter_students
								   LEFT JOIN starter_students_personalinfo ON
								   starter_students_personalinfo.spinfo_student_id=starter_students.student_id
								   WHERE starter_students.student_entryid='$entryid'
								   LIMIT 1
								  ");
		$result = $query->row_array();
		return $result['spinfo_first_name'].' '.$result['spinfo_middle_name'].' '.$result['spinfo_last_name'];
	}
	
	/*public function total_online_transaction()
	{
		$query = $this->db->query("SELECT onpay_id FROM starter_online_payments WHERE onpay_has_deleted='NO' GROUP BY onpay_transaction_id");
		return $query->num_rows();
	}*/

	public function total_online_transaction()
	{
		$this -> db -> select('onpay_id');
		$this -> db -> from('starter_online_payments');
		$this -> db -> where('onpay_has_deleted', 'NO');
		/* $this -> db -> group_by('onpay_transaction_id'); */
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	public function total_transaction_amount()
	{
		$query = $this->db->query("SELECT SUM(onpay_transaction_amount) AS total_amount FROM starter_online_payments WHERE onpay_has_deleted='NO'");
		$result = $query->row_array();
		if($result['total_amount'])
		{
			$total_amount = $result['total_amount'];
		}else
		{
			$total_amount = 0;
		}
		return $total_amount;
	}
	
	public function total_deposit_transaction()
	{
		$query = $this->db->query("SELECT deposit_id FROM starter_deposit_payments WHERE deposit_has_deleted ='NO'");
		return $query->num_rows();
	}
	
	public function total_deposit_transaction_amount()
	{
		$query = $this->db->query("SELECT SUM(deposit_amount) AS total_amount FROM starter_deposit_payments WHERE deposit_has_deleted ='NO'");
		$result = $query->row_array();
		if($result['total_amount'])
		{
			$total_amount = $result['total_amount'];
		}else
		{
			$total_amount = 0;
		}
		return $total_amount;
	}

	public function get_onlinepayment_detail_info()
	{
		$query = $this->db->query("SELECT 
								   starter_online_payments.*, 
								   starter_students.student_id,
								   starter_students.student_entryid,
								   starter_students.batch_name,
								   starter_students.student_email,
								   starter_students.student_regdate,
								   starter_students_personalinfo.spinfo_photo,
								   starter_students_personalinfo.spinfo_first_name,
								   starter_students_personalinfo.spinfo_middle_name,
								   starter_students_personalinfo.spinfo_last_name,
								   starter_students_personalinfo.spinfo_personal_phone,
								   starter_students_personalinfo.spinfo_current_address,
								   starter_students_personalinfo.spinfo_permanent_address,
								   starter_students_professionalinfo.spsinfo_bmanddc_number
								   FROM starter_online_payments
								   LEFT JOIN starter_students ON 
								   starter_students.student_entryid = starter_online_payments.onpay_student_entryid
								   LEFT JOIN starter_students_personalinfo ON
								   starter_students_personalinfo.spinfo_student_id=starter_students.student_id
								   LEFT JOIN starter_students_professionalinfo ON
								   starter_students_professionalinfo.spsinfo_student_id=starter_students.student_id	
								   								
								  ");
		
		/*$query = $this->db->query("SELECT * FROM starter_online_payments ORDER BY onpay_id DESC");*/
		return $query->result_array();
	}

	public function get_onlinepayment_detail_infobatch($batch)
	{
		$query = $this->db->query("SELECT 
								   starter_online_payments.*, 
								   starter_students.student_id,
								   starter_students.student_entryid,
								   starter_students.batch_name,
								   starter_students.student_email,
								   starter_students.student_regdate,
								   starter_students_personalinfo.spinfo_photo,
								   starter_students_personalinfo.spinfo_first_name,
								   starter_students_personalinfo.spinfo_middle_name,
								   starter_students_personalinfo.spinfo_last_name,
								   starter_students_personalinfo.spinfo_personal_phone,
								   starter_students_personalinfo.spinfo_current_address,
								   starter_students_personalinfo.spinfo_permanent_address,
								   starter_students_professionalinfo.spsinfo_bmanddc_number
								   FROM starter_online_payments
								   LEFT JOIN starter_students ON 
								   starter_students.student_entryid = starter_online_payments.onpay_student_entryid
								   LEFT JOIN starter_students_personalinfo ON
								   starter_students_personalinfo.spinfo_student_id=starter_students.student_id
								   LEFT JOIN starter_students_professionalinfo ON
								   starter_students_professionalinfo.spsinfo_student_id=starter_students.student_id	
								   WHERE starter_students.batch_name = '$batch' 								
								  ");
		
		/*$query = $this->db->query("SELECT * FROM starter_online_payments ORDER BY onpay_id DESC");*/
		return $query->result_array();
	}

	public function get_depositpayment_detail_info()
	{
		$query = $this->db->query("SELECT 
								   starter_deposit_payments.*, 
								   starter_students.student_id,
								   starter_students.batch_name,
								   starter_students.student_email,
								   starter_students.student_regdate,
								   starter_students_personalinfo.spinfo_photo,
								   starter_students_personalinfo.spinfo_first_name,
								   starter_students_personalinfo.spinfo_middle_name,
								   starter_students_personalinfo.spinfo_last_name,
								   starter_students_personalinfo.spinfo_personal_phone,
								   starter_students_personalinfo.spinfo_current_address,
								   starter_students_personalinfo.spinfo_permanent_address,
								   starter_students_professionalinfo.spsinfo_bmanddc_number
								   FROM starter_deposit_payments
								   LEFT JOIN starter_students ON 
								   starter_students.student_entryid=starter_deposit_payments.deposit_student_entryid
								   LEFT JOIN starter_students_personalinfo ON
								   starter_students_personalinfo.spinfo_student_id=starter_students.student_id
								   LEFT JOIN starter_students_professionalinfo ON
								   starter_students_professionalinfo.spsinfo_student_id=starter_students.student_id									
								  ");
		return $query->result_array();
	}

	public function get_depositpayment_detail_infobatch($batch)
	{
		$query = $this->db->query("SELECT 
								   starter_deposit_payments.*, 
								   starter_students.student_id,
								   starter_students.batch_name,
								   starter_students.student_email,
								   starter_students.student_regdate,
								   starter_students_personalinfo.spinfo_photo,
								   starter_students_personalinfo.spinfo_first_name,
								   starter_students_personalinfo.spinfo_middle_name,
								   starter_students_personalinfo.spinfo_last_name,
								   starter_students_personalinfo.spinfo_personal_phone,
								   starter_students_personalinfo.spinfo_current_address,
								   starter_students_personalinfo.spinfo_permanent_address,
								   starter_students_professionalinfo.spsinfo_bmanddc_number
								   FROM starter_deposit_payments
								   LEFT JOIN starter_students ON 
								   starter_students.student_entryid=starter_deposit_payments.deposit_student_entryid
								   LEFT JOIN starter_students_personalinfo ON
								   starter_students_personalinfo.spinfo_student_id=starter_students.student_id
								   LEFT JOIN starter_students_professionalinfo ON
								   starter_students_professionalinfo.spsinfo_student_id=starter_students.student_id	
								   WHERE starter_students.batch_name = '$batch'								
								  ");
		return $query->result_array();
	}

	public function getBatch()
	{
		$this -> db -> select('*');
		$this -> db -> from('ccvd_batch');
		$this -> db -> order_by('batch_name', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
}
