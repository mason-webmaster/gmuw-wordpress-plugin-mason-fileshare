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

  /* Add 'permissions' meta box */
  add_meta_box("gmuw_fs_custom_dashboard_meta_box_permissions", "Permissions", "gmuw_fs_custom_dashboard_meta_box_permissions", "dashboard","normal");

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
 * Provides content for the dashboard 'permissions' meta box
 */
function gmuw_fs_custom_dashboard_meta_box_permissions() {

  echo '<p><strong>Upload Permissions</strong></p>';

  //get user website permissions
  $user_website_ids = get_field('user_websites','user_'.get_current_user_id());

  //if the user has permissions
  if ($user_website_ids) {

    //display user website upload permissions
    echo '<p>You have permssions to upload files for the following websites:</p>';

    echo '<p>';

    //display links to update active website
    gmuw_fs_update_user_update_working_website_links();

    echo '<p>';

  } else {

    echo '<p>You do not have permssions to upload files for any websites.</p>';

  }

  echo '<p><strong>Admin Permissions</strong></p>';

  //get user website permissions
  $user_website_ids = get_field('user_websites_admin','user_'.get_current_user_id());

  //if the user has permissions
  if ($user_website_ids) {

    echo '<p>You have permssions to manage files for the following websites:</p>';

    echo '<p>';

    //loop through website permissions
    foreach ($user_website_ids as $user_website_id) {
      //display
      echo get_term($user_website_id)->name.'<br />';
    }

    echo '<p>';

  } else {

    echo '<p>You do not have permssions to manage files for any websites.</p>';

  }

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


/**
 * Adds an admin notice indicating the user's current working website and providing the ability to change it
 */
add_action( 'admin_notices', 'gmuw_fs_admin_notice_user_active_website' );
function gmuw_fs_admin_notice_user_active_website() {

  //get globals
  global $pagenow;

  //only run this on the dashboard and upload pages
  $admin_pages = [ 'index.php', 'media-new.php' ];
  if (in_array($pagenow, $admin_pages)) {

    echo '<div class="notice notice-info">';

    //handle updates to the users active website
    gmuw_fs_update_user_working_website();

    //user current working website message
    gmuw_fs_user_current_website_message();

    //if user has more than one permission
    if (gmuw_fs_user_has_more_than_one_website_upload_permission()) {

      echo '<p>Switch website: ';

      //display links to update active website
      gmuw_fs_update_user_update_working_website_links();

      echo '</p>';

    }

    echo '</div>';

  }

}

//function to return current html markup representing working website message
function gmuw_fs_user_current_website_message() {

  echo '<p><strong>You are currently uploading files for: '.get_term(gmuw_fs_user_related_website_active(get_current_user_id()))->name.'</strong></p>';

}

//function to handle updates to the users active working website
function gmuw_fs_update_user_working_website() {

  //get user website permissions
  $user_website_ids = get_field('user_websites','user_'.get_current_user_id());

  //if the user has permissions
  if ($user_website_ids) {

    //if we have a parameter to update the active website, and if that value is in the list of websites the user has permissions for
    if (isset($_GET['set_active_website']) && in_array($_GET['set_active_website'],$user_website_ids)) {

      //update user meta
      update_user_meta(get_current_user_id(),'user_website_active',$_GET['set_active_website']);

      //echo '<p><strong>Active website updated!</strong></p>';

    }

  }

}

//function to provide links to update the users active working website
function gmuw_fs_update_user_update_working_website_links() {

  //get user website permissions
  $user_website_ids = get_field('user_websites','user_'.get_current_user_id());

  //if the user has permissions
  if ($user_website_ids) {

    //begin output
    echo '<span class="gmuw_fs_user_active_website_links">';

    //loop through website permissions
    foreach ($user_website_ids as $user_website_id) {

      //display link
      echo '<a href="?set_active_website='.$user_website_id.'" title="update active website">'.get_term($user_website_id)->name.'</a>';

    }

    //finish output
    echo '</span>';

  }

}

//function to determine whether the user has more than one website upload permission
function gmuw_fs_user_has_more_than_one_website_upload_permission() {

  //get user website permissions
  $user_website_ids = get_field('user_websites','user_'.get_current_user_id());

  //if user has more than one permission
  if (preg_match("/^\d+,\d+/", implode(',',$user_website_ids))) {
    return true;
  } else {
    return false;
  }

}
