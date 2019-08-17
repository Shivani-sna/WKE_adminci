<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		is_user_logged_in();
		$this->load->model('role_model', 'roles');
		$this->load->model('user_model', 'users');
		$this->load->model('user_permission_model', 'user_permissions');
	}

	/**
	 * [index for view roles]
	 */
	public function index()
	{
		if (!has_permissions('roles', 'view'))
		{
			access_denied('roles', 'view');
		}

		$data['roles']   = $this->roles->get_all();
		$data['content'] = $this->load->view('admin/roles/index', $data, TRUE);
		$this->load->view('admin/index', $data);
	}

/**
 * [add for insert roles]
 */
	public function add()
	{
		if (!has_permissions('roles', 'create'))
		{
			access_denied('roles', 'create');
		}

		$data['permissions'] = get_users_permissions();
		$data['array']       = $this->load->view('admin/roles/roles_array', $data, TRUE);
		$data['content']     = $this->load->view('admin/roles/create', $data, TRUE);

		$this->load->view('admin/index', $data);

		if ($this->input->post())
		{
			$data = array(
				'name'        => $this->input->post('name'),
				'permissions' => serialize($this->input->post('permissions'))
			);

			$insert = $this->roles->insert($data);
			log_activity("Role Added [ID:$insert] ", get_loggedin_user_id());

			if ($insert)
			{
				$this->session->set_flashdata('success',_l('added_successfully_msg', _l('role')));
				redirect('admin/roles');
			}
		}
	}

/**
 *[update role by role id]
 * @param $id
 */
	public function edit($id)
	{
		if (!has_permissions('roles', 'edit'))
		{
			access_denied('roles', 'edit');
		}

		$data['role']        = $this->roles->get($id);
		$data['permissions'] = get_users_permissions();
		$data['array']       = $this->load->view('admin/roles/roles_array_update', $data, TRUE);
		$data['content']     = $this->load->view('admin/roles/edit', $data, TRUE);

		$this->load->view('admin/index', $data);

		if ($this->input->post())
		{
			$data = array(
				'name'        => $this->input->post('name'),
				'permissions' => serialize($this->input->post('permissions'))
			);
			$update = $this->roles->update($id, $data);
			log_activity("Role updated [ID:$update] ", get_loggedin_user_id());
			$users = $this->users->get_many_by(array('role' => $id));

			if ($users != null)
			{
				$user_id_array = array();

				foreach ($users as $key => $value)
				{
					$user_id = $value['id'];
					array_push($user_id_array, $user_id);
				}

				$delete_prmissions = $this->user_permissions->delete_by(array('user_id' => $user_id_array));
				$roles             = $this->roles->get($id);
				$permissions       = unserialize($roles['permissions']);

				foreach ($permissions as $key => $permission)
				{
					foreach ($permission as $key_permission => $value)
					{
						foreach ($user_id_array as $key_user_id => $user)
						{
							$data = array
								(
								'user_id'      => $user,
								'features'     => $key,
								'capabilities' => $value
							);
							$user_permissions_insert = $this->user_permissions->insert($data);
							//print_r($user_permissions_insert);
						}
					}
				}
			}

			if ($update)
			{
				$this->session->set_flashdata('success', 'Role updated Successfully');
				redirect('admin/roles');
			}
		}
	}

/**
 * [delete for delete role by id]
 */
	public function delete()
	{
		if (!has_permissions('roles', 'delete'))
		{
			access_denied('roles', 'delete');
		}

		$role_id = $this->input->post('role_id');
		$users   = $this->users->get_many_by(array('role' => $role_id));

		if ($users == NULL)
		{
			$result = $this->roles->delete($role_id);
			log_activity("Role Deleted [ID:$role_id] ", get_loggedin_user_id());
			echo "deleted";
		}
		else
		{
			echo "error";
			log_activity("Failed to Delete Role their related user exits [ID:$role_id] ", get_loggedin_user_id());
		}
	}

/**
 * [delete_selected for delete multiple roles by their ids]
 */
	public function delete_selected()
	{
		$session_id = get_loggedin_user_id();
		$where      = $this->input->post('ids');
		$ids        = implode(",", $where);
		$delete_all = $this->roles->delete_many($where);

		log_activity("Roles Deleted [IDS:$ids] ", $session_id);
	}
}
