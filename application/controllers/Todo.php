<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Todo extends CI_Controller {
	public function index()
	{
		$this->authentication->checkSession();

		// MySQL Query to get data
		// Column settings
		$columns = array("todo_linkE"=>array("header"=>'', "type"=>"link",'link_name'=>"<i class='fa fa-pencil-square-o' style='color:orange' title='".$this->lang->line('tit_Edit')."' >&nbsp;</i>"),
						"todo_linkT"=>array("header"=>'', "type"=>"link",'link_name'=>"<i class='fa fa-tasks' style='color:orange' title='".$this->lang->line('tit_services')."' style='color:#4f8cef;cursor:pointer'>&nbsp;</i>"),
						"row"=>array("header"=>$this->lang->line('tit_row'), "type"=>"label","header_align"=>'center',"width"=>30),
						"todo_title_code"=>array("header"=>$this->lang->line('tit_subscribe_code'), "type"=>"label","header_align"=>'center'),
						"todo_name"=>array("header"=>$this->lang->line('tit_Name'), "type"=>"label","header_align"=>'center'),
						"todo_family"=>array("header"=>$this->lang->line('tit_Family'), "type"=>"label","header_align"=>'center'),
						"todo_mobile"=>array("header"=>$this->lang->line('tit_Mobile'), "type"=>"label","header_align"=>'center'),
						"todo_tel"=>array("header"=>$this->lang->line('tit_Telephone'), "type"=>"label","header_align"=>'center'),
						"todo_address"=>array("header"=>$this->lang->line('tit_Address'), "type"=>"label","header_align"=>'center')
						); 
		// Set the grid 
		
		$this->to_do->makeTodoCondition($_POST);
		$data		= $this->to_do->getTodoList();
		for($i=0;$i<count($data);$i++)
		{
			$data[$i]['row']			= $i+1;
			$data[$i]['todo_linkE'] = base_url('todo/newTodo').'/'.$this->general->hashStr($data[$i]['todo_id']);
			$data[$i]['todo_linkT'] = base_url('todo/tasks').'/'.$this->general->base64url_encode($data[$i]['todo_id']);
		}
		$this->smartgrid->set_grid($data, $columns);
		$data['grid_html'] = $this->smartgrid->render_grid(); 

		// Load view
		$this->load->view('todo/todov', $data);
	}

	public function sortTodo()
	{
		$sortType	=	$this->uri->segment(3);
		$sortStatus	=	$this->uri->segment(4);
		$this->authentication->checkSession();
		$this->load->view('todo/todov',array('sortType'=>$sortType,'sortStatus'=>$sortStatus));
	}	

	function newTodo()
	{
		$this->authentication->checkSession();
		$this->load->view('todo/newTodov');
	}

	function newTodoSave()
	{
		$pageCFG	=	'';
		$this->authentication->checkSession();
		$this->form_validation->set_message('required','%s را وارد کنید ');
		$this->form_validation->set_rules('tdTitle',$this->lang->line('tit_subscribe_code'),'trim|required');
		$this->form_validation->set_rules('tdName',$this->lang->line('tit_Name'),'trim|required');
		$this->form_validation->set_rules('tdFamily',$this->lang->line('tit_Family'),'trim|required');
		$this->form_validation->set_rules('tdMobile',$this->lang->line('tit_Mobile'),'trim|required');
		$this->form_validation->set_rules('tdTel',$this->lang->line('tit_Telephone'),'trim|required');
		$this->form_validation->set_rules('tdAddress',$this->lang->line('tit_Address'),'trim|required');
		$this->form_validation->set_rules('tdDesc',$this->lang->line('tit_description'),'trim');
		if ($this->form_validation->run() == FALSE)
		{
die(validation_errors());
			$msg['msg'][0] = validation_errors();
			$msg['msg'][1] = "Error In Saving new TODO";
			$this->session->set_flashdata($msg);
			$this->load->view('todo/newTodov');
			// redirect('todo/newTodo');
		}
		else
		{
			$record			= array('todo_title_code'=>$this->input->get_post('tdTitle'),
									'todo_name'=>$this->input->get_post('tdName'),
									'todo_family'=>$this->input->get_post('tdFamily'),
									'todo_mobile'=>$this->input->get_post('tdMobile'),
									'todo_tel'=>$this->input->get_post('tdTel'),
									'todo_address'=>$this->input->get_post('tdAddress'),
									'todo_desc'=>$this->input->get_post('tdDesc'));//New
			if($this->uri->segment(3))
			{
				$record			= array_merge(array('todo_id'=>$this->uri->segment(3)),$record);
				$result			= $this->to_do->updateTodo($record);
			}
			else
			{
				$record['user_id']	=	$this->session->userdata('user_id');
				$result			= $this->to_do->newTodo($record);
			}
			if(!empty($result['error']))
			{
				$msg					= array();
				$msg['message']		= $this->lang->line('msg_Error_in_save').'<br>'.$this->general->translateError($result['error']);
				$this->load->view('todo/newTodov',$msg);
			}
			else
				$this->index();
		}
	}
	
	function delTodo($id)
	{
		if($id)
			$result			= $this->to_do->deleteTodo($id);
		if($result)
			redirect('todo');
			// $this->index();
		else
		{
			$msg['msg'][0] = $result['error']['message'];
			$this->session->set_flashdata($msg);
			redirect('todo/newTodo');
		}
	}
//______________________________________________________________________________________________	
//______________________________________________________________________________________________	
//______________________________________________________________________________________________	
	public function tasks()
	{
		$this->authentication->checkSession();
		if($this->uri->segment(3))
			$this->session->set_userdata('TODO_ID',$this->general->base64url_decode($this->uri->segment(3)));
		$techManArr		= $this->user->getTechMansArray();		
		$columns = array("task_linkD"=>array("header"=>'', "type"=>"link",'link_name'=>"<i class='fa fa-times' style='color:red;cursor:pointer' title='".$this->lang->line('tit_Delete')."' >&nbsp;</i>","width"=>16),
						"task_linkE"=>array("header"=>'', "type"=>"link",'link_name'=>"<i class='fa fa-pencil-square-o' style='color:orange;' title='".$this->lang->line('tit_Edit')."' >&nbsp;</i>","width"=>16),
						"row"=>array("header"=>$this->lang->line('tit_row'), "type"=>"label","header_align"=>'center',"width"=>30),
						"user"=>array("header"=>$this->lang->line('tit_tech_man'), "type"=>"label","header_align"=>'center'),
						"task_desc"=>array("header"=>$this->lang->line('tit_description'), "type"=>"label","header_align"=>'center'),
						"task_date"=>array("header"=>$this->lang->line('tit_service_date'), "type"=>"label","header_align"=>'center')); 

		$data		= $this->to_do->getTaskList($this->session->userdata('TODO_ID'));
		for($i=0;$i<count($data);$i++)
		{
			$data[$i]['row']	= $i+1;
			// $data[$i]['task_linkD']	= base_url('todo/delTask').'/'.$this->general->hashStr($data[$i]['task_id']);
			$data[$i]['task_linkD']	= "javascript:DeleteTask('{$this->general->hashStr($data[$i]['task_id'])}')";
			$data[$i]['task_linkE']	= base_url('todo/newTask').'/'.$this->general->hashStr($data[$i]['task_id']);
			$data[$i]['task_date']	= 	$this->general->gor2jal($data[$i]['task_date'],true);
			$data[$i]['user']	= 	$techManArr[$data[$i]['user_id']];
		}
		$this->smartgrid->set_grid($data, $columns);
		$data['grid_html'] = $this->smartgrid->render_grid(); 
			
		$this->load->view('todo/tasksv',$data);
	}
//______________________________________________________________________________________________	
	public function sortTask()
	{
		$sortType	=	$this->uri->segment(3);
		$sortStatus	=	$this->uri->segment(4);
		$this->authentication->checkSession();
		$this->load->view('todo/tasksv',array('sortType'=>$sortType,'sortStatus'=>$sortStatus));
	}	
//______________________________________________________________________________________________	
	function newTask()
	{
		$this->authentication->checkSession();
		$this->load->view('todo/newTaskv');
	}
//______________________________________________________________________________________________		
	function newTaskSave()
	{
		$this->authentication->checkSession();
		$this->form_validation->set_message('required','%s را وارد کنید ');
		$this->form_validation->set_rules('taskUserId',$this->lang->line('tit_tech_man'),'trim|required');
		$this->form_validation->set_rules('taskDesc',$this->lang->line('tit_description'),'trim|required');
		if ($this->form_validation->run() == FALSE)
		{
			$msg['message'][0] = validation_errors();
			$msg['message'][1] = $this->lang->line('msg_Error_In_Saving_new_task');
			$this->load->view('todo/newTaskv',$msg);
		}
		else
		{
			$record			= array('todo_id'=>$this->session->userdata('TODO_ID'),
									'user_id'=>$this->input->get_post('taskUserId'),
									'task_desc'=>$this->input->get_post('taskDesc'),
									'task_date'=>	$this->general->jal2gor($this->input->get_post('taskDate')));
			if($this->uri->segment(3))
			{
				$record					=	array_merge(array('task_id'=>$this->uri->segment(3)),$record);
				$result					= $this->to_do->updateTask($record);
			}
			else
				$result			= $this->to_do->newTask($record);

			if(!empty($result['error']))
			{
				$msg				= array();
				$msg['message']		= $this->lang->line('msg_Error_in_save').'<br>'.$this->general->translateError($result['error']['code']);
// print_arr($msg['message']);exit;
				$this->load->view('todo/newTaskv',$msg);
			}
			else
				redirect('todo/tasks/'.$this->general->base64url_encode($this->session->userdata('TODO_ID')));
		}
	}	
//______________________________________________________________________________________________
	function delTask($id)
	{
		if($id)
			$result			= $this->to_do->deleteTask($id);
		if($result)
			redirect('todo/tasks');
			// $this->index();
		else
		{
			$msg['msg'][0] = $result['error']['message'];
			$this->session->set_flashdata($msg);
			redirect('todo/newTask');
		}
	}
//______________________________________________________________________________________________	
}
?>