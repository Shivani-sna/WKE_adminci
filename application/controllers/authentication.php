<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Authentication extends MY_Controller
{
	/**
	 * [__construct load model]
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model', 'users');
	}

	/**
	 * [index for load view authentication]
	 * @return [array] [html content]
	 */
	public function index()
	{
		$data['content'] = $this->load->view('authentication', '', TRUE);
		$this->load->view('index', $data);
	}

	/**
	 * [check_login for authencation]
	 * @return [array] [user's data]
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

			$where = array
				(
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

				log_activity(_l('logged_in', _l('user'))." : [$firstname $lastname , $email]", $result['id']);

				$data = array
					(
					'last_ip'    => $this->input->ip_address(), //User Ip address
					'last_login' => current_timestamp()
				);

				$update = $this->users->update($result['id'], $data);

				if ($update)
				{
					$data = array
						(
						'user_id'        => $result['id'],
						'email'          => $result['email'],
						'username'       => $result['firstname'].' '.$result['lastname'],
						'user_logged_in' => TRUE
					);

					$this->session->set_userdata('user', $data);

					if ($redirect_url = $this->session->userdata('redirect_url'))
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
				$where     = array('email' => $email);
				$user      = $this->users->get_by($where);
				$firstname = $user['firstname'];
				$lastname  = $user['lastname'];
				$email     = $user['email'];

				if ($user['is_active'] == 1)
				{
					$this->session->set_flashdata('error', _l('required_field_valid', _l('password')));

					log_activity(_l('failed_login')." : [ $firstname $lastname , $email ]", $user['id']);
				}
				else

				if ($user['is_active'] == "0")
				{
					$this->session->set_flashdata('error', _l('inactive_login_error_msg'));
					log_activity(_l('inactive', _l('user')).": [ $firstname $lastname , $email ]", $user['id']);
				}
				else
				{
					$this->session->set_flashdata('error', _l('required_field_valid', _l('email')));
					log_activity(_l('failed_login')." [ Unknown Access ]");
				}

				redirect('authentication');
			}
		}
	}

	/**
	 * [forgot_password for verify user by their email]
	 * @return [string] [generate auth_token and send URL user's Registered Email]
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

				log_activity("$firstname $lastname request for forgot Password", $result['id']);

				$update = $this->users->update($result['id'], $key);

				if ($update)
				{
					$subject = "WKE Reset Password";
					$data['user'] = $this->users->get_by($key);
					$mailContent  = $this->load->view('email_password_recovery', $data, TRUE);
					
					$success = 'Please Check your Mail you have recive Reset Password Mail ';
					$redirect ='authentication';
					send_mail($email, $key , $subject,$mailContent,$success ,$redirect);
				}
				
			}
			else
			{
				log_activity(_l('failed_forgot_password')." [ Unknown Access ]");
				log_activity(" Unknown Access");
				$this->session->set_flashdata('error', _l('required_field_valid', _l('email')));
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
	 * [reset_password for update new password]
	 * @param  string $key [auth_token from URL]
	 * @return [boolean]
	 */
	public function reset_password($key = '')
	{
		$data['user'] = $this->users->get_by(array('auth_token' => $key));

		if ($key == NULL)
		{
			$this->session->set_flashdata('error', 'Your reset password link expire.Please Request For New');
			redirect('authentication');
		}

		if ($data['user'] == NULL)
		{
			$this->session->set_flashdata('error', 'Your reset password link expire.Please Request for New');
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
			$username     = $data['user']['firstname'].' '.$data['user']['lastname'];

			$update = $this->users->update($id, $password_data);

			if ($update)
			{
				log_activity("$username Reset Password", $id);
				$this->session->set_flashdata('success', 'Your Password changed Continue Login with New Password');

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
 * [logout dfor destroy session]
 * @return [boolean]
 */
	public function logout()
	{
		$username = get_loggedin_info('username');
		$email    = get_loggedin_info('email');

		log_activity(_l('logged_out', _l('user'))." : [$username , $email]", get_loggedin_info('user_id'));
		$this->session->sess_destroy();
		redirect('authentication');
	}
}
