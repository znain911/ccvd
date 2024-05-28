<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Online extends CI_Controller{
	
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Dhaka');
		$this->load->model('Payment_model');
	}
	
	public function pay()
	{
		$payment_amount = $this->Payment_model->get_payment_config();
		
		$post_data = array();
		/*$post_data['store_id'] = "ibrah5e2bedfd466b3";
		$post_data['store_passwd'] = "ibrah5e2bedfd466b3@ssl";*/
		//$post_data['total_amount'] = 20;
		$post_data['store_id'] = "ccvd";
		$post_data['signature_key'] = "8ccd8c71bd6e6743d4772f92c62707cf";
		$post_data['amount'] = $payment_amount['pconfig_course_fee'];
		$post_data['currency'] = "BDT";
		$post_data['tran_id'] = "ECCVD_".uniqid();
		$post_data['success_url'] = 'https://ccvd.ibrahimcardiac.org.bd/student/onboard/success?type=online&SID='.sha1($this->session->userdata('customer_additional')).'&SUCCESS=TRUE&ADDITIONAL=TRUE';
		$post_data['fail_url'] = 'https://ccvd.ibrahimcardiac.org.bd/student/onboard/cancel?type=online&SID='.sha1($this->session->userdata('customer_additional')).'&CANCEL=TRUE&ADDITIONAL=FALSE';
		$post_data['cancel_url'] = 'https://ccvd.ibrahimcardiac.org.bd/student/onboard/cancel?type=online&SID='.sha1($this->session->userdata('customer_additional')).'&CANCEL=TRUE&ADDITIONAL=FALSE';
		
		//customer information sending
		
		$post_data['cus_name'] = $this->session->userdata('customer_name');
		$post_data['cus_email'] = $this->session->userdata('customer_email');
		$post_data['cus_phone'] = $this->session->userdata('customer_phone');
		$post_data['opt_a'] = $this->session->userdata('customer_additional');
		$post_data['opt_b'] = $this->session->userdata('payment_fr');
		$post_data['opt_c'] = $payment_amount['pconfig_course_fee'];


		$post_data['ship_name'] = "Store Test";
		$post_data['ship_add1 '] = "Dhaka";
		$post_data['ship_add2'] = "Dhaka";
		$post_data['ship_city'] = "Dhaka";
		$post_data['ship_state'] = "Dhaka";
		$post_data['ship_postcode'] = "1000";
		$post_data['ship_country'] = "Bangladesh";
		$post_data['cus_city'] = "Dhaka";
		$post_data['cus_state'] = "Dhaka";
		$post_data['cus_postcode'] = "1000";
		$post_data['cus_country'] = "Bangladesh";
		$post_data['desc'] = "Test";
		
		# $post_data['multi_card_name'] = "mastercard,visacard,amexcard";  # DISABLE TO DISPLAY ALL AVAILABLE

		# EMI INFO
		/*
		$post_data['emi_option'] = "1";
		$post_data['emi_max_inst_option'] = "9";
		$post_data['emi_selected_inst'] = "9";
		*/

		# CUSTOMER INFORMATION
		/*
		$post_data['cus_name'] = "Test Customer";
		$post_data['cus_email'] = "test@test.com";
		$post_data['cus_add1'] = "Dhaka";
		$post_data['cus_add2'] = "Dhaka";
		$post_data['cus_city'] = "Dhaka";
		$post_data['cus_state'] = "Dhaka";
		$post_data['cus_postcode'] = "1000";
		$post_data['cus_country'] = "Bangladesh";
		$post_data['cus_phone'] = "01711111111";
		$post_data['cus_fax'] = "01711111111";
		*/

		# SHIPMENT INFORMATION
		/*
		$post_data['ship_name'] = "Store Test";
		$post_data['ship_add1 '] = "Dhaka";
		$post_data['ship_add2'] = "Dhaka";
		$post_data['ship_city'] = "Dhaka";
		$post_data['ship_state'] = "Dhaka";
		$post_data['ship_postcode'] = "1000";
		$post_data['ship_country'] = "Bangladesh";
		*/

		# OPTIONAL PARAMETERS
		//$post_data['value_a'] = 304019;
		/*
		$post_data['value_b'] = "ref002";
		$post_data['value_c'] = "ref003";
		$post_data['value_d'] = "ref004";
		*/

		# CART PARAMETERS
		/*
		$post_data['cart'] = json_encode(array(
			array("product"=>"DHK TO BRS AC A1","amount"=>"200.00"),
			array("product"=>"DHK TO BRS AC A2","amount"=>"200.00"),
			array("product"=>"DHK TO BRS AC A3","amount"=>"200.00"),
			array("product"=>"DHK TO BRS AC A4","amount"=>"200.00")    
		));
		*/
		/*
		$post_data['product_amount'] = "100";
		$post_data['vat'] = "5";
		$post_data['discount_amount'] = "5";
		$post_data['convenience_fee'] = "3";
		*/
		
		# REQUEST SEND TO SSLCOMMERZ
		$direct_api_url = "https://securepay.easypayway.com/payment/request.php";
		/*$direct_api_url = "https://securepay.sslcommerz.com/gwprocess/v3/api.php";*/

		$handle = curl_init();
		curl_setopt($handle, CURLOPT_URL, $direct_api_url );
		curl_setopt($handle, CURLOPT_TIMEOUT, 30);
		curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($handle, CURLOPT_POST, 1);
		curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE); # KEEP IT FALSE IF YOU RUN FROM LOCAL PC


		$content = curl_exec($handle );

		$code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

		if($code == 200 && !( curl_errno($handle))) {
			curl_close( $handle);
			/*$sslcommerzResponse = $content;*/
			echo "<meta http-equiv='refresh' content='0;url=".$content."'>";
			//# header("Location: ". $sslcz['GatewayPageURL']);
			exit;
		} else {
			curl_close( $handle);
			echo "FAILED TO CONNECT WITH SSLCOMMERZ API";
			exit;
		}

		# PARSE THE JSON RESPONSE
		/*$sslcz = json_decode($sslcommerzResponse, true );

		if(isset($sslcz['GatewayPageURL']) && $sslcz['GatewayPageURL']!="" ) {
			//# THERE ARE MANY WAYS TO REDIRECT - Javascript, Meta Tag or Php Header Redirect or Other
				//# echo "<script>window.location.href = '". $sslcz['GatewayPageURL'] ."';</script>";
			echo "<meta http-equiv='refresh' content='0;url=".$sslcz['GatewayPageURL']."'>";
			//# header("Location: ". $sslcz['GatewayPageURL']);
			exit;
		} else {
			echo "JSON Data parsing error!";
		}*/
	}
	
	public function paidinfo()
	{
		$ipn_array = array(
						'date_time'               => $_POST['tran_date'],
						'transaction_id'          => $_POST['tran_id'],
						'bank'                    => $_POST['card_issuer'],
						'ipn_student_id'          => $_POST['value_a'],
						'amount'                  => $_POST['amount'],
						'card_type'               => $_POST['card_type'],
						'card_number'             => $_POST['card_no'],
						'card_name'               => $_POST['card_brand'],
						'issuer_bank_or_country	' => $_POST['card_issuer_country'],
						'ip_address'              => $this->input->ip_address(),
						'status'                  => $_POST['status'],
					);
		$this->db->insert('starter_ipn', $ipn_array);
		
		if($_POST['status'] === 'VALID')
		{
			//save students online payment details
			$p_details = array(
							'onpay_student_entryid' => $_POST['value_a'],
							'onpay_account' => $_POST['value_b'],
							'onpay_transaction_id' => $_POST['tran_id'],
							'onpay_transaction_date' => $_POST['tran_date'],
							'onpay_transaction_amount' => $_POST['amount'],
							'onpay_transaction_status' => 'Paid',
							'onpay_create_date' => date("Y-m-d H:i:s"),
						);
			$this->Payment_model->save_online_pdetails($p_details);
			
			
		$get_studentinfo = $this->Payment_model->student_basic_info(sha1($_POST['value_a']));
		
		//set to enrolled
		$this->db->where('student_id', $get_studentinfo['student_id']);
		$this->db->update('starter_students', array('student_enrolled' => 1));
		
		$phone_number = $get_studentinfo['spinfo_personal_phone'];
		$name = $get_studentinfo['spinfo_first_name'].' '.$get_studentinfo['spinfo_middle_name'].' '.$get_studentinfo['spinfo_last_name'];
		$message ='Dear '.$name.',
		Congratulations. Your Payment has been successful. 
		Login ID : '.$get_studentinfo['student_entryid'].' 
		Login Password : '.$get_studentinfo['student_gtp'].' 		
		link : '.base_url('student/login').'
		';
		sendsms($phone_number, $message);
		}
		
	}
}