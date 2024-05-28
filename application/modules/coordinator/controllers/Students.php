<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Students extends CI_Controller {
	
	private $sqtoken;
	private $sqtoken_hash;
	
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Dhaka');
		
		$active_user = $this->session->userdata('active_user');
		$userLogin = $this->session->userdata('userLogin');
		if($active_user === NULL && $userLogin !== TRUE)
		{
			redirect('coordinator/login', 'refresh', true);
		}
		
		$check_permission = $this->Perm_model->check_permissionby_admin($active_user, 3);
		if($check_permission == true){ echo null; }else{ redirect('not-found'); }
		
		$this->sqtoken = $this->security->get_csrf_token_name();
		$this->sqtoken_hash = $this->security->get_csrf_hash();
		$this->perPage = 15;
		
		$this->load->model('Students_model');
		$this->load->library('ajax_pagination');
		$this->load->library('sendmaillib');
		$this->load->helper('custom_string');
		$this->load->helper('download');
		$this->load->library('t_cpdf');
	}
	
	public function pending()
	{
		$data = array();
        
        //total rows count
        $totalRec = count($this->Students_model->get_pending_students());
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'studentfilter/get_pending_student';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //get the posts data
        $data['get_items'] = $this->Students_model->get_pending_students(array('limit'=>$this->perPage));
        $data['get_betch'] = $this->Students_model->getBatch();
		
		$this->load->view('students/pending', $data);
	}

	public function pending_csv()
	{
		$data = array();
		$data['batchname'] = $batch_id;
        //get the posts data
        $data['get_items'] = $this->Students_model->get_pending_students_csv();		
		$this->load->view('students/panding_csv', $data);
	}

	public function pending_csvbybatch($batch_id)
	{
		//$batch_id = $this->input->post('bid');
		$data = array();
		
        //get the posts data
        if ($batch_id == '0') {
        	$data['batchname'] = 'All';
        	$data['get_items'] = $this->Students_model->get_pending_students_csv();
        }else{
        	$data['batchname'] = $batch_id;
        	$data['get_items'] = $this->Students_model->get_pending_students_csvbybatch($batch_id);
        }        		
		$this->load->view('students/panding_csv', $data);
	}

	public function create_pdf($batch_id)
	{		
        $data = array();
		$data['batchname'] = $batch_id;
        //get the posts data
        if ($batch_id == '0') {
        	$data['batchname'] = 'All';
        	$data['get_items'] = $this->Students_model->get_pending_students_csv();
        }else{
        	$data['batchname'] = $batch_id;
        	$data['get_items'] = $this->Students_model->get_pending_students_csvbybatch($batch_id);
        } 

        $html = $this->load->view('students/panding_pdf', $data, true); 
        $pdfFilePath = 'panding_students_'.$batch_id.'.pdf';
        $pdf = $this->t_cpdf->load();
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		// set margins
		$pdf->SetMargins(5, 10, 5);
		//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, 25);

		// set image scale factor
		$pdf->setImageScale(1.53);
		// set font
		$pdf->SetFont('times', 'B', 5);
        $pdf->AddPage('L', 'A4');        
        $pdf->WriteHTML($html, true, false, true, false, '');
		$pdf->lastPage();
        $pdf->Output($pdfFilePath, "D");
	}

	
	public function enrolled()
	{
		$data = array();
        
        //total rows count
        $totalRec = count($this->Students_model->get_enrolled_students());
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'studentfilter/get_enrolled_student';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //get the posts data
        $data['get_items'] = $this->Students_model->get_enrolled_students(array('limit'=>$this->perPage));
		$data['get_betch'] = $this->Students_model->getBatch();
		$this->load->view('students/enrolled', $data);
	}
	
	public function update_pass_and_gmail()
	{
		$data = array();
        
        //total rows count
        $totalRec = count($this->Students_model->update_pass_email());
   
        
        //get the posts data
        $data['get_items'] = $this->Students_model->update_pass_email();
		$data['get_betch'] = $this->Students_model->getBatch();
		$this->load->view('students/update_pass_email', $data);
	}
	
	public function reset_pass()
	{
		$student_id = $this->input->post('student_id');
		$data = $this->Students_model->update_pass($student_id);
		if($data === true){
		$result = array('status' => 'ok', 'content' => $data);
		}else{
			$result = array('status' => 'Network Error, Please Check Your Connection or student password 123456 exist');
		}
		
		echo json_encode($result);
		exit;
	}
	
	public function reset_email()
	{
		$student_id = $this->input->post('student_id');
		$newEmail = $this->input->post('newEmail');
		$data = $this->Students_model->update_email($student_id , $newEmail);
		if($data === true){
		$result = array('status' => 'ok', 'content' => $newEmail);
		}else{
			$result = array('status' => 'Network Error, Please Check Your Connection or student already have '.$newEmail);
		}
		
		echo json_encode($result);
		exit;
	}
	
	public function reset_phone()
	{
		$student_id = $this->input->post('student_id');
		$phone = $this->input->post('phone');
		
		$data = $this->Students_model->update_phone($student_id , $phone);
		if($data === true){
			$result = array('status' => 'ok', 'content' => $phone);
		}else{
			$result = array('status' => 'Network Error, Please Check Your Connection');
		}
		
		echo json_encode($result);
		exit;
	}

	public function enrolled_csv()
	{
		$data = array();
        //get the posts data
        $data['get_items'] = $this->Students_model->get_enrolled_students_csv();
		
		$this->load->view('students/enrolled_csv', $data);
	}

	public function enrolled_csvbybatch($batch_id)
	{
		//$batch_id = $this->input->post('bid');
		$data = array();
		
        //get the posts data
        if ($batch_id == '0') {
        	$data['batchname'] = 'All';
        	$data['get_items'] = $this->Students_model->get_enrolled_students_csv();
        }else{
        	$data['batchname'] = $batch_id;
        	$data['get_items'] = $this->Students_model->get_enrolled_students_csvbatch($batch_id);
        }        		
		$this->load->view('students/enrolled_csv', $data);
	}

	public function enrolled_pdf($batch_id)
	{		
        $data = array();
		$data['batchname'] = $batch_id;
        //get the posts data
        if ($batch_id == '0') {
        	$data['batchname'] = 'All';
        	$data['get_items'] = $this->Students_model->get_enrolled_students_csv();
        }else{
        	$data['batchname'] = $batch_id;
        	$data['get_items'] = $this->Students_model->get_enrolled_students_csvbatch($batch_id);
        } 

        $html = $this->load->view('students/enrolled_pdf', $data, true); 
        $pdfFilePath = 'enrolled_students_'.$batch_id.'.pdf';
        $pdf = $this->t_cpdf->load();
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		// set margins
		$pdf->SetMargins(5, 10, 5);
		//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, 25);

		// set image scale factor
		$pdf->setImageScale(1.53);
		// set font
		$pdf->SetFont('times', 'B', 5);
        $pdf->AddPage('L', 'A4');        
        $pdf->WriteHTML($html, true, false, true, false, '');
		$pdf->lastPage();
        $pdf->Output($pdfFilePath, "D");
	}

	public function payment_csvbybatch($batch_id)
	{
		//$batch_id = $this->input->post('bid');
		$data = array();
		
        //get the posts data
        if ($batch_id == '0') {
        	$data['batchname'] = 'All';
        	$data['get_items'] = $this->Students_model->get_payment_csv();
        	$data['get_pay'] = $this->Students_model->get_enrolled_students_csv();
        	$data['get_applicant'] = $this->Students_model->get_pending_students_csv();
        }else{
        	$data['batchname'] = $batch_id;
        	$data['get_items'] = $this->Students_model->get_payment_csvbatch($batch_id); 
        	$data['get_pay'] = $this->Students_model->get_enrolled_students_csvbatch($batch_id);
        	$data['get_applicant'] = $this->Students_model->get_pending_students_csvbybatch($batch_id);
        }        		
		$this->load->view('students/payment_csv', $data);
	}

	public function payment_csvbybatch_pdf($batch_id)
	{		
        $data = array();
		$data['batchname'] = $batch_id;
        //get the posts data
        if ($batch_id == '0') {
        	$data['batchname'] = 'All';
        	$data['get_items'] = $this->Students_model->get_payment_csv();
        	$data['get_pay'] = $this->Students_model->get_enrolled_students_csv();
        	$data['get_applicant'] = $this->Students_model->get_pending_students_csv();
        }else{
        	$data['batchname'] = $batch_id;
        	$data['get_items'] = $this->Students_model->get_payment_csvbatch($batch_id); 
        	$data['get_pay'] = $this->Students_model->get_enrolled_students_csvbatch($batch_id);
        	$data['get_applicant'] = $this->Students_model->get_pending_students_csvbybatch($batch_id);
        } 

        $html = $this->load->view('students/payment_pdf', $data, true); 
        $pdfFilePath = 'Payment_'.$batch_id.'.pdf';
        $pdf = $this->t_cpdf->load();
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		// set margins
		$pdf->SetMargins(5, 10, 5);
		//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, 25);

		// set image scale factor
		$pdf->setImageScale(1.53);
		// set font
		$pdf->SetFont('times', 'B', 5);
        $pdf->AddPage('L', 'A4');        
        $pdf->WriteHTML($html, true, false, true, false, '');
		$pdf->lastPage();
        $pdf->Output($pdfFilePath, "D");
	}


	public function approvedlist()
	{
		$data = array();
        
        //total rows count
        $totalRec = count($this->Students_model->get_approved_students());
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'studentfilter/get_approved_student';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //get the posts data
        $data['get_items'] = $this->Students_model->get_approved_students(array('limit'=>$this->perPage));
		$data['get_betch'] = $this->Students_model->getBatch();
		$this->load->view('students/approved', $data);
	}

	public function approve_csvbybatch($batch_id)
	{
		//$batch_id = $this->input->post('bid');
		$data = array();
		
        //get the posts data
        if ($batch_id == '0') {
        	$data['batchname'] = 'All';
        	$data['get_items'] = $this->Students_model->get_approve_students_csv();
        	$data['get_pay'] = $this->Students_model->get_enrolled_students_csv($batch_id);
        }else{
        	$data['batchname'] = $batch_id;
        	$data['get_items'] = $this->Students_model->get_approve_students_csvbybatch($batch_id);
        }        		
		$this->load->view('students/panding_csv', $data);
	}

	public function approve_pdf($batch_id)
	{		
        $data = array();
		$data['batchname'] = $batch_id;
        //get the posts data
        if ($batch_id == '0') {
        	$data['batchname'] = 'All';
        	$data['get_items'] = $this->Students_model->get_approve_students_csv();
        }else{
        	$data['batchname'] = $batch_id;
        	$data['get_items'] = $this->Students_model->get_approve_students_csvbybatch($batch_id);
        } 

        $html = $this->load->view('students/panding_pdf', $data, true); 
        $pdfFilePath = 'approved_students_'.$batch_id.'.pdf';
        $pdf = $this->t_cpdf->load();
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		// set margins
		$pdf->SetMargins(5, 10, 5);
		//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, 25);

		// set image scale factor
		$pdf->setImageScale(1.53);
		// set font
		$pdf->SetFont('times', 'B', 5);
        $pdf->AddPage('L', 'A4');        
        $pdf->WriteHTML($html, true, false, true, false, '');
		$pdf->lastPage();
        $pdf->Output($pdfFilePath, "D");
	}

	public function waitinglist()
	{
		$data = array();
        
        //total rows count
        $totalRec = count($this->Students_model->get_waiting_students());
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'studentfilter/get_waiting_student';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //get the posts data
        $data['get_items'] = $this->Students_model->get_waiting_students(array('limit'=>$this->perPage));
		
		$this->load->view('students/waitinglist', $data);
	}

	public function waiting_csv()
	{
		$data = array();
        //get the posts data
        $data['get_items'] = $this->Students_model->get_waiting_students_csv();
		
		$this->load->view('students/waiting_csv', $data);
	}
	public function ccvdsortlist()
	{
		$data = array();
        
        //total rows count
        $totalRec = count($this->Students_model->get_sort_students());
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'studentfilter/get_sort_student';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //get the posts data
        $data['get_items'] = $this->Students_model->get_sort_students(array('limit'=>$this->perPage));
		$data['get_betch'] = $this->Students_model->getBatch();
		$this->load->view('students/sort_list', $data);
	}

	public function ccvdsortlist_csv()
	{
		$data = array();
        //get the posts data
        $data['get_items'] = $this->Students_model->get_sort_students_csv();
		
		$this->load->view('students/sort_list_csv', $data);
	}

	public function ccvdsortlist_csvbybatch($batch_id)
	{
		//$batch_id = $this->input->post('bid');
		$data = array();
		
        //get the posts data
        if ($batch_id == '0') {
        	$data['batchname'] = 'All';
        	$data['get_items'] = $this->Students_model->get_sort_students_csv();
        }else{
        	$data['batchname'] = $batch_id;
        	$data['get_items'] = $this->Students_model->get_sort_students_csvbatch($batch_id);
        }        		
		$this->load->view('students/sort_list_csv', $data);
	}

	public function ccvdsortlist_pdf($batch_id)
	{		
        $data = array();
		$data['batchname'] = $batch_id;
        //get the posts data
        if ($batch_id == '0') {
        	$data['batchname'] = 'All';
        	$data['get_items'] = $this->Students_model->get_approve_students_csv();
        }else{
        	$data['batchname'] = $batch_id;
        	$data['get_items'] = $this->Students_model->get_approve_students_csvbybatch($batch_id);
        } 

        $html = $this->load->view('students/panding_pdf', $data, true); 
        $pdfFilePath = 'sortlist_students_'.$batch_id.'.pdf';
        $pdf = $this->t_cpdf->load();
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		// set margins
		$pdf->SetMargins(5, 10, 5);
		//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, 25);

		// set image scale factor
		$pdf->setImageScale(1.53);
		// set font
		$pdf->SetFont('times', 'B', 5);
        $pdf->AddPage('L', 'A4');        
        $pdf->WriteHTML($html, true, false, true, false, '');
		$pdf->lastPage();
        $pdf->Output($pdfFilePath, "D");
	}

	public function rejectlist()
	{
		$data = array();
        
        //total rows count
        $totalRec = count($this->Students_model->get_reject_students());
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'studentfilter/get_reject_student';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //get the posts data
        $data['get_items'] = $this->Students_model->get_reject_students(array('limit'=>$this->perPage));
		
		$this->load->view('students/rejectlist', $data);
	}

	public function rejectlist_csv()
	{
		$data = array();
        //get the posts data
        $data['get_items'] = $this->Students_model->get_reject_students_csv();
		
		$this->load->view('students/rejectlist_csv', $data);
	}

	public function pchanged()
	{
		$data = array();
        
        //total rows count
        $totalRec = count($this->Students_model->get_changed_phone_numbers());
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'studentfilter/get_changed_phone_numbers';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //get the posts data
        $data['get_items'] = $this->Students_model->get_changed_phone_numbers(array('limit'=>$this->perPage));
		
		$this->load->view('students/pchanged/enrolled', $data);
	}
	
	public function approve()
	{
		$student_id = $this->input->post('student_id');
		$active_module = $this->Students_model->get_active_module();
		$apprvdate = date("Y-m-d");
		$data = array(
					'student_active_module' => $active_module,
					'student_approve_date' => $apprvdate,
					'student_status' => 1,
				);
		$this->db->where('student_id', $student_id);
		$this->db->update('starter_students', $data);
		
		$get_studentinfo = $this->Students_model->get_student_info($student_id);
		$name = $get_studentinfo['spinfo_first_name'].' '.$get_studentinfo['spinfo_middle_name'].' '.$get_studentinfo['spinfo_last_name'];
		//Send email
		$data['get_studentinfo'] = $get_studentinfo;
		$data['full_name'] = $name;
		$body = $this->load->view('students/email', $data, true);
		
		/* $this->load->library('email');
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
		$this->email->initialize($config);
		$this->email->set_newline("\r\n");
		$this->email->from('ccvd@ibrahimcardiac.org.bd', 'Certificate Course on Cardiovascular Disease (CCVD)');
		
		$this->email->to($get_studentinfo['student_email']); 
		$this->email->subject('Your application has been approved');
		$this->email->set_crlf('\r\n');
		$this->email->set_header('MIME-Version', '1.0; charset=utf-8');
		$this->email->set_header('Content-Type', 'text/html');
		$this->email->message($body); 
		$this->email->send(); */
		
		$this->sendmaillib->from('ccvd@ibrahimcardiac.org.bd');
		$this->sendmaillib->to($get_studentinfo['student_email']);
		$this->sendmaillib->subject('Your application has been approved');
		$this->sendmaillib->content($body);
		$this->sendmaillib->send();
		
		$phone_number = $get_studentinfo['spinfo_personal_phone'];
 $message =" Dear ".$name.", \r\n We are pleased to inform you that, your CCVD Batch 13, admission application has been approved. We would like to request you to complete the deposit of course fee TK. 20,000/-(Twenty Thousand Only) within 29 May, 2024 via the link below : ".base_url("student/onboard/payment?SID=".sha1($get_studentinfo["student_entryid"])."&PORT=".sha1($get_studentinfo["student_id"])."&httpRdr=Online&status=pay")." 
 \r\n Thanks \r\n CCVD, DLP, ICHRI ";
		sendsms($phone_number, $message);		
		
		$result = array('status' => 'ok');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}


	public function waiting()
	{
		$student_id = $this->input->post('student_id');
		$data = array(					
					'student_status' => 2,
				);
		$this->db->where('student_id', $student_id);
		$this->db->update('starter_students', $data);
		
		$get_studentinfo = $this->Students_model->get_student_info($student_id);
		$name = $get_studentinfo['spinfo_first_name'].' '.$get_studentinfo['spinfo_middle_name'].' '.$get_studentinfo['spinfo_last_name'];
		//Send email
		$data['get_studentinfo'] = $get_studentinfo;
		$data['full_name'] = $name;
		$body = $this->load->view('students/waiting_email', $data, true);
		/* $this->load->library('email');
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
		$this->email->initialize($config);
		$this->email->set_newline("\r\n");
		$this->email->from('ccvd@ibrahimcardiac.org.bd', ' Certificate Course on Cardiovascular Disease (CCVD)');
		
		$this->email->to($get_studentinfo['student_email']); 
		$this->email->subject('Your application has been waiting');
		$this->email->set_crlf('\r\n');
		$this->email->set_header('MIME-Version', '1.0; charset=utf-8');
		$this->email->set_header('Content-Type', 'text/html');
		$this->email->message($body); 
		$this->email->send(); */
		
		$this->sendmaillib->from('ccvd@ibrahimcardiac.org.bd');
		$this->sendmaillib->to($get_studentinfo['student_email']);
		$this->sendmaillib->subject('Your application has been waiting');
		$this->sendmaillib->content($body);
		$this->sendmaillib->send();
		
		$phone_number = $get_studentinfo['spinfo_personal_phone'];
$message ='Dear '.$name.',
We are pleased to inform you that your application has been waiting.';
		sendsms($phone_number, $message);		
		
		$result = array('status' => 'ok');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function approve_phone_number()
	{
		$student_id = $this->input->post('student_id');
		$get_studentinfo = $this->Students_model->get_student_info($student_id);
		$data = array(
					'spinfo_personal_phone' => $get_studentinfo['spinfo_personal_phone_updated'],
					'spinfo_personal_phone_updaterqst' => 'NO',
					'spinfo_personal_phone_updated' => null,
				);
		$this->db->where('spinfo_student_id', $student_id);
		$this->db->update('starter_students_personalinfo', $data);
		
		$name = $get_studentinfo['spinfo_first_name'].' '.$get_studentinfo['spinfo_middle_name'].' '.$get_studentinfo['spinfo_last_name'];
		//Send email
		$data['get_studentinfo'] = $get_studentinfo;
		$data['full_name'] = $name;
		$body = $this->load->view('students/phone_approved_email', $data, true);
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
		$this->email->subject('Your phone number change request has been approved');
		$this->email->set_crlf('\r\n');
		$this->email->set_header('MIME-Version', '1.0; charset=utf-8');
		$this->email->set_header('Content-Type', 'text/html');
		$this->email->message($body); 
		$this->email->send();
		
		$phone_number = $get_studentinfo['spinfo_personal_phone'];
$message ='Dear '.$name.',
We are pleased to inform you that your phone number change request has been approved.';
		sendsms($phone_number, $message);		
		
		$result = array('status' => 'ok');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function declined()
	{
		$student_id = $this->input->post('student_id');
		
		$get_studentinfo = $this->Students_model->get_student_contactinfo($student_id);
		
		//Send email
		$data['get_studentinfo'] = $get_studentinfo;
		$body = $this->load->view('students/reject/email', $data, true);
		/* $config = Array(
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
		$this->email->subject('Your application has not been approved.');
		$this->email->set_crlf('\r\n');
		$this->email->set_header('MIME-Version', '1.0; charset=utf-8');
		$this->email->set_header('Content-Type', 'text/html');
		$this->email->message($body); 
		$this->email->send(); */
		$this->sendmaillib->from('ccvd@ibrahimcardiac.org.bd');
		$this->sendmaillib->to($get_studentinfo['student_email']);
		$this->sendmaillib->subject('Your application has not been declined.');
		$this->sendmaillib->content($body);
		$this->sendmaillib->send();
		
		$phone_number = $get_studentinfo['spinfo_personal_phone'];
$message ='Dear Candidate,
We regret to inform you that your application has not been declined.
';
		sendsms($phone_number, $message);
		
		$data = array(
					'student_status' => 0,
				);
		$this->db->where('student_id', $student_id);
		$this->db->update('starter_students', $data);
		
		$result = array('status' => 'ok');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function declined_phone_number()
	{
		$student_id = $this->input->post('student_id');
		
		$get_studentinfo = $this->Students_model->get_student_contactinfo($student_id);
		$get_studentinfo = $this->Students_model->get_student_info($student_id);
		$data = array(
					'spinfo_personal_phone_updaterqst' => 'CANCEL',
					'spinfo_personal_phone_updated' => null,
				);
		$this->db->where('spinfo_student_id', $student_id);
		$this->db->update('starter_students_personalinfo', $data);
		
		//Send email
		$data['get_studentinfo'] = $get_studentinfo;
		$body = $this->load->view('students/declined/email', $data, true);
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
		$this->email->subject('Your phone number change request has not been approved.');
		$this->email->set_crlf('\r\n');
		$this->email->set_header('MIME-Version', '1.0; charset=utf-8');
		$this->email->set_header('Content-Type', 'text/html');
		$this->email->message($body); 
		$this->email->send();
		
		$phone_number = $get_studentinfo['spinfo_personal_phone'];
$message ='Dear Candidate,
We are really sorry to inform you that your phone number change request has been declined.';
		sendsms($phone_number, $message);
		
		$result = array('status' => 'ok');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}

	public function sort_list()
	{
		$student_id = $this->input->post('student_id');
		$data = array(					
					'student_status' => 4,
				);
		$this->db->where('student_id', $student_id);
		$this->db->update('starter_students', $data);
		
		$get_studentinfo = $this->Students_model->get_student_info($student_id);
		$name = $get_studentinfo['spinfo_first_name'].' '.$get_studentinfo['spinfo_middle_name'].' '.$get_studentinfo['spinfo_last_name'];
		//Send email
		$data['get_studentinfo'] = $get_studentinfo;
		$data['full_name'] = $name;
		$data['mailperpus'] = 'Sort Listed';
		$body = $this->load->view('students/waiting_email', $data, true);
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
		$this->email->from('ccvd@ibrahimcardiac.org.bd', ' Certificate Course on Cardiovascular Disease (CCVD)');
		
		$this->email->to($get_studentinfo['student_email']); 
		$this->email->subject('Your application has been Sort Listed');
		$this->email->set_crlf('\r\n');
		$this->email->set_header('MIME-Version', '1.0; charset=utf-8');
		$this->email->set_header('Content-Type', 'text/html');
		$this->email->message($body); 
		$this->email->send();
		
		$phone_number = $get_studentinfo['spinfo_personal_phone'];
		$message ='Dear '.$name.',
		We are pleased to inform you that your application has been sort listed.';
		sendsms($phone_number, $message);		
		
		$result = array('status' => 'ok');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}

	public function rjct_list()
	{
		$student_id = $this->input->post('student_id');
		$note = $this->input->post('note');
		$data = array(					
					'student_status' => 5,
					'student_note' => $note,
				);
		$this->db->where('student_id', $student_id);
		$this->db->update('starter_students', $data);
		
		$get_studentinfo = $this->Students_model->get_student_info($student_id);
		$name = $get_studentinfo['spinfo_first_name'].' '.$get_studentinfo['spinfo_middle_name'].' '.$get_studentinfo['spinfo_last_name'];
		//Send email
		$data['get_studentinfo'] = $get_studentinfo;
		$data['full_name'] = $name;
		$data['mailperpus'] = 'Rejected';
		$body = $this->load->view('students/waiting_email', $data, true);
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
		$this->email->from('ccvd@ibrahimcardiac.org.bd', ' Certificate Course on Cardiovascular Disease (CCVD)');
		
		$this->email->to($get_studentinfo['student_email']); 
		$this->email->subject('Your application has been Rejected');
		$this->email->set_crlf('\r\n');
		$this->email->set_header('MIME-Version', '1.0; charset=utf-8');
		$this->email->set_header('Content-Type', 'text/html');
		$this->email->message($body); 
		$this->email->send();
		
		$phone_number = $get_studentinfo['spinfo_personal_phone'];
		$message ='Dear '.$name.',
		We are pleased to inform you that your application has been Rejected.';
		sendsms($phone_number, $message);		
		
		$result = array('status' => 'ok');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function exam_allow()
	{
		$student_id = $this->input->post('student_id');
		$note = $this->input->post('note');
		$data = array(
					'student_examstatus' => $note,
				);
		$this->db->where('student_id', $student_id);
		$this->db->update('starter_students', $data);
		
		$result = array('status' => 'ok');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}

	function certificate_download($id,$code)
	 {
	  
	  $certificate = $this->Students_model->get_academicinformation($id);
	   $this->load->library('zip');
	   foreach($certificate as $image)
	   {
	   	$imgurl = 'attachments/students/'.$image['sacinfo_certificate'];
	    $this->zip->read_file($imgurl);
	   }
	   $this->zip->download(''.$code.'.zip');
	  
	 }
	
	public static function delete_dir($dirPath) {
		if (! is_dir($dirPath)) {
			throw new InvalidArgumentException("$dirPath must be a directory");
		}
		if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
			$dirPath .= '/';
		}
		$files = glob($dirPath . '*', GLOB_MARK);
		foreach ($files as $file) {
			if (is_dir($file)) {
				self::deleteDir($file);
			} else {
				unlink($file);
			}
		}
		rmdir($dirPath);
	}
	
	public function delete()
	{
		$student_id = $this->input->post('student_id');
		$get_studentinfo = $this->Students_model->get_student_contactinfo($student_id);
		
		//Send email
		$data['get_studentinfo'] = $get_studentinfo;
		$body = $this->load->view('students/reject/email', $data, true);
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
		$this->email->subject('Your application has not been approved.');
		$this->email->set_crlf('\r\n');
		$this->email->set_header('MIME-Version', '1.0; charset=utf-8');
		$this->email->set_header('Content-Type', 'text/html');
		$this->email->message($body); 
		$this->email->send();
		
		$phone_number = $get_studentinfo['spinfo_personal_phone'];
$message ='Dear Candidate,
We regret to inform you that your application has not been approved.
';
		sendsms($phone_number, $message);
		
		$student_entryid = $this->Students_model->get_student_entryid($student_id);
		
		//delete from academic information
		$this->db->where('sacinfo_student_id', $student_id);
		$this->db->delete('starter_students_academicinfo');
		
		//delete from dlp categories
		$this->db->where('sdc_student_id', $student_id);
		$this->db->delete('starter_students_dlpcategories');
		
		//delete from personal information
		$this->db->where('spinfo_student_id', $student_id);
		$this->db->delete('starter_students_personalinfo');
		
		//delete from professional information
		$this->db->where('spsinfo_student_id', $student_id);
		$this->db->delete('starter_students_professionalinfo');
		
		//delete from specializations
		$this->db->where('ss_student_id', $student_id);
		$this->db->delete('starter_students_specializations');
		
		//delete from lesson has read
		$this->db->where('lessread_user_id', $student_id);
		$this->db->delete('starter_lesson_reading_completed');
		
		//delete student directory
		$dir = $_SERVER['DOCUMENT_ROOT'].'/attachments/students/'.$student_entryid;
		if(file_exists($dir))
		{
			$this->delete_dir($dir);
		}
		
		//delete from student table
		$this->db->where('student_id', $student_id);
		$this->db->delete('starter_students');
		
		$result = array('status' => 'ok');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function view()
	{
		$student_id = $this->input->post('student_id');
		$data['item'] = $this->Students_model->get_student_info($student_id);
		$content = $this->load->view('students/view_details', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function payment_details()
	{
		$student_id = $this->input->post('sid');
		echo $this->__p_details($student_id);
	}
	
	public function __p_details($student_id)
	{
		$online_payments = $this->Students_model->get_onlinepayment_info($student_id);
		$deposit_payments = $this->Students_model->get_depositpayment_info($student_id);
		
		$content = '
			<div class="tab-pane active" id="tab_default_1">
				<div class="near_by_hotel_wrapper">
					<div class="near_by_hotel_container">
					  <table class="table no-border custom_table dataTable no-footer dtr-inline">
						<colgroup>
							<col width="20%">
							<col width="30%">
							<col width="20%">
							<col width="20%">
							<col width="10%">
						</colgroup>
						<thead>
						  <tr>
							<th>Payment</th>
							<th class="text-center">Transaction ID</th>
							<th class="text-center">Transaction Date</th>
							<th class="text-center">Amount</th>
							<th class="text-center">Status</th>
						  </tr>
						</thead>
						<tbody>
						';
						foreach($online_payments as $online):
							$content .= '<tr>';
								$content .= '<td>'.$online['onpay_account'].'</td>';
								$content .= '<td class="text-center">'.$online['onpay_transaction_id'].'</td>';
								$content .= '<td class="text-center">'.date("d F, Y", strtotime($online['onpay_transaction_date'])).'</td>';
								$content .= '<td class="text-center">BDT '.$online['onpay_transaction_amount'].'</td>';
								$content .= '<td class="text-center"><strong style="color:#0a0">Paid</strong></td>';
							$content .= '</tr>';
						endforeach;
						  
		$content .= '
						</tbody>
					  </table>
					</div>
				</div>
			</div>
			<div class="tab-pane" id="tab_default_2">
				<div class="near_by_hotel_wrapper">
					<div class="near_by_hotel_container">
					  <table class="table no-border custom_table dataTable no-footer dtr-inline">
						<colgroup>
							<col width="10%">
							<col width="10%">
							<col width="20%">
							<col width="10%">
							<col width="10%">
							<col width="10%">
							<col width="20%">
						</colgroup>
						<thead>
						  <tr>
							<th>Payment</th>
							<th>Amount</th>
							<th>Bank</th>
							<th class="text-center">Branch</th>
							<th class="text-center">Account Number</th>
							<th class="text-center">Status</th>
							<th class="text-center">Deposit Slip</th>
						  </tr>
						</thead>
						<tbody>
						';
						foreach($deposit_payments as $deposit):
							$content .= '<tr>';
								$content .= '<td>'.$deposit['deposit_payment'].'</td>';
								$content .= '<td>BDT '.$deposit['deposit_amount'].'</td>';
								$content .= '<td>'.$deposit['deposit_bank'].'</td>';
								$content .= '<td class="text-center">'.$deposit['deposit_branch'].'</td>';
								$content .= '<td class="text-center">'.$deposit['deposit_account_number'].'</td>';
								if($deposit['deposit_slip_status'] === '0')
								{
									$content .= '<td class="text-center"><strong style="color:#0aa">Under Review</strong></td>';
								}elseif($deposit['deposit_slip_status'] === '1')
								{
									$content .= '<td class="text-center"><strong style="color:#0a0">Paid</strong></td>';
								}elseif($deposit['deposit_slip_status'] === '2')
								{
									$content .= '<td class="text-center"><strong style="color:#F00">Unpaid</strong></td>';
								}
								$content .= '<td class="text-center"><a href="'.attachment_url('students/'.$deposit['deposit_slip_file']).'" target="_blank"><i class="fa fa-eye"></i> View</a></td>';
							$content .= '</tr>';
						endforeach;
			$content .= '
						</tbody>
					  </table>
					</div>
				</div>
			</div>
		';
		
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		return json_encode($result);
		exit;
		
	}
	
}