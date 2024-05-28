<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Onboard extends CI_Controller{
	private $username = 'Ibrahimcardiachospital';
    private $password = 'ibrahyptrdck&qu5';
     //live
    private $server_url='https://engine.shurjopayment.com';
    //sandbox
    //private $server_url='https://sandbox.shurjopayment.com';
	
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

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Registration_model');
	}
	
	public function index()
	{
		redirect(base_url('student/onboard/account'), 'refresh', true);
	}
	
	public function account()
	{
		if($this->session->userdata('account_completed') === TRUE)
		{
			redirect('student/onboard/personal', 'refresh', true);
		}else{
			$data['template'] = 'account';
			$this->load->view('registration', $data);
		}
	}
	
	public function personal()
	{
		if($this->session->userdata('account_completed') === TRUE)
		{
			if($this->session->userdata('personal_completed') === TRUE)
			{
				redirect('student/onboard/academic', 'refresh', true);
			}else
			{
				$data['template'] = 'personal';
				/*$data['divisionlist'] = $this->Registration_model->division_list();*/
				$this->load->view('registration', $data);
			}
		}else
		{
			redirect('student/onboard/account', 'refresh', true);
		}
	}

	function fetch_district()
	 {
	  if($this->input->post('division_id'))
	  {
	   echo $this->Registration_model->fetch_district($this->input->post('division_id'));
	  }
	 }
	
	public function academic()
	{
		if($this->session->userdata('personal_completed') === TRUE)
		{
			if($this->session->userdata('academic_completed') === TRUE)
			{
				redirect('student/onboard/approval', 'refresh', true);
			}else{
				$data['template'] = 'academic';
				$this->load->view('registration', $data);
			}
		}else
		{
			redirect('student/onboard/personal', 'refresh', true);
		}
	}
	
	public function approval()
	{
		if($this->session->userdata('academic_completed') === TRUE)
		{
			//unset session data
			$this->session->unset_userdata('wizard_username');
			$this->session->unset_userdata('wizard_student_id');
			$this->session->unset_userdata('account_completed');
			$this->session->unset_userdata('personal_completed');
			$this->session->unset_userdata('academic_completed');
			
			$data['template'] = 'approval';
			$this->load->view('registration', $data);
		}else
		{
			redirect('student/onboard/academic', 'refresh', true);
		}
	}
	
	public function payment()
	{
		if(isset($_GET['PORT']) && $_GET['PORT'] !== '' && isset($_GET['SID']) && $_GET['SID'] !== '')
		{
			$data['template'] = 'payment';
			$this->load->view('registration', $data);
		}else
		{
			redirect('not-found');
		}
	}
	
	public function cancel()
	{
		$data['template'] = 'payment_cancel';
		$this->load->view('registration', $data);
	}
	
	public function success()
	{
		if(isset($_GET['type']) && $_GET['type'] == 'deposit' && isset($_GET['SID']) && $_GET['SID'] !== '')
		{
			//$student_id = $this->session->userdata('p_user');
			$student_portid = html_escape($_GET['SID']);
			$get_studentinfo = $this->Registration_model->student_basic_info_sms($student_portid);
			$name = $get_studentinfo['spinfo_first_name'].' '.$get_studentinfo['spinfo_middle_name'].' '.$get_studentinfo['spinfo_last_name'];
			//Send email
			$email_data['get_studentinfo'] = $get_studentinfo;
			$email_data['full_name'] = $name;
			$body = $this->load->view('regflow/email_deposit', $email_data, true);
			$config = Array(
				'protocol' => 'smtp',
				'smtp_host' => 'ssl://smtp.googlemail.com',
				'smtp_port' => 465,
				'smtp_user' => 'ccvd@ibrahimcardiac.org.bd',
				'smtp_pass' => 'ccvd@cardiac2020',
				'mailtype'  => 'html', 
				'charset'   => 'iso-8859-1',
				'wordwrap'  => TRUE
			);
			
			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");
			$this->email->from('ccvd@ibrahimcardiac.org.bd', 'Certificate Course on Cardiovascular Disease (CCVD)');
			
			$this->email->to($get_studentinfo['student_email']); 
			$this->email->subject('Payment successful');
			$this->email->set_crlf('\r\n');
			$this->email->set_header('MIME-Version', '1.0; charset=utf-8');
			$this->email->message($body); 
			$this->email->send();
			
			$phone_number = $get_studentinfo['spinfo_personal_phone'];
			$message ='Dear '.$name.',
			Thanks for uploading your deposit slip. The deposit slip is now under coordinator review. We will contact you shortly.
			';
			sendsms($phone_number, $message);
			
			
			$data['template'] = 'payment_success';
			$this->load->view('registration', $data);
		}elseif(isset($_GET['order_id']) && $_GET['order_id'] !== ''){
			//$student_id = $this->session->userdata('p_user');
			//$student_portid = html_escape($_GET['SID']);
			$order_id = html_escape($_GET['order_id']);

			$curl = curl_init();
        $token=$this->get_token();
        //echo $token;exit;
        $array = json_decode($token, true);
            curl_setopt_array($curl, [
              CURLOPT_URL => $this->server_url."/api/verification",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
			  CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_SSL_VERIFYHOST => false,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => "{\n\"order_id\":\"".$order_id."\"\n}",
              CURLOPT_HTTPHEADER => [
                "Authorization: Bearer ". $array['token'],
                "Content-Type: application/json"
              ],
            ]);
            
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
              echo "cURL Error #:" . $err;
            } else {
              
			  $data = json_decode($response, true);
			  
			  
			  $ipn_array = array(
						'date_time'               => $data[0]['date_time'],
						'transaction_id'          => $data[0]['order_id'],
						'bank'                    => $data[0]['bank_trx_id'],
						'ipn_student_id'          => $data[0]['value1'],
						'amount'                  => $data[0]['amount'],
						'card_type'               => $data[0]['method'],
						/*'card_number'             => $data[0]['card_number'],
						'card_name'               => $_POST['card_brand'],
						'issuer_bank_or_country	' => $_POST['epw_card_bank_country'],*/
						'ip_address'              => $this->input->ip_address(),
						'status'                  => $data[0]['sp_massage'],
					);
				$this->db->insert('starter_ipn', $ipn_array);
				
				if($data[0]['sp_massage'] === 'Success')
		{
			//save students online payment details
			$p_details = array(
							'onpay_student_entryid' => $data[0]['value1'],
							'onpay_account' => $data[0]['value2'],
							'onpay_transaction_id' => $data[0]['order_id'],
							'onpay_transaction_date' => $data[0]['date_time'],
							'onpay_transaction_amount' => $data[0]['amount'], /*+ $_POST['epw_service_charge_bdt'],*/
							'onpay_transaction_status' => 'Paid',
							'onpay_create_date' => date("Y-m-d H:i:s"),
						);
			//$this->Payment_model->save_online_pdetails($p_details);
			$this->db->insert('starter_online_payments', $p_details);
			
			 
				/*$get_studentinfo = $this->Payment_model->student_basic_info(sha1($_POST['value_a']));*/
				$student_portid = $data[0]['value1'];
				$get_studentinfo = $this->Registration_model->student_basic_info_sms($data[0]['value1']);
				;
				
				//set to enrolled
				$this->db->where('student_id', $get_studentinfo['student_id']);
				 $this->db->update('starter_students', array('student_enrolled' => 1));

				
				$phone_number = $get_studentinfo['spinfo_personal_phone'];
				$name = $get_studentinfo['spinfo_first_name'].' '.$get_studentinfo['spinfo_middle_name'].' '.$get_studentinfo['spinfo_last_name'];
				$message ='Dear '.$name.',Congratulations. Your Payment has been successful. Login ID : '.$get_studentinfo['student_entryid'].'. Login Password : '.$get_studentinfo['student_gtp'].'. link : '.base_url('student/login').'';
				sendsms($phone_number, $message);


				//Send email
			// $email_data['get_studentinfo'] = $get_studentinfo;
			// $email_data['full_name'] = $name;
			// $body = $this->load->view('regflow/email', $email_data, true);
			// $config = Array(
				// 'protocol' => 'smtp',
				// 'smtp_host' => 'ssl://smtp.googlemail.com',
				// 'smtp_port' => 465,
				// 'smtp_user' => 'ccvd@ibrahimcardiac.org.bd',
				// 'smtp_pass' => 'ccvd@cardiac2020',
				// 'mailtype'  => 'html', 
				// 'charset'   => 'iso-8859-1',
				// 'wordwrap'  => TRUE
			// );
			
			// $this->load->library('email', $config);
			// $this->email->set_newline("\r\n");
			// $this->email->from('ccvd@ibrahimcardiac.org.bd', 'Certificate Course on Cardiovascular Disease (CCVD)');
			
			// $this->email->to($get_studentinfo['student_email']); 
			// $this->email->subject('Payment successful');
			// $this->email->set_crlf('\r\n');
			// $this->email->set_header('MIME-Version', '1.0; charset=utf-8');
			// $this->email->message($body); 
			// $this->email->send();

            }
			}
			
			$data['template'] = 'payment_success';
			$this->load->view('registration', $data);	

					
		}else
		{
			redirect('not-found');
		}
	}
	
}