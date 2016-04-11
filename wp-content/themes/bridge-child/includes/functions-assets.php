<?php
/*
 * Assets manager
 * All assets ( styles and scripts ) are administrated here
 */
/*
function am2_enqueue_assets() {

	wp_register_style( 'style', get_bloginfo( 'template_directory' ) . '/style.css' );
	wp_enqueue_style( 'style' );

	wp_register_style( 'style-custom', get_bloginfo( 'template_directory' ) . '/css/custom.css' );
	wp_enqueue_style( 'style-custom' );

	wp_register_style( 'lightcase', get_bloginfo( 'template_directory' ) . '/css/lightcase.css' );
	wp_enqueue_style( 'lightcase' );


	wp_deregister_script( 'jquery' );

	wp_register_script( 'jquery', get_bloginfo( 'template_directory' ) . '/js/jquery.min.js', null, null, false );
	wp_enqueue_script( 'jquery' );

	wp_register_script( 'modernizr', get_bloginfo( 'template_directory' ) . '/js/modernizr.js', null, null, false );
	wp_enqueue_script( 'modernizr' );

	wp_register_script( 'jquery-tools', get_bloginfo( 'template_directory' ) . '/js/jquery.tools.min.js', null, null, true );
	wp_enqueue_script( 'jquery-tools' );

	wp_register_script( 'swipe', get_bloginfo( 'template_directory' ) . '/js/jquery.touchSwipe.min.js', null, null, true );
	wp_enqueue_script( 'swipe' );

	wp_register_script( 'slick', get_stylesheet_directory_uri() . '/js/slick.min.js', null, '1', true );
	wp_enqueue_script( 'slick' );
	
	wp_register_script( 'slimscroll', get_stylesheet_directory_uri() . '/js/jquery.slimscroll.js', null, '1', true );
	wp_enqueue_script( 'slimscroll' );

	wp_register_script( 'lightcase', get_stylesheet_directory_uri() . '/js/lightcase.js', null, '1', true );
	wp_enqueue_script( 'lightcase' );

	wp_register_script( 'owl.carousel.min.js', get_stylesheet_directory_uri() . '/js/owl.carousel.min.js', null, '1', true );
	wp_enqueue_script( 'owl.carousel.min.js' );

	

	//This is custom added, requires GeoIP Detection V2.6 or higher to be installed
	//wp_enqueue_script('geoip-detect-js');

	wp_register_script( 'functions', get_bloginfo( 'template_directory' ) . '/js/functions.js', null, null, true );
	wp_enqueue_script( 'functions' );

	wp_register_script( 'custom', get_stylesheet_directory_uri() . '/js/custom.js', null, '1', true );
	wp_enqueue_script( 'custom' );

}

if ( ! is_admin() ) {
	add_action( 'wp_enqueue_scripts', 'am2_enqueue_assets' );
}
*/
/*
 * You can add asset to admin panel in am2_enqueue_assets_admin function
 */
/*
function am2_enqueue_assets_admin() {

}

if ( is_admin() ) {
	add_action( 'wp_enqueue_scripts', 'am2_enqueue_assets_admin' );
}

if( function_exists( 'wpcf7_load_css' ) ) {
	add_filter( 'wpcf7_load_css', '__return_false' );
}
*/
/*
 *  enable svg images in media uploader
 */
/*
function cc_mime_types( $mimes ){
$mimes['svg'] = 'image/svg+xml';
return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );
*/
/*
 *  display svg images on media uploader and feature images
 */
/*
function fix_svg_thumb_display() {
  echo '<style> td.media-icon img[src$=".svg"], img[src$=".svg"].attachment-post-thumbnail { width: 100% !important; height: auto !important; } </style>';
}
add_action('admin_head', 'fix_svg_thumb_display');
*/
?>
