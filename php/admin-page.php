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

/**
 * generates the file index page
 */
function gmuw_fs_file_index_page(){

    // Only continue if this user has the 'manage options' capability
    if (!current_user_can('upload_files')) return;

    // Begin HTML output
    echo "<div class='wrap'>";

    // Page title
    echo "<h1>" . esc_html(get_admin_page_title()) . "</h1>";

    //set up query arguments
    $get_posts_args = array(
        'post_type'      => 'attachment',
        'posts_per_page' => -1,
        'post_status'    => 'any',
        'post_parent'    => null,
        'orderby'        => 'modified',
    );

    //do we have a related website id to filter for?
    if (isset($_GET['related_website_id']) && (int)$_GET['related_website_id']>0) {

        //provide a 'back to view all' link
        echo '<p>This table is only showing files associated with the website '.get_term_by('id', (int)$_GET['related_website_id'], 'related_website')->name.'. <a href="/wp-admin/admin.php?page=gmuw_fs_file_index">View files for all websites</a></p>';

        //set up meta query arguments
        $get_posts_meta_query_args = array(
            'meta_query' => array(
                array(
                    'key' => 'attachment_related_website',
                    'value' => (int)$_GET['related_website_id'],
                    'compare' => '=',
                )
            )
        );

        //merge arrays
        $get_posts_args=array_merge($get_posts_args,$get_posts_meta_query_args);

    }

    //get attachments
    $attachments = get_posts($get_posts_args);

    //put into table
    echo gmuw_fs_index_file_table($attachments);

    // Finish HTML output
    echo "</div>";

}
