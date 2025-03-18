<?php

/**
 * Summary: php file which implements the plugin WP admin menu changes
 */


/**
 * Adds Mason Fileshare admin menu item to Wordpress admin menu as a top-level item
 */
add_action('admin_menu', 'gmuj_add_admin_menu_mason_fileshare');

function gmuj_add_admin_menu_mason_fileshare() {

	// Add top admin menu page
	add_submenu_page(
		'options-general.php',
		'Mason WebDocs Settings',
		'Mason WebDocs',
		'manage_options',
		'gmuw_fs',
		'gmuw_fs_plugin_page',
		0
	);

}

/**
 * Adds file index admin menu item to Wordpress admin menu as a top-level item
 */
add_action('admin_menu', 'gmuj_add_admin_menu_fs_index');
function gmuj_add_admin_menu_fs_index() {

	// Add top admin page
	add_menu_page(
		'WebDocs File Index',
		'File Index',
		'upload_files',
		'gmuw_fs_file_index',
		'gmuw_fs_file_index_page',
		'dashicons-index-card',
		12
	);


}
