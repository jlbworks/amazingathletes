<?php
/*
 * CPT manager
 * All CPTs ( custom post types ) are administrated here
 */

add_action( 'init', 'am2_cpt' );

function am2_cpt() {


	$labels = array(
		'name'               => _x( 'Locations', 'post type general name' ),
		'singular_name'      => _x( 'Locations', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'Location' ),
		'add_new_item'       => __( 'Add New Location' ),
		'edit_item'          => __( 'Edit Location' ),
		'new_item'           => __( 'New Location' ),
		'view_item'          => __( 'View Location' ),
		'search_items'       => __( 'Search Locations' ),
		'not_found'          => __( 'No Locations found' ),
		'not_found_in_trash' => __( 'No Locations found in the trash' ),
		'parent_item_colon'  => '',
		'show_in_nav_menus'  => true
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'query_var'          => true,
		'has_archive'        => true,
		'rewrite'            => array( 'slug' => 'locations' ),
		'capability_type'    => 'post',
		'hierarchical'       => true,
		'menu_position'      => null,
		'supports'           => array( 'title', 'author', 'excerpt', 'thumbnail' ),
		'taxonomies'         => array( 'cities' )
	);

	register_post_type( 'news', $args );

}

?>