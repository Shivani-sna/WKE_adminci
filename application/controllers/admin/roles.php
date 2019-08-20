<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends MY_Controller
{
	/**
	 * [__construct for load models and session function]
	 */
	public function __construct()
	{
		parent::__construct();

		is_user_logged_in();

		$this->load->model('role_model', 'roles');
		$this->load->model('user_model', 'users');
		$this->load->model('user_permission_model', 'user_permissions');
	}

	/**
	 * [index for load view roles]
	 * @return [type] [description]
	 */
	public function index()
	{
		if (!has_permissions('roles', 'view'))
		{
			access_denied('roles', 'view');
		}
		else
		{
			$data['roles']   = $this->roles->get_all();
			$data['content'] = $this->load->view('admin/roles/index', $data, TRUE);
			$this->load->view('admin/index', $data);

			log_activity(_l('view', _l('roles')));
		}
	}

/**
 * [add for insert role]
 */

	public function add()
	{
		if (!has_permissions('roles', 'create'))
		{
			access_denied('roles', 'create');
		}
		else
		{
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

				log_activity(_l('added', _l('role'))."[ID:$insert] ");

				if ($insert)
				{
					$this->session->set_flashdata('success', _l('added_successfully_msg', _l('role')));
					redirect('admin/roles');
				}
			}
		}
	}

/**	
 * [edit for update role by role id]
 * @param  [int] $id [role id]
 * @return [array]     [updated role data]
 */
	public function edit($id)
	{
		if (!has_permissions('roles', 'edit'))
		{
			access_denied('roles', 'edit');
		}
		else
		{
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

				log_activity(_l('updated', _l('role'))."[ID:$id] ");

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
							}
						}
					}
				}

				if ($update)
				{
					$this->session->set_flashdata('success', _l('updated_successfully_msg', _l('role')));
					redirect('admin/roles');
				}
			}
		}
	}

/**
 * [delete for role delete]
 * @return [booolan] 
 */
	public function delete()
	{
		if (!has_permissions('roles', 'delete'))
		{
			access_denied('roles', 'delete');
		}
		else
		{
			$role_id = $this->input->post('role_id');
			$users   = $this->users->get_many_by(array('role' => $role_id));

			if ($users == NULL)
			{
				$result = $this->roles->delete($role_id);
				log_activity(_l('deleted', _l('role'))." [ID:$role_id]");
				echo "deleted";
			}
			else
			{
				echo "error";
				log_activity("Error "._l('deleted', _l('role'))." [ID:$role_id]");
			}
		}
	}
/**
 * [delete_selected for selected roles delete]
 */
	public function delete_selected()
	{
		if (!has_permissions('roles', 'delete'))
		{
			echo "error";
		}
		else
		{
			$where = $this->input->post('ids');
			$ids   = implode(",", $where);

			$delete_many = $this->roles->delete_many($where);

			if ($delete_many)
			{
				log_activity(_l('deleted', _l('roles'))."[IDS:$ids] ");
			}
		}
	}
}
