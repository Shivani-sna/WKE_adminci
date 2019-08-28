<?php

function current_timestamp()
{
	date_default_timezone_set('Asia/Kolkata');

	return time();
}
// function get_timezone()
// {
// 	return date_default_timezone_set(get_setting_value('time_zone'));

// }

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
 * @return mixed
 */

/**
 * get the user id of logged in user
 * @return int user id
 */
function get_loggedin_info($info)
{
	$CI   = &get_instance();
	$user = $CI->session->userdata('user');

	return $user[$info];
}
/**
 * @return mixed
 */
function get_setting_value($name)
{
	$CI = &get_instance();
	$CI->load->model('setting_model', 'settings');
	$settings=$CI->settings->get_all();
	foreach ($settings as $key => $setting)
	 {
		if ($setting['name']=="$name")
		 {
			return $setting['value'];
		}
	}
}

/**
 * @return mixed
 */
function get_settings()
{
	$CI = &get_instance();
	$CI->load->model('setting_model', 'settings');

	return $CI->settings->get_all();
}

/**
 * [send_mail function for sending mail when successfully registration]
 * @param $email [registration Email]
 * @param $subject [Subject for mail]
 * @param $htmlContent[Load view]
 * @return [boolean]
 */

function send_mail($email = '', $key = '', $subject = '', $mailContent = '', $success = '', $redirect = '')
{
	$CI = &get_instance();
	$CI->load->library('phpmailer_lib');
	$mail = $CI->phpmailer_lib->load();
	$mail->isSMTP();
	$mail->Host       = 'ssl://smtp.gmail.com';
	$mail->SMTPAuth   = true;
	$mail->Username   = 'test.narolainfotech@gmail.com';
	$mail->Password   = '#N@rol@12';
	$mail->SMTPSecure = 'ssl';
	$mail->Port       = 465;

	$mail->setFrom('test.narolainfotech@gmail.com', 'WKE Admin');
	$mail->addReplyTo($email);

	$mail->addAddress($email);
	$mail->Subject = $subject;

	$mail->isHTML(true);

	$mail->Body = $mailContent;

	if ($mail->send())
	{
		$CI->session->set_flashdata('success', $success);
		redirect($redirect);
	}
	else
	{
		$CI->session->set_flashdata('error', 'Your Mail Not Send');
		redirect($redirect);
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

/**
 * [auth_token generate random string]
 * @return [string] [random stringfor auth_token]
 */
function auth_token()
{
	$n            = 15;
	$characters   = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$randomString = '';

	for ($i = 0; $i < $n; $i++)
	{
		$index = rand(0, strlen($characters) - 1);
		$randomString .= $characters[$index];
	}

	return $randomString;
}

/**
 * [_l for lanuguage conversion]
 * @param  [string] $line  [string]
 * @param  string $label [entity name]
 * @return [string]        [convert string from language file]
 */
function _l($line, $label = '')
{
	$CI = &get_instance();

	$output = $CI->lang->line($line);

	if ($label != '')
	{
		$output = str_replace('%s', $label, $output);
	}

	return $output;
}

/**
 * [time_stamp for formate date and time]
 * @param  [timestamp] $session_time [get timestamp]
 * @return [string]               [time in proper formate ]
 */
function time_stamp($session_time)
{
	$time_difference = time() - $session_time;

	$seconds = $time_difference;
	$minutes = round($time_difference / 60);
	$hours   = round($time_difference / 3600);
	$days    = round($time_difference / 86400);
	$weeks   = round($time_difference / 604800);
	$months  = round($time_difference / 2419200);
	$years   = round($time_difference / 29030400);

// Seconds
	if ($seconds <= 60)
	{
		echo "$seconds seconds ago";
	}

	//Minutes
	else

	if ($minutes <= 60)
	{
		if ($minutes == 1)
		{
			echo "One minute ago";
		}
		else
		{
			echo "$minutes minutes ago";
		}
	}

	//Hours
	else

	if ($hours <= 24)
	{
		if ($hours == 1)
		{
			echo "One hour ago";
		}
		else
		{
			echo "$hours hours ago";
		}
	}

	//Days
	else

	if ($days <= 7)
	{
		if ($days == 1)
		{
			echo "One day ago";
		}
		else
		{
			echo "$days days ago";
		}
	}

	//Weeks
	else

	if ($weeks <= 4)
	{
		if ($weeks == 1)
		{
			echo "One week ago";
		}
		else
		{
			echo "$weeks weeks ago";
		}
	}

	//Months
	else

	if ($months <= 12)
	{
		if ($months == 1)
		{
			echo "One month ago";
		}
		else
		{
			echo "$months months ago";
		}
	}

	//Years
	else
	{
		if ($years == 1)
		{
			echo "One year ago";
		}
		else
		{
			echo "$years years ago";
		}
	}
}



function set_sort_redirect_url()
{
	$CI = &get_instance();

	if ($CI->uri->segment(3) == "search")
	{
		$sort_redirect_to = $CI->uri->segment(1).'/'.$CI->uri->segment(2).'/'.$CI->uri->segment(3);
	}
	else
	{
		$sort_redirect_to = $CI->uri->segment(1).'/'.$CI->uri->segment(2);
	}

	$CI->session->set_userdata('sort_redirect_to', $sort_redirect_to);
}
