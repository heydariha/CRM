<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller 
{
	public function index()
	{
		$this->load->view('generalAct/loginv');
	}
	
###########################
#Written by HAdi in 9511221 in order to check login
	function authenticating()
	{
		$this->form_validation->set_message('required','%s را وارد کنید ');
		$this->form_validation->set_rules('email','نام کاربری','trim|required|valid_email');
		$this->form_validation->set_rules('password','کلمه عبور','trim|required');//|xss_clean

		if ($this->form_validation->run() == FALSE)
		{
			$msg['msg'][0] = validation_errors();//'مشخصات ارسال شده معتبر نیست'; //نوشته ثابت
			$msg['msg'][1] = "login_error";
			$this->session->set_flashdata($msg);
			$this->index();
		}
		else
		{
			// redirect('/mainpage');

			$mail		= $this->input->get_post('email');
			$pass		= $this->input->get_post('password');
			$result		= $this->user->getUserLogin($mail,$pass);
			if(sizeof($result) > 0 && $result['user_active']==1)
			{
				$this->session->set_userdata('user_id',$result['user_id']);
				$this->session->set_userdata('user_email',$result['user_name']);
				$this->session->set_userdata('user_fname',$result['user_fname']);
				$this->session->set_userdata('user_lname',$result['user_lname']);

				redirect('todo');
			}
			else
			{
				if(isset($result['user_active']))
					$msg['msg'][0] = 'Please activate your account to start using our services!';
				else
					$msg['msg'][0] = 'Error in username or password';
				$msg['msg'][1] = "login_error";
				$this->session->set_flashdata($msg);
				$this->load->view('generalAct/loginv');
			}//end else
		}

	}

	function logout()
	{
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('user_email');
		$this->session->unset_userdata('user_fname');
		$this->session->unset_userdata('user_lname');
		$this->session->unset_userdata('user_type');
		$this->index();
		// redirect('mainpage');
	}

	function register()
	{
		$this->form_validation->set_message('required','%s را وارد کنید ');
		$this->form_validation->set_rules('runame','Name','trim|required');
		$this->form_validation->set_rules('rufamily','Family','trim|required');
		$this->form_validation->set_rules('remail','username','trim|required|valid_email|is_unique[ba_users.user_name]');
		$this->form_validation->set_rules('rpassword','password','trim|required');
		$this->form_validation->set_rules('rrepassword','','trim|required|matches[rpassword]');
		
	// $this->db->trans_start();
		
		if ($this->form_validation->run() == FALSE)
		{
			$msg['msg'][0] = validation_errors();
			$msg['msg'][1] = "registration_error";
			$this->session->set_flashdata($msg);
			$this->index();
		}
		else
		{
			$record			= array('user_fname'=>$this->input->get_post('runame'),
									'user_lname'=>$this->input->get_post('rufamily'),
									'user_name'=>$this->input->get_post('remail'),
									'user_password'=>$this->input->get_post('rpassword'));
			$result			= $this->user->putUser($record);

			if(!$result['result'])
			{
				$msg['msg'][0] = $result['error']['message'];
				$this->session->set_flashdata($msg);
			}
			else
			{
				// $this->sendActivationMail($record);
				$this->session->set_userdata('user_id',$result['result']);
				$this->session->set_userdata('user_email',$this->input->get_post('remail'));
				$this->session->set_userdata('user_fname',$this->input->get_post('rufamily'));
				$this->session->set_userdata('user_lname',$this->input->get_post('runame'));
				$this->session->set_userdata('user_type',1);
			}
			redirect('mainpage');
		}


	}
//______________________________________________________________________________________________________
	function activateUser()
	{
		$userCode	= addslashes($this->uri->segment(3));
		$result		= $this->user->getUserByCode($userCode);		
		$this->user->updateUser(array('user_active'=>1),$result['user_id']);
		
		$this->session->set_userdata('user_id',$result['user_id']);
		$this->session->set_userdata('user_email',$result['user_name']);
		$this->session->set_userdata('user_fname',$result['user_fname']);
		$this->session->set_userdata('user_lname',$result['user_lname']);
		$this->session->set_userdata('user_type',1);
		redirect('mainpage');
	}
//______________________________________________________________________________________________________
	function sendActivationMail($record)
	{
		return;
		$this->email->from('info@farhoonet.ir', 'Hadi Heydari');
		$this->email->to($record['user_name']);
		$this->email->subject('Activation code');
		$message	= "<center><h3>Dear {$record['user_lname']} </h3></center>\n";
		$message	.= "<center><h4>In order to activate your accout, please click the following link.:</h4></center> \n\n";
		$message	.= "<center><a href='".base_url('login/activateUser/').$this->general->hashStr($record['user_name'])."' >".
						base_url('login/activateUser/').$this->general->hashStr($record['user_name'])."</a></center> \n\n<br>";
		$message	.= "<center>This code is valid for 3 hours</center>";
		$this->email->message($message);
		$this->email->send();		
// echo $message."<BR>";
die("<br><br><br><center><h3 style='color:orange'>Your activation code was sent to your Email address. <br>Please activate your account to start using our services!</h3></canter>");
		// $this->db->trans_complete();
	}
//______________________________________________________________________________________________________
}
