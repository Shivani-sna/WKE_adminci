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
		$this->load->model('user_model', 'users');
		$this->load->model('activity_log_model', 'activity_log');
	}

	/**
	 * [index Display reastaurants and their counting]
	 */
	public function index()
	{
		if (empty(check_session()))
		{
			$this->session->set_flashdata('error', 'Access denied');
			redirect('authentication');
		}

		$id              = check_session()['id'];
		$data['user']    = $this->users->get($id);
		$data['content'] = $this->load->view('admin/profile/index', $data, TRUE);
		$this->load->view('admin/index', $data);
	}

	/**
	 * [index Display reastaurants and their counting]
	 */
	public function update()
	{
		if (empty(check_session()))
		{
			$this->session->set_flashdata('error', 'Access denied');
			redirect('authentication');
		}

		$id = check_session()['id'];

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
			$data   = array(
				'description' => "MyProfile Updated",
				'	user_id'    => $id
			);
			$insert_activity = $this->activity_log->insert($data);

			if ($update)
			{
				$this->session->set_flashdata('success', 'Profile Updated');
				redirect('admin/myprofile/update');
			}
			else
			{
				$this->session->set_flashdata('error', 'Error Update');
			}
		}
	}

	/**
	 * [index Display reastaurants and their counting]
	 */
	public function update_password()
	{
		if (empty(check_session()))
		{
			$this->session->set_flashdata('error', 'Access denied');
			redirect('authentication');
		}

		$id = check_session()['id'];

		$data['user'] = $this->users->get($id);

		if ($this->input->post())
		{
			$data = array(
				'password'             => md5($this->input->post('newpassword')),
				'last_password_change' => current_timestamp()

			);

			$update = $this->users->update($id, $data);
			$data   = array(
				'description' => "MyPassword Changed",
				'	user_id'    => $id
			);
			$insert_activity = $this->activity_log->insert($data);

			if ($update)
			{
				$this->session->set_flashdata('success', 'Password Changed');
				redirect('admin/myprofile/update');
			}
			else
			{
				$this->session->set_flashdata('error', 'Password Not Change');
				redirect('admin/myprofile/update');
			}
		}
		else
		{
			$this->session->set_flashdata('error', 'Error ');
		}
	}
}
