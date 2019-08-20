<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Myprofile extends MY_Controller
{
	/**
	 * [__construct load models and session function]
	 */
	public function __construct()
	{
		parent::__construct();

		is_user_logged_in();

		$this->load->model('user_model', 'users');
		$this->load->model('activity_log_model', 'activity_log');
	}

	/**
	 * [edit for update user's personal profile]
	 * @return [array] [updated profile load]
	 */
	public function edit()
	{
		$id = get_loggedin_info('user_id');

		if ($id)
		{
			$data['user']    = $this->users->get($id);
			$data['content'] = $this->load->view('admin/profile/edit', $data, TRUE);
			$this->load->view('admin/index', $data);
		}

		if ($this->input->post())
		{
			$data = array(
				'firstname' => $this->input->post('firstname'),
				'lastname'  => $this->input->post('lastname'),
				'email'     => $this->input->post('email'),
				'mobile_no' => $this->input->post('mobile_no')
			);

			$update = $this->users->update($id, $data);

			if ($update)
			{
				log_activity(get_loggedin_info('username').' '._l('updated', _l('profile')), $id);

				$this->session->set_flashdata('success', _l('updated', _l('profile')));
				redirect('admin/myprofile/edit');
			}
		}
	}

/**
 * [edit_password for update user's password]
 * @return [array] [updated password]
 */
	public function edit_password()
	{
		$id = get_loggedin_info('user_id');
		$data['user'] = $this->users->get($id);

		if ($this->input->post())
		{
			$data = array
				(
				'password'             => md5($this->input->post('newpassword')),
				'last_password_change' => current_timestamp()
			);

			$update = $this->users->update($id, $data);

			if ($update)
			{
				
				log_activity(get_loggedin_info('username').' '._l('changed', _l('password')), $id);
				$this->session->set_flashdata('success', _l('changed', _l('password')));
				redirect('admin/myprofile/edit');
			}
		}
		else
		{
			log_activity(_l('error').' '._l('password', _l('not_change')), $id);
			$this->session->set_flashdata('error', _l('password', 'required_field_msg'));
		}
	}
}
