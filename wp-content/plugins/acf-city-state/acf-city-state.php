<?php

/*
Plugin Name: Advanced Custom Fields: City State
Plugin URI: PLUGIN_URL
Description: SHORT_DESCRIPTION
Version: 1.0.0
Author: AUTHOR_NAME
Author URI: AUTHOR_URL
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

// exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

// check if class already exists
if (!class_exists('acf_plugin_city_state')):

	class acf_plugin_city_state {

		/*
			*  __construct
			*
			*  This function will setup the class functionality
			*
			*  @type	function
			*  @date	17/02/2016
			*  @since	1.0.0
			*
			*  @param	n/a
			*  @return	n/a
		*/

		function __construct() {

			// vars
			$this->settings = array(
				'version' => '1.0.0',
				'url' => plugin_dir_url(__FILE__),
				'path' => plugin_dir_path(__FILE__),
			);

			// set text domain
			// https://codex.wordpress.org/Function_Reference/load_plugin_textdomain
			load_plugin_textdomain('acf-city-state', false, plugin_basename(dirname(__FILE__)) . '/lang');

			// include field
			add_action('acf/include_field_types', array($this, 'include_field_types')); // v5
			add_action('acf/register_fields', array($this, 'include_field_types')); // v4

			register_activation_hook(__FILE__, array($this, 'activate'));
			register_deactivation_hook(__FILE__, array($this, 'deactivate'));

		}

		function activate() {
			require_once ABSPATH . 'wp-admin/includes/upgrade.php';

			//dbDelta(file_get_contents(dirname(__FILE__) . '/assets/sql/states.sql'));
			dbDelta(file_get_contents(dirname(__FILE__) . '/assets/sql/cities.sql'));
			dbDelta(file_get_contents(dirname(__FILE__) . '/assets/sql/states.sql'));
		}

		/*
			*  include_field_types
			*
			*  This function will include the field type class
			*
			*  @type	function
			*  @date	17/02/2016
			*  @since	1.0.0
			*
			*  @param	$version (int) major ACF version. Defaults to 4
			*  @return	n/a
		*/

		function include_field_types($version = 4) {

			// include
			include_once 'fields/acf-city-state-v' . $version . '.php';

		}

	}

// initialize
	new acf_plugin_city_state();

// class_exists check
endif;

?>