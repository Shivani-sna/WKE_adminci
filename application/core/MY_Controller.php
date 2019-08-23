<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->lang->load('english');
	}

	/**
	 * @return mixed
	 */
	public function paginate()
	{
		$config                    = array();
		$config['full_tag_open']   = "<ul class='pagination'>";
		$config['full_tag_close']  = '</ul>';
		$config['num_tag_open']    = '<li>';
		$config['num_tag_close']   = '</li>';
		$config['cur_tag_open']    = '<li class="active"><a href="#">';
		$config['cur_tag_close']   = '</a></li>';
		$config['prev_tag_open']   = '<li>';
		$config['prev_tag_close']  = '</li>';
		$config['first_tag_open']  = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open']   = '<li>';
		$config['last_tag_close']  = '</li>';
		$config['prev_link']       = 'Prev';
		$config['prev_tag_open']   = '<li>';
		$config['prev_tag_close']  = '</li>';
		$config['next_link']       = 'Next';
		$config['next_tag_open']   = '<li>';
		$config['next_tag_close']  = '</li>';
		$config['per_page']        = 4;

		return $config;
	}

	/**
	 * @param $sort_by
	 */
	public function sort_by($sort_by)
	{
		$order = 'ASC';

		if (null !== $this->session->userdata('sort_order'))
		{
			$sort_order =  $this->session->userdata('sort_order');
			 $order      = $sort_order['order'];
			$order      = ($order == 'ASC') ? 'DESC' : 'ASC';
		}

		//	$sort_order = $sort_by.'@'.$order;
		$sort_order = array
			(
			'sort_by'    => $sort_by,
			'order'      => $order,
			'controller' => $this->router->fetch_class()
		);
	
		$this->session->set_userdata('sort_order', $sort_order);
		redirect($this->session->userdata('sort_redirect_to'));
	}
}
