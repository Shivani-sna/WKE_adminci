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

		$config                = $this->paginate();
		$config['base_url']    = base_url().'admin/roles';
		$config['uri_segment'] = 3;
		$data['src_rolename']  = '';

		$config['total_rows'] = $data['total_rows'] = $this->roles->count_all();
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$this->roles->limit($config['per_page'], $page);

		$sort = $this->session->userdata('sort_order');

		if ($sort['controller'] == $this->router->fetch_class())
		{
			$this->roles->order_by($sort['sort_by'], $sort['order']);
		}

		$data['links'] = $this->pagination->create_links();

		$data['roles']   = $this->roles->get_all();
		$data['content'] = $this->load->view('admin/roles/index', $data, TRUE);
		$this->load->view('admin/index', $data);

		log_activity(_l('view', _l('roles')));
	}

	/**
	 * [search for searching with pagination]
	 * @return [str] [search data]
	 */
	public function search()
	{
		$config                = $this->paginate();
		$config['base_url']    = base_url('admin/roles/search');
		$config['uri_segment'] = 4;
		$data['src_rolename']  = '';

		$where = array();

		if ($this->input->post('search'))
		{
			if ($this->input->post('name'))
			{
				$where['name LIKE']   = $this->input->post('name').'%';
				$data['src_rolename'] = $this->input->post('name');
				$this->session->set_userdata('src_rolename', $this->input->post('name'));
			}
			else
			{
				$this->session->unset_userdata('src_rolename');
			}
		}
		else
		{
			if ($this->session->userdata('src_rolename'))
			{
				$where['name LIKE']   = $this->session->userdata('src_rolename').'%';
				$data['src_rolename'] = $this->session->userdata('src_rolename');
			}
			else
			{
				$this->session->unset_userdata('src_rolename');
			}
		}

		$config['total_rows'] = $data['total_rows'] = $this->roles->count_by($where);

		$this->pagination->initialize($config);

		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

		$sort = $this->session->userdata('sort_order');

		if ($sort['controller'] == $this->router->fetch_class())
		{
			$this->roles->order_by($sort['sort_by'], $sort['order']);
		}

		$this->roles->limit($config['per_page'], $page);

		$data['links'] = $this->pagination->create_links();

		$data['roles'] = $this->roles->get_many_by($where);

		$data['content'] = $this->load->view('admin/roles/index', $data, TRUE);
		$this->load->view('admin/index', $data);
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

		$this->load->model('user_model', 'users');

		$data['role']        = $this->roles->get($id);
		$data['permissions'] = get_users_permissions();
		//$data['permissions'] = $this->permissions();
		$data['users']       = $this->users->get_many_by(['role' => $id]);
		$data['array']       = $this->load->view('admin/roles/roles_array_update', $data, TRUE);
		$data['content']     = $this->load->view('admin/roles/edit', $data, TRUE);

		$this->load->view('admin/index', $data);
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

		$role_id = $this->input->post('role_id');
		$users   = $this->users->get_many_by(array('role' => $role_id));

		if ($users == NULL)
		{
			$result = $this->roles->delete($role_id);
			log_activity(_l('deleted', _l('role'))." [ID:$role_id]");
			echo 'deleted';
		}
		else
		{
			log_activity("Error "._l('deleted', _l('role'))." [ID:$role_id]");
			echo 'error';
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

		$where = $this->input->post('ids');
		$ids   = implode(",", $where);

		$delete_many = $this->roles->delete_many($where);

		if ($delete_many)
		{
			log_activity(_l('deleted', _l('roles'))."[IDS:$ids] ");
		}
	}
}
