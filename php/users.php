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

/**
 * Remove the color picker from the user edit page (but it is still available on the profile edit page)
 */
add_action( 'admin_head-user-edit.php', function(){ remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' ); });

/**
 * add custom css to the admin profile page to hide some fields
 * https://wordpress.stackexchange.com/questions/94963/removing-website-field-from-the-contact-info
 */
add_action( 'admin_head-user-edit.php', 'gmuw_fs_admin_user_profile_screen_custom_css' );
add_action( 'admin_head-profile.php',   'gmuw_fs_admin_user_profile_screen_custom_css' );
function gmuw_fs_admin_user_profile_screen_custom_css() {
    echo '<style>';
    echo 'tr.user-rich-editing-wrap{ display: none; }';
    echo 'tr.user-comment-shortcuts-wrap{ display: none; }';
    echo 'tr.user-syntax-highlighting-wrap{ display: none; }';
    echo 'tr.user-language-wrap{ display: none; }';
    echo 'tr.user-admin-bar-front-wrap{ display: none; }';
    echo 'tr.user-nickname-wrap{ display: none; }';
    echo 'tr.user-description-wrap{ display: none; }';
    echo 'tr.user-profile-picture{ display: none; }';
    echo 'tr.user-url-wrap{ display: none; }';
    echo 'tr.user-sessions-wrap{ display: none; }';
    echo 'div#application-passwords-section{ display: none; }';
    echo '</style>';
}

/**
 * Remove elements from the admin profile page which would be hard to remove via CSS
 * https://wordpress.stackexchange.com/questions/397816/wordpress-5-8-hide-or-remove-personal-fields-from-admin-profile-page
 */

// Remove fields from Admin profile page
add_action( 'admin_head', 'gmuw_fs_profile_subject_start' );
function gmuw_fs_profile_subject_start() {
	ob_start( 'gmuw_fs_remove_personal_options' );
}

function gmuw_fs_remove_personal_options( $subject ) {
    $subject = preg_replace('#<h2>'.__("Personal Options").'</h2>#s', '', $subject, 1); // Remove the "Personal Options" title
    $subject = preg_replace('#<h2>'.__("About the user").'</h2>#s', '', $subject, 1); // Remove the "About the user" title
    $subject = preg_replace('#<h2>'.__("About Yourself").'</h2>#s', '', $subject, 1); // Remove the "About Yourself" title
    return $subject;
}

add_action( 'admin_footer', 'gmuw_fs_profile_subject_end' );
function gmuw_fs_profile_subject_end() {
	ob_end_flush();
}

/**
 * Modifies columns in users admin list
 */
add_filter( 'manage_users_columns', 'gmuw_fs_set_columns_user' );
function gmuw_fs_set_columns_user( $columns ) {

    // unset the 'name' column
    unset( $columns['name'] );

    // unset the 'posts' column
    unset( $columns['posts'] );

    //add columns for our usermeta
    $columns['user_websites'] = 'Upload';
    $columns['user_websites_admin'] = 'Manage';

    return $columns;

}

/**
 * Populate additional column fields in users admin list
 */
add_filter( 'manage_users_custom_column', 'gmuw_fs_columns_user', 10, 3 );
function gmuw_fs_columns_user( $val, $column_name, $user_id ) {

    switch ($column_name) {
        case 'user_websites':

            //get user website permissions
            $user_website_ids = get_field('user_websites','user_'.$user_id);

            //if we don't have permissions, return
            if (!$user_website_ids) { return $val; }

            //loop through website permissions
            foreach ($user_website_ids as $user_website_id) {
              //display
              $val.=get_term($user_website_id)->name.'<br />';
            }
            break;

        case 'user_websites_admin':

            //get user website permissions
            $user_website_ids = get_field('user_websites_admin','user_'.$user_id);

            //if we don't have permissions, return
            if (!$user_website_ids) { return $val; }

            //loop through website permissions
            foreach ($user_website_ids as $user_website_id) {
              //display
              $val.=get_term($user_website_id)->name.'<br />';
            }
            break;
    }

    return $val;
}
