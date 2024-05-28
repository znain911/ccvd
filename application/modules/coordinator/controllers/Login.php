<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	
	private $sqtoken;
	private $sqtoken_hash;
	
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Dhaka');
		$this->sqtoken = $this->security->get_csrf_token_name();
		$this->sqtoken_hash = $this->security->get_csrf_hash();
		
		$active_user = $this->session->userdata('active_user');
		$userLogin = $this->session->userdata('userLogin');
		if($active_user !== NULL && $userLogin === TRUE)
		{
			redirect('coordinator/dashboard', 'refresh', true);
		}
		
		$this->load->model('Login_model');
	}
	
	public function index()
	{
		$this->load->view('login');
		/*$this->load->view('maintenance');*/
	}
	
	public function forget()
	{
		$this->load->view('login_forget');
	}
	
	//check user's login credentials
	public function checkadmin()
	{	
		//load form validation library
		$this->load->library('form_validation');
		
		$email = html_escape($this->input->post('email'));
		$password = sha1(html_escape($this->input->post('password')));
		$validate = array(
						array(
							'field' => 'email',
							'label' => 'Email',
							'rules' => 'required|trim|valid_email'
						),
						array(
							'field' => 'password',
							'label' => 'Password',
							'rules' => 'required|trim'
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			$isExitEmail = $this->Login_model->check_credential($email, $password);
			if($isExitEmail == true)
			{
				//Check user status (active OR deactive)
				if($isExitEmail->owner_activate !== '1')
				{
					$warning_alert = '<div class="alert alert-warning" role="alert">Account has blocked!</div>';
					$result = array("status" => "warning", "warning" => $warning_alert);
					$result[$this->sqtoken] = $this->sqtoken_hash;
					echo json_encode($result);
					exit;
				}else
				{
					$show_last['admllg'] = $isExitEmail->owner_last_login;
					$this->session->set_userdata($show_last);
					$logg['owner_login_ip'] = $this->input->ip_address();
					$logg['owner_last_login'] = date("Y-m-d H:i:s", strtotime("+6 hours"));
					$this->Login_model->update_admin($isExitEmail->owner_id, $logg);
					$activate['full_name'] = $isExitEmail->owner_name;
					$activate['active_user'] = $isExitEmail->owner_id;
					$activate['admin_photo'] = $isExitEmail->owner_photo;
					$activate['role'] = $isExitEmail->owner_role_id;
					$activate['userLogin'] = TRUE;
					$this->session->set_userdata($activate);
					$success_alert = '<div class="alert alert-success" role="alert">Login Success! Redirecting...</div>';
					$result = array("status" => "ok", "success" => $success_alert);
					echo json_encode($result);
					exit;
				}
			}else
			{
				$error_alert = '<div class="alert alert-danger" role="alert">Email Or Password incorrect!</div>';
				$result = array("status" => "failed_error", "error" => $error_alert);
				$result[$this->sqtoken] = $this->sqtoken_hash;
				echo json_encode($result);
				exit;
			}
		}else
		{
			$error_alert = '<div class="alert alert-danger" role="alert">'.validation_errors().'</div>';
			$result = array("status" => "valid_error", "validation_error" => $error_alert);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
	}
	
	//recover lost password
	public function recover()
	{
		$this->load->view('recover');
	}
	
	//Send email with reset code
	public function checkemail()
	{
		$email = html_escape($this->input->post('email'));
		$check_email = $this->Login_model->check_exist_email($email);
		if($check_email == true){
			
			$resetdigit = rand(132949,999999);
			$data['owner_passwrd_resetcd'] = sha1($resetdigit);
			$message_subject = "Your Password Reset Code";
			$rest['subject'] = $message_subject;
			$rest['reset_code'] = 'Your password reset code is - '.$resetdigit;
			$body = $this->load->view('preset_email', $rest, true);
			$this->Login_model->update_reset_code($check_email->owner_id, $data);
			/*Send An Emain Congratulation*/
			$config = Array(
				'protocol' => 'smtp',
				'smtp_host' => 'ssl://smtp.googlemail.com',
				'smtp_port' => 465,
				'smtp_user' => 'info@kroysale.com',
				'smtp_pass' => 'MosTak+Sumi019',
				'mailtype'  => 'html', 
				'charset'   => 'iso-8859-1',
				'wordwrap' => TRUE
			);
			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");
			$this->email->from('info@kroysale.com', 'Kroysale.com');
			
			$this->email->to($check_email->owner_email); 
			$this->email->subject($message_subject);
			$this->email->set_header('MIME-Version', '1.0; charset=utf-8');
			$this->email->set_header('Content-type', 'text/html');
			$this->email->message($body); 
			$this->email->send();
			
			$sess['reset_success'] = TRUE;
			$sess['gt_wnr'] = $check_email->owner_id;
			$this->session->set_userdata($sess);
			$result = array("status" => "ok");
			echo json_encode($result);
			exit;
			
		}else
		{
			$error_message = '<div class="alert alert-danger">Email is incorrect!</div>';
			$result = array("status" => "error", "error_message" => $error_message);
			echo json_encode($result);
			exit;
		}
	}
	
	//load reset form
	public function resetform()
	{
		if($this->session->userdata('reset_success') !== TRUE)
		{
			redirect('smartadmin/recover');
		}else
		{
			$this->load->view('reset_code');
		}
	}
	
	//check reset code
	public function checkcode()
	{
		$reset_code = sha1(html_escape($this->input->post('resetcd')));
		$user_id = $this->session->userdata('gt_wnr');
		$result = $this->Login_model->check_resetcode($reset_code, $user_id);
		if($result == true)
		{
			$data['owner_passwrd_resetcd'] = null;
			$this->Login_model->update_reset_code($result->owner_id, $data);
			$sess['code_success'] = TRUE;
			$this->session->set_userdata($sess);
			$jsresult = array("status" => "ok");
			echo json_encode($jsresult);
			exit;
		}else
		{
			$error_alert = '<div class="alert alert-danger" role="alert">Sorry! The reset code is wrong.</div>';
			$jsresult = array("status" => "notok", "error" => $error_alert);
			echo json_encode($jsresult);
			exit;
		}
	}
	
	//load new password form
	public function newpassword()
	{
		if($this->session->userdata('code_success') !== TRUE)
		{
			redirect('smartadmin/resetform');
		}else
		{
			$this->load->view('reset_form');
		}
	}
	
	//update password
	public function update_password()
	{
		$data['owner_password'] = sha1(html_escape($this->input->post('newpass')));
		$owner_id = $this->session->userdata('gt_wnr');
		$this->Login_model->update_password($owner_id, $data);
		$sess['updt_scss'] = TRUE;
		$this->session->set_userdata($sess);
		$result = array("status" => "ok");
		echo json_encode($result);
		exit;
	}
	
	// password reset success.
	public function success()
	{
		if($this->session->userdata('updt_scss') !== TRUE)
		{
			redirect('smartadmin/newpassword');
		}else
		{
			$this->session->unset_userdata('reset_success');
			$this->session->unset_userdata('gt_wnr');
			$this->session->unset_userdata('code_success');
			$this->session->unset_userdata('updt_scss');
			$this->load->view('success');
		}
	}
}
