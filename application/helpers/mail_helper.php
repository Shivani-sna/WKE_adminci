<?php

/**
 * [send_mail function for sending mail using PHP Malier library]
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

?>