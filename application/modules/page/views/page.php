<?php 
	defined('BASEPATH') OR exit('No direct script access allowed');
	$get_pageinfo = $this->Page_model->get_single_page($slug);
	if($get_pageinfo == true):
		echo null;
		//$seo = array("title" => $get_pageinfo['page_title'], "meta_key" => $get_pageinfo['page_meta_key'], "meta_description" => $get_pageinfo['page_meta_discription']);
	else : redirect('not-found');
	endif;
	require_once APPPATH.'modules/common/header.php';
	require_once APPPATH.'modules/page/template/page_content.php';
	require_once APPPATH.'modules/common/footer.php';