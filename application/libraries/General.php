<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class General extends CI_Controller
{	
	
	function __construct() {

	}
	
	function loadCalIns()
	{
		$str	= "
<link type='text/css' href='".base_url('vendore/calendar/styles/jquery-ui-1.8.14.css')."' rel='stylesheet' />
<script type='text/javascript' src='".base_url('vendore/calendar/scripts/jquery-1.6.2.min.js')."'></script>
<script type='text/javascript' src='".base_url('vendore/calendar/scripts/jquery.ui.core.js')."'></script>
<script type='text/javascript' src='".base_url('vendore/calendar/scripts/jquery.ui.datepicker-cc.js')."'></script>
<script type='text/javascript' src='".base_url('vendore/calendar/scripts/calendar.js')."'></script>
<script type='text/javascript' src='".base_url('vendore/calendar/cripts/jquery.ui.datepicker-cc-ar.js')."'></script>
<script type='text/javascript' src='".base_url('vendore/calendar/scripts/jquery.ui.datepicker-cc-fa.js')."'></script>";
		return $str;
	}
	
	function loadHeader()
	{
		$page = get_instance();
		require_once(BASE_PATH.'/application/views/commonCode/mainpagevHead.php');
	}	
	
	function loadFooter()
	{
		$page = get_instance();
		require_once(BASE_PATH.'/application/views/commonCode/mainpagevFoot.php');
	}
	
	function hashStr($str)
	{
		return md5(sha1(md5(sha1($str))));
	}
	
	
	function div($a,$b) {
		return (int) ($a / $b);
	}

	function showSaveCancel($backPage='')
	{
		$obj		= get_instance();
		$backPage	= $backPage ? $backPage : base_url('mainpage');
		$str	= "<button type='submit' style='margin:5px'>{$obj->lang->line('tit_Submit')}</button><button type='button' style='margin:5px' onclick='if(confirm(\"Would you like to ignore\")) window.location=\"".$backPage."\"'>";
		$str	.= $obj->lang->line('tit_Ignore');
		$str	.= "</button>";
		return $str;
	}
	
	function Encrypt($pure_string) {
		$encryption_key	= config_item('encryption_key');
	    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
	    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	    $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $encryption_key, utf8_encode($pure_string), MCRYPT_MODE_ECB, $iv);
	    return $encrypted_string;
	}
	
	public function Decrypt($encrypted_string) {
		$encryption_key		= config_item('encryption_key');
	    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
	    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	    $decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $encryption_key, $encrypted_string, MCRYPT_MODE_ECB, $iv);
	    return $decrypted_string;
	}

	function base64url_encode($data) {
		$data	= 'HadiHeydariham'.$data;
	  return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
	}

	function base64url_decode($data) {
		$temp	= base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
	  return substr($temp,14);
	} 

	function translateError($resultArr)
	{
		$msg		= $resultArr['message'];
		if($resultArr['code']==1062)
		{
			$obj		= get_instance();
			$msg		= $obj->lang->line('msg_Record_already_exists');
		}
		return $msg;
	}

###__________________________________________________________________________________________Date Function
	function division($a,$b) {
		return (int) ($a / $b);
	}

	function gor2jal($gorgian,$retunString=false)
	{
		if(preg_match('/0000-00-00/',$gorgian))
			return '';
		$data = explode('-',$gorgian);
		$result = $this->gregorian_to_jalali($data[0],$data[1],$data[2]);
		return $retunString? $result[0].'/'.$result[1].'/'.$result[2] : $result;
	}

	function jal2gor($jalali,$sep='/')
	{
		$data   = explode('/',$jalali);
		$temp   = $this->jalali_to_gregorian ($data[0],$data[1],$data[2]);
		return  $temp[0].$sep.$temp[1].$sep.$temp[2];
	}

	function gregorian_to_jalali ($g_y, $g_m, $g_d)
	{
		$g_days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
		$j_days_in_month = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);
		$gy = $g_y-1600;
		$gm = $g_m-1;
		$gd = $g_d-1;
		$g_day_no = 365*$gy+$this->division($gy+3,4)-$this->division($gy+99,100)+$this->division($gy+399,400);

		for ($i=0; $i < $gm; ++$i)
			$g_day_no += $g_days_in_month[$i];
		if ($gm>1 && (($gy%4==0 && $gy%100!=0) || ($gy%400==0)))
		/* leap and after Feb */
			$g_day_no++;
		$g_day_no += $gd;

		$j_day_no = $g_day_no-79;
		$j_np = $this->division($j_day_no, 12053); /* 12053 = 365*33 + 32/4 */
		$j_day_no = $j_day_no % 12053;
		$jy = 979+33*$j_np+4*$this->division($j_day_no,1461); /* 1461 = 365*4 + 4/4 */
		$j_day_no %= 1461;
		if ($j_day_no >= 366) 
		{
			$jy += $this->division($j_day_no-1, 365);
			$j_day_no = ($j_day_no-1)%365;
		}

		for ($i = 0; $i < 11 && $j_day_no >= $j_days_in_month[$i]; ++$i)
			$j_day_no -= $j_days_in_month[$i];
		$jm = $i+1;
		$jm	= str_pad($jm,2,"0",STR_PAD_LEFT);

		$jd = $j_day_no+1;
		$jd	= str_pad($jd,2,"0",STR_PAD_LEFT);
		return array($jy, $jm, $jd);
	}

	function jalali_to_gregorian($j_y,$j_m,$j_d)
	{
		$g_days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
		$j_days_in_month = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);

		$jy = $j_y-979;
		$jm = $j_m-1;
		$jd = $j_d-1;

		$j_day_no = 365*$jy + $this->division($jy, 33)*8 + $this->division($jy%33+3, 4);
		for ($i=0; $i < $jm; ++$i)
			$j_day_no += $j_days_in_month[$i];

		$j_day_no += $jd;
		$g_day_no = $j_day_no+79;
		$gy = 1600 + 400*$this->division($g_day_no, 146097); /* 146097 = 365*400 + 400/4 - 400/100 + 400/400 */
		$g_day_no = $g_day_no % 146097;
		$leap = true;
		if ($g_day_no >= 36525) /* 36525 = 365*100 + 100/4 */
		{
			$g_day_no--;
			$gy += 100*$this->division($g_day_no,  36524); /* 36524 = 365*100 + 100/4 - 100/100 */
			$g_day_no = $g_day_no % 36524;
			if ($g_day_no >= 365)
				$g_day_no++;
			else
				$leap = false;
		}

		$gy += 4*$this->division($g_day_no, 1461); /* 1461 = 365*4 + 4/4 */
		$g_day_no %= 1461;

		if ($g_day_no >= 366) 
		{
			$leap = false;
			$g_day_no--;
			$gy += $this->division($g_day_no, 365);
			$g_day_no = $g_day_no % 365;
		}

		for ($i = 0; $g_day_no >= $g_days_in_month[$i] + ($i == 1 && $leap); $i++)
			$g_day_no -= $g_days_in_month[$i] + ($i == 1 && $leap);
		$gm = $i+1;
		$gm	= str_pad($gm,2,"0",STR_PAD_LEFT);
		$gd = $g_day_no+1;
		$gd	= str_pad($gd,2,"0",STR_PAD_LEFT);
		return array($gy,$gm,$gd);
	}		
###__________________________________________________________________________________________
}
//end