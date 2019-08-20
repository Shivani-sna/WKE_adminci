<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class category_model extends MY_Model
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
	
	}
}
