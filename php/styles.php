<?php

/**
 * Summary: php file which implements the admin interface styles
 */


/**
 * Enqueue login page styles
 */
add_action('login_enqueue_scripts', 'gmuw_fs_login_stylesheet' );
function gmuw_fs_login_stylesheet() {

  // Enqueue login page stylesheet
  wp_enqueue_style(
    'gmuw_fs_style_login',
    plugin_dir_url( __DIR__ ).'/css/login.css'
  );

}

/**
 * Enqueue admin styles
 */
add_action('admin_enqueue_scripts','gmuw_fs_enqueue_styles_admin');
function gmuw_fs_enqueue_styles_admin() {

  // Enqueue datatables stylesheet
  wp_enqueue_style (
    'gmuw_fs_style_admin_datatables',
    plugin_dir_url( __DIR__ ).'datatables/datatables.min.css'
  );

  // Enqueue the plugin admin stylesheets
  wp_enqueue_style (
    'gmuw_fs_style_admin',
    plugin_dir_url( __DIR__ ).'/css/admin.css'
  );

}
