<?php

/**
 * Summary: php file which implements the plugin WP admin page interface
 */


/**
 * generates the plugin page
 */
function gmuw_fs_plugin_page(){

    // Only continue if this user has the 'manage options' capability
    if (!current_user_can('manage_options')) return;

    // Begin HTML output
    echo "<div class='wrap'>";

    // Page title
    echo "<h1>" . esc_html(get_admin_page_title()) . "</h1>";

    //process anything?
    //reset_dash?
    if(
        isset($_GET['action']) && 
        $_GET['action']== 'reset_dash' &&
        isset($_GET['user']) &&
        (string)(int)$_GET['user'] == $_GET['user']
    ){
        gmuw_reset_dash($_GET['user']);
    }

    //display settings
    gmuw_fs_plugin_settings_form();

    // Finish HTML output
    echo "</div>";
    
}
