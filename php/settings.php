<?php

/**
 * Summary: php file which sets up plugin settings
 */


/**
 * Register plugin settings
 */
add_action('admin_init', 'gmuw_fs_register_settings');
function gmuw_fs_register_settings() {
	
	/*
	Code reference:

	register_setting( 
		string   $option_group, // name of option group - should match the parameter used in the settings_fields function in the display_settings_page function
		string   $option_name, // name of the particular option
		callable $sanitize_callback = '' // function used to validate settings
	);

	add_settings_section( 
		string   $id, // section id
		string   $title, // title/heading of section
		callable $callback, // function that displays section
		string   $page // admin page (slug) on which this section should be displayed
	);

	add_settings_field(
    	string   $id, // setting id
		string   $title, // title of setting
		callable $callback, // outputs markup required to display the setting
		string   $page, // page on which setting should be displayed, same as menu slug of the menu item
		string   $section = 'default', // section id in which this setting is placed
		array    $args = [] // array the contains data to be passed to the callback function. by convention I pass back the setting id and label to make things easier
	);
	*/

	// Register serialized options setting to store this plugin's options
	register_setting(
		'gmuw_fs_options',
		'gmuw_fs_options',
		'gmuw_fs_callback_validate_options'
	);

	// Add section: basic settings
	add_settings_section(
		'gmuw_fs_section_settings_basic',
		'Basic Settings',
		'gmuw_fs_callback_section_settings_basic',
		'gmuw_fs'
	);

	// Add field: template user id
	add_settings_field(
		'template_user_id',
		'Template User',
		'gmuw_fs_callback_field_user',
		'gmuw_fs',
		'gmuw_fs_section_settings_basic',
		['id' => 'template_user_id', 'label' => 'template user']
	);

} 

/**
 * Generates the plugin settings page
 */
function gmuw_fs_plugin_settings_form() {
    
    // Only continue if this user has the 'manage options' capability
    if (!current_user_can('manage_options')) return;

    // heading
    echo "<h2>Plugin settings</h2>";

    // Begin form
    echo "<form action='options.php' method='post'>";

    // output settings fields - outputs required security fields - parameter specifes name of settings group
    settings_fields('gmuw_fs_options');

    // output setting sections - parameter specifies name of menu slug
    do_settings_sections('gmuw_fs');

    // submit button
    submit_button();

    // Close form
    echo "</form>";

}

/**
 * Generates content for basic settings section
 */
function gmuw_fs_callback_section_settings_basic() {

    echo '<p>Basic settings.</p>';

}

/**
 * Generates text field for plugin settings option
 */
function gmuw_fs_callback_field_text($args) {
    
    //Get array of options. If the specified option does not exist, get default options from a function
    $options = get_option('gmuw_fs_options', gmuw_fs_options_default());
    
    //Extract field id and label from arguments array
    $id    = isset($args['id'])    ? $args['id']    : '';
    $label = isset($args['label']) ? $args['label'] : '';
    
    //Get setting value
    $value = isset($options[$id]) ? sanitize_text_field($options[$id]) : '';
    
    //Output field markup
    echo '<input id="gmuw_fs_options_'. $id .'" name="gmuw_fs_options['. $id .']" type="text" size="40" value="'. $value .'">';
    echo "<br />";
    echo '<label for="gmuw_fs_options_'. $id .'">'. $label .'</label>';
    
}

/**
 * Generates user field for plugin settings option
 */
function gmuw_fs_callback_field_user($args) {
    
    //Get array of options. If the specified option does not exist, get default options from a function
    $options = get_option('gmuw_fs_options', gmuw_fs_options_default());
    
    //Extract field id and label from arguments array
    $id    = isset($args['id'])    ? $args['id']    : '';
    $label = isset($args['label']) ? $args['label'] : '';
    
    //Get setting value
    $value = isset($options[$id]) ? sanitize_text_field($options[$id]) : '';
    
    //Output field markup
	wp_dropdown_users(
		array(
			'name' => 'gmuw_fs_options['. $id .']',
			'selected' => $value
		)
	);
    echo '<p><label for="gmuw_fs_options_'. $id .'">'. $label .'</label></p>';

}

/**
 * Sets default plugin options
 */
function gmuw_fs_options_default() {

    return array(
        'template_user_id'   => '',
    );

}

/**
 * Validate plugin options
 */
function gmuw_fs_callback_validate_options($input) {
    
    // template_user_id
    if (isset($input['template_user_id'])) {
        $input['template_user_id'] = sanitize_text_field($input['template_user_id']);
    }

    return $input;
    
}
