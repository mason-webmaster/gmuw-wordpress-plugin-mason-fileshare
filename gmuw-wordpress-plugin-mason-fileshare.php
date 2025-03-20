<?php

/**
 * Main plugin file for the Mason WordPress: Fileshare
 */

/**
 * Plugin Name:       Mason WordPress: Fileshare
 * Author:            Mason Webmaster
 * Plugin URI:        https://github.com/mason-webmaster/gmuw-wordpress-plugin-mason-fileshare
 * Description:       Mason WordPress plugin which implements fileshare.
 * Version:           0.9
 */


// Exit if this file is not called directly.
	if (!defined('WPINC')) {
		die;
	}

// Set up auto-updates
	require 'plugin-update-checker/plugin-update-checker.php';
	$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/mason-webmaster/gmuw-wordpress-plugin-mason-fileshare/',
	__FILE__,
	'gmuw-wordpress-plugin-mason-fileshare'
	);


//plugin activation
require('php/activate-deactivate.php');

//admin menu
include('php/admin-menu.php');

//admin page
include('php/admin-page.php');

//dashboard
include('php/dashboard.php');

//email
include('php/email.php');

//file sharing
include('php/fileshare.php');

//icons
include('php/icons.php');

//permissions
require('php/permissions.php');

//scripts
include('php/scripts.php');

//settings
include('php/settings.php');

//styles
include('php/styles.php');

//taxonomy
include('php/taxonomy.php');

//users
include('php/users.php');

// custom URL handling
include('php/custom-urls.php');


//register activation hook
register_activation_hook(__FILE__, 'gmuw_fs_plugin_activate');

//register deactivation hook
register_deactivation_hook(__FILE__, 'gmuw_fs_plugin_deactivate');