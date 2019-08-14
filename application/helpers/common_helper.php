<?php

function current_timestamp()
{
	date_default_timezone_set('Asia/Kolkata');

	return time();
}

/**
 * @param $id
 */
function has_permissions($id)
{
	$CI = &get_instance();
	$CI->load->model('user_permission_model', 'user_permissions');
	$features     = $CI->router->fetch_class();
	$capabilities = $CI->router->fetch_method();

	if ($capabilities == 'index')
	{
		$capabilities = "view";
	}
	elseif ($capabilities == 'update')
	{
		$capabilities = "edit";
	}
	elseif ($capabilities == 'insert')
	{
		$capabilities = "create";
	}
	elseif ($capabilities == 'delete')
	{
		$capabilities = "delete";
	}

	$data = array(
		'user_id'      => $id,
		'features'     => $features,
		'capabilities' => $capabilities

	);

	$permissions=$CI->user_permissions->get_many_by($data);
	
	return $permissions;
}

/**
 * @return mixed
 */
function list_controllers()
{
	$controllers = array();

// Scan files in the /application/controllers directory

// Set the second param to TRUE or remove it if you
	// don't have controllers in sub directories
	$files = get_dir_file_info(APPPATH.'controllers', FALSE);

	foreach (array_keys($files) as $file)
	{
		if ($file != 'index.html')
		{
			$controllers[] = str_replace('.php', '', $file);
		}
	}

	return $controllers;
}

/**
 * @return mixed
 */
function get_dataclass()
{
	$ci = &get_instance();

	return $ci->router->fetch_class();
}

/**
 * [_setflashdata for get notification to set session]
 * @param  [type] $name [for define session name]
 * @param  [type] $msg  [for define msges]
 * @return [type]       [description]
 */
function check_session()
{
	$CI   = &get_instance();
	$user = $CI->session->userdata('user');

	return $user;
}

/**
 * @param array $data
 */
function get_users_permissions($data = [])
{
	$permissions_array = array();

// $all_permissions_array = [

// 	'view_own'

// 	'view'

// 	'create'

// 	'edit'

// 	'delete'
	// ];

	$view_permissions_array = [
		'view',
		'create',
		'edit',
		'delete'
	];

	$permissions = [

		'users'      => [
			'name'         => 'users',
			'capabilities' => [
				'view' => $view_permissions_array
			]
		],

		'projects'   => [
			'name'         => 'projects',
			'capabilities' => [
				'view' => $view_permissions_array
			]
		],
		'categories' => [
			'name'         => 'categories',
			'capabilities' => [
				'view' => $view_permissions_array
			]
		]

	];
	$permissions_array = $permissions;

	return $permissions_array;
}

/**
 * [send_mail function for sending mail when successfully registration]
 * @param $email [registration Email]
 * @param $subject [Subject for mail]
 * @param $htmlContent[Load view]
 */
function send_mail($email = '', $subject = '', $htmlContent = '')
{
	// email SMTP config
	$config['protocol']  = 'smtp';
	$config['smtp_host'] = 'smtp.1and1.com';
	$config['smtp_port'] = 587;
	$config['smtp_user'] = 'arj@narola.email';
	$config['smtp_pass'] = '3)jt1429P-97krW';
	$config['mailtype']  = 'html';
	$config['newline']   = "\r\n";
	$config['mailtype']  = 'html';
	$CI                  = &get_instance();
	$CI->load->library('email', $config);
	$CI->email->from('test.narolainfotech@gmail.com', 'WKE');
	$CI->email->to($email);
	$CI->email->subject($subject);
	$CI->email->message($htmlContent);

	if ($CI->email->send())
	{
		return TRUE;
	}
	else
	{
		return false;
	}
}

/**
 * @param $data
 */
function log_activity($description, $user_id)
{
	$CI = &get_instance();
	$CI->load->model('activity_log_model', 'activity_log');

	$data = array(
		'description' => $description,
		'date'        => current_timestamp(),
		' user_id'    => $user_id

	);

	$CI->activity_log->insert($data);
}

/**
 * @param $session_time
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
			echo "one minute ago";
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
			echo "one hour ago";
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
			echo "one day ago";
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
			echo "one week ago";
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
			echo "one month ago";
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
			echo "one year ago";
		}
		else
		{
			echo "$years years ago";
		}
	}
}

/**
 * @return mixed
 */
function remember_token()
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
