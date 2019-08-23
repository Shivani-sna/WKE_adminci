<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller
{
	/**
	 * [__construct load model and check session]
	 */
	public function __construct()
	{
		parent::__construct();
		is_user_logged_in();

		$this->load->model('user_model', 'users');
		$this->load->model('role_model', 'roles');
		$this->load->model('user_permission_model', 'user_permissions');
	}

	/**
	 * [index for load view users]
	 * @return [array] [load html content]
	 */
	public function index()
	{
		if (!has_permissions('users', 'view'))
		{
			access_denied('users', 'view');
		}

		$config                = $this->paginate();
		$config['base_url']    = base_url('admin/users');
		$config['uri_segment'] = 3;

		$data['src_firstname'] = '';
		$data['src_lastname']  = '';
		$data['src_email']     = '';
		$data['src_role']      = '';
		$data['src_is_active'] = '';

		$config['total_rows'] = $data['total_rows'] = $this->users->count_all();
		$this->pagination->initialize($config);

		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$this->users->limit($config['per_page'], $page);

		$sort = $this->session->userdata('sort_order');

		if ($sort['controller'] == $this->router->fetch_class())
		{
			$this->users->order_by($sort['sort_by'], $sort['order']);
		}

		$data['links'] = $this->pagination->create_links();
		$data['users'] = $this->users->get_all();

		$data['roles'] = $this->roles->get_all();

		$data['content'] = $this->load->view('admin/users/index', $data, TRUE);
		$this->load->view('admin/index', $data);
	}

	/**
	 * [search for searching with pagination]
	 * @return [str] [search data]
	 */
	public function search()
	{
		if (!has_permissions('users', 'view'))
		{
			access_denied('users', 'view');
		}

		$config                = $this->paginate();
		$config['base_url']    = base_url('admin/users/search');
		$config['uri_segment'] = 4;
		$data['src_firstname'] = '';
		$data['src_lastname']  = '';
		$data['src_email']     = '';
		$data['src_role']      = '';
		$data['src_is_active'] = '';

		$where = array();

		if ($this->input->post('search'))
		{
			if ($this->input->post('firstname'))
			{
				$where['firstname LIKE'] = $this->input->post('firstname').'%';
				$data['src_firstname']   = $this->input->post('firstname');
				$this->session->set_userdata('src_firstname', $this->input->post('firstname'));
			}
			else
			{
				$this->session->unset_userdata('src_firstname');
			}

			if ($this->input->post('lastname'))
			{
				$where['lastname LIKE'] = $this->input->post('lastname').'%';
				$data['src_lastname']   = $this->input->post('lastname');
				$this->session->set_userdata('src_lastname', $this->input->post('lastname'));
			}
			else
			{
				$this->session->unset_userdata('src_lastname');
			}

			if ($this->input->post('email'))
			{
				$where['email']    = $this->input->post('email');
				$data['src_email'] = $this->input->post('email');
				$this->session->set_userdata('src_email', $this->input->post('email'));
			}
			else
			{
				$this->session->unset_userdata('src_email');
			}

			if ($this->input->post('role'))
			{
				$where['role']    = $this->input->post('role');
				$data['src_role'] = $this->input->post('role');
				$this->session->set_userdata('src_role', $this->input->post('role'));
			}
			else
			{
				$this->session->unset_userdata('src_role');
			}

			if ($this->input->post('is_active') == '0' || $this->input->post('is_active') == '1')
			{
				$where['is_active']    = $this->input->post('is_active');
				$data['src_is_active'] = $this->input->post('is_active');
				$this->session->set_userdata('src_is_active', $this->input->post('is_active'));
			}
			else
			{
				$this->session->unset_userdata('src_is_active');
			}
		}
		else
		{
			if ($this->session->userdata('src_firstname'))
			{
				$where['firstname LIKE'] = $this->session->userdata('src_firstname').'%';
				$data['src_firstname']   = $this->session->userdata('src_firstname');
			}
			else
			{
				$this->session->unset_userdata('src_firstname');
			}

			if ($this->session->userdata('src_lastname'))
			{
				$where['lastname LIKE'] = $this->session->userdata('src_lastname').'%';
				$data['src_lastname']   = $this->session->userdata('src_lastname');
			}
			else
			{
				$this->session->unset_userdata('src_lastname');
			}

			if ($this->session->userdata('src_email'))
			{
				$where['email']    = $this->session->userdata('src_email');
				$data['src_email'] = $this->session->userdata('src_email');
			}
			else
			{
				$this->session->unset_userdata('src_email');
			}

			if ($this->session->userdata('src_role'))
			{
				$where['role']    = $this->session->userdata('src_role');
				$data['src_role'] = $this->session->userdata('src_role');
			}
			else
			{
				$this->session->unset_userdata('src_role');
			}

			if ($this->session->userdata('src_is_active'))
			{
				$where['is_active']    = $this->session->userdata('src_is_active');
				$data['src_is_active'] = $this->session->userdata('src_is_active');
			}
			else
			{
				$this->session->unset_userdata('src_is_active');
			}
		}

		$config['total_rows'] = $data['total_rows'] = $this->users->count_by($where);

		$this->pagination->initialize($config);

		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

		$sort = $this->session->userdata('sort_order');

		if ($sort['controller'] == $this->router->fetch_class())
		{
			$this->users->order_by($sort['sort_by'], $sort['order']);
		}

		$this->users->limit($config['per_page'], $page);

		$data['users'] = $this->users->get_many_by($where);
		$data['roles'] = $this->roles->get_all();

		$data['links'] = $this->pagination->create_links();

		$data['content'] = $this->load->view('admin/users/index', $data, TRUE);
		$this->load->view('admin/index', $data);
	}

/**
 * [add for insert user]
 */
	public function add()
	{
		if (!has_permissions('users', 'create'))
		{
			access_denied('users', 'create');
		}

		if ($this->input->post())
		{
			$data = array
				(

				'firstname' => $this->input->post('firstname'),
				'lastname'  => $this->input->post('lastname'),
				'email'     => $this->input->post('email'),
				'mobile_no' => $this->input->post('mobile_no'),
				'password'  => md5($this->input->post('password')),
				'role'      => $this->input->post('role'),
				'is_active' => 1
			);

			$insert = $this->users->insert($data);

			log_activity(_l('added', _l('user'))."[ID:$insert] ");

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
				$this->session->set_flashdata('success', _l('added_successfully_msg', _l('user')));
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
	 * [edit for update User]
	 * @param  [int] $id [user's id]
	 * @return [array]     [users data]
	 */
	public function edit($id)
	{
		if (!has_permissions('users', 'edit'))
		{
			access_denied('users', 'edit');
		}

		if ($id)
		{
			if ($this->input->post())
			{
				$role         = $this->input->post('role');
				$data['user'] = $this->users->get($id);

				if ($this->input->post('newpassword') == NULL)
				{
					$data = array
						(
						'firstname' => $this->input->post('firstname'),
						'lastname'  => $this->input->post('lastname'),
						'email'     => $this->input->post('email'),
						'mobile_no' => $this->input->post('mobile_no'),
						'role'      => $role
					);
				}
				else
				{
					$data = array
						(
						'firstname' => $this->input->post('firstname'),
						'lastname'  => $this->input->post('lastname'),
						'email'     => $this->input->post('email'),
						'mobile_no' => $this->input->post('mobile_no'),
						'password'  => md5($this->input->post('newpassword')),
						'role'      => $role
					);
				}

				$update = $this->users->update($id, $data);

				$user_id = $this->input->post('role');

				$this->user_permissions->delete_by(array('user_id' => $id));

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
					$this->session->set_flashdata('success', _l('updated_successfully_msg', _l('user')));
					log_activity(_l('updated', _l('user'))."[ID:$id] ");
					redirect('admin/users');
				}
			}
			else
			{
				$data['user']  = $this->users->get($id);
				$data['roles'] = $this->roles->get_all();

				if (get_loggedin_info('user_id') == $id)
				{
					/*
							Login id and personal id same then
							redirect to edit personal profile
						*/
					redirect('admin/myprofile/edit');
				}
				else
				{
					$data['content'] = $this->load->view('admin/users/edit', $data, TRUE);
					$this->load->view('admin/index', $data);
				}
			}
		}
	}

/**
 * [update_status for user's status]
 * @return [boolean]
 */
	public function update_status()
	{
		$user_id = $this->input->post('user_id');
		$data    = array('is_active' => $this->input->post('is_active'));

		$update = $this->users->update($user_id, $data);

		if ($update)
		{
			if ($this->input->post('is_active') == 1)
			{
				echo _l('activation_msg', _l('user'));

				log_activity(_l('activation_msg', _l('user'))." [ID:$user_id]");
			}
			else
			{
				echo _l('deactivation_msg', _l('user'));

				log_activity(_l('deactivation_msg', _l('user'))." [ID:$user_id]");
			}
		}
	}

/**
 * [delete for delete user]
 * @return [boolean]
 */
	public function delete()
	{
		if (!has_permissions('users', 'delete'))
		{
			echo "error";
		}

		$user_id = $this->input->post('user_id');
		$delete  = $this->users->delete($user_id);

		if ($delete)
		{
			log_activity(_l('deleted', _l('user'))." [ID:$user_id]");
		}

		echo "success";
	}

/**
 * [delete_selected for selected record deleted]
 * @return [boolean]
 */
	public function delete_selected()
	{
		if (!has_permissions('users', 'delete'))
		{
			echo "error";
		}

		$where = $this->input->post('ids');
		$ids   = implode(",", $where);

		$delete_many = $this->users->delete_many($where);

		if ($delete_many)
		{
			log_activity(_l('deleted', _l('users'))."[IDS:$ids] ");
		}
	}
}
