<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller
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
	}

	/**
	 * []
	 */
	public function index()
	{
		if (empty(check_session()))
		{
			$this->session->set_flashdata('error', 'Access denied');
			redirect('authentication');
		}

		$data['users']   = $this->users->get_all();
		$data['content'] = $this->load->view('admin/users/index', $data, TRUE);
		$this->load->view('admin/index', $data);
	}

	public function insert()
	{
		if (empty(check_session()))
		{
			$this->session->set_flashdata('error', 'Access denied');
			redirect('authentication');
		}

		$data['content'] = $this->load->view('admin/users/create', '', TRUE);
		$this->load->view('admin/index', $data);
		$id = check_session()['id'];

		if ($this->input->post())
		{
			$data = array
				('firstname' => $this->input->post('firstname'),
				'lastname'   => $this->input->post('lastname'),
				'email'      => $this->input->post('email'),
				'mobile_no'  => $this->input->post('mobile_no'),
				'password'   => md5($this->input->post('password')),
				'is_active'  => 1,
				'is_deleted' => 0
			);
			$insert = $this->users->insert($data);

			log_activity("User Added [ID:$insert] ", $id);

//log activity for user insert

			if ($insert)
			{
				$this->session->set_flashdata('success', 'You have Added User Successfully');
				redirect('admin/users');
			}
		}
	}

	/**
	 * @param $id
	 */
	public function update($id)
	{
		if (empty(check_session()))
		{
			$this->session->set_flashdata('error', 'Access denied');
			redirect('authentication');
		}

		if ($id)
		{
			$data['user'] = $this->users->get($id);

			if (check_session()['id'] == $id)
			{
				redirect('admin/myprofile/update');
			}
			else
			{
				$data['content'] = $this->load->view('admin/users/edit', $data, TRUE);
			}

			$this->load->view('admin/index', $data);

			if ($this->input->post())
			{
				$data = array(
					'firstname' => $this->input->post('firstname'),
					'lastname'  => $this->input->post('lastname'),
					'email'     => $this->input->post('email'),
					'mobile_no' => $this->input->post('mobile_no'),
					'password'  => md5($this->input->post('password'))
				);

				$update     = $this->users->update($id, $data);
				$session_id = check_session()['id'];
				log_activity("User Updated [ID:$id] ", $session_id);

				if ($update)
				{
					$this->session->set_flashdata('success', 'You have Updated User.');

					redirect('admin/users');
				}
			}
		}
	}

	public function update_status()
	{
		$session_id = check_session()['id'];
		$user_id    = $this->input->post('user_id');
		$data       = array('is_active' => $this->input->post('is_active'));
		$update     = $this->users->update($user_id, $data);
		log_activity("User Status Updated [ID:$user_id] ", $session_id);
	}

	public function delete()
	{
		$session_id = check_session()['id'];
		$user_id    = $this->input->post('user_id');
		$result     = $this->users->delete($user_id);

		log_activity("User Deleted [ID:$user_id] ", $session_id);
	}

	public function delete_selected()
	{
		$session_id = check_session()['id'];
		$where      = $this->input->post('ids');
		$ids        = implode(",", $where);
		$delete_all = $this->users->delete_many($where);

		log_activity("Users Deleted [IDS:$ids] ", $session_id);
	}
}
