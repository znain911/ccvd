<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller{
	
	private $sqtoken;
	private $sqtoken_hash;
	
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Dhaka');
		$this->sqtoken = $this->security->get_csrf_token_name();
		$this->sqtoken_hash = $this->security->get_csrf_hash();
		
		$active_student = $this->session->userdata('active_student');
		$studentLogin = $this->session->userdata('studentLogin');
		if($active_student === NULL && $studentLogin !== TRUE)
		{
			redirect('student/login', 'refresh', true);
		}
		
		$this->load->model('Dashboard_model');
	}
	
	public function index()
	{
		$prefs = array(
				'start_day'      => 'sunday',
				'month_type'     => 'long',
				'day_type'       => 'short',
				'show_next_prev' => TRUE,
				'next_prev_url'  => base_url('student/dashboard/index'),
		);
		$prefs['template'] = '
								{table_open}<table border="1" cellpadding="5" cellspacing="0">{/table_open}

								{heading_row_start}<tr>{/heading_row_start}

								{heading_previous_cell}<th><a href="{previous_url}"><i class="ion-ios-arrow-back"></i></a></th>{/heading_previous_cell}
								{heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}
								{heading_next_cell}<th><a href="{next_url}"><i class="ion-ios-arrow-forward"></i></a></th>{/heading_next_cell}

								{heading_row_end}</tr>{/heading_row_end}

								{week_row_start}<tr>{/week_row_start}
								{week_day_cell}<td>{week_day}</td>{/week_day_cell}
								{week_row_end}</tr>{/week_row_end}

								{cal_row_start}<tr>{/cal_row_start}
								{cal_cell_start}<td class="day"><span>{/cal_cell_start}
								{cal_cell_start_today}<td class="today"><span>{/cal_cell_start_today}
								{cal_cell_start_other}<td class="other-month"><span>{/cal_cell_start_other}

								{cal_cell_content}{content}{day}</span>{/cal_cell_content}
								{cal_cell_content_today}<span class="highlight">{day}</span>{/cal_cell_content_today}

								{cal_cell_no_content}<span>{day}</span>{/cal_cell_no_content}
								{cal_cell_no_content_today}<span class="highlight">{day}</span>{/cal_cell_no_content_today}

								{cal_cell_blank}<span>&nbsp;</span>{/cal_cell_blank}

								{cal_cell_other}<span>{day}</span>{/cal_cel_other}

								{cal_cell_end}</span></td>{/cal_cell_end}
								{cal_cell_end_today}</span></td>{/cal_cell_end_today}
								{cal_cell_end_other}</span></td>{/cal_cell_end_other}
								{cal_row_end}</tr>{/cal_row_end}

								{table_close}</table>{/table_close}
						';
		$this->load->library('calendar', $prefs);
		$this->load->view('dashboard');
	}
	
	
}