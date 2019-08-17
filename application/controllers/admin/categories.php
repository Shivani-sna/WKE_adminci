<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends MY_Controller
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
		$this->load->model('category_model', 'category');
		$this->load->model('user_permission_model', 'user_permissions');
	}

/**
 * [index for view Categories]
 */
	public function index()
	{
		if (!has_permissions('categories', 'view'))
		{
			access_denied('categories', 'view');
		}

		$data['categories'] = $this->category->get_all();

		$data['content'] = $this->load->view('admin/categories/index', $data, TRUE);
		$this->load->view('admin/index', $data);
	}

/**
 * [add for insert Categories]
 */
	public function add()
	{
		if (!has_permissions('categories', 'create'))
		{
			access_denied('categories', 'create');
		}

		if ($this->input->post())
		{
			$data = array
				('name'     => $this->input->post('name'),
				'user_id'   => get_loggedin_user_id(),
				'is_active' => 1,
				'created'   => current_timestamp()
			);
			//print_r($data);
			$insert = $this->category->insert($data);
			$id     = get_loggedin_user_id();
			log_activity("Category Added [ID:$insert] ", $id);

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

	/**
	 *[update category by category id]
	 * @param $id
	 */
	public function edit($id)
	{
		if (!has_permissions('categories', 'edit'))
		{
			access_denied('categories', 'edit');
		}

		if ($id)
		{
			if ($this->input->post())
			{
				$data = array
					('name'   => $this->input->post('name'),
					'user_id' => get_loggedin_user_id(),
					'updated' => current_timestamp()
				);

				$update     = $this->category->update($id, $data);
				$session_id = get_loggedin_user_id();
				log_activity("Category Updated [ID:$id] ", $session_id);

				if ($update)
				{
					$this->session->set_flashdata('success', 'You have Updated category.');

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

/**
 * [update_status for update category is_active]
 */
	public function update_status()
	{
		$session_id  = get_loggedin_user_id();
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

		log_activity("Task Status Updated [ID:$category_id] ", $session_id);
	}

/**
 * [delete for delete category by id]
 */
	public function delete()
	{
		if (!has_permissions('categories', 'delete'))
		{
			access_denied('categories', 'delete');
		}

		$session_id  = get_loggedin_user_id();
		$category_id = $this->input->post('category_id');
		$result      = $this->category->delete($category_id);

		log_activity("Task Deleted [ID:$category_id] ", $session_id);
	}

/**
 * [delete_selected for delete multiple categories by their ids]
 */
	public function delete_selected()
	{
		$session_id = get_loggedin_user_id();
		$where      = $this->input->post('ids');
		$ids        = implode(",", $where);
		$delete_all = $this->category->delete_many($where);

		log_activity("category Deleted [IDS:$ids] ", $session_id);
	}
}
