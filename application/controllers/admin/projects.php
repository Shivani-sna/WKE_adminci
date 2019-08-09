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
		$this->load->model('project_model', 'projects');
	}

	public function index()
	{
		if (empty(check_session()))
		{
			$this->session->set_flashdata('error', 'Access denied');
			redirect('authentication');
		}

		$data['projects'] = $this->projects->get_all();
		$data['content']  = $this->load->view('admin/projects/index', $data, TRUE);
		$this->load->view('admin/index', $data);
	}

	public function insert()
	{
		if (empty(check_session()))
		{
			$this->session->set_flashdata('error', 'Access denied');
			redirect('authentication');
		}

		$data['content'] = $this->load->view('admin/projects/create', '', TRUE);
		$this->load->view('admin/index', $data);
		$id = check_session()['id'];

		if ($this->input->post())
		{
			$data = array
				('project_id' => "PROJECT_".rand(10, 100),
				'name'        => $this->input->post('name'),
				'details'     => $this->input->post('details'),
				'created'     => current_timestamp()
			);
			$insert = $this->projects->insert($data);

			log_activity("Project Added [ID:$insert] ", $id);

//log activity for Project insert

			if ($insert)
			{
				$this->session->set_flashdata('success', 'You have Added Project Successfully');
				redirect('admin/projects');
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
			$data['project'] = $this->projects->get($id);

			$data['content'] = $this->load->view('admin/projects/edit', $data, TRUE);

			$this->load->view('admin/index', $data);

			if ($this->input->post())
			{
				$data = array
					('project_id' => "PROJECT_".rand(10, 100),
					'name'        => $this->input->post('name'),
					'details'     => $this->input->post('details'),
					'updated'     => current_timestamp()
				);

				$update     = $this->projects->update($id, $data);
				$session_id = check_session()['id'];
				log_activity("Project Updated [ID:$id] ", $session_id);

				if ($update)
				{
					$this->session->set_flashdata('success', 'You have Updated Project.');

					redirect('admin/projects');
				}
			}
		}
	}

	public function update_status()
	{
		$session_id = check_session()['id'];
		$project_id = $this->input->post('project_id');
		$data       = array('is_active' => $this->input->post('is_active'));
		$update     = $this->projects->update($project_id, $data);
		log_activity("Project Status Updated [ID:$project_id] ", $session_id);
	}

	public function delete()
	{
		$session_id = check_session()['id'];
		$project_id = $this->input->post('project_id');
		$result     = $this->projects->delete($project_id);

		log_activity("Project Deleted [ID:$project_id] ", $session_id);
	}

	public function delete_selected()
	{
		$session_id = check_session()['id'];
		$where      = $this->input->post('ids');
		$ids        = implode(",", $where);
		$delete_all = $this->projects->delete_many($where);

		log_activity("Projects Deleted [IDS:$ids] ", $session_id);
	}
}
