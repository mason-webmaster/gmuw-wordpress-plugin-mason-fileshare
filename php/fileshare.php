<?php

/**
 * Summary: php file which implements customizations related to the file sharing
 */


//display custom dashboard meta box with a table of files
function gmuw_fs_custom_dashboard_meta_box_files($post,$args) {

	//get mode from arguments
	if (
		isset($args) &&
		isset($args['args']) &&
		isset($args['args'][0])
	) {
		$mode=$args['args'][0];
	} else {
		$mode=null;
	}

	//set up query arguments
	$get_posts_args = array(
		'post_type'      => 'attachment',
		'posts_per_page' => 10,
		'post_status'    => 'any',
		'post_parent'    => null,
		'orderby'		 => 'modified',
	);

	//restrict query based on file mime type, if specified
	switch ($mode) {
		case 'documents':
			$get_posts_args['post_mime_type']='application/*';
			break;
		case 'images':
			$get_posts_args['post_mime_type']='image/*';
			break;
		case 'pdfs':
			$get_posts_args['post_mime_type']='application/pdf';
			break;
		case 'yours':
			$get_posts_args['author']=get_current_user_id();
			break;
		case 'oldest':
			$get_posts_args['order']='ASC';
			break;
	}

	//get attachments
	$attachments = get_posts($get_posts_args);

	//put into table
	echo gmuw_fs_dashboard_widget_file_table($attachments);

}

//function to display dashboard meta box datatables file table
function gmuw_fs_dashboard_widget_file_table($posts){

	//initialize return variable
	$return_value='';

	if ($posts) {
		$return_value.='<table class="data_table dashboardwidget">';
		$return_value.='<thead>';
		$return_value.='<tr>';
		$return_value.='<td>File</td>';
		$return_value.='<td>Modified</td>';
		$return_value.='<td>&nbsp;</td>';
		$return_value.='</tr>';
		$return_value.='</thead>';
		$return_value.='<tbody>';
		foreach ($posts as $post) {
			$return_value.='<tr>';
			//file
			$return_value.='<td>';
			$return_value.=gmuw_fs_icon(gmuw_fs_mime_type_icon($post->post_mime_type)).' '.'<a href="'.wp_get_attachment_url($post->ID).'" target="_blank">'.get_the_title($post).'</a>';
			//does this file require attestation?
			if (gmuw_fs_file_requires_attestation($post->ID)) {
				$return_value.=' <span class="notice notice-error">';
				$return_value.='*requires attestation ';
				//attest link
				$return_value.='<a class="admin-icon admin-attest" href="admin.php?page=gmuw_fs_file_index&action=attest&mypostid='.$post->ID.'" onclick="return confirm(\'Do you attest that this file is still in active use and is still required to be hosted?\')"></a> ';
				$return_value.='</span> ';
			}
			$return_value.='</td>';
			//modified date
			$return_value.='<td>'.get_the_modified_date('Y-m-d', $post).'</td>';
			//links
			$return_value.='<td>';
			//edit link, if the user can edit this post
			if ($post->post_author == get_current_user_id() || current_user_can('manage_options') ) {
				$return_value.='<a class="admin-icon admin-edit" title="edit" href="/wp-admin/post.php?post='.$post->ID.'&action=edit"></a>';
			}
			//open link
			//$return_value.='<a class="admin-icon admin-external" title="open" href="'.wp_get_attachment_url($post->ID).'" target="_blank"></a>';
			$return_value.='</td>';
			$return_value.='</tr>';
		}
		$return_value.='</tbody>';
		$return_value.='</table>';
	}

	//return value
	return $return_value;

}

//function to display admin file index page datatables file table
function gmuw_fs_index_file_table($posts){

	//initialize return variable
	$return_value='';

	//process any actions
	if ( isset($_GET['action']) &&
		in_array($_GET['action'], array(
		'attest',
		'delete'
	)) ) {

		//get post id
		$mypostid = isset($_GET['mypostid']) ? (int)$_GET['mypostid'] : 0;

		//do we not have a good value?
		if ($mypostid==0) {
			$return_value='<div class="notice notice-error is-dismissable "><p>Bad post ID. Unable to '.$_GET['action'].'.</p></div>';
		} else {

			//do we not have permissions?
			if (!(get_post($mypostid)->post_author == get_current_user_id() || current_user_can('manage_options') ) ) {

				$return_value='<div class="notice notice-error is-dismissable "><p>You do not have permissions.</p></div>';

			} else {

				//we are good. we have a good id, and we have permissions...

				if ($_GET['action']=='attest') {

					//perform attestation
					update_post_meta(
						$mypostid,
						'gmuw_fs_file_attestation',
						array(
							get_current_user_id(),
							time()-14400, //minus the number of seconds in 4 hours to account for time zone difference
						)
					);

					//trigger notification email
					if (get_option('gmuw_fs_options')['gmuw_fs_email_notification_attest']==1) {
						gmuw_fs_email_notification($_GET['action'],$mypostid);
					}

					//output
					$return_value='<div class="notice notice-success is-dismissable"><p>'.get_user_by('id',get_current_user_id())->user_login.' attested for the file <a href="'.wp_get_attachment_url($mypostid).'" target="_blank">'.basename(get_attached_file($mypostid)).'</a> ('.$mypostid.').</p></div>';

				}

				if ($_GET['action']=='delete') {

					//trigger notification email
					if (get_option('gmuw_fs_options')['gmuw_fs_email_notification_delete']==1) {
						gmuw_fs_email_notification($_GET['action'],$mypostid);
					}

					//output
					$return_value='<div class="notice notice-error is-dismissable "><p>'.$_GET['action'].' post '.$mypostid.'</p></div>';

				}

			}

		}

	}

	if ($posts) {
		$return_value.='<table class="data_table">';
		$return_value.='<thead>';
		$return_value.='<tr>';
		$return_value.='<td>File</td>';
		$return_value.='<td>Post ID</td>';
		$return_value.='<td>Mime type</td>';
		$return_value.='<td>User</td>';
		$return_value.='<td>Modified</td>';
		$return_value.='<td>Attested</td>';
		$return_value.='<td>Actions</td>';
		$return_value.='</tr>';
		$return_value.='</thead>';
		$return_value.='<tbody>';
		foreach ($posts as $post) {
			$return_value.='<tr>';
			//title/link
			$return_value.='<td><a href="'.wp_get_attachment_url($post->ID).'" target="_blank">'.get_the_title($post).'</a></td>';
			//post ID
			$return_value.='<td>'. $post->ID.'</td>';
			//mime type
			$return_value.='<td>';
			$return_value.=gmuw_fs_icon(gmuw_fs_mime_type_icon($post->post_mime_type)).' ';
			$return_value.=$post->post_mime_type;
			$return_value.='</td>';
			//user
			$return_value.='<td>';
			$return_value.= $post->post_author == get_current_user_id() ? '<span class="gmuw_fs_highlight">' : '';
			$return_value.=get_user_by('id', $post->post_author)->user_login;
			$return_value.= $post->post_author == get_current_user_id() ? '</span>' : '';
			$return_value.='</td>';
			//date modified
			$return_value.='<td>'.get_the_modified_date('Y-m-d', $post).'</td>';
			//date attested
			$return_value.='<td>';
			$file_attestation=get_post_meta($post->ID,'gmuw_fs_file_attestation', true);
			if (is_array($file_attestation)) {

				$return_value.='<span style="color:'.gmuw_fs_get_file_attestation_color($post->ID).'">';
				$return_value.=date("Y-m-d H:i:s", $file_attestation[1]);
				$return_value.=' ('.gmuw_fs_days_since_file_attestation($post->ID).' day(s))';
				$return_value.='</span>';
				$return_value.='<br />by ';
				$return_value.=get_user_by('id',$file_attestation[0])->user_login . ' ';

			}
			//does this file require attestation?
			$return_value.=gmuw_fs_file_requires_attestation($post->ID) ? '<span class="notice notice-error">*requires attestation</span>' : '';

			$return_value.='</td>';
			//actions
			$return_value.='<td>';
			//does this file belong to the current user?
			if ($post->post_author == get_current_user_id() || current_user_can('manage_options') ) {
				//edit button
				$return_value.='<a class="button button-primary" href="/wp-admin/post.php?post='.$post->ID.'&action=edit">edit</a> ';
				//attest button
				$return_value.='<a class="button" href="admin.php?page=gmuw_fs_file_index&action=attest&mypostid='.$post->ID.'" onclick="return confirm(\'Do you attest that this file is still in active use and is still required to be hosted?\')">attest</a> ';
				//delete button
				$return_value.='<a class="button" href="admin.php?page=gmuw_fs_file_index&action=delete&mypostid='.$post->ID.'" onclick="return confirm(\'Are you sure you want to delete this file?\')">delete</a> ';
			}
			$return_value.='</td>';
			$return_value.='</tr>';
		}
		$return_value.='</tbody>';
		$return_value.='</table>';
	}

	//return value
	return $return_value;

}

function gmuw_fs_days_since_file_attestation($post_id){

	//initialize return variable
	$return_value='';

	//get file attestation
	$file_attestation=get_post_meta($post_id,'gmuw_fs_file_attestation', true);

	//get file attestation timestamp
	$file_attestation_time=$file_attestation[1];

	//is the timestamp anything other than an integer?
	if (!ctype_digit(strval($file_attestation_time))) { return $return_value; }

	//calculate number of days since last attested (86400 is the number of seconds in 1 day)
	$days_since_last_attested=floor((time()-$file_attestation_time)/86400);

	//set return value
	$return_value=$days_since_last_attested;

	//return value
	return $return_value;

}

function gmuw_fs_get_file_attestation_color($post_id){

	//initialize return variable
	$return_value='#000000';

	//get number of days since last attested
	$days_since_last_attested=gmuw_fs_days_since_file_attestation($post_id);

	//calculate color based on days last attested
	//if the number of days is greater than 255, just stop at 255
	$days_since_last_attested_for_color_value = $days_since_last_attested<=255 ? $days_since_last_attested : 255;

	//convert number of days to hexamecimal equivalent
	$red_hex_color_value=dechex($days_since_last_attested_for_color_value);

	//assemble hex color value
	$color_value='#'.$red_hex_color_value.'0000';

	//set return value
	$return_value=$color_value;

	//return value
	return $return_value;

}

function gmuw_fs_file_attestation_time_effective($post_id){

	//get file attestation
	$file_attestation=get_post_meta($post_id,'gmuw_fs_file_attestation', true);

	//is the value an array?
	if (is_array($file_attestation) && sizeof($file_attestation)>=2 ) {

		//get file attestation timestamp
		$file_attestation_time=$file_attestation[1];

		//do we have a good timestamp (an integer)?
		if (ctype_digit(strval($file_attestation_time))) {
			//return value
			return $file_attestation_time;
		}

	}

	//if we're still here, we didn't get a file attestation time, so use the post created timestamp
	$post_created_time=get_post_timestamp($post_id);

	//return value
	return $post_created_time;

}

//function to determine whether file requires attestation
function gmuw_fs_file_requires_attestation($post_id){


	//initialize return variable
	$return_value=false;

	//get effective file attestation
	$file_attestation_time_effective=gmuw_fs_file_attestation_time_effective($post_id);

	//calculate number of days since effective file attestation (86400 is the number of seconds in 1 day)
	$days_since_last_attested_effective=floor((time()-$file_attestation_time_effective)/86400);

	//get required file attestation interval from plugin settings or use a default fallback
	if (isset(get_option('gmuw_fs_options')['gmuw_fs_file_attestation_interval_days'])) {
		$required_attestation_interval=get_option('gmuw_fs_options')['gmuw_fs_file_attestation_interval_days'];
	} else {
		$required_attestation_interval=30;
	}

	//if days since effective attestation is greater than some threshold, indicate that attestation is required
	if ($days_since_last_attested_effective>$required_attestation_interval) {
		$return_value=true;
	}

	//return value
	return $return_value;


}
