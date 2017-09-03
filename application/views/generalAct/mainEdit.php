<?php
$this->general->loadHeader();
$person		= $this->user->getUser($this->session->userdata('user_id'))[0];
echo $this->general->loadCalIns();
//<form id="contactForm" action="<?php echo base_url('mainpage/mainEditSave');" method="post">
?>
						<!-- SECTION Edit -->
						<section class="no-height">
							<div class="item contact" id="5">
								<div class="page-head">
									<div class="row" >
										<div class="col-md-6" style="float:right">
											<h3><i style='color:cornflowerblue' class="fa fa-file-text"></i> <?php echo $this->lang->line('tit_Edit_personal_information');?></h3>
										</div>
									</div>
								</div>

								<div class="contact-form">
									<h4></h4>
									<?php echo form_open_multipart('mainpage/mainEditSave'.$updFlag,"id='EditMain' ");?>
										<div class="row">
											<div class="col-md-5">
												<input type="text" name="uName" id="uName" placeholder="<?php echo $this->lang->line('tit_Name');?>" value="<?php echo content($person,'user_fname');?>">
											</div>
											<div class="col-md-5">
												<input type="text" name="uFamily" id="uFamily" placeholder="<?php echo $this->lang->line('tit_Family');?>" value="<?php echo content($person,'user_lname');?>">
											</div>
											<div class="col-md-5">
												<input type="text" name="uAddress" id="uAddress" placeholder="<?php echo $this->lang->line('tit_Address');?>" value="<?php echo content($person,'user_address');?>">
											</div>
										</div>
										<div class="row">
											<div class="col-md-10">
												<textarea name="uDesc" id="uDesc" rows="6" placeholder="<?php echo $this->lang->line('tit_description');?>"><?php echo content($person,'user_desc');?></textarea>
												<?php echo $this->general->showSaveCancel();?>
											</div>
										</div>
										
									</form>
								</div>
							</div>
						</section>
						<script>
							$('#uBirthdate').datepicker();
						</script>
						<!-- SECTION - Edit -->
<?php
$this->general->loadFooter();
?>