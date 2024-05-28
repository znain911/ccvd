<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_model extends CI_Model{
	
	public function get_order_items($order_id)
	{
		$query = $this->db->query("SELECT starter_orders_details.details_item_quantity, starter_orders_details.details_item_unitprice, starter_shop_products.product_title 
								   FROM starter_orders_details
								   LEFT JOIN starter_shop_products ON
								   starter_shop_products.product_id=starter_orders_details.details_item_id
								   WHERE starter_orders_details.details_orderid='$order_id'
								  ");
		return $query->result_array();
	}
	
	public function update_ordertbl($order_id, $user_id, $data)
	{
		$this->db->where('order_id', $order_id);
		$this->db->where('order_userid', $user_id);
		$this->db->update('starter_users_orders', $data);
	}
	
	public function get_discountif($order_id)
	{
		$query = $this->db->query("SELECT order_applied_coupon, order_coupon_discount FROM starter_users_orders WHERE starter_users_orders.order_id='$order_id'");
		return $query->row_array();
	}
	
	public function get_payment_config()
	{
		$query = $this->db->query("SELECT pconfig_course_fee FROM starter_payment_config WHERE starter_payment_config.pconfig_key='One_Time' LIMIT 1");
		return $query->row_array();
	}
	
	public function student_basic_info($student_portid)
	{
		$query = $this->db->query("SELECT * 
								   FROM starter_students 
								   LEFT JOIN starter_students_personalinfo ON
								   starter_students_personalinfo.spinfo_student_id=starter_students.student_id
								   WHERE starter_students.student_portid='$student_portid' LIMIT 1");
		return $query->row_array();
	}
	
	public function save_online_pdetails($data)
	{
		$this->db->insert('starter_online_payments', $data);
	}
	
}