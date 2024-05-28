<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include_once APPPATH.'/third_party/TCPDF/tcpdf.php';
class T_cpdf {
    
    function load($param=NULL)
    { 
        return new tcpdf($param);
    }
}