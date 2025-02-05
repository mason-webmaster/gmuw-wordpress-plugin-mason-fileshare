<?php

/**
 * Summary: php file which implements the custom taxonomies
 */


// Register taxonomies
add_action('init', 'gmuw_fs_register_taxonomies');
function gmuw_fs_register_taxonomies() {

    // register taxonomy for related websites
    register_taxonomy(
        'related_website',
        'post',
        array(
            'hierarchical' => false,
            'labels' => array(
                'name' => 'Related Websites',
                'singular_name' => 'Related Website',
                'search_items' =>  'Search Related Websites',
                'all_items' => 'All Related Websites',
                'parent_item' => 'Parent Related Website',
                'parent_item_colon' => 'Parent Related Website:',
                'edit_item' => 'Edit Related Website',
                'update_item' => 'Update Related Website',
                'add_new_item' => 'Add New Related Website',
                'new_item_name' => 'New Related Website',
                'menu_name' => 'Related Websites',
            ),
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => 'related_website' ),
            'show_admin_column' => true,
            'show_in_rest' => true,
        )
    );

}
