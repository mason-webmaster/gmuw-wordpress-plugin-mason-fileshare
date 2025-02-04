<?php

/**
 * Summary: php file which implements customizations related to email
 */


//send notification emails for file actions
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

//send notification email when a file is uploaded
add_action('add_attachment', 'gmuw_fs_send_email_on_file_upload');
function gmuw_fs_send_email_on_file_upload($post_id){

	//are we set to send an email on file upload?
	if (get_option('gmuw_fs_options')['gmuw_fs_email_notification_upload']==1) {

		//send email
		gmuw_fs_email_notification('upload',$post_id);

	}

}
