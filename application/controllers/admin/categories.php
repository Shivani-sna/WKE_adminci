<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends MY_Controller
{
	/**
	 * [__construct load model and session function]
	 */
	public function __construct()
	{
		parent::__construct();

		is_user_logged_in();

		$this->load->model('category_model', 'category');
		$this->load->model('user_permission_model', 'user_permissions');
	}

/**
 * [index load view for categories]
 * @return [type] [description]
 */
	public function index()
	{
		if (!has_permissions('categories', 'view'))
		{
			access_denied('categories', 'view');
		}
		else
		{
			$data['categories'] = $this->category->get_all();

			$data['content'] = $this->load->view('admin/categories/index', $data, TRUE);
			$this->load->view('admin/index', $data);

			log_activity(_l('view', _l('categories')));
		}
	}

/**
 * [add for categories insert]
 */
	public function add()
	{
		if (!has_permissions('categories', 'create'))
		{
			access_denied('categories', 'create');
		}
		else
		{
			if ($this->input->post())
			{
				$data = array
					('name'     => $this->input->post('name'),
					'user_id'   => get_loggedin_info('user_id'),
					'is_active' => 1,
					'created'   => current_timestamp()
				);
				$insert = $this->category->insert($data);

				log_activity(_l('added', _l('user'))."[ID:$insert] ");

				if ($insert)
				{
					$this->session->set_flashdata('success', _l('added_successfully_msg', _l('category')));
					redirect('admin/categories');
				}
			}
			else
			{
				$data['content'] = $this->load->view('admin/categories/create', '', TRUE);
				$this->load->view('admin/index', $data);
			}
		}
	}

/**
 * [edit for update category by their id]
 * @param  [int] $id [category id]
 * @return [array]     [updated category]
 */
	public function edit($id)
	{
		if (!has_permissions('categories', 'edit'))
		{
			access_denied('categories', 'edit');
		}
		else
		{
			if ($id)
			{
				if ($this->input->post())
				{
					$data = array
						('name'   => $this->input->post('name'),
						'user_id' => get_loggedin_info('user_id'),
						'updated' => current_timestamp()
					);

					$update = $this->category->update($id, $data);

					if ($update)
					{
						log_activity(_l('updated', _l('category'))."[ID:$id] ");

						$this->session->set_flashdata('success', _l('updated_successfully_msg', _l('category')));

						redirect('admin/categories');
					}
				}
				else
				{
					$data['category'] = $this->category->get($id);
					$data['content']  = $this->load->view('admin/categories/edit', $data, TRUE);
					$this->load->view('admin/index', $data);
				}
			}
		}
	}

/**
 * [update_status for update category is_active]
 */
	public function update_status()
	{
		$category_id = $this->input->post('category_id');
		$data        = array('is_active' => $this->input->post('is_active'));

		$update = $this->category->update($category_id, $data);

		if ($update)
		{
			if ($this->input->post('is_active') == 1)
			{
				echo "Active";
			}
		}

		log_activity(_l('status_updated', _l('category'))." [ID:$category_id]");
	}

/**
 * [delete for delete category by id]
 */
	public function delete()
	{
		$category_id = $this->input->post('category_id');
		$delete      = $this->category->delete($category_id);

		if ($delete)
		{
			log_activity(_l('deleted', _l('category'))." [ID:$category_id]");
		}

		echo "success";
	}

/**
 * [delete_selected for delete multiple categories by their ids]
 */
	public function delete_selected()
	{
		$where = $this->input->post('ids');
		$ids   = implode(",", $where);

		$delete_many = $this->category->delete_many($where);

		if ($delete_many)
		{
			log_activity(_l('deleted', _l('category'))."[IDS:$ids] ");
		}
	}
}
