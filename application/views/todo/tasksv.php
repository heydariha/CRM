<?php
$page		= $this->general->loadHeader();
$todoId		= $this->uri->segment(3);
?>
						<!-- SECTION 1 - HOMEPAGE -->
						<section class="no-display">
							<div class="profile" id="1">
								<h4>
									<a href='<?php echo base_url('todo');?>'>
										<i style='color:cornflowerblue;font-size:32px' class="fa fa-arrow-circle-right"></i>
									</a>
									<a href="<?php echo base_url('todo/newTask');?>" title="New Todo"><i class="fa fa-plus"></i></a>
									<?php echo $this->lang->line('tit_tasks_list_for');?>
									<Select name="sortStatus" id="sortStatus" onchange=loadTasks(this.value) style='font-size:11pt;border:0px' >
<?php
$result	= $this->to_do->getTodoList($this->general->hashStr($this->general->base64url_decode($todoId)));
for($i=0;$i<count($result);$i++)
{
	$selected	= '';
	if($this->general->base64url_decode($todoId) == $result[$i]['todo_id'])
		$selected	= 'Selected';
	$todoIdForSend = $this->general->base64url_encode($result[$i]['todo_id']);
	echo "<option value='$todoIdForSend' $selected >{$result[$i]['todo_title_code']} - {$result[$i]['todo_name']} {$result[$i]['todo_family']}</option>";
}
?>
									</Select>
								</h4>
								<div class="sep1"></div>
								<div class="personal-info col-md-12 no-padding">
									<?php 
										echo $grid_html;
										// if(isset($sortType)||isset($sortStatus))
											// $this->load->view('todo/drawTasksGrid',array('sort_type'=>$sortType,'sortStatus'=>$sortStatus));
										// else
											// $this->load->view('todo/drawTasksGrid',$todoId);
									?>
								</div>
								<div class="clearfix"></div>
							</div>
						</section>
						<!-- SECTION 1 - HOMEPAGE -->
<script>
function loadTasks(todoId)
{
	window.location = '<?php echo base_url('todo/tasks/');?>'+todoId;
}
function todoSort(type,status)
{
	window.location = '<?php echo base_url('todo/sortTask/');?>'+type+'/'+status;
}
function DeleteTask(id){
	if(confirm("Do you want to delet this record?"))
		window.location = '<?php echo base_url('todo/delTask/');?>'+id;
}
</script>
<?php
$page		= $this->general->loadFooter();
?>