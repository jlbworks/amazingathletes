<?php
require_once( 'includes/functions-assets.php' );
require_once( 'includes/functions-cpt.php' );
require_once( 'includes/functions-thumbnails.php' );
require_once( 'includes/functions-taxonomies.php' );
require_once( 'includes/functions-tiny-MCE.php' );
require_once( 'includes/functions-menus.php' );
require_once( 'includes/functions-yoast.php' );
require_once( 'includes/functions-site-specific.php' );

// enqueue the child theme stylesheet

Function wp_schools_enqueue_scripts() {
wp_register_style( 'childstyle', get_stylesheet_directory_uri() . '/style.css'  );
wp_enqueue_style( 'childstyle' );
}
add_action( 'wp_enqueue_scripts', 'wp_schools_enqueue_scripts', 11);
