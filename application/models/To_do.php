<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class To_do extends CI_Model {
#___________________________________________________
	var $todoCondition='1';
    function __construct() {
        parent::__construct();
    }
#___________________________________________________	
	function newTodo($array)
	{
		$query	= "INSERT INTO ba_todo (todo_title_code,todo_name,todo_family,todo_mobile,todo_tel,todo_address,todo_desc,user_id) VALUES (";
		foreach($array AS $field => $value)
		{
			$value	= addslashes($value);
			$query	.= "'{$value}',";
		}
		$query		= rtrim($query,',').')';
		$this->db->query($query);
		$result	= $this->db->error();

		$answer['result']	= $this->db->insert_id();
		$answer['error']	= '';
		
		if($result['code']>0)
		{
			$answer['result']	= 0;
			$answer['error']	= $this->db->error();
		}
		return $answer;
	}
#___________________________________________________	
	function updateTodo($record)
	{
		$query	= "UPDATE ba_todo SET ";
		foreach($record AS $field => $value)
		{
			if($field == 'todo_id')
				continue;
			$query	.= " {$field} = '{$value}',";
		}		
		$query	= rtrim($query,',')." WHERE hashstr(todo_id) = '{$record['todo_id']}'";
		$this->db->query($query);
		
		if($record['todo_status']==3)
		{
			$query	= "UPDATE ba_tasks SET task_status = 3 WHERE hashstr(todo_id) = '{$record['todo_id']}'";
			$this->db->query($query);
		}
		
		$result	= $this->db->error();
		$answer['result']	= $this->db->insert_id();
		$answer['error']	= '';
		
		if($result['code']>0)
		{
			$answer['result']	= 0;
			$answer['error']	= $this->db->error();
		}
		return $answer;
	}
#___________________________________________________
	function makeTodoCondition($array)
	{
		if(intval($array['fCode']))
			$this->todoCondition .= " AND todo_title_code = '{$array['fCode']}' ";
			
		if(!empty($array['fName']))
			$this->todoCondition .= " AND todo_name LIKE '%{$array['fName']}%' ";
			
		if(!empty($array['fFamily']))
			$this->todoCondition .= " AND todo_family LIKE '%{$array['fFamily']}%' ";

		if(!empty($array['fMobile']))
			$this->todoCondition .= " AND todo_mobile LIKE '%{$array['fMobile']}%' ";

		if(!empty($array['fTel']))
			$this->todoCondition .= " AND todo_tel LIKE '%{$array['fTel']}%' ";
	}
#___________________________________________________
	function getTodoList($todoId='',$sortType='1')
	{
		$userId	= $this->session->userdata('user_id');
		$order	='';
		switch ($sortType){
			case 1:
				$order = "ORDER BY todo_title_code ASC";
				break;
			case 2:
				$order = "ORDER BY todo_title_code DESC";
				break;
			case 3:
				$order = "ORDER BY todo_desc ASC";
				break;			
			case 4:
				$order = "ORDER BY todo_desc DESC";
				break;			
		}
		$query	= "SELECT * FROM ba_todo
					WHERE	IF('$todoId' <> '',hashstr(todo_id) = '$todoId',1) AND
					{$this->todoCondition}
					$order";
		$query	= $this->db->query($query);
		return $query->result_array();
	}
#___________________________________________________
	function getTodoStatusString($status)
	{
		$result	= array();
		switch($status){
			case 1:
				$result['status'] = 'New';
				$result['class'] = 'gridRowNew';
				break;
			case 2:
				$result['status'] = 'Done';
				$result['class'] = 'gridRowDone';
				break;
			default:
				$result['status'] = 'Canceled';
				$result['class'] = 'gridRowCanceled';
		}
		return $result;
	}
#___________________________________________________
	function deleteTodo($todoId)
	{
		$query	= "DELETE FROM ba_todo WHERE hashstr(todo_id) = '$todoId'";
		$query	= $this->db->query($query);
		return $query;
	}
#___________________________________________________
function getTasksForTodo($todoId='')
{
	$query	= "SELECT todo_id,count(task_id) AS cnt
				FROM ba_tasks
				WHERE IF('$todoId' <> '',todo_id = '$todoId',1)
				GROUP BY todo_id";
	$query	= $this->db->query($query);
	return $query->result_array();
}
#___________________________________________________
#___________________________________________________	
	function newTask($array)
	{
		$query	= "INSERT INTO ba_tasks (todo_id,user_id,task_desc,task_date) VALUES (";
		foreach($array AS $field => $value)
		{
			$query	.= "'{$value}',";
		}
		$query		= rtrim($query,',').')';
		$this->db->query($query);
		$result	= $this->db->error();

		$answer['result']	= $this->db->insert_id();
		$answer['error']	= '';
		
		if($result['code']>0)
		{
			$answer['result']	= 0;
			$answer['error']	= $this->db->error();
		}
		return $answer;
	}
#___________________________________________________	
	function updateTask($array)
	{
		$prevData	= $this->getTaskList('',$array['task_id']);

		$query	= "UPDATE ba_tasks SET ";
		foreach($array AS $field => $value)
		{
			if($field == 'task_id')
				continue;
			$query	.= " {$field} = '{$value}',";
		}
		$query	= rtrim($query,',')." WHERE hashstr(task_id) = '{$array['task_id']}'";
		$this->db->query($query);
		
		$result	= $this->db->error();
		$answer['result']	= $this->db->insert_id();
		$answer['error']	= '';
		
		if($result['code']>0)
		{
			$answer['result']	= 0;
			$answer['error']	= $this->db->error();
		}
		return $answer;
	}
#___________________________________________________
	function getTaskList($todoId='',$taskId='',$status='',$sortType='6')
	{
		
		$order	='';
		switch ($sortType){
			case 1:
				$order = "ORDER BY task_title ASC";
				break;
			case 2:
				$order = "ORDER BY task_title DESC";
				break;
			case 3:
				$order = "ORDER BY task_desc ASC";
				break;
			case 4:
				$order = "ORDER BY task_desc DESC";
				break;
			case 5:
				$order = "ORDER BY task_date ASC";
				break;
			case 6:
				$order = "ORDER BY task_date DESC";
				break;
		}
		
		$query	= "SELECT * FROM ba_tasks
					WHERE	IF('$todoId' <> '',todo_id = '$todoId',1) AND
							IF('$taskId' <> '',hashstr(task_id) = '$taskId',1) AND
							IF('$status' <> '' AND '$status' <> 0,task_status = '$status',1)
					$order";
		$query	= $this->db->query($query);
		return $query->result_array();
	}
#___________________________________________________
	function deleteTask($taskId)
	{
		$query	= "DELETE FROM ba_tasks WHERE hashstr(task_id) = '$taskId'";
		$query	= $this->db->query($query);
		return $query;
	}
#___________________________________________________
	function getStatus()
	{
		$query		= "SELECT * FROM ba_status";
		$query	= $this->db->query($query);
		return $query->result_array();		
	}
#___________________________________________________
	function getStatusOptions($defStatus='',$disabledArr=array())
	{
		$result	= $this->getStatus();
		$str	= '';
		for($i=0;$i<count($result);$i++)
		{
			$selected	= '';
			if($defStatus == $result[$i]['st_id'])
				$selected = 'Selected';
			$disabled	= in_array($result[$i]['st_id'],$disabledArr)?'disabled':'';
			$str.= "<option $disabled $selected value='{$result[$i]['st_id']}' >{$result[$i]['st_status']}</option>";
		}
		return $str;
	}
#___________________________________________________
}

?>