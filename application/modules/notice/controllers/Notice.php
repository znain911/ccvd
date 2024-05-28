<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notice extends CI_Controller {
	
	private $sqtoken;
	private $sqtoken_hash;
	
	public function __construct()
	{
      parent::__construct();
	  date_default_timezone_set('Asia/Dhaka');
	  $this->sqtoken = $this->security->get_csrf_token_name();
	  $this->sqtoken_hash = $this->security->get_csrf_hash();
	  $this->load->model('Notice_model');
	  $this->load->library('session');
      $this->load->helper('form');
	  $this->load->library('sendmaillib');
	}
	
	public function index()
	{
		$data['notice_list'] = $this->Notice_model->get_notice();
      $this->load->view('index',$data);
	}
	public function details($id)
	{
		$data['notice_dtl'] = $this->Notice_model->get_noticeDetail($id);
      $this->load->view('details',$data);
	}
	
	public function emailsend() {
        $this->load->helper('form');
        $this->load->view('contact_email_form');
    }
    public function send_mail() {
        $from_email = "ccvd@ibrahimcardiac.org.bd";
        $to_email = $this->input->post('email');
        //Load email library
        /*$this->load->library('email');
        $config = array();
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'ssl://smtp.googlemail.com';
		$config['smtp_user'] = 'dlp.coordinator@dldchc-badas.org.bd';
		$config['smtp_pass'] = 'Dlp@2018-badas';
		$config['smtp_port'] = 465;
		$this->email->initialize($config);
		$this->email->set_newline("\r\n");
        $this->email->from($from_email, 'Identification');
        $this->email->to($to_email);
        $this->email->subject('Send Email Codeigniter');
        $this->email->message('The email send using codeigniter library');*/
        $this->sendmaillib->from('ccvd@ibrahimcardiac.org.bd');
		$this->sendmaillib->to('sazedul.tuhin@gmail.com');
		$this->sendmaillib->subject('Your application has been approved');
		$this->sendmaillib->content('Test mail');
		//$this->sendmaillib->send();
        //Send mail
        if($this->sendmaillib->send())
            $this->session->set_flashdata("email_sent","Congragulation Email Send Successfully.");
        else
            $this->session->set_flashdata("email_sent","You have encountered an error");
        $this->load->view('contact_email_form');
    }
	
	public function tmpltemail() {
        $name = 'Mr. Test';
            $email = 'sazedul.tuhin@gmail.com';
            $contact_no = '01712007362';
            $company = 'SHT';
            $subject = 'Inquery for Test';
            $comment = 'Test Message';
            $moqdata = 'moq';
            $to='tuhin06114@gmail.com';
            //$cc=' info@eqtlbd.com,j.alam@eqtlbd.com,al.amin@eqtlbd.com';
            if(!empty($email)) {
                // send mail
                $config = array (
                  'mailtype' => 'html',
                  'charset'  => 'utf-8',
                  'priority' => '1'
                );
                $message='';
                $bodyMsg = '<p style="font-size:14px;font-weight:normal;margin-bottom:10px;margin-top:0;">'.$comment.'<br>MOQ: '.$moqdata.'</p>';   
                $delimeter = $name."<br>Company: ".$company."<br>".$contact_no;
                $dataMail = array('topMsg'=>$subject, 'bodyMsg'=>$bodyMsg, 'thanksMsg'=>'Best regards,', 'delimeter'=> $delimeter);

                $this->email->initialize($config);
                $this->email->from($email, $name);
                $this->email->to($to);
                //$this->email->cc($cc);
                $this->email->subject('Contact Form-'.$subject);
                $message = $this->load->view('contactTemplate', $dataMail, TRUE);
                $this->email->message($message);
                $this->email->send();
    }
    }
	
	
}
