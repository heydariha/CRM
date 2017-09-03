<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class PAGE extends CI_Controller{
    var $HEAD			= '';
    var $FOOT			= '';
    var $DIRECTION		= 'rtl';
    var $title			= 'Pooyaservice';
    var $icon			= '';
    var $acse			= '';
    var $keyWord		= 'PooyaService';
//_________________________________________________
	function __construct()
	{
		// $it =& get_instance();
		// $it->authentication->checkSession();
	}
//_________________________________________________
    function headPage()
    {
        global $confArray;
        //<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.1//EN' 'http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd'>
        //<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN' 'http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd'>
		// <link rel='author' href='http://hamgroup.ir/license/lco.php?flag=web&application&php' type='image/icon' />
        $HEAD = "<!DOCTYPE html>
		<!--[if IE 8]>			<html class='ie ie8'> <![endif]-->
		<!--[if IE 9]>			<html class='ie ie9'> <![endif]-->
		<!--[if gt IE 9]><!-->	<html> <!--<![endif]-->
        <head>
            <link rel='shortcut icon' href='{$this->icon}' type='image/ico'/>
			<title> {$this->title} </title>
			
			<!-- Meta -->
			<meta charset='utf-8'>
			<META HTTP-EQUIV='Content-Type' CONTENT='text/html;charset=utf-8'>
			<meta name='description' content='Farhoonet'>
			<meta name='author' content='Farhoonet'>
			<!-- Mobile Meta -->
			<meta name='viewport' content='width=device-width, initial-scale=1.0'>
			
			<meta name='keywords' content='{$this->keyWord}'>
			{$this->acse}
			
        </head>
        <body dir='{$this->DIRECTION}'>
        <div id='modalContentDiv'></div>
        <div id='ERROR'></div>";
        echo $HEAD.$this->HEAD;
    }
//_________________________________________________
    function footPage()
    {
//<div>Copyright © 2006 Company. All Rights Reserved. XHTML 1.1 | CSS | design/inspired by growldesign</div>
         $this->FOOT = "
		</body>
	</html>";
        echo $this->FOOT;
    }
}

?>