<?php

/**
 * Summary: php file which implements customizations related to users
 */

//action to take when new users are created
add_action( 'user_register', 'gmuw_fs_new_user', 10, 1 );
function gmuw_fs_new_user( $user_id ) {

	//if user is subscriber
	if ( in_array( 'subscriber', (array) get_userdata($user_id)->roles ) ) {

		//set up dashboard
		gmuw_reset_dash($user_id);

	}

}
