<?php

/**
 * Summary: php file which implements customizations related to permissions
 */


function gmuw_fs_roles_and_caps_setup() {

	//add upload_files capability to subscriber role
	get_role('subscriber')->add_cap('upload_files');

}

function gmuw_fs_roles_and_caps_cleanup() {

	//remove upload_files capability from subscriber role
	get_role('subscriber')->remove_cap('upload_files');

}
