<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Onboard extends CI_Controller{
	
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
			$get_studentinfo = $this->Registration_model->student_basic_info($student_portid);
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
		}elseif(isset($_GET['type']) && $_GET['type'] == 'online' && isset($_GET['SID']) && $_GET['SID'] !== ''){
			//$student_id = $this->session->userdata('p_user');
			$student_portid = html_escape($_GET['SID']);

			

				$ipn_array = array(
						'date_time'               => $_POST['pay_time'],
						'transaction_id'          => $_POST['mer_txnid'],
						'bank'                    => $_POST['epw_card_bank_name'],
						'ipn_student_id'          => $_POST['opt_a'],
						'amount'                  => $_POST['store_amount'],
						'card_type'               => $_POST['card_type'],
						'card_number'             => $_POST['card_number'],
						/*'card_name'               => $_POST['card_brand'],*/
						'issuer_bank_or_country	' => $_POST['epw_card_bank_country'],
						'ip_address'              => $this->input->ip_address(),
						'status'                  => $_POST['pay_status'],
					);
				$this->db->insert('starter_ipn', $ipn_array);



			/*echo $direct_api_url = "https://securepay.easypayway.com/api/v1/trxcheck/request.php?request_id=".$_POST['mer_txnid']."&store_id=ccvd&signature_key=8ccd8c71bd6e6743d4772f92c62707cf&type=json";
		

		$handle = curl_init();
		curl_setopt($handle, CURLOPT_URL, $direct_api_url );
		curl_setopt($handle, CURLOPT_TIMEOUT, 30);
		curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($handle, CURLOPT_POST, 1);
		
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE); # KEEP IT FALSE IF YOU RUN FROM LOCAL PC


		$content = curl_exec($handle );

		print_r($content);exit;*/

		/*$code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

		if($code == 200 && !( curl_errno($handle))) {
			curl_close( $handle);
			
			echo "<meta http-equiv='refresh' content='0;url=".$content."'>";
			//# header("Location: ". $sslcz['GatewayPageURL']);
			exit;
		} else {
			curl_close( $handle);
			echo "FAILED TO CONNECT WITH SSLCOMMERZ API";
			exit;
		}*/


		if($_POST['pay_status'] === 'Successful')
		{
			//save students online payment details
			$p_details = array(
							'onpay_student_entryid' => $_POST['opt_a'],
							'onpay_account' => $_POST['opt_b'],
							'onpay_transaction_id' => $_POST['mer_txnid'],
							'onpay_transaction_date' => $_POST['pay_time'],
							'onpay_transaction_amount' => $_POST['store_amount'] + $_POST['epw_service_charge_bdt'],
							'onpay_transaction_status' => 'Paid',
							'onpay_create_date' => date("Y-m-d H:i:s"),
						);
			//$this->Payment_model->save_online_pdetails($p_details);
			$this->db->insert('starter_online_payments', $p_details);


			
			
				/*$get_studentinfo = $this->Payment_model->student_basic_info(sha1($_POST['value_a']));*/
				$get_studentinfo = $this->Registration_model->student_basic_info($student_portid);
				
				//set to enrolled
				$this->db->where('student_id', $get_studentinfo['student_id']);
				$this->db->update('starter_students', array('student_enrolled' => 1));

				
				$phone_number = $get_studentinfo['spinfo_personal_phone'];
				$name = $get_studentinfo['spinfo_first_name'].' '.$get_studentinfo['spinfo_middle_name'].' '.$get_studentinfo['spinfo_last_name'];
				$message ='Dear '.$name.',Congratulations. Your Payment has been successful. Login ID : '.$get_studentinfo['student_entryid'].'. Login Password : '.$get_studentinfo['student_gtp'].'. link : '.base_url('student/login').'
				';
				sendsms($phone_number, $message);


				//Send email
			$email_data['get_studentinfo'] = $get_studentinfo;
			$email_data['full_name'] = $name;
			$body = $this->load->view('regflow/email', $email_data, true);
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
		}

			/*$get_studentinfo = $this->Registration_model->student_basic_info($student_portid);
			$name = $get_studentinfo['spinfo_first_name'].' '.$get_studentinfo['spinfo_middle_name'].' '.$get_studentinfo['spinfo_last_name'];
			//Send email
			$email_data['get_studentinfo'] = $get_studentinfo;
			$email_data['full_name'] = $name;
			$body = $this->load->view('regflow/email', $email_data, true);
			$config = Array(
				'protocol' => 'smtp',
				'smtp_host' => 'ssl://smtp.googlemail.com',
				'smtp_port' => 465,
				'smtp_user' => 'dlp.coordinator@dldchc-badas.org.bd',
				'smtp_pass' => 'Dlp@2018-badas',
				'mailtype'  => 'html', 
				'charset'   => 'iso-8859-1',
				'wordwrap'  => TRUE
			);
			
			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");
			$this->email->from('dlp.coordinator@dldchc-badas.org.bd', 'Distance Learning Programme (DLP)');
			
			$this->email->to($get_studentinfo['student_email']); 
			$this->email->subject('Payment successful');
			$this->email->set_crlf('\r\n');
			$this->email->set_header('MIME-Version', '1.0; charset=utf-8');
			$this->email->message($body); 
			$this->email->send();
			
			$phone_number = $get_studentinfo['spinfo_personal_phone'];
			$message ='Dear '.$name.',
			Thank you for your payment.
			Student ID : '.$get_studentinfo['student_entryid'].'
			Password : '.$get_studentinfo['student_gtp'].'
			link : '.base_url('student/login').'
			';
			sendsms($phone_number, $message);*/
			
			
			$data['template'] = 'payment_success';
			$this->load->view('registration', $data);	
		}else
		{
			redirect('not-found');
		}
	}
	
}