<?php
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
 * [set_sort_redirect_url for sorting get uri segment and generate session]
 */
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

/**
 * [get_settings for fetch settings value from database]
 * @return mixed
 */
function get_settings($name = '')
{
	$CI = &get_instance();
	$CI->load->model('setting_model', 'settings');

	if ($name == '')
	{
		$settings = $CI->settings->get_all();

		return $settings;
	}
	else
	{
		$result = $CI->settings->get_by(['name' => $name]);

		if ($result)
		{
			return $result['value'];
		}
		else
		{
			return null;
		}
	}
}

