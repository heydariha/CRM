<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$title		= isset($title) ? $title : 'ddd';
$page		= new PAGE();
$page->DIRECTION = '';
$page->headPage();

?>
<link rel="stylesheet" href="<?php echo base_url('vendore/css/style.css');?>">
<body>
<?php 
	$loginErr	= '';
	$rgistErr	= '';
	
	if( !isset($msg))
	{
		$msg = $this->session->flashdata('msg');
		if($msg[1]=='registration_error')
			$rgistErr	= "<center><h5 style='color:red'>".$msg[0].$this->lang->line($msg[1])."</h5></center>";
		else
		if($msg[1] == "login_error")
			$loginErr	= "<center><h5 style='color:red'>".$msg[0].$this->lang->line($msg[1])."</h5></center>";
	}	
?>

	<div class="body"></div>
	<div class="form">      
      <ul class="tab-group">
        <li class="tab active"><a href="#signup">Registration</a></li>
        <li class="tab"><a href="#login">Login</a></li>
      </ul>
      
      <div class="tab-content">
        <div id="signup">
          <h1 class="main_title">Free Registration</h1>
          
<?php
			echo 	$rgistErr ? $rgistErr : '';
?>
		  
          <form action="<?php echo base_url('login/register');?>" method="post">
          
          <div class="top-row">
            <div class="field-wrap">
              <input type="text" name="runame" required autocomplete="off" placeholder="*Name" value='<?php echo $this->input->get_post('runame');?>' />
            </div>
        
            <div class="field-wrap">
              <input type="text"  name="rufamily" required autocomplete="off" placeholder="*Family" value='<?php echo $this->input->get_post('rufamily');?>' />
            </div>
          </div>

          <div class="field-wrap">
            <input type="email"  name="remail" required autocomplete="on" placeholder="*Email" value='<?php echo $this->input->get_post('remail');?>' />
          </div>
          
          <div class="field-wrap">
            <label>
              <span class="req">Password*</span>
            </label>
            <input type="password"  id="rpassword" name="rpassword" required autocomplete="off"/>
          </div>
		  
			<div class="field-wrap">
				<label>
					<span class="req">*Repeat Password</span>
				</label>
				<input type="password" required autocomplete="off" name="rrepassword" id="rrepassword" />
			</div>
		  
          <button type="submit" class="button button-block"/>Submit</button>
          </form>

        </div>
        
        <div id="login">   
          <h1>wellcome</h1>
		  
<?php
			echo 	$loginErr ? $loginErr : '';
?>
		  
			<form action="<?php echo base_url('login/authenticating');?>" method="post">
				<div class="field-wrap">
					<input type="email" required autocomplete="off" name="email" id="email" placeholder="*Email" value='' />
				</div>
				<div class="field-wrap">
					<label>
						<span class="req">*Password</span>
					</label>
					<input type="password" required autocomplete="off" name="password" id="password" />
				</div>
				<p class="forgot"><a href="#">Forget password?</a></p>
				<button class="button button-block"/>Login</button>
			</form>

        </div>
        
      </div><!-- tab-content -->
      
</div> <!-- /form -->

	<script src='<?php echo base_url('vendore/js/jquery.min.js');?>'></script>
	<script src="<?php echo base_url('vendore/js/index.js');?>"></script>


<?php
$page->footPage();
?>