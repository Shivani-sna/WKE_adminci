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
		is_user_logged_in();
		$this->load->model('user_model', 'users');
		$this->load->model('role_model', 'roles');
		$this->load->model('user_permission_model', 'user_permissions');
	}

	/**
	 * [index for view Users]
	 */
	public function index()
	{
		$data = array(
			'user_id'      => get_loggedin_user_id(),
			'features'     => 'users',
			'capabilities' => 'view'

		);
		$this->users->order_by('id', 'DESC');
		$data['users']   = $this->users->get_all();
		$data['roles']   = $this->roles->get_all();
		$data['content'] = $this->load->view('admin/users/index', $data, TRUE);
		$this->load->view('admin/index', $data);
	}

/**
 * [add for insert users]
 */
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
			$id     = get_loggedin_user_id();
			log_activity("User Added [ID:$insert] ", $id);

			$role_id = $this->input->post('role');
			$role    = $this->roles->get($role_id);

			$permissions = unserialize($role['permissions']);

			foreach ($permissions as $key => $permission)
			{
				foreach ($permission as $key_permission => $value)
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
				$this->session->set_flashdata('success',_l('added_successfully_msg', _l('user')));
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
	 *[update user by user id]
	 * @param $id
	 */
	public function edit($id)
	{
		if (empty(has_permissions('users', 'edit')))
		{
			$this->session->set_flashdata('error', 'You have Not access');
			redirect('admin/dashboard');
		}

		if ($id)
		{
			if ($this->input->post())
			{
				$role         = $this->input->post('role');
				$data['user'] = $this->users->get($id);

				if ($this->input->post('newpassword') == NULL)
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
				$session_id = get_loggedin_user_id();
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
						foreach ($permission as $key_permission => $value)
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

				if (get_loggedin_user_id() == $id)
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

/**
 * [update_status for update users is_active]
 */
	public function update_status()
	{
		$session_id = get_loggedin_user_id();
		$user_id    = $this->input->post('user_id');
		$data       = array('is_active' => $this->input->post('is_active'));
		// print_r($data);
		// die();
		$update     = $this->users->update($user_id, $data);
		if ($update) 
		{
			if ($this->input->post('is_active')==1) 
			{
				echo "Active";
			}
			

		}
		log_activity("User Status Updated [ID:$user_id] ", $session_id);
	}

/**
 * [delete for delete user by id]
 */
	public function delete()
	{
		if (empty(has_permissions('users','delete')))
		{
			$this->session->set_flashdata('error', 'You have Not access');
			redirect('admin/home');
		}

		$session_id = get_loggedin_user_id();
		$user_id    = $this->input->post('user_id');
		$result     = $this->users->delete($user_id);

		log_activity("User Deleted [ID:$user_id] ", $session_id);
	}

/**
 * [delete_selected for delete multiple users by their ids]
 */
	public function delete_selected()
	{
		$session_id = get_loggedin_user_id();
		$where      = $this->input->post('ids');
		$ids        = implode(",", $where);
		$delete_all = $this->users->delete_many($where);

		log_activity("Users Deleted [IDS:$ids] ", $session_id);
	}
}
