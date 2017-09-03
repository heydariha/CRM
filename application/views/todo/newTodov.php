<?php
$page		= $this->general->loadHeader();
$todoList	= array();
$visible	= 'none';
$updFlag	= '';
$error		= '';
if($this->uri->segment(3))
{
	$todoList	= $this->to_do->getTodoList($this->uri->segment(3));

	if(count($todoList))
	{
		$todoList	= $todoList[0];
		$updFlag	= '/'.$this->uri->segment(3);
		$visible	= 'block';
	}
	else
		$error	= 'Selected Record is invalid';
}

if(isset($message))
	print_arr('<center style="font-family:tahoma;color:red">'.$message.'</center>');
//<form action="<?php echo base_url('todo/newTodoSave').$updFlag;?>" method="post">
?>
						<!-- SECTION Edit -->
						<section class="no-height">
							<div class="item contact" id="5">
								<div class="page-head">
									<div class="row" >
										<div class="col-md-12" style="float:right">
											<h3>
												<a href='<?php echo base_url('todo');?>'>
													<i style='color:cornflowerblue;font-size:32px' class="fa fa-arrow-circle-right"></i>
												</a>
											<i style='color:cornflowerblue' class="fa fa-file-text"></i> <?php echo $this->lang->line('tit_new_customer');?></h3>
										</div>
									</div>
								</div>
								<div class="contact-form">
									<h6 style='color:red;text-align:center'><?php echo $error;?></h6>
									<?php echo form_open_multipart('todo/newTodoSave'.$updFlag,"id='NewTodo' ");?>
										<div class="row">
											<div class="col-md-4">
												<input required type="text" name="tdTitle" id="tdTitle" placeholder="<?php echo $this->lang->line('tit_subscribe_code');?>" value="<?php echo $this->input->get_post('tdTitle')?$this->input->get_post('tdTitle'):content($todoList,'todo_title_code');?>">
												<input required type="text" name="tdName" id="tdName" placeholder="<?php echo $this->lang->line('tit_Name');?>" value="<?php echo $this->input->get_post('tdName')?$this->input->get_post('tdName'):content($todoList,'todo_name');?>">
												<input required type="text" name="tdFamily" id="tdFamily" placeholder="<?php echo $this->lang->line('tit_Family');?>" value="<?php echo $this->input->get_post('tdFamily')?$this->input->get_post('tdFamily'):content($todoList,'todo_family');?>">												
												<input required type="text" name="tdMobile" id="tdMobile" placeholder="<?php echo $this->lang->line('tit_Mobile');?>" value="<?php echo $this->input->get_post('tdMobile')?$this->input->get_post('tdMobile'):content($todoList,'todo_mobile');?>">
												<input required type="text" name="tdTel" id="tdTel" placeholder="<?php echo $this->lang->line('tit_Telephone');?>" value="<?php echo $this->input->get_post('tdTel')?$this->input->get_post('tdTel'):content($todoList,'todo_tel');?>">
											</div>
										</div>
										<div class="row">
											<div class="col-md-10">
												<textarea required  name="tdAddress" id="tdAddress" rows="6" placeholder="<?php echo $this->lang->line('tit_Address');?>"><?php echo $this->input->get_post('tdAddress')?$this->input->get_post('tdAddress'):content($todoList,'todo_address');?></textarea>
												<textarea name="tdDesc" id="tdDesc" rows="6" placeholder="<?php echo $this->lang->line('tit_description');?>"><?php echo $this->input->get_post('tdDesc')?$this->input->get_post('tdDesc'):content($todoList,'todo_desc');?></textarea>
											</div>
										</div>
										<div class="row">
											<div class="col-md-5">
												<?php echo $this->general->showSaveCancel(base_url('todo'));?>
											</div>
										</div>										
									</form>
								</div>
							</div>
						</section>
<script>
	function setStatus(val)
	{
		document.getElementById('tdStatus').value = val;
	}
</script>
						<!-- SECTION - Edit -->
<?php
$page		= $this->general->loadFooter();
?>