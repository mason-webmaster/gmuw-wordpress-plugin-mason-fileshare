<?php

/**
 * Summary: php file which implements customizations related to users
 */

/**
 * WordPress function for redirecting users on login based on user role
 */
add_filter( 'login_redirect', 'gmuw_fs_login_redirect_subscribers', 10, 3 );
function gmuw_fs_login_redirect_subscribers( $url, $request, $user ) {

	//if user is a subscriber, redirect them to the WP dashboard (instead of their user profile page, which they would be by default)
	if (
		//$user &&
		//is_object($user) &&
		is_a($user, 'WP_User') &&
		$user->has_cap('subscriber')
	) {
		$url = '/wp-admin/index.php';
	}

	//return value
	return $url;

}
