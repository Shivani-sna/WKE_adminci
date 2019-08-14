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
		check_islogin();
		$this->load->model('user_model', 'users');
		$this->load->model('role_model', 'roles');
		$this->load->model('user_permission_model', 'user_permissions');
	}

	/**
	 * []
	 */
	public function index()
	{
		$data = array(
			'user_id'      => check_islogin()['id'],
			'features'     => 'users',
			'capabilities' => 'view'

		);

		$data['users']   = $this->users->get_all();
		$data['roles']   = $this->roles->get_all();
		$data['content'] = $this->load->view('admin/users/index', $data, TRUE);
		$this->load->view('admin/index', $data);
	}

	public function add()
	{
		if ($this->input->post())
		{
			$data = array
				('firstname' => $this->input->post('firstname'),
				'lastname'   => $this->input->post('lastname'),
				'email'      => $this->input->post('email'),
				'mobile_no'  => $this->input->post('mobile_no'),
				'password'   => md5($this->input->post('password')),
				'role'       => $this->input->post('role'),
				'is_active'  => 1,
				'is_deleted' => 0
			);
			$insert = $this->users->insert($data);
			$id     = check_islogin()['id'];
			log_activity("User Added [ID:$insert] ", $id);

			$role_id = $this->input->post('role');
			$role    = $this->roles->get($role_id);

			$permissions = unserialize($role['permissions']);

			foreach ($permissions as $key => $permission)
			{
				foreach ($permission as $use => $value)
				{
					$data = array
						('user_id'     => $insert,
						'features'     => $key,
						'capabilities' => $value);
					$permission_insert = $this->user_permissions->insert($data);
				}
			}

			if ($insert)
			{
				$this->session->set_flashdata('success', 'You have Added User Successfully');
				redirect('admin/users');
			}
		}
		else
		{
			$data['roles']   = $this->roles->get_all();
			$data['content'] = $this->load->view('admin/users/create', $data, TRUE);
			$this->load->view('admin/index', $data);
		}
	}

	/**
	 * @param $id
	 */
	public function edit($id)
	{
		if (empty(has_permissions('users', 'edit')))
		{
			$this->session->set_flashdata('error', 'You have Not access');
			redirect('admin/home');
		}

		if ($id)
		{
			if ($this->input->post())
			{
				$role         = $this->input->post('role');
				$data['user'] = $this->users->get($id);

				if ($this->input->post('newpassword')==NULL)
				{
					$data = array(
					'firstname' => $this->input->post('firstname'),
					'lastname'  => $this->input->post('lastname'),
					'email'     => $this->input->post('email'),
					'mobile_no' => $this->input->post('mobile_no'),
					'role'      => $role
				);
				}
				else
				{
					$data = array(
					'firstname' => $this->input->post('firstname'),
					'lastname'  => $this->input->post('lastname'),
					'email'     => $this->input->post('email'),
					'mobile_no' => $this->input->post('mobile_no'),
					'password'  => md5($this->input->post('newpassword')),
					'role'      => $role
				);
				}

				

				$update     = $this->users->update($id, $data);
				$session_id = check_islogin()['id'];
				log_activity("User Updated [ID:$id] ", $session_id);
				$user_id = $this->input->post('role');

				$user_permissions_data = $this->user_permissions->delete_by(array('user_id' => $id));

				$role_id   = $this->input->post('role');
				$role_data = $this->roles->get_by(array('id' => $role_id));

				$permissions = unserialize($role_data['permissions']);

				foreach ($permissions as $key => $permission)
				{
					if ($permission != NULL)
					{
						foreach ($permission as $use => $value)
						{
							$data = array
								('user_id'     => $id,
								'features'     => $key,
								'capabilities' => $value);
							
							$permission_insert = $this->user_permissions->insert($data);
						}
					}
				}

				if ($update)
				{
					$this->session->set_flashdata('success', 'User updated Successfully');
					redirect('admin/users');
				}
			}
			else
			{
				$data['user']  = $this->users->get($id);
				$data['roles'] = $this->roles->get_all();

				if (check_islogin()['id'] == $id)
				{
					redirect('admin/myprofile/edit');
				}
				else
				{
					$data['content'] = $this->load->view('admin/users/edit', $data, TRUE);
				}

				$this->load->view('admin/index', $data);
			}
		}
	}

	public function update_status()
	{
		$session_id = check_islogin()['id'];
		$user_id    = $this->input->post('user_id');
		$data       = array('is_active' => $this->input->post('is_active'));
		$update     = $this->users->update($user_id, $data);
		log_activity("User Status Updated [ID:$user_id] ", $session_id);
	}

	public function delete()
	{
		if (empty(has_permissions(check_islogin()['id'])))
		{
			$this->session->set_flashdata('error', 'You have Not access');
			redirect('admin/home');
		}

		$session_id = check_islogin()['id'];
		$user_id    = $this->input->post('user_id');
		$result     = $this->users->delete($user_id);

		log_activity("User Deleted [ID:$user_id] ", $session_id);
	}

	public function delete_selected()
	{
		$session_id = check_islogin()['id'];
		$where      = $this->input->post('ids');
		$ids        = implode(",", $where);
		$delete_all = $this->users->delete_many($where);

		log_activity("Users Deleted [IDS:$ids] ", $session_id);
	}
}
