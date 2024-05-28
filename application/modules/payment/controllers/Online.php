<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Online extends CI_Controller{
	
	private $username = 'Ibrahimcardiachospital';
    private $password = 'ibrahyptrdck&qu5';
     //live
    private $server_url='https://engine.shurjopayment.com';
    //sandbox
    //private $server_url='https://sandbox.shurjopayment.com';
	
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Dhaka');
		$this->load->model('Payment_model');
		$this->load->library('Shurjopay');
	}
	 public function get_token(){
		$curl = curl_init();
		$request_credential = array(
            'username' => $this->username,
            'password' => $this->password
        );
		$requestbodyJson = json_encode($request_credential);
    //echo $requestbodyJson;exit;
		curl_setopt_array($curl, [
		  CURLOPT_URL => $this->server_url."/api/get_token",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_SSL_VERIFYHOST => false,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => $requestbodyJson,
		  CURLOPT_HTTPHEADER => [
			"Content-Type: application/json"
		  ],
		]);
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
         //seve the response in your database
		  return $response;
		}
}
	public function get_ip(){
	  $this->CI = & get_instance();

			if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
				//ip from share internet
				$ip = $_SERVER['HTTP_CLIENT_IP'];
			} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				//ip pass from proxy
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {
				$ip = $_SERVER['REMOTE_ADDR'];
			}
			return $ip;
	}
	public function pay()
	{
		
		$payment_amount = $this->Payment_model->get_payment_config();
		$entry_id = $this->session->userdata('customer_additional');
		$personal_info = $this->Payment_model->get_student_personal_info($entry_id);
		
		$data = array();
        $token=$this->get_token();
        $array = json_decode($token, true);
        $prefix='ICH';
		$tx_id = $prefix . uniqid();
        
		$ip=$this->get_ip();
		
		$request_data=array(
            'token' => $array['token'],
            'store_id' => $array['store_id'],
            'prefix' => $prefix,                              
            'currency' => "BDT",
            'return_url' => 'https://ccvd.ibrahimcardiac.org.bd/student/onboard/success',
            'cancel_url' => 'https://ccvd.ibrahimcardiac.org.bd/student/onboard/cancel?type=online&SID='.sha1($this->session->userdata('customer_additional')).'&CANCEL=TRUE&ADDITIONAL=FALSE',
            'amount' => $payment_amount['pconfig_course_fee'],                
            // Order information
            'order_id' => $tx_id,
            'discsount_amount' => '',
            'disc_percent' => '',
            // Customer information
            'client_ip' => $ip,                
            'customer_name' => $this->session->userdata('customer_name'),
            'customer_phone' => $this->session->userdata('customer_phone'),
            'email' => $this->session->userdata('customer_email'),
            'customer_address' => $personal_info['spinfo_current_address'],                
            'customer_city' => $personal_info['district'],
            'customer_state' => $personal_info['division'],
            'customer_postcode' => '',
            'customer_country' => $personal_info['country_name'],
            'value1' => $this->session->userdata('customer_additional'),
            'value2' => $this->session->userdata('payment_fr'),
            'value3' => $payment_amount['pconfig_course_fee'],
            'value4' => ''
        );
		$requestbodyJson = json_encode($request_data);
        $response=$this->shurjopay->sendPayment($requestbodyJson);
        //seve the response in your database
        $get_spyurl = json_decode($response, true);
        if(isset($get_spyurl['checkout_url']) && !empty($get_spyurl['checkout_url'])){
         echo '<script language="javascript">';
                     echo 'window.location.href = "'.$get_spyurl['checkout_url'].'"';
          echo '</script>';
        }else{
            echo $response;
        }
		
		
		
		
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