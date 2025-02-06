<?php

/**
 * Summary: php file which implements customizations related to the dashboard
 */


/**
 * adds custom meta boxes to WordPress admin dashboard
 */
add_action('wp_dashboard_setup', 'gmuw_fs_custom_dashboard_meta_boxes');
function gmuw_fs_custom_dashboard_meta_boxes() {

  // Declare global variables
  global $wp_meta_boxes;

  /* Add 'upload' meta box */
  add_meta_box("gmuw_fs_custom_dashboard_meta_box_upload", "Upload", "gmuw_fs_custom_dashboard_meta_box_upload", "dashboard","normal");

  /* Add 'index' meta box */
  add_meta_box("gmuw_fs_custom_dashboard_meta_box_index", "Index", "gmuw_fs_custom_dashboard_meta_box_index", "dashboard","normal");

   /* most recent files */
  add_meta_box("gmuw_fs_custom_dashboard_meta_box_files_mostrecent", "Recent Files", "gmuw_fs_custom_dashboard_meta_box_files", "dashboard","normal");

   /* oldest files */
  add_meta_box("gmuw_fs_custom_dashboard_meta_box_files_oldest", "Oldest Files", "gmuw_fs_custom_dashboard_meta_box_files", "dashboard","normal","",array("oldest"));

   /* most recent documents */
  add_meta_box("gmuw_fs_custom_dashboard_meta_box_files_mostrecent_docs", "Recent Document Files", "gmuw_fs_custom_dashboard_meta_box_files", "dashboard","normal","",array("documents"));

   /* most recent images */
  add_meta_box("gmuw_fs_custom_dashboard_meta_box_files_mostrecent_images", "Recent Image Files", "gmuw_fs_custom_dashboard_meta_box_files", "dashboard","normal","",array("images"));

   /* most recent pdfs */
  add_meta_box("gmuw_fs_custom_dashboard_meta_box_files_mostrecent_pdfs", "Recent PDF Files", "gmuw_fs_custom_dashboard_meta_box_files", "dashboard","normal","",array("pdfs"));

   /* most recent your files */
  add_meta_box("gmuw_fs_custom_dashboard_meta_box_files_mostrecent_yours", "Your Recent Files", "gmuw_fs_custom_dashboard_meta_box_files", "dashboard","normal","",array("yours"));

}

/**
 * Provides content for the dashboard 'upload' meta box
 */
function gmuw_fs_custom_dashboard_meta_box_upload() {

  //Output content
  echo '<p><a href="/wp-admin/media-new.php">Upload New File</a></p>';

}

/**
 * Provides content for the dashboard 'index' meta box
 */
function gmuw_fs_custom_dashboard_meta_box_index() {

  //Output content
  echo '<p><a href="/wp-admin/admin.php?page=gmuw_fs_file_index">File Index</a></p>';

}
