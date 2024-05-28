<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paymentapi_model extends CI_Model {
	
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
	
	public function count_onlinepayment_info($params = array())
	{
		$query = "SELECT starter_online_payments.onpay_id FROM starter_online_payments LEFT JOIN starter_students ON	starter_online_payments.onpay_student_entryid = starter_students.student_entryid ";
		$query .= "WHERE starter_online_payments.onpay_has_deleted='NO' ";
		if(!empty($params['search']['from_date']) && !empty($params['search']['to_date'])){
			$from_date = $params['search']['from_date'];
			$to_date = $params['search']['to_date'];
			$query .= "AND starter_online_payments.onpay_transaction_date>='$from_date' AND starter_online_payments.onpay_transaction_date <='$to_date' ";
        }
		if(!empty($params['search']['month']) && !empty($params['search']['year']))
		{
			$month = $params['search']['month'];
			$year = $params['search']['year'];
			$make_date = $year.'-'.$month.'-';
			$query .= "AND starter_online_payments.onpay_transaction_date LIKE '%$make_date%' ";
		}else if(!empty($params['search']['month']) && empty($params['search']['year'])){
			$month = $params['search']['month'];
			$make_date = '-'.$month.'-';
			$query .= "AND starter_online_payments.onpay_transaction_date LIKE '%$make_date%' ";
		}else if(empty($params['search']['month']) && !empty($params['search']['year'])){
			$year = $params['search']['year'];
			$make_date = $year.'-';
			$query .= "AND starter_online_payments.onpay_transaction_date LIKE '%$make_date%' ";
		}
		if(!empty($params['search']['keywords'])){
			$search_term = $params['search']['keywords'];
			$query .= "AND (starter_online_payments.onpay_account LIKE '%$search_term%' ";
			$query .= "OR starter_online_payments.onpay_student_entryid LIKE '%$search_term%' ";
			$query .= "OR starter_online_payments.onpay_transaction_id LIKE '%$search_term%' ";
			$query .= "OR starter_online_payments.onpay_transaction_amount LIKE '%$search_term%') ";
        }
        if(!empty($params['search']['batch'])){
			$batchno = $params['search']['batch'] ;
			$query .= " AND starter_students.batch_name=$batchno " ;
		}
		$result = $this->db->query($query);
		return $result->num_rows();
	}
	
	public function count_onlinepayment_totalamount($params = array())
	{
		$query = "SELECT SUM(starter_online_payments.onpay_transaction_amount) AS total_amount FROM starter_online_payments LEFT JOIN starter_students ON	starter_online_payments.onpay_student_entryid = starter_students.student_entryid ";
		$query .= "WHERE starter_online_payments.onpay_has_deleted='NO' ";
		if(!empty($params['search']['from_date']) && !empty($params['search']['to_date'])){
			$from_date = $params['search']['from_date'];
			$to_date = $params['search']['to_date'];
			$query .= "AND starter_online_payments.onpay_transaction_date>='$from_date' AND starter_online_payments.onpay_transaction_date <='$to_date' ";
        }
		if(!empty($params['search']['month']) && !empty($params['search']['year']))
		{
			$month = $params['search']['month'];
			$year = $params['search']['year'];
			$make_date = $year.'-'.$month.'-';
			$query .= "AND starter_online_payments.onpay_transaction_date LIKE '%$make_date%' ";
		}else if(!empty($params['search']['month']) && empty($params['search']['year'])){
			$month = $params['search']['month'];
			$make_date = '-'.$month.'-';
			$query .= "AND starter_online_payments.onpay_transaction_date LIKE '%$make_date%' ";
		}else if(empty($params['search']['month']) && !empty($params['search']['year'])){
			$year = $params['search']['year'];
			$make_date = $year.'-';
			$query .= "AND starter_online_payments.onpay_transaction_date LIKE '%$make_date%' ";
		}
		if(!empty($params['search']['keywords'])){
			$search_term = $params['search']['keywords'];
			$query .= "AND (starter_online_payments.onpay_account LIKE '%$search_term%' ";
			$query .= "OR starter_online_payments.onpay_student_entryid LIKE '%$search_term%' ";
			$query .= "OR starter_online_payments.onpay_transaction_id LIKE '%$search_term%' ";
			$query .= "OR starter_online_payments.onpay_transaction_amount LIKE '%$search_term%') ";
        }
        if(!empty($params['search']['batch'])){
			$batchno = $params['search']['batch'] ;
			$query .= " AND starter_students.batch_name=$batchno " ;
		}
		$result = $this->db->query($query);
		$the_amount = $result->row_array();
		if($the_amount['total_amount'])
		{
			$amount = $the_amount['total_amount'];
		}else
		{
			$amount = 0;
		}
		
		return $amount;
	}
	
	public function count_depositpayment_totalamount($params = array())
	{
		$query = "SELECT SUM(starter_deposit_payments.deposit_amount) AS total_amount FROM starter_deposit_payments LEFT JOIN starter_students ON starter_deposit_payments.deposit_student_entryid = starter_students.student_entryid ";
		$query .= "WHERE starter_deposit_payments.deposit_has_deleted='NO' ";
		if(!empty($params['search']['from_date']) && !empty($params['search']['to_date'])){
			$from_date = $params['search']['from_date'];
			$to_date = $params['search']['to_date'];
			$query .= "AND starter_deposit_payments.deposit_submit_date>='$from_date' AND starter_deposit_payments.deposit_submit_date <='$to_date' ";
        }
		
		if(!empty($params['search']['month']) && !empty($params['search']['year']))
		{
			$month = $params['search']['month'];
			$year = $params['search']['year'];
			$make_date = $year.'-'.$month.'-';
			$query .= "AND starter_deposit_payments.deposit_submit_date LIKE '%$make_date%' ";
		}else if(!empty($params['search']['month']) && empty($params['search']['year'])){
			$month = $params['search']['month'];
			$make_date = '-'.$month.'-';
			$query .= "AND starter_deposit_payments.deposit_submit_date LIKE '%$make_date%' ";
		}else if(empty($params['search']['month']) && !empty($params['search']['year'])){
			$year = $params['search']['year'];
			$make_date = $year.'-';
			$query .= "AND starter_deposit_payments.deposit_submit_date LIKE '%$make_date%' ";
		}

		if(!empty($params['search']['batch'])){
			$batchno = $params['search']['batch'] ;
			$query .= " AND starter_students.batch_name=$batchno " ;
		}
		
		if(!empty($params['search']['keywords'])){
			$search_term = $params['search']['keywords'];
			$query .= "AND (starter_deposit_payments.deposit_student_entryid LIKE '%$search_term%' ";
			$query .= "OR starter_deposit_payments.deposit_amount LIKE '%$search_term%' ";
			$query .= "OR starter_deposit_payments.deposit_account_number LIKE '%$search_term%') ";
        }
		$result = $this->db->query($query);
		$the_amount = $result->row_array();
		if($the_amount['total_amount'])
		{
			$amount = $the_amount['total_amount'];
		}else
		{
			$amount = 0;
		}
		
		return $amount;
	}
	
	public function get_onlinepayment_info($params = array())
	{
		$query = "SELECT starter_online_payments.*, starter_students.student_entryid FROM starter_online_payments LEFT JOIN starter_students ON
				  starter_online_payments.onpay_student_entryid = starter_students.student_entryid ";
		$query .= "WHERE starter_online_payments.onpay_has_deleted='NO' ";
		if(!empty($params['search']['from_date']) && !empty($params['search']['to_date'])){
			$from_date = $params['search']['from_date'];
			$to_date = $params['search']['to_date'];
			$query .= "AND starter_online_payments.onpay_transaction_date>='$from_date' AND starter_online_payments.onpay_transaction_date <='$to_date' ";
        }
		
		if(!empty($params['search']['month']) && !empty($params['search']['year']))
		{
			$month = $params['search']['month'];
			$year = $params['search']['year'];
			$make_date = $year.'-'.$month.'-';
			$query .= "AND starter_online_payments.onpay_transaction_date LIKE '%$make_date%' ";
		}else if(!empty($params['search']['month']) && empty($params['search']['year'])){
			$month = $params['search']['month'];
			$make_date = '-'.$month.'-';
			$query .= "AND starter_online_payments.onpay_transaction_date LIKE '%$make_date%' ";
		}else if(empty($params['search']['month']) && !empty($params['search']['year'])){
			$year = $params['search']['year'];
			$make_date = $year.'-';
			$query .= "AND starter_online_payments.onpay_transaction_date LIKE '%$make_date%' ";
		}
		if(!empty($params['search']['batch'])){
			$batchno = $params['search']['batch'] ;
			$query .= " AND starter_students.batch_name=$batchno " ;
		}
		
		if(!empty($params['search']['keywords'])){
			$search_term = $params['search']['keywords'];
			$query .= "AND (starter_online_payments.onpay_account LIKE '%$search_term%' ";
			$query .= "OR starter_online_payments.onpay_student_entryid LIKE '%$search_term%' ";
			$query .= "OR starter_online_payments.onpay_transaction_id LIKE '%$search_term%' ";
			$query .= "OR starter_online_payments.onpay_transaction_amount LIKE '%$search_term%') ";
        }
		
		if(!empty($params['search']['sortby'])){
			$sortby = $params['search']['sortby'];
			$query .= "ORDER BY starter_online_payments.onpay_id $sortby ";
		}else
		{
			$query .= "ORDER BY starter_online_payments.onpay_id DESC ";
		}
		if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
			$start = $params['start'];
			$query .= "LIMIT {$start},{$limit} ";
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
            $query .= "LIMIT {$limit} ";
        }
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	public function count_depositpayment_info($params = array())
	{
		$query = "SELECT starter_deposit_payments.deposit_id FROM starter_deposit_payments LEFT JOIN starter_students ON starter_deposit_payments.deposit_student_entryid = starter_students.student_entryid ";
		$query .= "WHERE starter_deposit_payments.deposit_has_deleted='NO' ";
		if(!empty($params['search']['from_date']) && !empty($params['search']['to_date'])){
			$from_date = $params['search']['from_date'];
			$to_date = $params['search']['to_date'];
			$query .= "AND starter_deposit_payments.deposit_submit_date>='$from_date' AND starter_deposit_payments.deposit_submit_date <='$to_date' ";
        }
		
		if(!empty($params['search']['month']) && !empty($params['search']['year']))
		{
			$month = $params['search']['month'];
			$year = $params['search']['year'];
			$make_date = $year.'-'.$month.'-';
			$query .= "AND starter_deposit_payments.deposit_submit_date LIKE '%$make_date%' ";
		}else if(!empty($params['search']['month']) && empty($params['search']['year'])){
			$month = $params['search']['month'];
			$make_date = '-'.$month.'-';
			$query .= "AND starter_deposit_payments.deposit_submit_date LIKE '%$make_date%' ";
		}else if(empty($params['search']['month']) && !empty($params['search']['year'])){
			$year = $params['search']['year'];
			$make_date = $year.'-';
			$query .= "AND starter_deposit_payments.deposit_submit_date LIKE '%$make_date%' ";
		}

		if(!empty($params['search']['batch'])){
			$batchno = $params['search']['batch'] ;
			$query .= " AND starter_students.batch_name=$batchno " ;
		}
		
		if(!empty($params['search']['keywords'])){
			$search_term = $params['search']['keywords'];
			$query .= "AND (starter_deposit_payments.deposit_student_entryid LIKE '%$search_term%' ";
			$query .= "OR starter_deposit_payments.deposit_amount LIKE '%$search_term%' ";
			$query .= "OR starter_deposit_payments.deposit_account_number LIKE '%$search_term%') ";
        }
		$result = $this->db->query($query);
		return $result->num_rows();
	}
	
	public function get_depositpayment_info($params = array())
	{
		$query = "SELECT starter_deposit_payments.*, starter_students.student_entryid FROM starter_deposit_payments LEFT JOIN starter_students ON starter_deposit_payments.deposit_student_entryid = starter_students.student_entryid ";
		$query .= "WHERE starter_deposit_payments.deposit_has_deleted='NO' ";
		if(!empty($params['search']['from_date']) && !empty($params['search']['to_date'])){
			$from_date = $params['search']['from_date'];
			$to_date = $params['search']['to_date'];
			$query .= "AND starter_deposit_payments.deposit_submit_date>='$from_date' AND starter_deposit_payments.deposit_submit_date <='$to_date' ";
        }
		
		if(!empty($params['search']['month']) && !empty($params['search']['year']))
		{
			$month = $params['search']['month'];
			$year = $params['search']['year'];
			$make_date = $year.'-'.$month.'-';
			$query .= "AND starter_deposit_payments.deposit_submit_date LIKE '%$make_date%' ";
		}else if(!empty($params['search']['month']) && empty($params['search']['year'])){
			$month = $params['search']['month'];
			$make_date = '-'.$month.'-';
			$query .= "AND starter_deposit_payments.deposit_submit_date LIKE '%$make_date%' ";
		}else if(empty($params['search']['month']) && !empty($params['search']['year'])){
			$year = $params['search']['year'];
			$make_date = $year.'-';
			$query .= "AND starter_deposit_payments.deposit_submit_date LIKE '%$make_date%' ";
		}

		if(!empty($params['search']['batch'])){
			$batchno = $params['search']['batch'] ;
			$query .= " AND starter_students.batch_name=$batchno " ;
		}
		
		if(!empty($params['search']['keywords'])){
			$search_term = $params['search']['keywords'];
			$query .= "AND (starter_deposit_payments.deposit_student_entryid LIKE '%$search_term%' ";
			$query .= "OR starter_deposit_payments.deposit_amount LIKE '%$search_term%' ";
			$query .= "OR starter_deposit_payments.deposit_account_number LIKE '%$search_term%') ";
        }
		if(!empty($params['search']['sortby'])){
			$sortby = $params['search']['sortby'];
			$query .= "ORDER BY starter_deposit_payments.deposit_id $sortby ";
		}else
		{
			$query .= "ORDER BY starter_deposit_payments.deposit_id DESC ";
		}
		if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
			$start = $params['start'];
			$query .= "LIMIT {$start},{$limit} ";
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
            $query .= "LIMIT {$limit} ";
        }
		
		$result = $this->db->query($query);
		return $result->result_array();
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
	
}
