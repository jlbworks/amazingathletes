<?php
/*
 * Menu manager
 * All menus are administrated here
 */

if ( function_exists( 'acf_add_options_page' ) ) {
	acf_add_options_page();
	acf_add_options_sub_page( 'Client-Franchisee' );
	//acf_add_options_sub_page( 'Tracking codes' );
	//acf_add_options_sub_page( 'Footer' );
	//acf_add_options_sub_page( 'General Settings' );
	acf_add_options_sub_page( 'Admin Page Settings' );
}
/*
register_nav_menus( array(
		'main_menu'   => __( 'Main menu', 'Main menu' ),
		'footer_menu' => __( 'Footer menu', 'Footer menu' ),
	)
);

add_filter( 'wp_nav_menu_items', 'am2_search_menu_item', 10, 2 );
function am2_search_menu_item( $items, $args ) {
	if ( $args->theme_location == 'top_menu' ) {
		$items .= '<li class="hidden-mobile"><a href="#modal-search" rel="modal:open" class="js-button-search-toggler"><i class="fa fa-search"></i></a></li>';
	}

	return $items;
}
*/

?>