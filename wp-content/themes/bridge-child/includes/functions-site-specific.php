<?php

/*
 * Code that is specific to this site only
 */


/*
if ( ! function_exists( 'unregister_post_type' ) ) :
function unregister_post_type( $post_type ) {
    global $wp_post_types; 
    if ( isset( $wp_post_types[ $post_type ] ) ) {
        unset( $wp_post_types[ $post_type ] );
        return true;
    }
    return false;
}
endif;

//add_action( 'init', 'am2_unregister_default_post_types' );
function am2_unregister_default_post_types(){
	unregister_post_type('post');
}

function pre_get_posts_function( $query ) {
    if ( $query->is_post_type_archive('faq') && $query->is_main_query() ) {
    	if(!empty($_GET['fs'])) {
    		$query->set( 's', $_GET['fs'] );
    	}
        $query->set( 'numberposts', -1 );
        $query->set( 'posts_per_page', -1 );
    }
    if ( $query->is_post_type_archive('news') && $query->is_main_query() ) {
        $query->set( 'numberposts', 11 );
        $query->set( 'posts_per_page', 11 );
    }
}
add_action( 'pre_get_posts', 'pre_get_posts_function' );
*/


add_action('wp_ajax_am2_filter_locations', 'am2_filter_locations');

add_action('wp_ajax_nopriv_am2_filter_locations', 'am2_filter_locations');


function am2_filter_locations(){
    global $wpdb;
	
	$state = isset($_REQUEST['am2_state']) ? $_REQUEST['am2_state'] : null;
	
	$franchise_name = isset($_REQUEST['franchise_name']) ? $_REQUEST['franchise_name'] : null;
	
	$zip_code = isset($_REQUEST['zip_code']) ? $_REQUEST['zip_code'] : null;
		
	$args = array(
	'post_type' => 'location',
	'post_status' => 'publish',
	'posts_per_page' => -1,
	'orderby' => 'title',
	'order' => 'ASC',
	//'	meta_query' => $meta_query,
    );

    $_locations = array();
    $meta_query = array();

    if(!empty($state)){
        $meta_query[] = array(
            'key' => 'city__state',
            'value' => "$state|",
            'compare' => 'LIKE',
        );
    }

    if(!empty($franchise_name)){
        $_franchisees = get_users(
            array(
                'meta_query' => array(
                    array(
                        'key' => 'franchise_name',
                        'value' => $franchise_name,
                        'compare' => 'LIKE',
                    )
                )
            )
        );

        $user_ids = array();

        foreach($_franchisees as $f){
            $user_ids[] = $f->ID;
        }

        $args['author__in'] = (!empty($user_ids) ? $user_ids : array(0)) ;
    }

    if(!empty($zip_code)){
        $meta_query[] = array(
            'key' => 'zip_areas',
            'value' => $zip_code,
            'compare' => 'LIKE',
        );
    }

    $args['meta_query'] = $meta_query;
    $_locations = get_posts($args);    

    //var_dump($_locations);

    $locations = array();

    foreach($_locations as $_loc){
        $meta = get_post_meta($_loc->ID);            
        $author_id = get_post_field( 'post_author', $_loc->ID );

        $author_name = get_user_by('ID', $author_id)->user_nicename;

        foreach($meta as $key => $val){
            $meta[$key] = $val[0];
        }

        $meta_franchisee = get_user_meta($author_id);        

        foreach($meta_franchisee as $key => $val){

            $meta_franchisee[$key] = $val[0];

            if ('session_tokens' == $key) {
                unset($meta_franchisee[$key]);
            }

            if ('page_content' == $key) {
                unset($meta_franchisee[$key]);
            }
        }

        $meta['post_title'] = get_the_title( $_loc->ID );
        $meta_franchisee['url'] = site_url() . '/franchisee/' . $author_name . '/about';

        $city = explode('|',$meta['city__state'])[1];
        $locations[$city][] = array('id' => $_loc->ID, 'meta' => $meta, 'url' => get_permalink( $_loc->ID ), 'meta_franchisee' => $meta_franchisee ) ;
    }

    header('Content-Type: application/json');
    echo json_encode($locations);
    exit();

}


add_action('wp_ajax_am2_get_state_locations', 'am2_get_state_locations');
add_action('wp_ajax_nopriv_am2_get_state_locations', 'am2_get_state_locations');

function am2_get_state_locations(){
    $state = isset($_REQUEST['am2_state']) ? $_REQUEST['am2_state'] : null;    

    $_locations = array();

    if(!empty($state)){
        $_locations = get_posts(array(
            'post_type' => 'location',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC',
            'meta_query' => array(
                array(
                    'key' => 'city__state',
                    'value' => "$state|",
                    'compare' => 'LIKE',
                )
            )
        ));
    }

    //var_dump($_locations);

    $locations = array();

    foreach($_locations as $_loc){
        $meta = get_post_meta($_loc->ID);            
        $author_id = get_post_field( 'post_author', $_loc->ID );

        $author_name = get_user_by('ID', $author_id)->user_nicename;

        foreach($meta as $key => $val){
            $meta[$key] = $val[0];
        }

        $meta_franchisee = get_user_meta($author_id);        

        foreach($meta_franchisee as $key => $val){

            $meta_franchisee[$key] = $val[0];

            if ('session_tokens' == $key) {
                unset($meta_franchisee[$key]);
            }

            if ('page_content' == $key) {
                unset($meta_franchisee[$key]);
            }
        }

        $meta['post_title'] = get_the_title( $_loc->ID );
        $meta_franchisee['url'] = site_url() . '/franchisee/' . $author_name . '/about';

        $city = explode('|',$meta['city__state'])[1];
        $locations[$city][] = array('id' => $_loc->ID, 'meta' => $meta, 'url' => get_permalink( $_loc->ID ), 'meta_franchisee' => $meta_franchisee ) ;
    }

    header('Content-Type: application/json');
    echo json_encode($locations);
    exit();
}

function change_author_permalinks() {    
    global $wp,$wp_rewrite,$wpdb;

    $wp->add_query_var('mypage');
    $wp->add_query_var('locations');

    $_franchises = $wpdb->get_results("SELECT wum.meta_value, wu.ID, wu.user_login FROM $wpdb->usermeta wum JOIN $wpdb->users wu ON wu.ID = wum.user_id WHERE wum.meta_key = 'franchise_slug' GROUP BY wu.ID");
    $franchises = array();
    foreach($_franchises as $_franchise){
        $franchises[$_franchise->meta_value] = $_franchise->user_login;        
        $wp_rewrite->add_rule('^'.$_franchise->meta_value.'/locations/?', 'index.php?author_name=' . $_franchise->user_login . '&locations=1', 'top');
        $wp_rewrite->add_rule('^'.$_franchise->meta_value.'/(.*)/?', 'index.php?author_name=' . $_franchise->user_login . '&mypage=$matches[1]', 'top');
        $wp_rewrite->add_rule('^'.$_franchise->meta_value.'/?', 'index.php?author_name=' . $_franchise->user_login, 'top');
    }    

    #$wp_rewrite->add_rule('^franchisee/(.*)/locations/?', 'index.php?author_name=$matches[1]&locations=1', 'top');    
    //$wp_rewrite->add_rule('^franchisee/(.*)/(.*)/?', 'index.php?author_name=$matches[1]&mypage=$matches[2]', 'top');    
    //$wp_rewrite->add_rule('^franchisee/(.*)/?', 'index.php?author_name=$matches[1]', 'top');    

    //$wp_rewrite->flush_rules(false);      
}

add_action('init','change_author_permalinks');

add_shortcode( 'GET_USER_EMAIL', 'get_user_email' );

function get_user_email($atts){
if(isset($_GET['location_id'])){
        $cur_user_id = get_post_field( 'post_author', $_GET['location_id'] );
    }
    else {
        $cur_user_id = get_current_user_id();
    }
    
    $a = shortcode_atts( array(
        'user_id' => $cur_user_id,
        // ...etc
    ), $atts );

    $user = get_user_by('ID', $a['user_id']);
    if(!empty($user))
        return $user->user_email;
    else 
        return "";
}

function rewrite_locations_states() {    
    global $wp,$wp_rewrite;
    $states = array("AL","AK","AZ","AR","CA","CO","CT","DE","FL","GA","HI","ID","IL","IN","IA","KS","KY","LA","ME","MD","MA","MI","MN","MS","MO","MT","NE","NV","NH","NJ","NM","NY","NC","ND","OH","OK","OR","PA","RI","SC","SD","TN","TX","UT","VT","VA","WA","WV","WI","WY");

    $wp->add_query_var('aa_state');    
        
    foreach($states as $state){
        $wp_rewrite->add_rule(strtolower($state). '$', 'index.php?pagename=locations&aa_state='.$state, 'top');   
    }    

    $wp_rewrite->add_rule('^locations/(.*)/?', 'index.php?pagename=locations&aa_state=$matches[1]', 'top');            
}

add_action('init','rewrite_locations_states');

if( function_exists('acf_add_options_page') ) {    
	
	acf_add_options_page(array(
		'page_title' 	=> 'Theme General Settings',
		'menu_title'	=> 'Theme Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Header Settings',
		'menu_title'	=> 'Header',
		'parent_slug'	=> 'theme-general-settings',
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Footer Settings',
		'menu_title'	=> 'Footer',
		'parent_slug'	=> 'theme-general-settings',
	));
	
}
?>