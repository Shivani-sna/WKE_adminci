<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends MY_Model
{
	/**
	 * @var mixed
	 */
	protected $soft_delete = TRUE;
	public function __construct()
	{
		parent::__construct();
	
	}
}
