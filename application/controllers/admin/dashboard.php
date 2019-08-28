<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
	/**
	 * [__construct load function for session]
	 */
	public function __construct()
	{
		parent::__construct();
		is_user_logged_in();
	}

/**
 * [index for view dashboard]
 * @return [array] [html content]
 */
	public function index()
	{
		
		log_activity(_l('view', _l('dashboard')));
		$data['content'] = $this->load->view('admin/dashboard', '', TRUE);
		$this->load->view('admin/index', $data);

	}
}
