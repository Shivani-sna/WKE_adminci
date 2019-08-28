<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Projects extends MY_Controller
{
	/**
	 * [__construct for load models and session function]
	 */
	public function __construct()
	{
		parent::__construct();

		is_user_logged_in();

		$this->load->model('project_model', 'projects');
	}

/**
 * [index description]
 * @return [type] [description]
 */
	public function index()
	{
		if (!has_permissions('projects', 'view'))
		{
			access_denied('projects', 'view');
		}

		$config                = $this->paginate();
		$config['base_url']    = base_url('admin/projects');
		$config['uri_segment'] = 3;

		$data['src_project_id'] = '';
		$data['src_name']       = '';

		$config['total_rows'] = $data['total_rows'] = $this->projects->count_all();
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$this->projects->limit($config['per_page'], $page);

		$sort = $this->session->userdata('sort_order');

		if ($sort['controller'] == $this->router->fetch_class())
		{
			$this->projects->order_by($sort['sort_by'], $sort['order']);
		}

		$data['links'] = $this->pagination->create_links();

		$data['projects'] = $this->projects->get_all();
		$data['content']  = $this->load->view('admin/projects/index', $data, TRUE);
		$this->load->view('admin/index', $data);

		log_activity(_l('view', _l('projects')));
	}

/**
 * [search for searching with pagination]
 * @return [str] [search data]
 */
	public function search()
	{
		$config                 = $this->paginate();
		$config['base_url']     = base_url('admin/projects/search');
		$config['uri_segment']  = 4;
		$data['src_project_id'] = '';
		$data['src_name']       = '';
		$data['src_email']      = '';
		$data['src_role']       = '';

		$where = array();

		if ($this->input->post('search'))
		{
			if ($this->input->post('project_id'))
			{
				$where['project_id LIKE'] = $this->input->post('project_id').'%';
				$data['src_project_id']   = $this->input->post('project_id');
				$this->session->set_userdata('src_project_id', $this->input->post('project_id'));
			}
			else
			{
				$this->session->unset_userdata('src_project_id');
			}

			if ($this->input->post('name'))
			{
				$where['name LIKE'] = $this->input->post('name').'%';
				$data['src_name']   = $this->input->post('name');
				$this->session->set_userdata('src_name', $this->input->post('name'));
			}
			else
			{
				$this->session->unset_userdata('src_name');
			}
		}
		else
		{
			if ($this->session->userdata('src_project_id'))
			{
				$where['project_id LIKE'] = $this->session->userdata('src_project_id').'%';
				$data['src_project_id']   = $this->session->userdata('src_project_id');
			}
			else
			{
				$this->session->unset_userdata('src_project_id');
			}

			if ($this->session->userdata('src_name'))
			{
				$where['name LIKE'] = $this->session->userdata('src_name').'%';
				$data['src_name']   = $this->session->userdata('src_name');
			}
			else
			{
				$this->session->unset_userdata('src_name');
			}
		}

		$config['total_rows'] = $data['total_rows'] = $this->projects->count_by($where);

		$this->pagination->initialize($config);

		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

		$sort = $this->session->userdata('sort_order');

		if ($sort['controller'] == $this->router->fetch_class())
		{
			$this->projects->order_by($sort['sort_by'], $sort['order']);
		}

		$this->projects->limit($config['per_page'], $page);

		$data['projects'] = $this->projects->get_many_by($where);

		$data['links'] = $this->pagination->create_links();

		$data['content'] = $this->load->view('admin/projects/index', $data, TRUE);
		$this->load->view('admin/index', $data);
	}

/**
 * [add for insert projects]
 */
	public function add()
	{
		if (!has_permissions('projects', 'create'))
		{
			access_denied('projects', 'create');
		}

		if ($this->input->post())
		{
			$data = array
				('project_id' => "PROJECT_".rand(10, 100),
				'name'        => $this->input->post('name'),
				'details'     => $this->input->post('details'),
				'created'     => current_timestamp()
			);

			$insert = $this->projects->insert($data);

			log_activity(_l('added', _l('project'))."[ID:$insert] ");

			if ($insert)
			{
				$this->session->set_flashdata('success', _l('added_successfully_msg', _l('project')));
				redirect('admin/projects');
			}
		}
		else
		{
			$data['content'] = $this->load->view('admin/projects/create', '', TRUE);
			$this->load->view('admin/index', $data);
		}
	}

	/**
	 *[update project by project id]
	 * @param $id
	 */
	public function edit($id)
	{
		if (!has_permissions('projects', 'edit'))
		{
			access_denied('projects', 'edit');
		}

		if ($id)
		{
			$data['project'] = $this->projects->get($id);

			if ($this->input->post())
			{
				$data = array
					('project_id' => "PROJECT_".rand(10, 100),
					'name'        => $this->input->post('name'),
					'details'     => $this->input->post('details'),
					'updated'     => current_timestamp()
				);

				$update = $this->projects->update($id, $data);
				log_activity(_l('updated', _l('project'))."[ID:$id] ");

				if ($update)
				{
					$this->session->set_flashdata('success', _l('updated_successfully_msg', _l('project')));

					redirect('admin/projects');
				}
			}
			else
			{
				$data['content'] = $this->load->view('admin/projects/edit', $data, TRUE);
				$this->load->view('admin/index', $data);
			}
		}
	}

/**
 * [delete for delete project by id]
 */
	public function delete()
	{
		if (!has_permissions('users', 'delete'))
		{
			echo "error";
		}

		$project_id = $this->input->post('project_id');
		$delete     = $this->projects->delete($project_id);

		if ($delete)
		{
			log_activity(_l('deleted', _l('project'))." [ID:$project_id]");
		}

		echo "success";
	}

/**
 * [delete_selected for delete multiple projects by their ids]
 */
	public function delete_selected()
	{
		if (!has_permissions('users', 'delete'))
		{
			echo "error";
		}

		$where = $this->input->post('ids');
		$ids   = implode(",", $where);

		$delete_many = $this->projects->delete_many($where);

		if ($delete_many)
		{
			log_activity(_l('deleted', _l('projects'))."[IDS:$ids] ");
		}
	}
}
