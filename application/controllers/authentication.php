<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authentication extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model', 'users');
	}

	/**
	 * [index for Display about us]
	 */
	public function index()
	{
		if (empty(check_session()))
		{
			$data['content'] = $this->load->view('authentication', '', TRUE);
			$this->load->view('index', $data);
		}
		else
		{
			redirect('admin/home');
		}
	}

	public function check_login()
	{
		if (empty(check_session()))
		{
			if ($this->input->post())
			{
				$remember = $this->input->post('remember');
				$email    = $this->input->post('email');
				$password = md5($this->input->post('password'));
				$set_data = array($email, $this->input->post('password'));
				$where    = array('email' => $email, 'password' => $password, 'is_active' => 1);
				$result   = $this->users->get_by($where);

				if ($result)
				{
					$firstname = $result['firstname'];
					$lastname  = $result['lastname'];
					$email     = $result['email'];
					log_activity("Login User : [$firstname $lastname,$email]", $result['id']);
					$data = array(
						'last_ip'    => $this->input->ip_address(), //User Ip address
						'last_login' => current_timestamp()
					);
					$update = $this->users->update($result['id'], $data);

					if ($update)
					{
						$this->session->set_userdata('user', $result);
						redirect('admin/home');
					}
				}
				else
				{
					$this->session->set_flashdata('error', 'Please Enter Valid Credentials.');
					redirect('authentication');
				}
			}
		}
		else
		{
			redirect('home');
		}
	}

	public function password_recovery()
	{
		if (empty(check_session()))
		{
			$data['content'] = $this->load->view('password_recovery', '', TRUE);
			$this->load->view('index', $data);
		//	print_r($this->input->post());
			if ($this->input->post('email'))
			{
				$result = $this->users->get_by('email',$this->input->post('email'));
				if ($result)
				 {
					$email             = $this->input->post('email');
					$data['firstname'] = "sh";
					$data['lastname']  = "nk";
					$subject           = "Password Reset form WKE";
					$htmlContent       = $this->load->view('email_password_recovery', $data, TRUE);
					send_mail($email, $subject, $htmlContent);
				}
				else
				{
					$this->session->set_flashdata('error', 'Please Enter Valid Email.');
					redirect('authentication/password_recovery');
				}
				// print_r($data);
				// die();

			}
		}
		else
		{
			redirect('admin/home');
		}
	}

	public function logout()
	{
		$session   = check_session();
		$firstname = $session['firstname'];
		$lastname  = $session['lastname'];
		$email     = $session['email'];
		log_activity("Logout User : [$firstname $lastname,$email]", $session['id']);
		$this->session->unset_userdata('user');
		redirect('authentication');
	}
}
