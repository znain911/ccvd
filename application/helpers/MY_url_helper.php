<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function current_url()
{
    $CI =& get_instance();
    $url = $CI->config->site_url($CI->uri->uri_string());
    return $_SERVER['QUERY_STRING'] ? $url.'?'.$_SERVER['QUERY_STRING'] : $url;
}

// function for sms
/* function sendsms($number, $message)
{
	$user = "cthealth"; 
	$pass = "CT@ihUHCC11"; 
	$sid = "DLP"; 
	$url="http://sms.sslwireless.com/pushapi/dynamic/server.php";
	$param="user=$user&pass=$pass&sms[0][0]=$number&sms[0][1]=".urlencode($message)."&sid=$sid";
	$crl = curl_init();
	curl_setopt($crl,CURLOPT_SSL_VERIFYPEER,FALSE);
	curl_setopt($crl,CURLOPT_SSL_VERIFYHOST,2);
	curl_setopt($crl,CURLOPT_URL,$url); 
	curl_setopt($crl,CURLOPT_HEADER,0);
	curl_setopt($crl,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($crl,CURLOPT_POST,1);
	curl_setopt($crl,CURLOPT_POSTFIELDS,$param); 
	$response = curl_exec($crl);
	curl_close($crl);
} */

function sendsms($number, $message) {
  $url = "";
  $data = [
    "api_key" => "",
    "type" => "text",
    "contacts" => $number,
    "senderid" => "",
    "msg" => $message,
  ];

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  $response = curl_exec($ch);
  curl_close($ch);
  return $response;
}

function menu_item_activate($url_param)
{
	$CI =& get_instance();
	$url = $CI->load->helper('url');
	
	$segment = $url->uri->segment(2);
	
	if($segment == $url_param)
	{
		return 'active';
	}else
	{
		return null;
	}
	
}

function submenu_item_activate($url_param, $url_param2)
{
	$CI =& get_instance();
	$url = $CI->load->helper('url');
	
	$segment = $url->uri->segment(2);
	$segment2 = $url->uri->segment(3);
	
	if($segment == $url_param && $segment2 == $url_param2)
	{
		return 'active';
	}else
	{
		return null;
	}
	
}

function student_item_activate($url_param, $url_param2)
{
	$CI =& get_instance();
	$url = $CI->load->helper('url');
	
	$segment = $url->uri->segment(1);
	$segment2 = $url->uri->segment(2);
	
	if($segment == $url_param && $segment2 == $url_param2)
	{
		return 'active';
	}else
	{
		return null;
	}
	
}

function submenu_singleitem_queryactivate($url_param, $key, $value=null)
{
	$CI =& get_instance();
	$url = $CI->load->helper('url');
	
	$segment = $url->uri->segment(2);
	
	if($segment == $url_param && isset($_GET[$key]) && $_GET[$key] === $value)
	{
		return 'active';
	}else
	{
		return null;
	}
	
}

function submenu_item_queryactivate($url_param, $url_param2, $key, $value)
{
	$CI =& get_instance();
	$url = $CI->load->helper('url');
	
	$segment = $url->uri->segment(2);
	$segment2 = $url->uri->segment(3);
	
	if($segment == $url_param && $segment2 == $url_param2 && isset($_GET[$key]) && $_GET[$key] === $value)
	{
		return 'active';
	}else
	{
		return null;
	}
	
}

function active_chat_link($param, $value, $param3=false)
{
	if(isset($_GET[$param]) && $_GET[$param] === $value)
	{
		$class = 'btn-success active';
	}elseif(!isset($_GET[$param]) && $param3 !== false){
		$class = 'btn-success active';
	}else{
		$class = null;
	}
	return $class;
}

/******For Live Environment******/

function attachment_dir($param=null)
{
	if($param !== null)
	{
		if ($_SERVER['HTTP_HOST']=='ccvd.ibrahimcardiac.org.bd') {
			$dir = $_SERVER['DOCUMENT_ROOT']."/attachments/".$param;
		}else{
			$dir = $_SERVER['DOCUMENT_ROOT']."/eccvd/attachments/".$param;
		}
	}else
	{
		if ($_SERVER['HTTP_HOST']=='ccvd.ibrahimcardiac.org.bd') {
			$dir = $_SERVER['DOCUMENT_ROOT']."/attachments/";
		}else{
			$dir = $_SERVER['DOCUMENT_ROOT']."/eccvd/attachments/";
		}
	}
	
	return $dir;
}

function attachment_url($param=null)
{
	if($param !== null)
	{
		if($_SERVER['HTTP_HOST'] == 'ccvd.ibrahimcardiac.org.bd')
		{
			$url = "https://ccvd.ibrahimcardiac.org.bd/attachments/".$param;
		}else
		{
			$url = "http://localhost/eccvd/attachments/".$param;
		}
	}else
	{
		if($_SERVER['HTTP_HOST'] == 'ccvd.ibrahimcardiac.org.bd')
		{
			$url = "https://ccvd.ibrahimcardiac.org.bd/attachments/";
		}else
		{
			$url = "http://localhost/eccvd/attachments/";
		}
	}
	
	return $url;
}

function completed_module($module_id=null)
{
	$CI =& get_instance();
	$get_class = false;
	if($module_id == null)
	{
		return false;
	}else{
		$user_id = $CI->session->userdata('active_student');
		$query = $CI->db->query("SELECT lessread_id FROM starter_lesson_reading_completed 
								 WHERE starter_lesson_reading_completed.lessread_module_id='$module_id' 
								 AND starter_lesson_reading_completed.lessread_user_id='$user_id'");
		$query_two = $CI->db->query("SELECT lesson_id FROM starter_modules_lessons WHERE starter_modules_lessons.lesson_module_id='$module_id'");
		$result_one = $query->num_rows();
		$result_two = $query_two->num_rows();
		
		if($result_one == $result_two)
		{
			$get_class = true;
		}else
		{
			$get_class = false;
		}
	}
	
	return $get_class;
}

function pca_exam_activate()
{
	date_default_timezone_set('Asia/Dhaka');
	$CI =& get_instance();
	$marks_config = $CI->db->query("SELECT * FROM starter_marks_config WHERE starter_marks_config.mrkconfig_key='One_Time' LIMIT 1");
	$get_mrks_config = $marks_config->row_array();
	$plus_time = $get_mrks_config['mrkconfig_exam_date'];
	
	$student_id = $CI->session->userdata('active_student');
	$query = $CI->db->query("SELECT student_regdate FROM starter_students WHERE starter_students.student_id='$student_id' LIMIT 1");
	$result = $query->row_array();
	$register_date = date("Y-m-d H:i:s", strtotime($result['student_regdate']));
	$after_four_week = date("Y-m-d", strtotime($register_date.'+'.$plus_time));
	$current_date = date("Y-m-d");
	$get_class = '';
	if(strtotime($current_date) <= strtotime($after_four_week))
	{
		$get_class = 'active-exm-bttn'; 
	}
	
	return $get_class;
}

function users_directory($param=null)
{
	if($param !== null)
	{
		if ($_SERVER['HTTP_HOST']=='ccvd.ibrahimcardiac.org.bd') {
			$dir = $_SERVER['DOCUMENT_ROOT']."/attachments/".$param;
		}else{
			$dir = $_SERVER['DOCUMENT_ROOT']."/eccvd/attachments/".$param;
		}
	}else
	{
		if ($_SERVER['HTTP_HOST']=='ccvd.ibrahimcardiac.org.bd') {
			$dir = $_SERVER['DOCUMENT_ROOT']."/attachments/";
		}else{
			$dir = $_SERVER['DOCUMENT_ROOT']."/eccvd/attachments/";
		}
	}
	
	return $dir;
}


function booking_schedule_range($booking_id, $schedule_type)
{
	if($schedule_type == 'SDT')
	{
		$sel_table = 'starter_sdt_schedule';
	}elseif($schedule_type == 'WORKSHOP')
	{
		$sel_table = 'starter_workshop_schedule';
	}elseif($schedule_type == 'ECE')
	{
		$sel_table = 'starter_ece_exschedule';
	}
	
	$CI =& get_instance();
	$query = $CI->db->query("SELECT endmschedule_from_date, endmschedule_to_date FROM $sel_table WHERE $sel_table.endmschedule_id='$booking_id' LIMIT 1");
	$result = $query->row_array();
	if($result == true)
	{
		$range = '<strong>'.$result['endmschedule_from_date'].'</strong> to <strong>'.$result['endmschedule_to_date'].'</strong>';
	}else
	{
		$range = null;
	}
	
	return $range;
}

function send_dynamic_email($to, $subject, $body)
{
	$CI =& get_instance();
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
	
	$CI->load->library('email', $config);
	$CI->email->set_newline("\r\n");
	$CI->email->from('dlp.coordinator@dldchc-badas.org.bd', 'Certificate Course on Cardiovascular Disease (CCVD)');
	
	$CI->email->to($to); 
	$CI->email->subject($subject);
	$CI->email->set_crlf('\r\n');
	$CI->email->set_header('MIME-Version', '1.0; charset=utf-8');
	$CI->email->set_header('Content-Type', 'text/html');
	$CI->email->message($body); 
	$CI->email->send();
}

function mail_body($data=array())
{
	$html = '
	<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<title>Certificate Course on Cardiovascular Disease (CCVD)</title>
	<style type="text/css">
		.main-title{
		color: #393939;
		text-align: left;
		text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
		}
		.main-title > span{
		color: #ffa500;
		font-weight: bold;
		text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
		}
		p.login-dtls{}
		p.regards-best{line-height:23px;}
		p {
		  color: #454545;
		  font-size: 14px;
		  text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
		}
		.aftr-pid, .login-dtls{line-height:22px;}
		.mail-container-bdy{
			background: #fff;
			padding: 37px 50px 50px;
			margin: 0px 150px;
		}
		.main-body{
			background:#3C73B1;
			padding:100px 0px;
			margin:0;
		}
		@media (min-width: 320px) and (max-width: 480px) {
			.main-body {
			  background: #3c73b1 none repeat scroll 0 0;
			  margin: 0;
			  padding: 5px;
			}
			.mail-container-bdy {
			  background: #fff none repeat scroll 0 0;
			  margin: 0;
			  padding: 10px 25px 30px;
			}
		}
		@media (min-width: 360px) and (max-width: 640px) {
			.main-body {
			  background: #3c73b1 none repeat scroll 0 0;
			  margin: 0;
			  padding: 5px;
			}
			.mail-container-bdy {
			  background: #fff none repeat scroll 0 0;
			  margin: 0;
			  padding: 10px 25px 30px;
			}
		}
		@media (min-width: 768px) and (max-width: 1024px) {
			.main-body {
			  background: #3c73b1 none repeat scroll 0 0;
			  margin: 0;
			  padding: 5px;
			}
			.mail-container-bdy {
			  background: #fff none repeat scroll 0 0;
			  margin: 0;
			  padding: 10px 25px 30px;
			}
		}
		@media (min-width: 980px) and (max-width: 1280px) {}
		@media (min-width: 980px) and (max-width: 1280px) {}
	</style>
</head>
<body class="main-body">
	<div class="mail-container-bdy">
		'.$data['mail_title'].'
		'.$data['mail_content'].'
		<p class="regards-best">
			Thanks & Regards <br />
			<strong>Coordinator</strong> <br />
			Distance Learning Programme (DLP)
		</p>
	</div>
</body>
</html>
	';
	
	return $html;
}
