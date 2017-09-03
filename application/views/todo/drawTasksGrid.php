<?php

$all='Selected';
$new='';
$done='';
$canceled = '';
if(isset($sortType)||isset($sortStatus))
	$taskList	= $this->to_do->getTaskList($this->session->userdata('TODO_ID'),'',$sortStatus,$sortType);
else
	$taskList	= $this->to_do->getTaskList($this->session->userdata('TODO_ID'));
$techManArr		= $this->user->getTechMansArray();

$str		= '<table class="grid">
					<tr>
						<Th class="gridHeader">&nbsp</Th>
						<Th class="gridHeader"><em>'.$this->lang->line('tit_row').'</em></Th>
						<Th class="gridHeader">
							<i class="fa fa-caret-square-o-up" style="cursor:pointer" title="'.$this->lang->line('tit_sort_ASC').'" onclick="todoSort(1,0)"></i> '.$this->lang->line('tit_tech_man').'
							<i class="fa fa-caret-square-o-down" style="cursor:pointer" title="'.$this->lang->line('tit_sort_DESC').'" onclick="todoSort(2,0)" ></i>
						</Th>
						<Th class="gridHeader">
							<i class="fa fa-caret-square-o-up" style="cursor:pointer" title="'.$this->lang->line('tit_sort_ASC').'" onclick="todoSort(3,0)" ></i>
								'.$this->lang->line('tit_description').'
							<i class="fa fa-caret-square-o-down" style="cursor:pointer" title="'.$this->lang->line('tit_sort_DESC').'" onclick="todoSort(4,0)" ></i>
						</Th>
						<Th class="gridHeader">
							<i class="fa fa-caret-square-o-up" style="cursor:pointer" title="'.$this->lang->line('tit_sort_ASC').'" onclick="todoSort(5,0)" ></i>
								'.$this->lang->line('tit_service_date').'
							<i class="fa fa-caret-square-o-down" style="cursor:pointer" title="'.$this->lang->line('tit_sort_DESC').'" onclick="todoSort(6,0)" ></i>
						</Th>
					</tr>';

for($i=0;$i<count($taskList);$i++)
{
	$taskList[$i]['task_id']	= $this->general->hashStr($taskList[$i]['task_id']);
	$adrEdit	= base_url('todo/newTask').'/'.$taskList[$i]['task_id'];
	if($taskList[$i]['task_date'] == 0000-00-00)
		$taskList[$i]['task_date'] = '';
	$taskDate	= date_create($taskList[$i]['task_date']);
	$class	= 'gridRowDone';
	$techMan	= $techManArr[$taskList[$i]['user_id']];
	$servDate	= $this->general->gor2jal($taskList[$i]['task_date'],true);
	$j=$i+1;
	$str	.= "<tr class='{$class}' >
					<td class='gridCell'>
						<i class='fa fa-unlink' style='cursor:pointer' title='Delete' onclick=DeleteTask('{$taskList[$i]['task_id']}')></i>
						<a href='$adrEdit'><i class='fa fa-edit' title='Edit'>&nbsp;</i></a>
					</td>
					<td class='gridCell'>$j</td>
					<td class='gridCell'>{$techMan}</td>
					<td class='gridCell'>{$taskList[$i]['task_desc']}</td>
					<td class='gridCell'>{$servDate}</td>
				</tr>";
}
echo $str.'</table>';
?>