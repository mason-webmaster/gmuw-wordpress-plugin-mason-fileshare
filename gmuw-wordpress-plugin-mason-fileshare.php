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
