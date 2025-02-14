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

	// Add field: file attestation interval in days
	add_settings_field(
		'gmuw_fs_file_attestation_interval_days',
		'Required File Attestation Interval (Days)',
		'gmuw_fs_callback_field_text',
		'gmuw_fs',
		'gmuw_fs_section_settings_basic',
		['id' => 'gmuw_fs_file_attestation_interval_days', 'label' => 'required interval in days between file attestations']
	);

	// Add section: email settings
	add_settings_section(
		'gmuw_fs_section_settings_email',
		'Email Settings',
		'gmuw_fs_callback_section_settings_email',
		'gmuw_fs'
	);

	// Add field: email addresses for notifications
	add_settings_field(
		'gmuw_fs_email_notification_addresses',
		'Email address(es) for notification emails',
		'gmuw_fs_callback_field_text',
		'gmuw_fs',
		'gmuw_fs_section_settings_email',
		['id' => 'gmuw_fs_email_notification_addresses', 'label' => 'comma-separated, please']
	);

	// Add field: turn on notification emails for file uploads
	add_settings_field(
		'gmuw_fs_email_notification_upload',
		'Send email notification on file upload?',
		'gmuw_fs_callback_field_yesno',
		'gmuw_fs',
		'gmuw_fs_section_settings_email',
		['id' => 'gmuw_fs_email_notification_upload', 'label' => '']
	);

	// Add field: turn on notification emails for file attestation
	add_settings_field(
		'gmuw_fs_email_notification_attest',
		'Send email notification on file attestation?',
		'gmuw_fs_callback_field_yesno',
		'gmuw_fs',
		'gmuw_fs_section_settings_email',
		['id' => 'gmuw_fs_email_notification_attest', 'label' => '']
	);

	// Add field: turn on notification emails for file deletion
	add_settings_field(
		'gmuw_fs_email_notification_delete',
		'Send email notification on file deletion?',
		'gmuw_fs_callback_field_yesno',
		'gmuw_fs',
		'gmuw_fs_section_settings_email',
		['id' => 'gmuw_fs_email_notification_delete', 'label' => '']
	);

} 

/**
 * Generates the plugin settings page
 */
function gmuw_fs_plugin_settings_form() {
    
    // Only continue if this user has the 'manage options' capability
    if (!current_user_can('manage_options')) return;

    // heading
    echo "<h2>Plugin Settings</h2>";

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

    //echo '<p>Basic settings.</p>';

}

/**
 * Generates content for email settings section
 */
function gmuw_fs_callback_section_settings_email() {

    //echo '<p>Email settings.</p>';

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
 * Generates yes/no field for plugin settings options
 */
function gmuw_fs_callback_field_yesno($args) {

    //Get array of options. If the specified option does not exist, get default options from a function
    $options = get_option('gmuw_fs_options', gmuw_fs_options_default());

    //Extract field id and label from arguments array
    $id    = isset($args['id'])    ? $args['id']    : '';
    $label = isset($args['label']) ? $args['label'] : '';

    //Get setting value
    $value = isset($options[$id]) ? sanitize_text_field($options[$id]) : '';

    //Output field markup
    echo '<select id="gmuw_fs_options_'. $id .'" name="gmuw_fs_options['. $id .']">';
    echo '<option ';
    echo $value ? 'selected ' : '';
    echo 'value="1">Yes</option>';
    echo '<option ';
    echo !$value ? 'selected ' : '';
    echo 'value="0">No</option>';
    echo '</select>';
    echo "<br />";
    echo '<label for="gmuw_fs_options_'. $id .'">'. $label .'</label>';

}

/**
 * Sets default plugin options
 */
function gmuw_fs_options_default() {

    return array(
        'gmuw_fs_email_notification_upload' => '1',
        'gmuw_fs_email_notification_attest' => '1',
        'gmuw_fs_email_notification_delete' => '1',
        'gmuw_fs_file_attestation_interval_days' => '30',
    );

}

/**
 * Validate plugin options
 */
function gmuw_fs_callback_validate_options($input) {

    // gmuw_fs_email_notification_upload
    if (isset($input['gmuw_fs_email_notification_upload'])) {

		//sanitize input
        $input['gmuw_fs_email_notification_upload'] = sanitize_text_field($input['gmuw_fs_email_notification_upload']);

        //if not blank...
        if (!empty($input['gmuw_fs_email_notification_upload'])) {

			//if it's not an integer, throw it out
			if (!preg_match("/[01]/", $input['gmuw_fs_email_notification_upload'])) {
				$input['gmuw_fs_email_notification_upload']='';
			}

        }

    }

    // gmuw_fs_email_notification_attest
    if (isset($input['gmuw_fs_email_notification_attest'])) {

		//sanitize input
        $input['gmuw_fs_email_notification_attest'] = sanitize_text_field($input['gmuw_fs_email_notification_attest']);

        //if not blank...
        if (!empty($input['gmuw_fs_email_notification_attest'])) {

			//if it's not an integer, throw it out
			if (!preg_match("/[01]/", $input['gmuw_fs_email_notification_attest'])) {
				$input['gmuw_fs_email_notification_attest']='';
			}

        }

    }

    // gmuw_fs_email_notification_delete
    if (isset($input['gmuw_fs_email_notification_delete'])) {

		//sanitize input
        $input['gmuw_fs_email_notification_delete'] = sanitize_text_field($input['gmuw_fs_email_notification_delete']);

        //if not blank...
        if (!empty($input['gmuw_fs_email_notification_delete'])) {

			//if it's not an integer, throw it out
			if (!preg_match("/[01]/", $input['gmuw_fs_email_notification_delete'])) {
				$input['gmuw_fs_email_notification_delete']='';
			}

        }

    }

    // gmuw_fs_file_attestation_interval_days
    if (isset($input['gmuw_fs_file_attestation_interval_days'])) {
        //is it an integer value?
        if ($input['gmuw_fs_file_attestation_interval_days'] == strval((int)$input['gmuw_fs_file_attestation_interval_days']) ) {
			//store it (casting to int for best-practice)
			$input['gmuw_fs_file_attestation_interval_days'] = (int)$input['gmuw_fs_file_attestation_interval_days'];
        } else {
			//if it's a bad value (a non-integer) store a default of 30 days
			$input['gmuw_fs_file_attestation_interval_days'] = 30;
        }
    }

	// gmuw_fs_email_notification_addresses
	if (isset($input['gmuw_fs_email_notification_addresses'])) {

		//strip out spaces
		$input['gmuw_fs_email_notification_addresses']=str_replace(' ', '', $input['gmuw_fs_email_notification_addresses']);

		//split into array with commas
		$email_array=explode(',',$input['gmuw_fs_email_notification_addresses']);

		//is is an array, with anything in it?
		if (is_array($email_array) && count($email_array)>0) {

			//yes we have emails
			$have_emails=true;

			//assume that they are all good emails, unless we disprove it
			$all_emails_good=true;

			//loop through array
			foreach ($email_array as $email_address) {

				//is this a valid email
				if (!is_email($email_address)) {

					//this data is not an email, so the field is no good
					$all_emails_good=false;

				}

			}

		}

		//if anything was wrong, throw out the input
		if (!$have_emails || !$all_emails_good) {
			$input['gmuw_fs_email_notification_addresses']='';
		}

	}

    return $input;
    
}
