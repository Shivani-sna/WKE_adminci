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
		else
		{
			$data['projects'] = $this->projects->get_all();
			$data['content']  = $this->load->view('admin/projects/index', $data, TRUE);
			$this->load->view('admin/index', $data);

			log_activity(_l('view', _l('projects')));
		}
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
		else
		{
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
		else
		{
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
					log_activity("Project Updated [ID:$id] ");

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
			else
			{
				$project_id = $this->input->post('project_id');
				$delete     = $this->projects->delete($project_id);

				if ($delete)
				{
					log_activity(_l('deleted', _l('project'))." [ID:$project_id]");
				}

				echo "success";
			}
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
			else
			{
				$where = $this->input->post('ids');
				$ids   = implode(",", $where);

				$delete_many = $this->projects->delete_many($where);

				if ($delete_many)
				{
					log_activity(_l('deleted', _l('projects'))."[IDS:$ids] ");
				}
			}
		}
	}
