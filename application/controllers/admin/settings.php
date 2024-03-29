<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends MY_Controller
{
	/**
	 * [__construct load model and check session]
	 */
	public function __construct()
	{
		parent::__construct();
		is_user_logged_in();
	}

	/**
	 * [index for load view settings]
	 * @return [array] [load html content]
	 */
	public function index()
	{
		$data['settings'] = get_settings();
		$data['content']  = $this->load->view('admin/settings/index', $data, TRUE);
		$this->load->view('admin/index', $data);
	}

	public function add()
	{
		if ($this->input->post())
		{
			foreach ($this->input->post() as $key => $value)
			{
				if ($value == '' && $key != 'submit')
				{
					$delete = $this->settings->delete_by(['name' => $key]);

					if ($delete)
					{
						$this->session->set_flashdata('success', _l('deleted_successfully_msg', $key));
					}
				}
				else
				{
					if ($key == "allowed_file_types")
					{
						$value = serialize($value);
					}

					$settings = $this->settings->get_by(['name' => $key]);

					if ($settings)
					{
						$this->settings->update($settings['id'], array('value' => $value));
						$this->session->set_flashdata('success', _l('updated_successfully_msg', _l('settings')));
						log_activity(_l('updated', _l('settings'))."[Name : $key Value :$value] ");
					}
					else
					{
						if ($key != "submit")
						{
							$data = [
								'name'  => $key,
								'value' => $value
							];

							$this->settings->insert($data);
							$this->session->set_flashdata('success', _l('added_successfully_msg', _l('settings')));
							log_activity(_l('added', _l('settings'))."[ Name : $key Value :$value] ");
						}
					}
				}
			}
		}

		redirect('admin/settings');
	}
}
