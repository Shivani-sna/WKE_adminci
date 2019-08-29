<?php

/**
 * check if user is logged in or not
 * @return boolean
 */
function is_user_logged_in()
{
	$CI = &get_instance();

	$CI->load->model('user_model', 'users');
	$user = $CI->users->get_by('id', $CI->session->userdata('user')['user_id']);

	if (!$CI->session->userdata('user') || $user['is_active'] == 0)
	{
		$CI->session->set_userdata('redirect_url', current_url());
		redirect('authentication');
	}
}

/**
 * get the user session of logged in user
 * @return int user id
 */
function get_loggedin_info($info)
{
	$CI   = &get_instance();
	$user = $CI->session->userdata('user');

	return $user[$info];
}

/**
 * @param  [type]
 * @param  [type]
 * @return boolean
 */
function has_permissions($feature, $capability)
{
	$CI = &get_instance();
	$CI->load->model('user_permission_model', 'user_permissions');
	$data = array(
		'user_id'      => get_loggedin_info('user_id'),
		'features'     => $feature,
		'capabilities' => $capability

	);

	$permissions = $CI->user_permissions->get_many_by($data);

	return $permissions;
}

/**
 * @param  [str] name of the feature
 * @param  [str] name of capability
 * @return [null]
 */
function access_denied($feature, $capability)
{
	$CI = &get_instance();
	$CI->session->set_flashdata('error', _l('access_denied'));

	log_activity(get_loggedin_info('username').' '._l('log_access_denied')." $feature $capability page without permission");

	$CI->session->set_userdata('redirect_url', current_url());

	if (!empty($_SERVER['HTTP_REFERER']))
	{
		redirect($_SERVER['HTTP_REFERER']);
	}
	else
	{
		redirect("admin/dashboard");
	}
}

/**
 * [log_activity maintain logs in log_activity table]
 * @param  [string] $description [for log_sctivity]
 * @param  string $user_id     [get logged In user_id]
 */
function log_activity($description, $user_id = '')
{
	$CI = &get_instance();
	$CI->load->model('activity_log_model', 'activity_log');

	if ($user_id == '')
	{
		$user_id = get_loggedin_info('user_id');
	}

	$data = array(
		'description' => $description,
		'date'        => current_timestamp(),
		'user_id'     => $user_id,
		'ip_address'  => $CI->input->ip_address()
	);

	$CI->activity_log->insert($data);
}

?>