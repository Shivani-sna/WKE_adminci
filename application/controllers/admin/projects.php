<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Projects extends MY_Controller
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
		$this->load->model('project_model', 'projects');
	}

/**
 * [index for view projects]
 */
	public function index()
	{
		if (!has_permissions('projects', 'view'))
		{
			access_denied('projects', 'view');
		}

		$data['projects'] = $this->projects->get_all();
		$data['content']  = $this->load->view('admin/projects/index', $data, TRUE);
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
			$id     = get_loggedin_user_id();
			log_activity("Project Added [ID:$insert] ", $id);

			if ($insert)
			{
				$this->session->set_flashdata('success',_l('added_successfully_msg', _l('project')));
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

				$update     = $this->projects->update($id, $data);
				$session_id = get_loggedin_user_id();
				log_activity("Project Updated [ID:$id] ", $session_id);

				if ($update)
				{
					$this->session->set_flashdata('success', 'You have Updated Project.');

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
		if (!has_permissions('projects', 'delete'))
		{
			access_denied('projects', 'delete');
		}

		$session_id = get_loggedin_user_id();
		$project_id = $this->input->post('project_id');
		$result     = $this->projects->delete($project_id);

		log_activity("Project Deleted [ID:$project_id] ", $session_id);
	}

/**
 * [delete_selected for delete multiple projects by their ids]
 */
	public function delete_selected()
	{
		$session_id = get_loggedin_user_id();
		$where      = $this->input->post('ids');
		$ids        = implode(",", $where);
		$delete_all = $this->projects->delete_many($where);

		log_activity("Projects Deleted [IDS:$ids] ", $session_id);
	}
}
