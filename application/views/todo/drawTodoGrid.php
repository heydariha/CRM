<?php
$all='Selected';
$new='';
$done='';
$canceled = '';
if(isset($sortType)||isset($sortStatus))
{
	$todoList	= $this->to_do->getTodoList('',$sortStatus,$sortType);
}
else
	$todoList	= $this->to_do->getTodoList();
$str		= '<table class="grid">
					<tr>
						<Th class="gridHeader">&nbsp</Th>
						<Th class="gridHeader"><em>'.$this->lang->line('tit_row').'</em></Th>
						<Th class="gridHeader">
							<i class="fa fa-caret-square-o-up" style="cursor:pointer" title="Sort ASC" onclick="todoSort(1,0)"></i> '.$this->lang->line('tit_subscribe_code').'
							<i class="fa fa-caret-square-o-down" style="cursor:pointer" title="Sort DESC" onclick="todoSort(2,0)" ></i>
						</Th>

						<TH class="gridHeader">'.$this->lang->line('tit_Name').'</th>
						<TH class="gridHeader">'.$this->lang->line('tit_Family').'</th>
						<TH class="gridHeader">'.$this->lang->line('tit_Mobile').'</th>
						<TH class="gridHeader">'.$this->lang->line('tit_Telephone').'</th>
						<TH class="gridHeader">'.$this->lang->line('tit_Address').'</th>
						<Th class="gridHeader">'.$this->lang->line('tit_description').'</Th>
						<TH class="gridHeader">'.$this->lang->line('tit_services').'</th>
					</tr>';

$count	= $this->to_do->getTasksForTodo();
$getCnt	= array();
foreach($count AS $row=>$arr)
	$getCnt[$arr['todo_id']] = $arr['cnt'];

$temp			= $this->to_do->getStatus();
$statusArr		= array();
for($i=0;$i<count($temp);$i++)
{
	$statusArr[$temp[$i]['st_id']]['status'] = $temp[$i]['st_status'];
	$statusArr[$temp[$i]['st_id']]['class'] = $temp[$i]['st_class'];	
}
	
for($i=0;$i<count($todoList);$i++)
{	
	$todoIdForSend = $this->general->base64url_encode($todoList[$i]['todo_id']);
	$todoIdC	= $this->general->hashStr($todoList[$i]['todo_id']);
	$adrEdit	= base_url('todo/newTodo').'/'.$todoIdC;
	
	// $deleteIcon	= "<i class='fa fa-unlink' style='cursor:pointer' title='Delete' onclick=DeleteTodo('{$todoIdC}')></i>";
	$taskCnt	= 0;
	
	if(isset($getCnt[$todoList[$i]['todo_id']]))
	{
		$deleteIcon	= "";
		$taskCnt	= intval($getCnt[$todoList[$i]['todo_id']]);
	}
	
	$status			= $statusArr[$todoList[$i]['todo_status']]['status'];
	$class			= 'gridRowNew';//$statusArr[$todoList[$i]['todo_status']]['class'];
	
	$j				= $i+1;
	$str	.= "<tr class='{$class}'>
					<td class='gridCell'>
					{$deleteIcon}
						<a href='$adrEdit'><i class='fa fa-edit' style='color:orange' title='".$this->lang->line('tit_Edit')."' >&nbsp;</i></a>
						<i class='fa fa-tasks' style='color:orange' title='".$this->lang->line('tit_services')."' style='color:#4f8cef;cursor:pointer' onclick=loadTasks('$todoIdForSend')>&nbsp;</i>
					</td>
					<td class='gridCell'>$j</td>
					<td class='gridCell'>{$todoList[$i]['todo_title_code']}</td>
					<td class='gridCell'>{$todoList[$i]['todo_name']}</td>
					<td class='gridCell'>{$todoList[$i]['todo_family']}</td>
					<td class='gridCell'>{$todoList[$i]['todo_mobile']}</td>
					<td class='gridCell'>{$todoList[$i]['todo_tel']}</td>
					<td class='gridCell'>{$todoList[$i]['todo_address']}</td>
					<td class='gridCell'>{$todoList[$i]['todo_desc']}</td>
					<td class='gridCell'>{$taskCnt}</td>
				</tr>";
}
echo $str.'</table>';
?>