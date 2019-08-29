<?php
/*
 *current_timestamp() for generate cureent time stamp value
*/

function current_timestamp()
{
	date_default_timezone_set('Asia/Kolkata');
	return time();
}

/**[display_date_time for diaplay date and time format set in settings]
 * @param $timestamp
 */
function display_date_time($timestamp)
{
	if (get_settings('date_format') != '' && get_settings('time_format') != '')
	{
		return date(get_settings('date_format').'  '.get_settings('time_format'), $timestamp);
	}
	else if (get_settings('date_format') != '' && get_settings('time_format') == '')
	{
		return date(get_settings('date_format').'  h:i A', $timestamp);
	}
	else if (get_settings('date_format') == '' && get_settings('time_format') != '')
	{
		return date('d-m-Y  '.get_settings('time_format'), $timestamp);
	}
	else
	{
		return date('d-m-Y  h:i A', $timestamp);
	}
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
?>