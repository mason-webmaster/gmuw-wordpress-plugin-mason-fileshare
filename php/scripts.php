<?php

/**
 * Summary: php file which implements custom javascript
 */


/**
 * Enqueue admin javascript
 */
add_action('admin_enqueue_scripts','gmuw_fs_enqueue_scripts_admin');
function gmuw_fs_enqueue_scripts_admin() {

  // Enqueue datatables javascript
  wp_enqueue_script(
    'gmuw_pf_script_admin_datatables', //script name
    plugin_dir_url( __DIR__ ).'datatables/datatables.min.js' //path to script
  );

  // Enqueue the plugin admin javascript
  wp_enqueue_script(
    'gmuw_pf_script_admin', //script name
    plugin_dir_url( __DIR__ ).'js/admin.js' //path to script
  );

}

/**
 * Enqueue custom upload page javascript
 */
add_action('admin_enqueue_scripts', function($hook_suffix){

  // are we on the upload page?
  if($hook_suffix == 'media-new.php') {

    // enqueue the custom javascript
    wp_enqueue_script(
      'gmuw_fs_admin_upload_js', //script name
      plugin_dir_url( __DIR__ ).'js/admin-upload.js', //path to script
      array('jquery') //dependencies
    );

  }

});

/**
 * Enqueue custom media library page javascript
 */
add_action('admin_enqueue_scripts', function($hook_suffix){

  // are we on the upload page?
  if($hook_suffix == 'upload.php') {

    // enqueue the custom javascript
    wp_enqueue_script(
      'gmuw_fs_admin_media_library_js', //script name
      plugin_dir_url( __DIR__ ).'js/admin-media-library.js', //path to script
      array('jquery') //dependencies
    );

  }

});
