<?php defined('BASEPATH') OR exit('No direct script access allowed');
class MainPage extends CI_Controller {

	public function index()
	{
		$this->authentication->checkSession();
		$pageCFG	= array('title'=>'newPage');
		$this->load->view('generalAct/mainpagev',$pageCFG);
	}
//________________________________________________________________________
	function mainEdit()
	{
		$this->authentication->checkSession();
		$pageCFG	= '';
		$this->load->view('generalAct/mainEdit',$pageCFG);
	}//________________________________________________________________________
	function mainEditSave()
	{
		$this->authentication->checkSession();

		$this->form_validation->set_message('required','%s را وارد کنید ');
		$this->form_validation->set_rules('uName','نام','trim|required');
		$this->form_validation->set_rules('uFamily','نام خانوادگی','trim|required');
		$this->form_validation->set_rules('uDesc','متن معرفی','trim');
		if ($this->form_validation->run() == FALSE)
		{
			$msg['msg'][0] = validation_errors();
			$msg['msg'][1] = "خطا در ویرایش اطلاعات فردی";
			$this->session->set_flashdata($msg);
			$this->index();
		}
		else
		{
			$record			= array('user_fname'=>$this->input->get_post('uName'),
									'user_lname'=>$this->input->get_post('uFamily'),
									'user_address'=>$this->input->get_post('uAddress'),
									'user_desc'=>$this->input->get_post('uDesc'));
			$result			= $this->user->updateUser($record);
			if(!empty($result))
			{
				$msg['msg'][0] = $result['error']['message'];
				$this->session->set_flashdata($msg);
			}
			redirect('mainpage');
		}
	}
//__________________________________________________________________________________
	function changePass()
	{
		$this->authentication->checkSession();
		$pageCFG	= '';
		$this->load->view('generalAct/changePassv',$pageCFG);
	}
//__________________________________________________________________________________
	function changePassSave($userId='')
	{
		$msg		= array();
		$this->form_validation->set_message('required','%s را بررسی کنید');
		$this->form_validation->set_rules('current','کلمه عبور جاری','trim|required');
		$this->form_validation->set_rules('password','کلمه عبور جدید','trim|required');
		$this->form_validation->set_rules('repassword','نکرا کلمه عبور','trim|required|matches[password]');
		if ($this->form_validation->run() == FALSE)
		{
			$msg['msg'][0] = validation_errors();
			$msg['msg'][1] = "خطا در تغییر کلمه عبور";
			$this->session->set_flashdata($msg);
			$this->load->view('generalAct/changePassv',$msg);
			return;
		}
		else
			$msg			= $this->user->updatePassword();
		$this->load->view('generalAct/changePassv',$msg);
	}
}