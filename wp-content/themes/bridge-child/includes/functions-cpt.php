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
		'rewrite'            => array( 'slug' => 'locations-list' ),
		'capability_type'    => 'post',
		'hierarchical'       => true,
		'menu_position'      => null,
		'supports'           => array( 'title', 'author', 'excerpt', 'thumbnail' ),
		'taxonomies'         => array( 'cities' )
	);

	register_post_type( 'location', $args );

	$labels = array(
		'name'               => _x( 'Class', 'post type general name' ),
		'singular_name'      => _x( 'Classes', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'Class' ),
		'add_new_item'       => __( 'Add New Class' ),
		'edit_item'          => __( 'Edit Class' ),
		'new_item'           => __( 'New Class' ),
		'view_item'          => __( 'View Class' ),
		'search_items'       => __( 'Search Classes' ),
		'not_found'          => __( 'No Classes found' ),
		'not_found_in_trash' => __( 'No Classes found in the trash' ),
		'parent_item_colon'  => '',
		'show_in_nav_menus'  => true
	);

	$args = array(
		'labels'             => $labels,
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => false,
		'query_var'          => true,
		'has_archive'        => true,
		'rewrite'            => array( 'slug' => 'classes-list' ),
		'capability_type'    => 'post',
		'hierarchical'       => true,
		'menu_position'      => null,
		'supports'           => array( 'title', 'author', 'excerpt', 'thumbnail' ),
		//'taxonomies'         => array( 'cities' )
	);

	register_post_type( 'location_class', $args );

	/*$labels = array(
		'name'               => _x( 'Franchise pages', 'post type general name' ),
		'singular_name'      => _x( 'Franchise page', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'Franchise page' ),
		'add_new_item'       => __( 'Add New Franchise page' ),
		'edit_item'          => __( 'Edit Franchise page' ),
		'new_item'           => __( 'New Franchise page' ),
		'view_item'          => __( 'View Franchise page' ),
		'search_items'       => __( 'Search Franchise pages' ),
		'not_found'          => __( 'No Franchise pages found' ),
		'not_found_in_trash' => __( 'No Franchise pages found in the trash' ),
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
		'rewrite'            => array( 'slug' => 'franchise-pages' ),
		'capability_type'    => 'post',
		'hierarchical'       => true,
		'menu_position'      => null,
		'supports'           => array( 'title', 'author', 'excerpt', 'thumbnail' ),
		//'taxonomies'         => array( 'cities' )
	);

	register_post_type( 'franchise_page', $args );*/

}

?>