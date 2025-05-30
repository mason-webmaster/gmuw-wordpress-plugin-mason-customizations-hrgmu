<?php

/**
 * Main plugin file for the Mason WordPress customizations plugin for the instance: hrgmu
 */

/**
 * Plugin Name:       Mason WordPress: Customizations Plugin: hrgmu
 * Author:            Mason Web Administration
 * Plugin URI:        https://github.com/mason-webmaster/gmuw-wordpress-plugin-mason-customizations-hrgmu
 * Description:       Mason WordPress Plugin to implement custom functionality for this website
 * Version:           1.0
 */


// Exit if this file is not called directly.
if (!defined('WPINC')) {
	die;
}

// Set up auto-updates
require 'plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
'https://github.com/mason-webmaster/gmuw-wordpress-plugin-mason-customizations-hrgmu/',
__FILE__,
'gmuw-wordpress-plugin-mason-customizations-hrgmu'
);


//redirect requests for certain URLs to login
add_action( 'wp', 'gmuw_customizations_hrgmu_restrict_access_to_fses_area', 3 );
function gmuw_customizations_hrgmu_restrict_access_to_fses_area(){

	//set regex for URLs for the faculty/staff experience survey to require a login
	//only matches URLs under the /faculty-staff-experience-survey/ path, not that page itself, which serves as a landing page
	$fses_url_regex='/^faculty-staff-experience-survey\/.+/i';

	//set login redirect url - will require a login which will redirect to the requested page
	$login_redirect_url=home_url() . '/wp-login.php?redirect_to=' . get_permalink();

	// Get current page URL slug
	global $wp;
	$current_slug = add_query_arg( array(), $wp->request );

	//is the requested URL one which matches our restriction criteria?
	if ( preg_match($fses_url_regex, $current_slug) ) {

	// is the user NOT logged in?
		if ( !is_user_logged_in() ) {
		
			//perform redirect to login page
			wp_redirect($login_redirect_url);
			exit;

		}

	}

}
