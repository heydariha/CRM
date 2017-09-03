<?php
$this->general->loadHeader();
$person		= $this->user->getUser($this->session->userdata('user_id'))[0];
?>
						<!-- SECTION 1 - HOMEPAGE -->
						<section class="no-display">
							<div class="profile" id="1">
								<h4><?php echo $this->lang->line('tit_hello');?> <span><?php echo $person['user_fname'];?></span></h4>
								<div class="sep1"></div>
								<p><?php echo $person['user_desc'];?></p>
								<div class="personal-info col-md-12 no-padding">
									<h4>
										<a href="<?php echo base_url('mainpage/mainEdit');?>" title="<?php echo $this->lang->line('tit_Edit');?>">
											<i class="fa fa-edit"></i>
											</a><?php echo $this->lang->line('tit_Personal_Information');?></h4>
									<div class="sep2"></div>
									<ul>
										<li>
											<div><em><?php echo $this->lang->line('tit_Name');?> </em><span><?php echo $person['user_fname'].' '.$person['user_lname'];?></span></div>
										</li>

										<li>
											<div><em><?php echo $this->lang->line('tit_Email');?></em><span><?php echo $person['user_name'];?></span></div>
										</li>

										<li>
											<div><em><?php echo $this->lang->line('tit_Address');?> </em><span><?php echo $person['user_address'];?></span></div>
										</li>

									</ul>
								</div>
								<div class="clearfix"></div>
							</div>
						</section>
						<!-- SECTION 1 - HOMEPAGE -->
<?php
$this->general->loadFooter();
?>