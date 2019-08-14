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
		$this->load->model('role_model', 'roles');
		$this->load->model('user_permission_model', 'user_permissions');
	}

	/**
	 * []
	 */
	public function index()
	{
		if (empty(check_session()))
		{
			$this->session->set_flashdata('error', 'Please Login');
			redirect('authentication');
		}
		$data = array(
		'user_id'      => check_session()['id'],
		'features'     => 'users',
		'capabilities' => 'view'

	);

	

		$data['users']   = $this->users->get_all();
		$data['content'] = $this->load->view('admin/users/index', $data, TRUE);
		$this->load->view('admin/index', $data);
	}

	public function insert()
	{
		if (empty(check_session()))
		{
			$this->session->set_flashdata('error', 'Please Login');
			redirect('authentication');
		}
		// if (empty(has_permissions(check_session()['id'])))
		//  {
		// 	$this->session->set_flashdata('error', 'You have Not access');
		// 	redirect('admin/home');
		// }

		$data['roles']   = $this->roles->get_all();
		$data['content'] = $this->load->view('admin/users/create', $data, TRUE);
		$this->load->view('admin/index', $data);
		$id = check_session()['id'];

// print_r($this->input->post());

// die();

		if ($this->input->post())
		{
			$role = $this->input->post('role');
			if ($role == 'Admin')
			{
				$role = 1;
			}
			else

			if ($role = 'Super Admin')
			{
				$role = 2;
			}

			$data = array
				('firstname' => $this->input->post('firstname'),
				'lastname'   => $this->input->post('lastname'),
				'email'      => $this->input->post('email'),
				'mobile_no'  => $this->input->post('mobile_no'),
				'password'   => md5($this->input->post('password')),
				'role'       => $role,
				'is_active'  => 1,
				'is_deleted' => 0
			);
			$insert = $this->users->insert($data);

			log_activity("User Added [ID:$insert] ", $id);

//log activity for user insert
			$role_id   = $this->input->post('role');
			$role = $this->roles->get($role_id);

			$permissions = unserialize($role['permissions']);
			// print_r($permissions);
			// die();

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
	}

	/**
	 * @param $id
	 */
	public function update($id)
	{
		if (empty(check_session()))
		{
			$this->session->set_flashdata('error', 'Please Login');
			redirect('authentication');
		}
		// print_r(has_permissions(check_session()['id']));
		// die();
		if (empty(has_permissions(check_session()['id'])))
		 {
			$this->session->set_flashdata('error', 'You have Not access');
			redirect('admin/home');
		}

		if ($id)
		{
			$data['user']  = $this->users->get($id);
			$data['roles'] = $this->roles->get_all();

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
//print_r($this->input->post());

				
				$role = $this->input->post('role');

				if ($role == 'Admin')
				{
					$role = 1;
				}
				else

				if ($role = 'Super Admin')
				{
					$role = 2;
				}
				//print_r($role);
 // die();
				$data = array(
					'firstname' => $this->input->post('firstname'),
					'lastname'  => $this->input->post('lastname'),
					'email'     => $this->input->post('email'),
					'mobile_no' => $this->input->post('mobile_no'),
					'password'  => md5($this->input->post('password')),
					'role'      => $role
				);
				 print_r($data);
				

				$update     = $this->users->update($id, $data);
				$session_id = check_session()['id'];
				log_activity("User Updated [ID:$id] ", $session_id);
				$user_id   = $this->input->post('role');
				 print_r($user_id);
				 //die();

				$user_permissions_data = $this->user_permissions->delete_by(array('user_id' => $id));

 				$role_id   = $this->input->post('role');
				$role_data = $this->roles->get_by(array('name'=>$role_id));


				$permissions = unserialize($role_data['permissions']);
				//print_r($permissions);
/// die();

				foreach ($permissions as $key => $permission)
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
		if (empty(has_permissions(check_session()['id'])))
		 {
			$this->session->set_flashdata('error', 'You have Not access');
			redirect('admin/home');
		}
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
