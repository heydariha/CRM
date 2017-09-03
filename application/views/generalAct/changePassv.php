<?php
$this->general->loadHeader();
$error	= '';
if(!empty($msg))
{
	if(is_array($msg[0]))
		$error	= implode('<br>',$msg[0]);
}
else
	$msg[1]		= '';
$person	= $this->user->getUser($this->session->userdata('user_id'));
//<form id="contactForm" action="<?php echo base_url('mainpage/changePassSave');" method="post">
?>
						<!-- SECTION Edit -->
						<section class="no-height">
							<div class="item contact" id="5">
								<div class="page-head">
									<div class="row" >
									<?php echo '<center style="color:red">'.$msg[1].$error.'</center>';?>
										<div class="col-md-12" style="float:right">
											<h3><i style='color:cornflowerblue' class="fa fa-lock"></i> <?php echo $this->lang->line('tit_Change_Password');?></h3>
										</div>
									</div>
								</div>

								<div class="contact-form">
									<br>
									<h5><?php echo $this->lang->line('tit_Take_care_of_your_password');?></h5>
									<?php echo form_open_multipart('mainpage/changePassSave'.$updFlag,"id='changePass' ");?>
										<div class="row">
											<div class="col-md-5">
												<input type="password" name="current" id="current" placeholder="<?php echo $this->lang->line('tit_current_password');?>" >
												<input type="password" name="password" id="password" placeholder="<?php echo $this->lang->line('tit_new_password');?>" >
												<input type="password" name="repassword" id="repassword" placeholder="<?php echo $this->lang->line('tit_repeat_new_password');?>" >
											</div>
										</div>
										<div class="row">
											<div class="col-md-10">
												<?php echo $this->general->showSaveCancel();?>
											</div>
										</div>
									</form>
								</div>
							</div>
						</section>
						<!-- SECTION - Edit -->
<?php
$this->general->loadFooter();
?>