<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		check_islogin();
	}

	/**
	 * [index for Dashboard view]
	 */
	public function index()
	{
		$data['content'] = $this->load->view('admin/dashboard', '', TRUE);
		$this->load->view('admin/index', $data);

	}
}
