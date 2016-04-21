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

// enqueue the child theme stylesheet

Function wp_schools_enqueue_scripts() {

	wp_register_style('childstyle', get_stylesheet_directory_uri() . '/style.css');
	wp_enqueue_style('childstyle');

	wp_register_script('jquery', get_stylesheet_directory_uri() . '/js/jquery-1.12.3.min.js');
	wp_enqueue_script('jquery');

	wp_register_script('jquery.validate', get_stylesheet_directory_uri() . '/js/jquery.validation/jquery.validate.min.js');
	wp_enqueue_script('jquery.validate');
}
add_action('wp_enqueue_scripts', 'wp_schools_enqueue_scripts', 11);

add_action('wp_footer', 'am2_add_preloader');

function am2_add_preloader(){?>
	<div id="preloader_wrap">
	<div id="preloader_1">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
    </div>
<?php }
