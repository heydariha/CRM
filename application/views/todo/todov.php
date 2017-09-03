<?php
$page		= $this->general->loadHeader();
//<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
?>
`
<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('tit_search');?></h4>
            </div>
			<?php echo form_open_multipart('todo',"id='filter' ");?>
				<div class="modal-body">
					<input type="text" name="fCode" id="fCode" placeholder="<?php echo $this->lang->line('tit_subscribe_code');?>" value="<?php echo $this->input->get_post('fCode')?$this->input->get_post('fCode'):'';?>">
					<input type="text" name="fName" id="fName" placeholder="<?php echo $this->lang->line('tit_Name');?>" value="<?php echo $this->input->get_post('fName')?$this->input->get_post('fName'):'';?>">
					<input type="text" name="fFamily" id="fFamily" placeholder="<?php echo $this->lang->line('tit_Family');?>" value="<?php echo $this->input->get_post('fFamily')?$this->input->get_post('fFamily'):'';?>">
					<input type="text" name="fMobile" id="fMobile" placeholder="<?php echo $this->lang->line('tit_Mobile');?>" value="<?php echo $this->input->get_post('fMobile')?$this->input->get_post('fMobile'):'';?>">
					<input type="text" name="fTel" id="fTel" placeholder="<?php echo $this->lang->line('tit_Telephone');?>" value="<?php echo $this->input->get_post('fTel')?$this->input->get_post('fTel'):'';?>">
				</div>
				<div class="modal-footer">
					<input type="submit" value="<?php echo $this->lang->line('tit_search');?>" class="btn btn-primary" >
					<input type="reset" value="<?php echo $this->lang->line('tit_Ignore');?>" class="btn btn-default" data-dismiss="modal">
				</div>
			</form>
        </div>
    </div>
</div>

						<!-- SECTION 1 - HOMEPAGE -->
						<section class="no-display">
							<div class="profile" id="1" >
								<h4>
									<i class="fa fa-user"></i>
									<?php echo $this->lang->line('tit_customers_list');?>
								</h4>
								<div class="sep1" style="width:100%;text-align:right;padding-bottom:34px;border-radius:3px">
									<button class="btn" title="<?php echo $this->lang->line('tit_new_customer');?>" onclick=window.location="<?php echo base_url('todo/newTodo');?>" ><i class="fa fa-plus"></i></button>
									<button id='clickMDL' class="btn" title="<?php echo $this->lang->line('tit_search');?>"><i class="fa fa-search"></i></button>
									<button class="btn" title="<?php echo $this->lang->line('tit_view_all');?>" onclick=window.location="<?php echo base_url('todo');?>" ><i class="fa fa-list"></i></button>
								</div>
								<div class="personal-info col-md-12 no-padding">
									<?php
										echo $grid_html;
									?>
								</div>
								<div class="clearfix"></div>
							</div>
						</section>
						<!-- SECTION 1 - HOMEPAGE -->
<script>

	document.getElementById('clickMDL').onclick = function(){
		$("#myModal").modal('show');
	};

function todoSort(type,status)
{
	window.location = '<?php echo base_url('todo/sortTodo/');?>'+type+'/'+status;
}
function DeleteTodo(id){
	if(confirm("Do you want to delet this record?"))
		window.location = '<?php echo base_url('todo/delTodo/');?>'+id;
}
function loadTasks(id){
	
	window.location = encodeURI('<?php echo base_url('todo/tasks/');?>'+id);
}
</script>
<?php
$page		= $this->general->loadFooter();
?>