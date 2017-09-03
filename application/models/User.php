<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Model {
#___________________________________________________
    function __construct() {
        parent::__construct();
    }
#___________________________________________________
    function getUserLogin($userName,$password) {
		$pass		= $this->general->hashStr($this->input->get_post('password'));
        $query		= $this->db->query("SELECT * FROM ba_users WHERE user_name = '$userName' AND user_password = '$pass'");
        return $query->row_array();
    }
#___________________________________________________
    function getUserByCode($userCode) {

        $query = $this->db->query("SELECT * FROM ba_users WHERE user_code = '$userCode'");
        return $query->row_array();
    }
#___________________________________________________
    function getUser($userId='') {
        $query = $this->db->query("SELECT * FROM ba_users WHERE IF('$userId' <> '',user_id = '$userId',1)");
        return $query->result_array();
    }
#___________________________________________________	
    function getTechMans($userId='') {
		$result	= $this->getUser($userId);
		$answer	= array();
		for($i=0;$i<count($result);$i++)
		{
			if($result[$i]['user_type_id'] != 3)
				continue;
			$answer[]	= $result[$i];
		}
		return $answer;
    }
#___________________________________________________	
function getTechMansArray($userId='')
{
	$result	= $this->getTechMans();
	$answer	= array();
	for($i=0;$i<count($result);$i++)
		$answer[$result[$i]['user_id']] = $result[$i]['user_fname'].''.$result[$i]['user_lname'];
	return $answer;
}
#___________________________________________________	
	function getTechManOptions($defUser='')
	{
		$result	= $this->getTechMans();
		$str	= '';
		for($i=0;$i<count($result);$i++)
		{
			$selected	= '';
			if($defUser == $result[$i]['user_id'])
				$selected = 'Selected';
			$str.= "<option $selected value='{$result[$i]['user_id']}' >{$result[$i]['user_lname']} {$result[$i]['user_fname']}</option>";
		}
		return $str;
	}
#___________________________________________________	
	function putUser($array)
	{
		$pass	= $this->general->hashStr($array['user_password']);
		
		$uniqueCode		= $this->general->hashStr($array['user_name']);
		$query	= "INSERT INTO ba_users (user_fname,user_lname,user_name,user_password,user_code,user_active) VALUES ('{$array['user_fname']}','{$array['user_lname']}','{$array['user_name']}','{$pass}','{$uniqueCode}',0)";
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
	function updateUser($array,$id='')
	{
		$answer	= array();
		$id		= $id ? $id	: $this->session->userdata('user_id');
		$query	= "UPDATE ba_users SET ";
		foreach($array AS $field => $value)
			$query	.= " {$field} = '{$value}',";

		$query	= rtrim($query,',')." WHERE user_id = '$id'";
		$ans	= $this->db->query($query);
		$result	= $this->db->error();		
		if($result['code']>0)
		{
			$answer['result']	= 0;
			$answer['error']	= $this->db->error();
		}
		return $answer;
	}
#___________________________________________________
	function updatePassword($id='')
	{
		$answer		= array();
		$id			= $id ? $id	: $this->session->userdata('user_id');
		$current	= $this->general->hashStr($this->input->get_post('current'));
		$check		= $this->db->query("SELECT * FROM ba_users WHERE user_id='{$id}' AND user_password = '{$current}'");

		if(count($check->row_array()) == 0)
		{
			$answer['result']	= 0;
			$answer['error']	= "کلمه عبور جاری معتبر نیست";
			return $answer;
		}

		$password	= $this->general->hashStr($this->input->get_post('password'));
		$query		= "UPDATE ba_users SET user_password = '{$password}' WHERE user_id = '$id' AND user_password = '$current' ";
		
		$ans	= $this->db->query($query);
		$result	= $this->db->error();		
		if($result['code']>0)
		{
			$answer['result']	= 0;
			$answer['error']	= $this->db->error();
		}
		return $answer;
	}
#___________________________________________________
}

?>