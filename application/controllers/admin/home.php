<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * [index Display reastaurants and their counting]
	 */
	public function index()
	{
		if (empty(check_session()))
		{
			$this->session->set_flashdata('error', 'Access denied');
			redirect('authentication');
		}
		else
		{
			$data['content'] = $this->load->view('admin/dashboard', '', TRUE);
			$this->load->view('admin/index', $data);
			
		}
	}
}
