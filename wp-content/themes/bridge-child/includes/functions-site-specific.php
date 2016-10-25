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

add_action('wp_head','add_js_permalink_to_head');

function add_js_permalink_to_head() {

    $output="<script>var permalink = '".get_permalink()."';</script>";
    echo $output;

}

add_action('wp_ajax_am2_ajax_register_for_class', 'am2_ajax_register_for_class');
add_action('am2_register_for_class_complete', 'am2_insert_customer');

add_action('wp_ajax_nopriv_am2_ajax_register_for_class', 'am2_ajax_register_for_class');
add_action('am2_register_for_class_complete', 'am2_insert_customer');

function am2_ajax_register_for_class(){
    header('Content-Type: application/json');
    $response = array('success' => false);
   
    $location_id = $_POST['location_id'];
    $franchisee_id = get_post($location_id)->post_author;
    $franchisee = get_user_by('id', $franchisee_id);    

    $to = $franchisee->user_email;
    $from = 'web@jlbworks.com';
    $subject = 'Amazing Athletes registration';
    $reply_to = $_POST['email'];

    $message = 
    //'From: [parent-name] <[email]>
    'Child name: [child-first-name] [child-last-name]
    Birthday: [child-birthday]
    Gender: [child-gender]
    Shirt size: [child-shirt-size]
    Classroom/Teacher: [classroom-teacher]
    Parent name: [parent-name]
    Address: [address]
    State: [state]
    City: [city]
    ZIP: [zipcode]
    Phone: [primary-phone]
    Email: [email]
    Liability release: [liability]
    Photo release: [photo_release]
    Location ID: [location_id]
    Class ID: [class_id]
    Paid Tuition: [paid_tuition]

    Comments & Questions:
    [comments]

    --
    This e-mail was sent from a contact form on Amazing Athletes ('.site_url().')';

    function replace_with_postdata($match){
        //var_dump($match);
        if(!isset($_POST[$match[1]])) return '';
        return $_POST[$match[1]];
    }

    $message = preg_replace_callback('(\[([a-zA-Z0-9-_]+?)\])', "replace_with_postdata", $message );
    
    $headers  = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type: text/plain; charset=utf-8" . "\r\n";
    //$headers .= "Bcc: ivan.svaljek@am2studio.hr\r\n";

    $headers1 = $headers;
    $headers1 .= "Reply-To: <$reply_to>" . "\r\n";    
    
    $headers2 = $headers;
    $headers2 .= "Reply-To: <$to>" . "\r\n";     

    /*to franchisee*/
    $result1 = wp_mail($to, $subject, $message, $headers1);

    /*to parent*/
    $result2 = wp_mail($reply_to, $subject, $message, $headers2);

    $response['success'] = 'true';
    $response['paid_tuition'] = isset($_POST['paid_tuition']);

    if($response['success']){        
       do_action( 'am2_register_for_class_complete' ); 
    }   
    else {

    } 

    echo json_encode($response);
    exit();
}



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

        $author = get_user_by('ID', $author_id);

        $author_name = $author->user_nicename;
        $display_name = $author->display_name;

        foreach($meta as $key => $val){
            $meta[$key] = $val[0];
        }

        $_meta_franchisee = get_user_meta($author_id);    
        $meta_franchisee = array();    

        /*foreach($meta_franchisee as $key => $val){

            $meta_franchisee[$key] = $val[0];

            if ('session_tokens' == $key) {
                unset($meta_franchisee[$key]);
            }

            if ('page_content' == $key) {
                unset($meta_franchisee[$key]);
            }
        }*/

        $meta['post_title'] = get_the_title( $_loc->ID );
        $meta_franchisee['url'] = site_url() . '/franchisee/' . $author_name . '/about';
        $meta_franchisee['franchisee'] = $display_name;     
        $meta_franchisee['franchise_slug'] = $_meta_franchisee['franchise_slug'][0];
        $meta_franchisee['franchise_name'] = $_meta_franchisee['franchise_name'][0];      
        $meta_franchisee['franchise_phone'] = $_meta_franchisee['telephone'][0];
        $meta_franchisee['franchise_email'] = $_meta_franchisee['email_address'][0];
        $meta_franchisee['franchise_photo'] = wp_get_attachment_image_src( (int) $_meta_franchisee['user_photo'][0] , 'medium' )[0];


        $city = explode('|',$meta['city__state'])[1];
        $locations[$city][] = array('id' => $_loc->ID, 'meta' => $meta, 'url' => get_permalink( $_loc->ID ), 'meta_franchisee' => $meta_franchisee ) ;         
    }

    ksort($locations);

    header('Content-Type: application/json');
    echo json_encode($locations);
    exit();

    /*$locations = array();

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
    exit();*/

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

        $author = get_user_by('ID', $author_id);

        $author_name = $author->user_nicename;
        $display_name = $author->display_name;

        foreach($meta as $key => $val){
            $meta[$key] = $val[0];
        }

        $_meta_franchisee = get_user_meta($author_id);    
        $meta_franchisee = array();    

        /*foreach($meta_franchisee as $key => $val){

            $meta_franchisee[$key] = $val[0];

            if ('session_tokens' == $key) {
                unset($meta_franchisee[$key]);
            }

            if ('page_content' == $key) {
                unset($meta_franchisee[$key]);
            }
        }*/

        $meta['post_title'] = get_the_title( $_loc->ID );
        $meta_franchisee['url'] = site_url() . '/franchisee/' . $author_name . '/about';
        $meta_franchisee['franchisee'] = $display_name;     
        $meta_franchisee['franchise_slug'] = $_meta_franchisee['franchise_slug'][0];
        $meta_franchisee['franchise_name'] = $_meta_franchisee['franchise_name'][0];      
        $meta_franchisee['franchise_phone'] = $_meta_franchisee['telephone'][0];
        $meta_franchisee['franchise_email'] = $_meta_franchisee['email_address'][0];
        $meta_franchisee['franchise_photo'] = wp_get_attachment_image_src( (int) $_meta_franchisee['user_photo'][0] , 'medium' )[0];


        $city = explode('|',$meta['city__state'])[1];
        $locations[$city][] = array('id' => $_loc->ID, 'meta' => $meta, 'url' => get_permalink( $_loc->ID ), 'meta_franchisee' => $meta_franchisee ) ;         
    }

    ksort($locations);

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
        $wp_rewrite->add_rule('^'.$_franchise->meta_value.'$/?', 'index.php?author_name=' . $_franchise->user_login, 'top');
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
	));

    acf_add_options_page(array(
		'page_title' 	=> 'Programs description',
		'menu_title'	=> 'Programs description',
		'parent_slug' 	=> 'theme-general-settings',		
	));

    /*acf_add_options_page(array(
		'page_title' 	=> 'Notifications',
		'menu_title'	=> 'Notifications',
		'parent_slug' 	=> 'theme-general-settings',		
	));*/
	
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

function am2_acf_on_user_save( $post_id ) {
    global $wp_rewrite;
    
    // bail early if no ACF data
    if( empty($_POST['acf']) ) {
        return;
    }

    if(strpos($post_id,'user_') === 0){
        $franchise_slug = get_field('field_57d193970901e', $post_id);

        if(empty($franchise_slug)){
        // if(empty($_POST['acf']['field_579b7dbe732ee'])){            
            $field = $_POST['acf']['field_570b6ce0220d8'];
            //$franchise_slug = sanitize_title_with_dashes($field);
			//$_franchises = $wpdb->get_results("SELECT wum.meta_value, wu.ID, wu.user_login FROM $wpdb->usermeta wum JOIN $wpdb->users wu ON wu.ID = wum.user_id WHERE wu.ID != $user_id AND wum.meta_key = 'franchise_slug' AND wum.meta_value = '".$franchise_slug."' GROUP BY wu.ID");
            $field = sanitize_title_with_dashes($field);
            update_field('field_57d193970901e', $field, $post_id);                
        }

        change_author_permalinks();
        $wp_rewrite->flush_rules(false);

        // exit(); 
    }
}

// run before ACF saves the $_POST['acf'] data
add_action('acf/save_post', 'am2_acf_on_user_save', 99);


?>