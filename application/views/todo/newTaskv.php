<?php
echo $this->general->loadCalIns();
$this->general->loadHeader();
$taskList	= array();
$visible	= 'none';
$updFlag	= '';
$error		= '';
if($this->uri->segment(3))
{
	$taskList	= $this->to_do->getTaskList('',$this->uri->segment(3));
	if(count($taskList))
	{
		$taskList	= $taskList[0];
		$taskList['task_date']	= $this->general->gor2jal($taskList['task_date'],true);
		if($taskList['task_date'] == '0000-00-00')
			$taskList['task_date'] = '';
		$updFlag	= '/'.$this->uri->segment(3);
		$visible	= 'block';
	}
	else
		$error	= 'Selected Record is invalid';
}

if(!empty($message[1]))
{
	echo '<center style="font-family:tahoma;color:red"> ERROR </center>';
	// echo '<center style="font-family:tahoma;color:red"> '. implode(',',$message) .' </center>';
}
//<form id="contactForm" action="<?php echo base_url('todo/newTaskSave').$updFlag;" method="post">
?>
						<!-- SECTION Edit -->
						<section class="no-height">
							<div class="item contact" id="5">
								<div class="page-head">
									<div class="row" >
										<div class="col-md-12" style="float:right">
											<h3>
												<a href='<?php echo base_url('todo/tasks');?>'>
													<i style='color:cornflowerblue' class="fa fa-arrow-circle-right"></i>
												</a>
												<i style='color:cornflowerblue' class="fa fa-file-text"></i> <?php echo $this->lang->line('tit_new_task');?></h3>
										</div>
									</div>
								</div>
								<div class="contact-form">
									<h6 style='color:red;text-align:center'><?php echo $error;?></h6>
									<?php echo form_open_multipart('todo/newTaskSave'.$updFlag,"id='NewTask' ");?>
										<div class="row">
										
											<div class="col-md-5">
												<Select name="taskUserId" id="taskUserId" >
													<option value="" disabled selected><?php echo $this->lang->line('tit_tech_man');?></option>
													<?php echo $this->user->getTechManOptions($taskList['user_id']);?>
												</Select>												
											<input type='text' name='taskDate' id='taskDate' placeholder='<?php echo $this->lang->line('tit_done_date')?>' value='<?php echo $this->input->get_post('taskDate')?$this->input->get_post('taskDate'):content($taskList,'task_date');?>' >
											</div>
										</div>
										<div class="row">
											<div class="col-md-10">
												<textarea required  name="taskDesc" id="taskDesc" rows="6" placeholder="<?php echo $this->lang->line('tit_description');?>"><?php echo $this->input->get_post('taskDesc')?$this->input->get_post('taskDesc'):content($taskList,'task_desc');?></textarea>
											</div>
										</div>
										<div class="row">
											<div class="col-md-5">
												<?php echo $this->general->showSaveCancel(base_url('todo/tasks'));?>
											</div>
										</div>
									</form>
								</div>
							</div>
						</section>
<script>
$('#taskDate').datepicker();
</script>
						<!-- SECTION - Edit -->
<?php
$this->general->loadFooter();
?>