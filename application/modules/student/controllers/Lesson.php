<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lesson extends CI_Controller{
	
	private $sqtoken;
	private $sqtoken_hash;
	
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Dhaka');
		
		$active_student = $this->session->userdata('active_student');
		$studentLogin = $this->session->userdata('studentLogin');
		if($active_student === NULL && $studentLogin !== TRUE)
		{
			redirect('student/login', 'refresh', true);
		}
		
		$this->sqtoken = $this->security->get_csrf_token_name();
		$this->sqtoken_hash = $this->security->get_csrf_hash();
		
		$this->load->model('Lesson_model');
		$this->load->helper('download');
		$this->load->library('t_cpdf');
	}
	
	public function sendotp()
	{
		$student_id = $this->session->userdata('active_student');
		$phone_number = $this->Lesson_model->get_student_phone($student_id);
		$lesson_id = $this->input->post('lesson');
		$number = $phone_number;
		$otp = rand(132949,999999);
$message='Dear User,
The OTP is : '.$otp.'
Distance Learning Programme (DLP)
';
		//store at session
		$sess['lessotp'] = $otp;
		$sess['active_lesson'] = $lesson_id;
		$this->session->set_userdata($sess);
		sendsms($number, $message);
		
		$result = array('status' => 'ok', 'lesson' => $lesson_id);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function check_otp()
	{
		$otp = html_escape($this->input->post('otp'));
		$lesson = html_escape($this->input->post('lesson'));
		$otp_number = $this->session->userdata('lessotp');
		$active_lesson = $this->session->userdata('active_lesson');
		
		if($otp_number == $otp && $active_lesson == $lesson)
		{
			//save original lesson
			$sess['lesson_orogin'] = $active_lesson;
			$this->session->set_userdata($sess);
			
			//check has attached
			$lesson_info = $this->Lesson_model->get_lessonby_id($active_lesson);
			if($lesson_info['lesson_attach_file'])
			{
				$attach = 'Yes';
			}else
			{
				$attach = 'No';
			}
			
			$result = array('status' => 'ok', 'attach' => $attach);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else
		{
			$error_content = '<p style="color:#F00"><strong>Please enter correct OTP.</strong></p>';
			$result = array('status' => 'error', 'error_content' => $error_content);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
		
	}
	
	public function create_pdf()
	{
		$lesson_id = $this->session->userdata('lesson_orogin');
		$get_lesson_info = $this->Lesson_model->get_lessonby_id($lesson_id);
		
		//inclusions
		$module_name = str_replace(' ', '_', $get_lesson_info['module_name']);
		
		
        $data['lesson_info'] = $get_lesson_info;
        $html = $this->load->view('lesson_to_pdf', $data, true); 
        $pdfFilePath = $module_name.'_lesson_'.$get_lesson_info['lesson_position'].'_'.date("d-m-Y-H:i:s").'.pdf';
        $pdf = $this->t_cpdf->load();
		
		// set margins
		$pdf->SetMargins(10, 10, 10);
		//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, 25);

		// set image scale factor
		$pdf->setImageScale(1.53);
		
        $pdf->AddPage();        
        $pdf->WriteHTML($html, true, false, true, false, '');
		$pdf->lastPage();
        $pdf->Output($pdfFilePath, "D");
	}
	
	public function download()
	{
		$lesson_id = $this->session->userdata('lesson_orogin');
		$lesson_info = $this->Lesson_model->get_lessonby_id($lesson_id);
		$module_name = str_replace(' ', '_', $lesson_info['module_name']);
		$file_name = $module_name.'_lesson_'.$lesson_info['lesson_position'].date("d-m-Y-H:i:s").'.pdf';
		$file_content = file_get_contents('attachments/lessons/'.$lesson_info['lesson_attach_file']);
		force_download($file_name, $file_content, NULL);
	}
	
	public function get_less_content()
	{
		$lession_id = $this->input->post('lesson');
		$module_id = $this->input->post('data_module');
		$phase_level = $this->input->post('phase');
		$get_lesson_info = $this->Lesson_model->get_lessonby_id($lession_id);
		if($get_lesson_info == true)
		{
			$ins_read = array(
							'lessread_module_id' => $module_id,
							'lessread_lesson_id' => $lession_id,
							'lessread_user_id' => $this->session->userdata('active_student'),
						);
			$this->db->insert('starter_lesson_reading_completed', $ins_read);
		}
		
		$has_completed = completed_module($module_id);
		if($has_completed == true)
		{
			$active_phase = $this->Lesson_model->get_active_phase($this->session->userdata('active_student'));
			$max_mdl = $this->Lesson_model->get_max_mdl($module_id, $active_phase);
			$this->db->where('student_id', $this->session->userdata('active_student'));
			$this->db->update('starter_students', array('student_active_module' => $max_mdl));
			$sess['active_module'] = $max_mdl;
			$this->session->set_userdata($sess);
			$part_has_completed = 1;
		}elseif($has_completed == false)
		{
			$part_has_completed = 0;
		}else
		{
			$part_has_completed = 0;
		}
		if($phase_level == '1'){
			$exm_phase = 'Phase-A';
		}elseif($phase_level == '2'){
			$exm_phase = 'Phase-B';
		}elseif($phase_level == '3'){
			$exm_phase = 'Phase-C';	
		}elseif($phase_level == '4'){
			$exm_phase = 'Phase-D';	
		}
		else
		{
			$exm_phase = 'Phase-A';
		}
		
		/*$content = '<div class="cnt-body">
					<div class="lesson-title-header">'.$get_lesson_info['lesson_title'].'</div>
					<div class="lesson-body-content">'.$get_lesson_info['lesson_content'].'</div>
					'.if(!empty($get_lesson_info['lesson_attach_file'])) {.'<div class="lesson-body-content"><iframe src="'.base_url().'attachments/lessons/'.$get_lesson_info['lesson_attach_file'].'" width="100%" height="auto"></iframe></div>'.}.'<div class="lesson-downld-exam-links">
						<div class="lesson-download-lnk downld-btn-ext" data-target="#sendOtp" data-toggle="modal" data-lesson="'.$get_lesson_info['lesson_id'].'"><i class="fa fa-download"></i> Download</div>
						<div class="lesson-exam-lnk"><a target="_blank" href="'.base_url('student/exam/prcstart/End-Lesson/'.$exm_phase.'/START?module='.$module_id.'&lesson='.$get_lesson_info['lesson_id'].'&type=practice').'">Start practice based on your study</a></div>
					</div>
					</div>
					';*/

		$content = '<div class="cnt-body">
					<!--<div class="lesson-title-header">'.$get_lesson_info['lesson_title'].'</div>--><div class="lesson-body-content">'.$get_lesson_info['lesson_content'].'</div>';
		if(!empty($get_lesson_info['lesson_attach_file'])){
			$content .='<iframe src="'.base_url().'attachments/lessons/'.$get_lesson_info['lesson_attach_file'].'#toolbar=0" width="100%" height="500px"></iframe>';
		}
		$content .= '<div class="lesson-downld-exam-links">
						<div class="lesson-download-lnk downld-btn-ext" data-target="#sendOtp" data-toggle="modal" data-lesson="'.$get_lesson_info['lesson_id'].'"><i class="fa fa-download"></i> Download</div>
						<div class="lesson-exam-lnk"><a target="_blank" href="'.base_url('student/exam/prcstart/End-Lesson/'.$exm_phase.'/START?module='.$module_id.'&lesson='.$get_lesson_info['lesson_id'].'&type=practice').'">Start practice based on your study</a></div>
					</div>
					</div>';

		$result = array('status' => 'ok', 'content' => $content, 'part_has_completed' => $part_has_completed);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
}