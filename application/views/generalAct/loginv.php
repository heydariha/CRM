<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$title		= isset($title) ? $title : 'ddd';
$page		= new PAGE();
$page->DIRECTION = '';
$page->headPage();
?>

<link rel="StyleSheet" type="text/css" href="<?php echo base_url('vendore/login/');?>style.css"/>
<body>
<?php 
	$loginErr	= '';
	if( !isset($msg))
	{
		if($msg[1] == "login_error")
			$loginErr	= "<center><h5 style='color:red'>".$msg[0].$this->lang->line($msg[1])."</h5></center>";
	}	
?>

<div id="auth"> <img class="logo" src="<?php echo base_url('vendore/login/');?>images/logo.png"/>
  <form action="<?php echo base_url('login/authenticating');?>" method="post" id="frmAuth" >
    <span class="title">اطلاعات ورود</span>
	<!--نام کاربری:-->
    <input class="input" type="text" name="email" id="email" required autofocus placeholder="<?php echo $this->lang->line('tit_Username')?>" autocomplete="off" value='<?php echo $this->input->get_post('runame');?>' />
    <!--رمز عبور:<br/>-->
    <input class="input" type="password" name="password" id="password" required autocomplete="off" placeholder="<?php echo $this->lang->line('tit_Password')?>" autocomplete="off" />
    <br/>
    <input class="button" type="submit" name="sumbit" value="ورود"/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="action" href="#">عضویت</a>&nbsp;
	<a class="action" href="#">پسوردتان را فراموش کرده اید؟</a>

  </form>
</div>
