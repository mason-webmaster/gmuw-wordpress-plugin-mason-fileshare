<?php

/**
 * Summary: php file which implements customizations related to email
 */


//send annual report update notification email
function gmuw_fs_email_notification($action,$post_id){

	//set email content
	$email_content=array(
		'Mason Fileshare update:',
		wp_get_current_user()->user_login,
		$action,
		wp_get_attachment_url($post_id)
	);

	//build email subject and body using email content array
	$email_subject=implode(', ',$email_content);
	$email_body=implode(PHP_EOL,$email_content);

	//send notification email
	wp_mail(
		array('jmacario@gmu.edu'),
		$email_subject,
		$email_body,
	);

}
