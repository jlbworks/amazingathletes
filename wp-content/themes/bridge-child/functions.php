<?php
require_once 'includes/functions-assets.php';
require_once 'includes/functions-cpt.php';
require_once 'includes/functions-thumbnails.php';
require_once 'includes/functions-taxonomies.php';
require_once 'includes/functions-tiny-MCE.php';
require_once 'includes/functions-menus.php';
require_once 'includes/functions-yoast.php';
require_once 'includes/functions-site-specific.php';
require_once 'includes/functions-user.php';

function am2_has_role($user, $role) {

	if (!empty($user->roles) && is_array($user->roles)) {
		foreach ($user->roles as $role) {
			if ($role == $role) {	
				return true;
			}
		}
	}

	return false;
}

add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar() {
	// if user is franchisee don't show admin bar on front pages
	if (am2_has_role(wp_get_current_user(), 'franchisee')) {
	  show_admin_bar(false);
	}

}

// enqueue the child theme stylesheet
function wp_schools_enqueue_scripts() {

	wp_register_style('childstyle', get_stylesheet_directory_uri() . '/style.css');
	wp_enqueue_style('childstyle');

	wp_register_style('style-am2', get_stylesheet_directory_uri() . '/style-am2.css');
	wp_enqueue_style('style-am2');

	wp_register_script('jquery', get_stylesheet_directory_uri() . '/js/jquery-1.12.3.min.js');
	wp_enqueue_script('jquery');

	wp_register_script('jquery.validate', get_stylesheet_directory_uri() . '/js/jquery.validation/jquery.validate.min.js');
	wp_enqueue_script('jquery.validate');
}
add_action('wp_enqueue_scripts', 'wp_schools_enqueue_scripts', 11);

function am2_init() {
	global $wpdb;
	wp_register_style('selectize', get_stylesheet_directory_uri() . '/js/selectize/selectize.css');
	wp_enqueue_style('selectize');
	
	wp_register_style('svg', get_stylesheet_directory_uri() . '/js/svg/jquery.svg.css');
	wp_enqueue_style('svg');

	wp_register_style('selectize.default', get_stylesheet_directory_uri() . '/js/selectize/selectize.default.css');
	wp_enqueue_style('selectize.default');

	wp_register_style('remodal', get_stylesheet_directory_uri() . '/js/remodal/remodal.css');
	wp_enqueue_style('remodal');
	wp_register_style('remodal-default', get_stylesheet_directory_uri() . '/js/remodal/remodal-default-theme.css');
	wp_enqueue_style('remodal-default');

	wp_register_script('selectize', get_stylesheet_directory_uri() . '/js/selectize/selectize.min.js', array('jquery'));
	wp_enqueue_script('selectize');

	wp_register_script('remodal', get_stylesheet_directory_uri() . '/js/remodal/remodal.min.js');
	wp_enqueue_script('remodal');
	
	wp_register_script('jquery.form', get_stylesheet_directory_uri() . '/js/jquery.form.min.js');
	wp_enqueue_script('jquery.form');

	wp_register_script('fineuploader', get_stylesheet_directory_uri() . '/js/fineuploader.js');
	wp_enqueue_script('fineuploader');

	wp_register_script('svg', get_stylesheet_directory_uri() . '/js/svg/jquery.svg.min.js');
	wp_enqueue_script('svg');

	wp_register_script('am2_main', get_stylesheet_directory_uri() . '/js/am2_main.js' , array('jquery'), '', true);	
	wp_enqueue_script('am2_main');

	wp_register_script('jquery.timepicker', get_stylesheet_directory_uri() . '/js/jquery.timepicker.min.js' , array('jquery'), '', true);	
	wp_enqueue_script('jquery.timepicker');

	$states_db = $wpdb->get_results("SELECT DISTINCT * FROM states ORDER BY state ASC");
	wp_localize_script('am2_main', 'ajax_login_object', array(
		'ajaxurl' => admin_url('admin-ajax.php'),
		'site_url' => site_url(),
		'theme_url' => get_stylesheet_directory_uri(),
		'states' => $states_db,
		'aa_state' => get_query_var( 'aa_state' , '' )
	));
}

add_action('wp_enqueue_scripts', 'am2_init', 12);

add_action('wp_footer', 'am2_add_preloader');

function am2_add_preloader(){?>
	<div id="preloader_overlay">
	<div id="preloader_wrap">
	<div id="preloader_1">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
    </div>
    </div>
<?php }
?>
