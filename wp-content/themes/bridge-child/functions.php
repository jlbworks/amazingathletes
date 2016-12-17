<?php


require_once 'includes/functions-am2.php';
require_once 'includes/functions-assets.php';
require_once 'includes/functions-cpt.php';
require_once 'includes/functions-thumbnails.php';
require_once 'includes/functions-taxonomies.php';
require_once 'includes/functions-tiny-MCE.php';
require_once 'includes/functions-menus.php';
require_once 'includes/functions-yoast.php';
require_once 'includes/functions-site-specific.php';
require_once 'includes/functions-user.php';
require_once 'includes/functions-globals.php';
// Include ERP functions
require_once( 'functions-erp.php' );

function am2_has_role($user, $role) {

	if (!empty($user->roles) && is_array($user->roles)) {
		foreach ($user->roles as $_role) {
			if ($_role == $role) {
				return true;
			}
		}
	}

	return false;
}

//add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar() {
	// if user is franchisee don't show admin bar on front pages
	if (am2_has_role(wp_get_current_user(), 'franchisee')) {
	  show_admin_bar(false);
	}

}

// enqueue the child theme stylesheet
function wp_schools_enqueue_scripts() {
	//wp_deregister_script( 'jquery' );
	//wp_deregister_script( 'jquery-migrate' );

	//wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js');
	//wp_register_script( 'jquery-migrate', 'https://code.jquery.com/jquery-migrate-1.3.0.js', array('jquery'));
	//wp_enqueue_script( 'jquery-migrate');

	wp_register_style('fancybox', get_stylesheet_directory_uri() . '/js/fancybox/jquery.fancybox.css');
	wp_enqueue_style('fancybox');

	wp_register_style('jquery-ui.structure', get_stylesheet_directory_uri() . '/js/jquery-ui-1.12.1.custom/jquery-ui.structure.css');
	wp_enqueue_style('jquery-ui.structure');
	wp_register_style('jquery-ui.css', get_stylesheet_directory_uri() . '/js/jquery-ui-1.12.1.custom/jquery-ui.css');
	wp_enqueue_style('jquery-ui.css');

	wp_register_style('childstyle', get_stylesheet_directory_uri() . '/style.css');
	wp_enqueue_style('childstyle');

	wp_register_style('style-am2', get_stylesheet_directory_uri() . '/style-am2.css', array(),1);
	wp_enqueue_style('style-am2');

	//wp_register_script('jquery', get_stylesheet_directory_uri() . '/js/jquery-1.12.3.min.js');
	//wp_enqueue_script('jquery');

	

}
add_action('wp_enqueue_scripts', 'wp_schools_enqueue_scripts', 11);

function am2_init() {
	global $wpdb, $possible_class_costs;

	wp_enqueue_script( 'wp-util' );

	/*wp_register_script('jquery-ui', get_stylesheet_directory_uri() . '/js/jquery-ui-1.12.1.custom/jquery-ui.min.js');
	wp_enqueue_script('jquery-ui');*/

	wp_register_script('jquery-ui.multidatespicker', get_stylesheet_directory_uri() . '/js/jquery-ui.multidatespicker.js');
	wp_enqueue_script('jquery-ui.multidatespicker',false, array('plugins'),false,true);	

	wp_register_script('jquery.validate', get_stylesheet_directory_uri() . '/js/jquery.validation/jquery.validate.min.js');
	wp_enqueue_script('jquery.validate');

	wp_register_script('fancybox', get_stylesheet_directory_uri() . '/js/fancybox/jquery.fancybox.pack.js');
	wp_enqueue_script('fancybox');
	
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

	wp_register_style('jquery.datetimepicker', get_stylesheet_directory_uri() . '/css/jquery.datetimepicker.css');
	wp_enqueue_style('jquery.datetimepicker');

	wp_register_style('fullcalendar', get_stylesheet_directory_uri() . '/js/fullcalendar.min.css');
	wp_enqueue_style('fullcalendar');

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

	wp_register_script('moment', get_stylesheet_directory_uri() . '/js/moment.min.js');
	wp_enqueue_script('moment');

	wp_register_script('fullcalendar', get_stylesheet_directory_uri() . '/js/fullcalendar.min.js' , array('jquery'));
	wp_enqueue_script('fullcalendar');	

	wp_register_script('jquery.timepicker', get_stylesheet_directory_uri() . '/js/jquery.timepicker.min.js' , array('jquery'), '', true);
	wp_enqueue_script('jquery.timepicker');

	wp_register_script('jquery.datepicker', get_stylesheet_directory_uri() . '/js/jquery.datetimepicker.min.js' , array('jquery'), '', true);	
	wp_enqueue_script('jquery.datepicker');

	wp_register_script('am2_main', get_stylesheet_directory_uri() . '/js/am2_main.js' , array('jquery'), 4, true);

	wp_localize_script('am2_main', 'am2_registration', array(		
		'possible_class_costs' => $possible_class_costs,
	));

	wp_enqueue_script('am2_main');

	$states_db = $wpdb->get_results("SELECT DISTINCT * FROM states ORDER BY state ASC");
	wp_localize_script('am2_main', 'ajax_login_object', array(
		'ajaxurl' => admin_url('admin-ajax.php'),
		'site_url' => site_url(),
		'theme_url' => get_stylesheet_directory_uri(),
		'states' => $states_db,
		'aa_state' => get_query_var( 'aa_state' , '' ),
	));
}

add_action('wp_enqueue_scripts', 'am2_init', 99,1);

add_action('wp_footer', 'am2_add_preloader');

function am2_add_preloader(){?>
	<div id="preloader_overlay" class="preloader_overlay">
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

add_action('wp_footer', function(){
	echo '<!-- page_template: ' . basename( get_page_template() ) . ' -->'; 
});

function am2_get_occurrences($_class) {
	require_once('includes/When/Valid.php');
    require_once('includes/When/When.php');

    $r = new When\When();

	if($_class->datetype == 'recurring'){
		if (date('l') == $_class->day) {
			$r->startDate(new DateTime(date('Y-m-d')));
		} else {
			$r->startDate(new DateTime(date('Y-m-d', strtotime("next {$_class->day}"))));
		}

		$r->count(365);

		if ('Weekly' === $_class->schedule_type) {
			$r->byday(substr($_class->day, 0, 2));
			$r->freq('weekly');
		}

		if ('Monthly' == $_class->schedule_type) {
			$r->startDate(new DateTime(date('Y-m-d', strtotime("{$_class->monthly_every} {$_class->day} of this month"))));        
			$r->count(365);
			$r->freq('monthly');
			$r->byday(substr($_class->day, 0, 2));      
			//$r->bymonthday(1);
		}

		if ('Yearly' == $_class->schedule_type) {
			$this_year = date('Y');
			$r->startDate(new DateTime(date("{$this_year}-m-d", strtotime("{$_class->date_every_year}"))));
			//$r->bymonthday(date('d', strtotime("{$_class->day}")));
			$r->count(10);
			$r->freq('yearly');
		}
	}    
	else {
		$r->startDate(new DateTime(date('Y-m-d', strtotime("{$_class->date_start}"))));
		$r->until(new DateTime(date('Y-m-d', strtotime("{$_class->date_end}"))));
		$r->freq('daily');
	}

    $r->generateOccurrences();

    $occurences = $r->occurrences;    

    return  $occurences;
}

function am2_is_top_role($role){
	global $current_user;
	global $aa_role_hierarchy;

	if(empty($role)){
		return false;
	}
	
	if(in_array($role, $current_user->roles) ){
		if(count($current_user->roles)<2){
			return true;
		}
		else {
			$pos = array_search($role, $aa_role_hierarchy);
			if( $pos === FALSE ) return false;

			foreach($current_user->roles as $_role){
				$r_pos = array_search($_role, $aa_role_hierarchy);

				if($r_pos !== FALSE && $r_pos < $pos) return false;				
			}

			return true;
		}		
	}		

	return false;
}

/*function am2_is_bottom_role($role){
	global $current_user;
	global $aa_role_hierarchy;

	if(empty($role)){
		return false;
	}
	
	if(in_array($role, $current_user->roles) ){
		if(count($current_user->roles)<2){
			return true;
		}
		else {
			$pos = array_search($role, $aa_role_hierarchy);
			
			if( $pos === FALSE || $pos < count($aa_role_hierarchy)-1 ) return false;
			else return true;
		}		
	}		

	return false;
}*/

function am2_is_single_role($role){
	global $current_user;

	if(empty($role)){
		return false;
	}
	
	if(count($current_user->roles)>1){
		return false;
	} 
	else if(in_array($role, $current_user->roles)){
		return true;
	}

	return false;
}

/*function am2_is_single_role($user,$role){
	if(empty($user) || empty($role)) return false;

	if(is_object($user)){
				
	}
	else if(is_integer($user)){
		$user = get_user_by('id',$user);
	}
	else
		return false;
	
	if(count($user->roles)>1){
		return false;
	} 
	else if(in_array($role, $user->roles)){
		return true;
	}

	return false;
}*/

/*
$users = get_users();

echo '<pre>';
foreach($users as $user){
	print_r($user->roles);
}
echo '</pre>';

exit();*/

?>