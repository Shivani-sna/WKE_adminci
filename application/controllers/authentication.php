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
				$password = $this->input->post('password');

				if (isset($remember))
				{
					set_cookie('email_cookie', $email, '3600');
					set_cookie('password_cookie', $password, '3600');
				}
				else
				{
					delete_cookie('email_cookie');
					delete_cookie('password_cookie');
				}

				$where = array(
					'email'     => $email,
					'password'  => md5($password),
					'is_active' => 1
				);
				$result = $this->users->get_by($where);

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
					$where = array('email' => $email);
					$user  = $this->users->get_by($where);

					if ($user)
					{
						$this->session->set_flashdata('error', 'Please Enter Valid Password.');
						$firstname = $user['firstname'];
						$lastname  = $user['lastname'];
						$email     = $user['email'];
						log_activity("Failed Login User: [$firstname $lastname,$email]", $user['id']);
					}
					else
					{
						$this->session->set_flashdata('error', 'Please Enter Valid Email.');
						$ip = $this->input->ip_address();
						log_activity("Failed Login User Unknown Access [IP : $ip]", null);
					}

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

			if ($this->input->post('email'))
			{
				$result = $this->users->get_by('email', $this->input->post('email'));

				if ($result)
				{
					$this->session->set_flashdata('success', 'Your Reset Password Link has send');
					$firstname = $result['firstname'];
					$lastname  = $result['lastname'];
					$email     = $result['email'];
					$key       = array('remember_token' => remember_token());

// print_r($key);
					// die();
					log_activity("Forgot Password request user: [$firstname $lastname,$email]", $result['id']);
					$update = $this->users->update($result['id'], $key);

					if ($update)
					{
						redirect('authentication/reset_password');
					}

//redirect('authentication/reset_password',$data);

//$this->reset_password($data);
					//redirect($this->load->view('email_password_recovery',$data));
				}
				else
				{
					$ip = $this->input->ip_address();
					log_activity("Failed forgot Password request Unknown Access [IP : $ip]", null);
					$this->session->set_flashdata('error', 'Please Enter Valid Email.');
					redirect('authentication/password_recovery');
				}
			}
		}
		else
		{
			redirect('admin/home');
		}
	}

	/**
	 * @param $key
	 */
	public function reset_password($key)
	{
		if (!empty(check_session()))
		{
			redirect('admin/home');
		}

		$data['user'] = $this->users->get_by(array('remember_token' => $key));

// if ($data['user'] == null)

// {

// 	//$this->session->set_flashdata('error', 'Invalid Forgot Password Request');

// 	//redirect('authentication/password_recovery');

// }

// else
		// {
		$data['content'] = $this->load->view('reset_password', $data, TRUE);
		$this->load->view('index', $data);
		$id = $data['user']['id'];

		if ($this->input->post() != null)
		{
			$data = array(
				'password'             => md5($this->input->post('password')),
				'last_password_change' => current_timestamp(),
				'remember_token'       => null

			);
			$update = $this->users->update($id, $data);

			if ($update)
			{
				log_activity("Reset Password user:[ID : $id]", $id);
				$this->session->set_flashdata('success', 'your Password changed');

				redirect('authentication');
			}
			else
			{
				log_activity("!Failed Reset Password user:[ID : $id]", $id);
				$this->session->set_flashdata('error', 'Error in Password change');
			}
		}

		// }
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
