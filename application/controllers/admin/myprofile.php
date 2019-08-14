<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Myprofile extends MY_Controller
{
	/**
	 * @var mixed
	 */
	protected $soft_delete = TRUE;
	/**
	 * @var string
	 */
	protected $soft_delete_key = 'is_deleted';

	public function __construct()
	{
		parent::__construct();
		check_islogin();
		$this->load->model('user_model', 'users');
		$this->load->model('activity_log_model', 'activity_log');
	}

	/**
	 * [edit  for update profile details by session_id]
	 */
	public function edit()
	{
		$id = check_islogin()['id'];

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
				log_activity("MyProfile Updated", $id);
				$this->session->set_flashdata('success', 'Profile Updated');
				redirect('admin/myprofile/update');
			}
			else
			{
				log_activity("!Error Myprofile not update", $id);
				$this->session->set_flashdata('error', 'Error Update');
			}
		}
	}

	/**
	 * [edit password for change password]
	 */
	public function edit_password()
	{
		$id = check_islogin()['id'];

		$data['user'] = $this->users->get($id);

		if ($this->input->post())
		{
			$data = array(
				'password'             => md5($this->input->post('newpassword')),
				'last_password_change' => current_timestamp()

			);

			$update = $this->users->update($id, $data);

			if ($update)
			{
				log_activity("MyPassword Changed", $id);
				$this->session->set_flashdata('success', 'Password Changed');
				redirect('admin/myprofile/update');
			}
			else
			{
				log_activity("!Error MyPassword Not Change", $id);
				$this->session->set_flashdata('error', 'Password Not Change');
				redirect('admin/myprofile/update');
			}
		}
		else
		{
			log_activity("!Error MyPassword Not Change", $id);
			$this->session->set_flashdata('error', 'Plese Enter valid Password');
		}
	}
}
