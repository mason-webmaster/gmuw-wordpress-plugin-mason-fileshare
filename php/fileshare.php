<?php

/**
 * Summary: php file which implements customizations related to the file sharing
 */


//display most recent uploaded attachments
function gmuw_fs_files_mostrecent() {

	//initialize return variable
	$return_value='';

	//get attachments
	$attachments = get_posts( array(
		'post_type'      => 'attachment',
		'posts_per_page' => 10,
		'post_status'    => 'any',
		'post_parent'    => null,
		'orderby'		 => 'modified',
	) );

	if ( $attachments ) {
		$return_value.='<table class="data_table simple">';
		$return_value.='<thead>';
		$return_value.='<tr>';
		$return_value.='<td>File</td>';
		$return_value.='<td>Modified</td>';
		$return_value.='</tr>';
		$return_value.='</thead>';
		$return_value.='<tbody>';
		foreach ($attachments as $post) {
			$return_value.='<tr>';
			$return_value.='<td><a href="'.wp_get_attachment_url($post->ID).'" target="_blank">'.get_the_title($post).' ('.$post->ID.')</a></td>';
			$return_value.='<td>'.get_the_modified_date('', $post).'</td>';
			$return_value.='</tr>';
		}
		$return_value.='</tbody>';
		$return_value.='</table>';
	}

	//return value
	return $return_value;

}

