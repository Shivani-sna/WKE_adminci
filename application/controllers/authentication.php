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
	 * [index for redirect authentication page]
	 */
	public function index()
	{
		$data['content'] = $this->load->view('authentication', '', TRUE);
		$this->load->view('index', $data);
	}

/**
 * [check login for login credentials]
 */
	public function check_login()
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
					$data = array
						(
						'user_id'        => $result['id'],
						'username'       => $result['firstname'].' '.$result['lastname'],
						'user_logged_in' => TRUE
					);

					$this->session->set_userdata('user', $data);

//print_r($this->session->get_userdata('user[user_id]'));
					// die();
					if ($redirect_url=$this->session->userdata('redirect_url')) 
					{
						redirect($redirect_url);
					}
					else
					{
						redirect('admin/dashboard');
					}
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

/**
 * [password_recovery for forgot password]
 */
	public function forgot_password()
	{
		if ($this->input->post('email'))
		{
			$result = $this->users->get_by('email', $this->input->post('email'));

			if ($result)
			{
				$this->session->set_flashdata('success', 'Your Reset Password Link has send');

				$firstname = $result['firstname'];
				$lastname  = $result['lastname'];
				$email     = $result['email'];
				$key       = array('auth_token' => auth_token());

				log_activity("Forgot Password request user: [$firstname $lastname,$email]", $result['id']);

				$update = $this->users->update($result['id'], $key);

				if ($update)
				{
/*
//send Mail form here

$email             = $email;

$data['firstname'] = $firstname;

$data['lastname']  = $lastname;

$subject           = "Password Recovery for WKE";

$htmlContent       = $this->load->view('email_password_recovery', $data, TRUE);
send_mail($email, $subject, $htmlContent);
 */

//$data['key'] = $key;

//print_r($data);

					redirect('authentication/email_view/'.$key['auth_token']);
				}
			}
			else
			{
				$ip = $this->input->ip_address();
				log_activity("Failed forgot Password request Unknown Access [IP : $ip]", NULL);

				$this->session->set_flashdata('error', 'Please Enter Valid Email.');

				redirect('authentication/forgot_password');
			}
		}
		else
		{
			$data['content'] = $this->load->view('forgot_password', '', TRUE);
			$this->load->view('index', $data);
		}
	}

/**
 * @param $key
 */
	public function email_view()
	{
		$data['key']  = $this->uri->segment(3);
		$data['user'] = $this->users->get_by(array('auth_token' => $this->uri->segment(3)));

// print_r($data);
		// die();
		$this->load->view('email_password_recovery', $data);
	}

// public function

	/**
	 * [reset_password for sending mail after url redirect]
	 */
	public function reset_password($key = '')
	{
// print_r($key);

// die();
		if ($key == NULL)
		{
			$this->session->set_flashdata('error', 'your reset password link expire');
			redirect('authentication');
		}

		if ($this->input->post('password'))
		{
			$password_data = array(
				'password'             => md5($this->input->post('password')),
				'last_password_change' => current_timestamp(),
				'auth_token'           => null

			);

			$data['user'] = $this->users->get_by(array('auth_token' => $key));
			$id           = $data['user']['id'];

			$update = $this->users->update($id, $password_data);

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
		else
		{
			$data['user']    = $this->users->get_by(array('auth_token' => $key));
			$id              = $data['user']['id'];
			$data['content'] = $this->load->view('reset_password', $data, TRUE);
			$this->load->view('index', $data);
		}
	}

/**
 * [logout destroy session]
 */
	public function logout()
	{
		$session  = is_user_logged_in();
		$username = $session['username'];
		$email    = $session['email'];
		log_activity("Logout User : [$username,$email]", get_loggedin_user_id());
		$this->session->unset_userdata('user');
		$this->session->unset_userdata('redirect_url');
		redirect('authentication');
	}
}
