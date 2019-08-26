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

		$this->load->model('setting_model', 'settings');
	}

	/**
	 * [index for load view settings]
	 * @return [array] [load html content]
	 */
	public function index()
	{
		$data['settings'] = $this->get_settings();
		$data['content']  = $this->load->view('admin/settings/index', $data, TRUE);
		$this->load->view('admin/index', $data);
	}

	/**
	 * [get_settings]
	 * @param  array  $data [user's get_settings]
	 * @return [array]       [user's get_settings]
	 */
	public function get_settings($data = [])
	{
		$settings = [
			'general'  => 'General',
			'date'     => 'Date',
			'language' => 'Language'

		];

		return $settings;
	}

	public function add()
	{
		if ($this->input->post())
		{
			foreach ($this->input->post() as $key => $value)
			{
				
				$settings = $this->settings->get_by(array('name' => $key));
				

				if ($settings)
				{
					$this->settings->update($settings['id'],array('value' => $value));
				}
				else
				{
					if ($key != "submit")
					{
						$data = array
							(
							'name'  => $key,
							'value' => $value
						);
						$this->settings->insert($data);
						$this->session->set_flashdata('success', 'insert settings');
					}
				}
			}
		}

		$data['settings'] = $this->get_settings();
		$data['content']  = $this->load->view('admin/settings/index', $data, TRUE);
		$this->load->view('admin/index', $data);
	}
}
