<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Results extends CI_Controller {
	
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
		
		$check_permission = $this->Perm_model->check_permissionby_admin($active_user, 10);
		if($check_permission == true){ echo null; }else{ redirect('not-found'); }
		
		$this->sqtoken = $this->security->get_csrf_token_name();
		$this->sqtoken_hash = $this->security->get_csrf_hash();
		
		$this->load->model('Results_model');
		$this->load->model('Phaseresults_model');
		$this->load->model('Eceresults_model');
		$this->load->library('t_cpdf');
	}
	
	public function index()
	{
		$this->load->view('results/index');
	}

	public function resultexport()
	{
		$data = array();
		$data['get_betch'] = $this->Results_model->getBatch();

		$this->load->view('results/result', $data);
	}

	public function result_summery($batch_id, $type)
	{
		//$batch_id = $this->input->post('bid');
		$data = array();
		if ($type==1) {
			$data['etyp'] = 'CCA 1';
		}elseif($type==2){
			$data['etyp'] = 'CCA 2';
		}elseif($type==3){
			$data['etyp'] = 'CCA 3';
		}elseif($type==4){
			$data['etyp'] = 'ECE';
		}
        $data['batchname'] = $batch_id;
        $data['get_items'] = $this->Results_model->get_module_result_all($batch_id, $type);
        /*print_r($data['get_items']); exit;*/       	

		$this->load->view('results/result_summery', $data);
	}

	public function result_summery_pdf($batch_id, $type)
	{
		//$batch_id = $this->input->post('bid');
		$data = array();
		if ($type==1) {
			$data['etyp'] = 'CCA 1';
		}elseif($type==2){
			$data['etyp'] = 'CCA 2';
		}elseif($type==3){
			$data['etyp'] = 'CCA 3';
		}elseif($type==4){
			$data['etyp'] = 'ECE';
		}
       
		$data['batchname'] = $batch_id;
        $data['get_items'] = $this->Results_model->get_module_result_all($batch_id, $type);

        $html = $this->load->view('results/result_summery_pdf', $data, true); 
        $pdfFilePath = 'summery_result_'.$batch_id.'.pdf';
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
		$pdf->SetFont('times', 'B', 8);
        $pdf->AddPage('P', 'A4');        
        $pdf->WriteHTML($html, true, false, true, false, '');
		$pdf->lastPage();
        $pdf->Output($pdfFilePath, "D");
	}


	public function result_pass($batch_id, $type)
	{
		//$batch_id = $this->input->post('bid');
		$data = array();
		if ($type==1) {
			$data['etyp'] = 'CCA 1';
		}elseif($type==2){
			$data['etyp'] = 'CCA 2';
		}elseif($type==3){
			$data['etyp'] = 'CCA 3';
		}elseif($type==4){
			$data['etyp'] = 'ECE';
		}
        $data['batchname'] = $batch_id;
        $data['get_items'] = $this->Results_model->get_module_result_pass($batch_id, $type);
        /*print_r($data['get_items']); exit;*/       	

		$this->load->view('results/result_pass', $data);
	}

	public function result_pass_pdf($batch_id, $type)
	{
		
		$data = array();
		if ($type==1) {
			$data['etyp'] = 'CCA 1';
		}elseif($type==2){
			$data['etyp'] = 'CCA 2';
		}elseif($type==3){
			$data['etyp'] = 'CCA 3';
		}elseif($type==4){
			$data['etyp'] = 'ECE';
		}
       
		$data['batchname'] = $batch_id;
        $data['get_items'] = $this->Results_model->get_module_result_pass($batch_id, $type);

        $html = $this->load->view('results/result_pass_pdf', $data, true); 
        $pdfFilePath = 'Pass_result_'.$batch_id.'.pdf';
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
		$pdf->SetFont('times', 'B', 8);
        $pdf->AddPage('P', 'A4');        
        $pdf->WriteHTML($html, true, false, true, false, '');
		$pdf->lastPage();
        $pdf->Output($pdfFilePath, "D");
	}

	public function result_fail($batch_id, $type)
	{
		//$batch_id = $this->input->post('bid');
		$data = array();
		if ($type==1) {
			$data['etyp'] = 'CCA 1';
		}elseif($type==2){
			$data['etyp'] = 'CCA 2';
		}elseif($type==3){
			$data['etyp'] = 'CCA 3';
		}elseif($type==4){
			$data['etyp'] = 'ECE';
		}
        $data['batchname'] = $batch_id;
        $data['get_items'] = $this->Results_model->get_module_result_fail($batch_id, $type);
        /*print_r($data['get_items']); exit;*/       	

		$this->load->view('results/result_fail', $data);
	}

	public function result_fail_pdf($batch_id, $type)
	{
		
		$data = array();
		if ($type==1) {
			$data['etyp'] = 'CCA 1';
		}elseif($type==2){
			$data['etyp'] = 'CCA 2';
		}elseif($type==3){
			$data['etyp'] = 'CCA 3';
		}elseif($type==4){
			$data['etyp'] = 'ECE';
		}
       
		$data['batchname'] = $batch_id;
        $data['get_items'] = $this->Results_model->get_module_result_fail($batch_id, $type);

        $html = $this->load->view('results/result_fail_pdf', $data, true); 
        $pdfFilePath = 'Fail_result_'.$batch_id.'.pdf';
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
		$pdf->SetFont('times', 'B', 8);
        $pdf->AddPage('P', 'A4');        
        $pdf->WriteHTML($html, true, false, true, false, '');
		$pdf->lastPage();
        $pdf->Output($pdfFilePath, "D");
	}
	
	public function student_summery()
	{
		$data = array();
		$data['get_betch'] = $this->Results_model->getBatch();
		$this->load->view('results/studentsummery', $data);
	}

	public function student_summery_exl($batch_id)
	{
		$data = array();		
        $data['batchname'] = $batch_id;
        $data['get_items'] = $this->Results_model->getstudent($batch_id);
		$this->load->view('results/student_summery_exl', $data);
	}

	public function examdate()
	{
		$data = array();
		
        /*$data['get_items'] = $this->Results_model->get_exam_date();*/
        $data['get_items'] = $this->Results_model->get_exam_date2();
        /*print_r($data['get_items']); exit;*/
		$this->load->view('results/examdate_csv', $data);
	}

	
	public function result_export()
	{
		$this->load->view('results/module/result_csv');
	}

	public function result_export1()
	{
		$this->load->view('results/module/result_chapter1_csv');
	}

	public function result_export2()
	{
		$this->load->view('results/module/result_chapter2_csv');
	}
	
	public function sdt()
	{
		$this->load->view('results/sdt/index');
	}
	
	public function workshop()
	{
		$this->load->view('results/workshop/index');
	}
	
	public function module()
	{
		$this->load->view('results/module/index');
	}
	
	public function detailresult($id,$pid)
	{
		$data['gotexams'] = $this->Results_model->getExam($id,$pid);
		$this->load->view('results/detail_result', $data);
	}

	public function detailresultece($id,$pid)
	{	
		$data['ece_result'] = $this->Results_model->getEceExam($id,$pid);
		$this->load->view('results/ece_result_detail', $data);
	}
	public function viewdetails()
	{
		$id = $this->input->post('id');
		$data['all_answers'] = $this->Results_model->get_all_answers($id);
		$this->load->view('results/viewdetails', $data);
	}
	public function viewdetails_ece()
	{
		$id = $this->input->post('id');
		$data['all_answers'] = $this->Results_model->get_all_answers_ece($id);
		$this->load->view('results/eceviewdetails', $data);
	}
	
	/********************************/
	/**********START PHASE RESULTS*************/
	/********************************/
	
	public function phase()
	{
		$this->load->view('results/phase/index');
	}
	
	public function phase_create()
	{
		$this->load->library('form_validation');
		
		//check already result created
		$phase_level = $this->input->post('phase_level');
		$student_id = $this->input->post('student_id');
		$check_already_has = $this->Phaseresults_model->check_already_has($phase_level, $student_id);
		if($check_already_has == true)
		{
			$error = '<div class="alert alert-warning">Result has been already created for the student!</div>';
			$result = array('status' => 'error', 'error' => $error);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else
		{
			$data = array(
						'cpreport_phase_id'      => $phase_level,  
						'cpreport_student_id'    => $student_id,  
						'cpreport_status'        => $this->input->post('status'),  
						'cpreport_exam_status'   => $this->input->post('exam_status'),  
						'cpreport_create_date'   => date("Y-m-d H:i:s"),  
						'cpreport_created_by'    => $this->session->userdata('active_user'),  
					);
			$validate = array(
							array(
								'field' => 'phase_level', 
								'label' => 'Phase Level', 
								'rules' => 'required|trim', 
							),
							array(
								'field' => 'student_id', 
								'label' => 'Student', 
								'rules' => 'required|trim', 
							),
						);
			$this->form_validation->set_rules($validate);
			if($this->form_validation->run() == true)
			{
				//save
				$ins_id = $this->Phaseresults_model->create($data);
				$result_id = $this->db->insert_id($ins_id);
				
				//Save marks
				$total_rows = $this->input->post('rownumber');
				foreach($total_rows as $row)
				{
					$marks_label = $this->input->post('marks_label_'.$row);
					$marks = $this->input->post('marks_'.$row);
					if($marks_label && $marks)
					{
						$marks_data = array(
										'pmark_cpreport_id' => $result_id,
										'pmark_label'       => $marks_label,
										'pmark_number'      => $marks,
									  );
						$this->Phaseresults_model->save_phase_marks($marks_data);
					}
				}
				
				//update student table
				if($this->input->post('exam_status') === '1')
				{
					$count_phaselvl = $phase_level+1;
					if($count_phaselvl == 4)
					{
						$upgrade_data = array(
										'student_phaselevel_id' => 0, 
										'student_ece_status' => 1, 
									);
					}else
					{
						$upgrade_data = array(
										'student_phaselevel_id' => $count_phaselvl, 
									);
					}
					
					$this->db->where('student_id', $student_id);
					$this->db->update('starter_students', $upgrade_data);
				}else
				{
					$count_phaselvl = $phase_level;
					$upgrade_data = array(
									'student_phaselevel_id' => $count_phaselvl, 
								);
					
					$this->db->where('student_id', $student_id);
					$this->db->update('starter_students', $upgrade_data);
				}
				
				$data_template['display_content'] = TRUE;
				$content = $this->load->view('results/phase/content_list', $data_template, true);
				$success = '<div class="alert alert-success">successfully created!</div>';
				$result = array('status' => 'ok', 'success' => $success, 'content' => $content);
				$result[$this->sqtoken] = $this->sqtoken_hash;
				echo json_encode($result);
				exit;
			}else
			{
				$error = '<div class="alert alert-danger">'.validation_errors().'</div>';
				$result = array('status' => 'error', 'error' => $error);
				$result[$this->sqtoken] = $this->sqtoken_hash;
				echo json_encode($result);
				exit;
			}
		}
	}
	
	public function phase_create_item()
	{
		$data['display'] = TRUE;
		$data['phase_id'] = $this->input->post('phase_id');
		$content = $this->load->view('results/phase/create_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function phase_edit()
	{
		$data['id'] = $this->input->post('id');
		$content = $this->load->view('results/phase/edit_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function phase_update()
	{
		$this->load->library('form_validation');
		$id = $this->input->post('id');
		$phase_level = $this->input->post('phase_level');
		$student_id = $this->input->post('student_id');
		$data = array(  
					'cpreport_status'        => $this->input->post('status'),  
					'cpreport_exam_status'   => $this->input->post('exam_status'),  
					'cpreport_create_date'   => date("Y-m-d H:i:s"),  
					'cpreport_created_by'    => $this->session->userdata('active_user'),  
				);
		$validate = array(
						array(
							'field' => 'phase_level', 
							'label' => 'Phase Level', 
							'rules' => 'required|trim', 
						),
						array(
							'field' => 'student_id', 
							'label' => 'Student', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->Phaseresults_model->update($id, $data);
			
			//Save marks
			$total_rows = $this->input->post('rownumber');
			if(count($total_rows) !== 0)
			{
				foreach($total_rows as $row)
				{
					$marks_label = $this->input->post('marks_label_'.$row);
					$marks = $this->input->post('marks_'.$row);
					if($marks_label && $marks)
					{
						$marks_data = array(
										'pmark_label'       => $marks_label,
										'pmark_number'      => $marks,
									  );
						$this->Phaseresults_model->update_phase_marks($row, $id, $marks_data);
					}
				}
			}
			
			//update student table
			if($this->input->post('exam_status') === '1')
			{
				$count_phaselvl = $phase_level+1;
				if($count_phaselvl == 4)
				{
					$upgrade_data = array(
									'student_phaselevel_id' => 0, 
									'student_ece_status' => 1, 
								);
				}else
				{
					$upgrade_data = array(
									'student_phaselevel_id' => $count_phaselvl, 
								);
				}
				
				$this->db->where('student_id', $student_id);
				$this->db->update('starter_students', $upgrade_data);
			}else
			{
				$count_phaselvl = $phase_level;
				$upgrade_data = array(
								'student_phaselevel_id' => $count_phaselvl, 
							);
				
				$this->db->where('student_id', $student_id);
				$this->db->update('starter_students', $upgrade_data);
			}
			
			$data_template['display_content'] = TRUE;
			$content = $this->load->view('results/phase/content_list', $data_template, true);
			$success = '<div class="alert alert-success">successfully updated!</div>';
			$result = array('status' => 'ok', 'success' => $success, 'content' => $content);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else
		{
			$error = '<div class="alert alert-danger">'.validation_errors().'</div>';
			$result = array('status' => 'error', 'error' => $error);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
	}
	
	public function phase_delete()
	{
		$id = $this->input->post('id');
		
		//Delete coordinator
		$this->db->where('center_id', $id);
		$this->db->delete('starter_centers');
		
		$data['id'] = $id;
		$content = $this->load->view('results/phase/create_form', $data, true);
		
		$result = array("status" => "ok", "content" => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function get_students()
	{
		$phase_id = $this->input->post('phase_level');
		$content = '<option value="">Select Student</option>'; 
		$get_studentsid = $this->Phaseresults_model->get_students_ids($phase_id);
		foreach($get_studentsid as $sid):
		if($sid['spinfo_middle_name'])
		{
			$full_name = $sid['spinfo_first_name'].' '.$sid['spinfo_middle_name'].' '.$sid['spinfo_last_name'];
		}else
		{
			$full_name = $sid['spinfo_first_name'].' '.$sid['spinfo_last_name'];
		}
		$content .= '<option value="'.$sid['student_id'].'">'.$full_name.' ('.$sid['student_entryid'].')'.'</option>';
		endforeach;
		
		$result = array("status" => "ok", "content" => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	/********************************/
	/**********END PHASE RESULTS*************/
	/********************************/
	
	
	/********************************/
	/**********START ECE RESULTS*************/
	/********************************/
	
	public function ece()
	{
		$this->load->view('results/ece/index');
	}
	
	public function ece_create()
	{
		$this->load->library('form_validation');
		
		//check already result created
		$student_id = $this->input->post('student_id');
		$check_already_has = $this->Eceresults_model->check_already_has($student_id);
		if($check_already_has == true)
		{
			$error = '<div class="alert alert-warning">Result has been already created for the student!</div>';
			$result = array('status' => 'error', 'error' => $error);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else
		{
			$data = array(
						'cpreport_student_id'    => $student_id,  
						'cpreport_status'        => $this->input->post('status'),  
						'cpreport_exam_status'   => $this->input->post('exam_status'),  
						'cpreport_create_date'   => date("Y-m-d H:i:s"),  
						'cpreport_created_by'    => $this->session->userdata('active_user'),  
					);
			$validate = array(
							array(
								'field' => 'student_id', 
								'label' => 'Student', 
								'rules' => 'required|trim', 
							),
						);
			$this->form_validation->set_rules($validate);
			if($this->form_validation->run() == true)
			{
				//save
				$ins_id = $this->Eceresults_model->create($data);
				$result_id = $this->db->insert_id($ins_id);
				
				//Save marks
				$total_rows = $this->input->post('rownumber');
				foreach($total_rows as $row)
				{
					$marks_label = $this->input->post('marks_label_'.$row);
					$marks = $this->input->post('marks_'.$row);
					if($marks_label && $marks)
					{
						$marks_data = array(
										'pmark_cpreport_id' => $result_id,
										'pmark_label'       => $marks_label,
										'pmark_number'      => $marks,
									  );
						$this->Eceresults_model->save_phase_marks($marks_data);
					}
				}
				
				//update student table
				if($this->input->post('exam_status') === '1')
				{
					$upgrade_data = array(
										'student_ece_status' => 0, 
									);
					
					$this->db->where('student_id', $student_id);
					$this->db->update('starter_students', $upgrade_data);
				}else
				{
					$upgrade_data = array(
										'student_ece_status' => 1, 
									);
					
					$this->db->where('student_id', $student_id);
					$this->db->update('starter_students', $upgrade_data);
				}
				
				/*Alert student via sms and email*/
				$get_studentinfo = $this->Eceresults_model->get_student_contact_info($student_id);
				/******Send SMS*******/
				$phone_number = $get_studentinfo['spinfo_personal_phone'];
				$name = $get_studentinfo['spinfo_first_name'].' '.$get_studentinfo['spinfo_middle_name'].' '.$get_studentinfo['spinfo_last_name'];
$message ='Dear '.$name.',
Please visit your DLP Account to view your Result of ECE Exam.
';
				sendsms($phone_number, $message);	
				
				/******Send Email*******/
				$mail_body_data['name'] = $name;
				$mail_body_data['content'] = '<p>The ECE Exam Result has been published. Please check Result in the Menu to view your result of ECE Exam.</p>';
				
				$to = $get_studentinfo['student_email'];
				$subject = 'CCD practice based examination result.';
				$body = $this->load->view('emails/dynamic_email', $mail_body_data, true);
				send_dynamic_email($to, $subject, $body);
				
				/*End of alert*/
				
				$data_template['display_content'] = TRUE;
				$content = $this->load->view('results/ece/content_list', $data_template, true);
				$success = '<div class="alert alert-success">successfully created!</div>';
				$result = array('status' => 'ok', 'success' => $success, 'content' => $content);
				$result[$this->sqtoken] = $this->sqtoken_hash;
				echo json_encode($result);
				exit;
			}else
			{
				$error = '<div class="alert alert-danger">'.validation_errors().'</div>';
				$result = array('status' => 'error', 'error' => $error);
				$result[$this->sqtoken] = $this->sqtoken_hash;
				echo json_encode($result);
				exit;
			}
		}
	}
	
	public function ece_create_item()
	{
		$data['display'] = TRUE;
		$data['phase_id'] = $this->input->post('phase_id');
		$content = $this->load->view('results/ece/create_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function ece_edit()
	{
		$data['id'] = $this->input->post('id');
		$content = $this->load->view('results/ece/edit_form', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function ece_update()
	{
		$this->load->library('form_validation');
		$id = $this->input->post('id');
		$student_id = $this->input->post('student_id');
		$data = array(
					'cpreport_student_id'    => $student_id,  
					'cpreport_status'        => $this->input->post('status'),  
					'cpreport_exam_status'   => $this->input->post('exam_status'),  
					'cpreport_create_date'   => date("Y-m-d H:i:s"),  
					'cpreport_created_by'    => $this->session->userdata('active_user'),  
				);
		$validate = array(
						array(
							'field' => 'student_id', 
							'label' => 'Student', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->Eceresults_model->update($id, $data);
			
			//Save marks
			$total_rows = $this->input->post('rownumber');
			foreach($total_rows as $row)
			{
				$marks_label = $this->input->post('marks_label_'.$row);
				$marks = $this->input->post('marks_'.$row);
				if($marks_label && $marks)
				{
					$marks_data = array(
									'pmark_label'       => $marks_label,
									'pmark_number'      => $marks,
								  );
					$this->Eceresults_model->update_phase_marks($row, $id, $marks_data);
				}
			}
			
			//update student table
			if($this->input->post('exam_status') === '1')
			{
				$upgrade_data = array(
									'student_ece_status' => 0, 
								);
				
				$this->db->where('student_id', $student_id);
				$this->db->update('starter_students', $upgrade_data);
			}else
			{
				$upgrade_data = array(
									'student_ece_status' => 1, 
								);
				
				$this->db->where('student_id', $student_id);
				$this->db->update('starter_students', $upgrade_data);
			}
			
			$data_template['display_content'] = TRUE;
			$content = $this->load->view('results/ece/content_list', $data_template, true);
			$success = '<div class="alert alert-success">successfully updated!</div>';
			$result = array('status' => 'ok', 'success' => $success, 'content' => $content);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else
		{
			$error = '<div class="alert alert-danger">'.validation_errors().'</div>';
			$result = array('status' => 'error', 'error' => $error);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
	}
	
	public function ece_delete()
	{
		$id = $this->input->post('id');
		
		//Delete coordinator
		$this->db->where('center_id', $id);
		$this->db->delete('starter_centers');
		
		$data['id'] = $id;
		$content = $this->load->view('results/ece/create_form', $data, true);
		
		$result = array("status" => "ok", "content" => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	/********************************/
	/**********END ECE RESULTS*************/
	/********************************/
	
}
