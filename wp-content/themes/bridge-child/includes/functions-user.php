<?php
function am2_get_meta_value($key, $meta_data) {

    if(isset($meta_data[$key])) {

        if(isset($meta_data[$key][0])) {
            return $meta_data[$key][0];
        }

    }

    return false;
}

global $mypages;

$mypages = array(
	'Home' => '', 
	'About' => 'about', 
	'Program options' => 'programs', 
	'Classes' => array(
		'menu' => 'locations', 
		'submenu'=> array(
			'On-Site' => 'locations?type=on-site',
			'Community Classes' => 'locations?type=community-classes',
		),
	), 
	'Policies' => 'policies_and_procedures',
	'Staff' => 'staff', 
	'Contact' => 'contact',
	'Testimonials' => 'testimonials',
	'Blog' => 'blog',
	'Press' => 'press',
);

global $mypages_multi;

$mypages_multi = array(
	'testimonials',
	'blog',
	'press',
);

add_action('wp_ajax_am2_logout', 'am2_logout');

function am2_logout() {
	//check_ajax_referer( 'ajax-logout-nonce', 'ajaxsecurity' );
	wp_clear_auth_cookie();
	wp_logout();
	wp_set_current_user(0);

	echo 'adios!';
	exit();
}

add_action('wp_ajax_ajax_forgotPassword', 'ajax_forgotPassword');
add_action('wp_ajax_nopriv_ajax_forgotPassword', 'ajax_forgotPassword');

function ajax_forgotPassword() {
	header("Content-Type: application/json; charset=UTF-8");
	global $wpdb;

	$account = $_POST['forgot_password'];

	if (empty($account)) {
		$error = 'Please enter username or email.';
	} else {
		if (is_email($account)) {
			if (email_exists($account)) {
				$get_by = 'email';
			} else {
				$error = 'There is no account with that email address.';
			}

		} else if (validate_username($account)) {
			if (username_exists($account)) {
				$get_by = 'login';
			} else {
				$error = 'There is no account with that username.';
			}

		} else {
			$error = 'Invalid username or email address.';
		}

	}

	if (empty($error)) {
		// lets generate our new password
		//$random_password = wp_generate_password( 12, false );
		$random_password = wp_generate_password();

		// Get user data by field and data, fields are id, slug, email and login
		$user = get_user_by($get_by, $account);

		$update_user = wp_update_user(array('ID' => $user->ID, 'user_pass' => $random_password));

		// if  update user return true then lets send user an email containing the new password
		if ($update_user) {

			//$from = 'info@foxandb.com'; // Set whatever you want like mail@yourdomain.com

			if (!(isset($from) && is_email($from))) {
				$sitename = strtolower($_SERVER['SERVER_NAME']);
				if (substr($sitename, 0, 4) == 'www.') {
					$sitename = substr($sitename, 4);
				}
				$from = 'info@' . $sitename;
			}

			$to = $user->user_email;
			$subject = 'Your new password for ' . get_bloginfo('site_title');
			$sender = 'From: ' . get_option('blogname') . ' <' . $from . '>' . "\r\n";

			$message = 'Your new password is: ' . $random_password;

			$headers[] = 'MIME-Version: 1.0' . "\r\n";
			$headers[] = 'Content-type: text/plain; charset=utf-8' . "\r\n";
			$headers[] = "X-Mailer: PHP \r\n";
			$headers[] = $sender;

			$mail = wp_mail($to, $subject, $message, $headers);
			if ($mail) {
				$success = 'An email was sent to you regarding your registration details.';
			} else {
				$error = 'System failed to send you a new password.';
			}

		} else {
			$error = 'Oops! Something went wrong while we tried to update your account.';
		}
	}

	if (!empty($error)) {
		echo json_encode(array('success' => false, 'loggedin' => false, 'message' => __($error)));
	}

	if (!empty($success)) {
		echo json_encode(array('success' => true, 'loggedin' => false, 'message' => __($success)));
	}

	exit();
}

add_action('wp_ajax_nopriv_am2_login', 'am2_login');

function am2_login() {
	header("Content-Type: application/json; charset=UTF-8");

	// First check the nonce, if it fails the function will break
	//check_ajax_referer( 'ajax-login-nonce', 'security' );

	// Nonce is checked, get the POST data and sign user on
	$info = array();
	$info['user_login'] = $_POST['username'];
	$info['user_password'] = $_POST['password'];
	$info['remember'] = ($_POST['remember'] == 'on');

	$user_signon = wp_signon($info, false);

	if (is_wp_error($user_signon)) {
		echo json_encode(array('loggedin' => false, 'message' => __('Wrong username or password.')));
	} else {
		$user = get_user_by('login', $_POST['username']);
		/*wp_set_current_user($user->ID);
			wp_set_auth_cookie( $user->ID, true, false );
		*/

		$redirect = site_url() . "/my-account/";

		echo json_encode(array('loggedin' => true, 'message' => __("Welcome <span class='txt-blue'>" . $user->first_name . " " . $user->last_name . "</span>"), 'redirect' => $redirect));
	}

	exit();
}

add_action('wp_ajax_am2_user_password', 'am2_user_password');

function am2_user_password() {
	$user = wp_get_current_user();
	$user_id = $user->ID;

	if(isset($_POST['password']) && !empty($_POST['password']) && isset($_POST['password2']) && !empty($_POST['password2'])){
		if($_POST['password'] === $_POST['password2']) {
			$user_id = wp_update_user(array(
				'ID' => $user_id,
				'user_pass' => $_POST['password'],				
				)
			);
		}			

		if(!is_wp_error($user_id)) echo "Your password was successfully changed.";
		else echo $user_id->get_error_message();
	} else {
		echo "Please supply a password in both password fields";
	}		

	exit();
}

add_action('wp_ajax_am2_franchisee_account', 'am2_franchisee_account');

function am2_franchisee_account() {
	global $wpdb, $wp_rewrite;

	$user = wp_get_current_user();
	$user_id = $user->ID;

	$fields = array('franchise_name' => 'franchise_name', 'franchise_owner' => 'owners', 'franchise_address' => 'mailing_address', 'franchise_zip' => 'zip_code', 'franchise_telephone' => 'telephone', 'franchise_fax' => 'fax', 'franchise_email' => 'email_address', 'franchise_aaemail' => 'aa_email_address', 'franchise_website' => 'website_address', 'franchise_market' => 'market_area', 'franchise_facebook' => 'facebook_page', 'franchise_youtube' => 'youtube_page', 'franchise_twitter' => 'twitter_page', 'franchise_pinterest' => 'pinterest_page', 'franchise_city_state' => 'city__state', 'password' => 'password', 'video' => 'video' );

	$required_fields = array('franchise_name', 'franchise_owner', 'franchise_address', 'franchise_city_state', 'franchise_zip', 'franchise_telephone', 'franchise_email');

	$i=0;$j=0;
	foreach ($fields as $post_key => $meta_key) {
		if($post_key == 'franchise_email' && isset($_POST[$post_key]) && !empty($_POST[$post_key])){
			$user_id = wp_update_user(array(
					'ID' => $user_id,
					'user_email' => $_POST[$post_key],							
				)
			);
		}
		else if($post_key == 'franchise_name'){			
			$franchise_slug = sanitize_title_with_dashes($_POST[$post_key]);			
			$_franchises = $wpdb->get_results("SELECT wum.meta_value, wu.ID, wu.user_login FROM $wpdb->usermeta wum JOIN $wpdb->users wu ON wu.ID = wum.user_id WHERE wu.ID != $user_id AND wum.meta_key = 'franchise_slug' AND wum.meta_value = '".$franchise_slug."' GROUP BY wu.ID");

			if(is_array($_franchises) && count($_franchises) > 0 ) {
				echo "That franchise name is already taken";				
				exit();		
			}
			else {
				update_user_meta($user_id, $meta_key, $_POST[$post_key]);
				update_user_meta($user_id, 'franchise_slug', $franchise_slug);

				change_author_permalinks();
				$wp_rewrite->flush_rules(false); 
			}
		}
		else if (isset($_POST[$post_key]) && !empty($_POST[$post_key])) {
			update_user_meta($user_id, $meta_key, $_POST[$post_key]);
		} 
		else if(in_array($post_key, $required_fields)){
			echo "Field $post_key is required";			
			exit();
		}		
	}	 

	if(!is_wp_error( $user_id )){
		echo "Your profile was successfully saved.";	
	}
	else {
		echo $user_id->get_error_message();
	}
	
	exit();

}

add_action('wp_ajax_am2_user_account', 'am2_user_account');
//add_action('wp_ajax_nopriv_am2_user_account', 'am2_user_account');

function am2_user_account() {
	$user = wp_get_current_user();
	$user_id = $user->ID;

	$fields = array('first_name' => 'first_name', 'last_name' => 'last_name', 'email' => 'email', 'password' => 'password',  );

	$required_fields = array('first_name', 'last_name', 'email');

	foreach ($fields as $post_key => $meta_key) {
		if($post_key == 'password' && isset($_POST[$post_key]) && !empty($_POST[$post_key]) && isset($_POST['password2']) && !empty($_POST['password2'])){
			if($_POST['password'] === $_POST['password2']) {
				$user_id = wp_update_user(array(
					'ID' => $user_id,
					'user_pass' => $_POST[$post_key],				
					)
				);
			}			
		}	
		else if($post_key == 'email' && isset($_POST[$post_key]) && !empty($_POST[$post_key])){
			$user_id = wp_update_user(array(
					'ID' => $user_id,
					'user_email' => $_POST[$post_key],				
				)
			);
		}
		else if (isset($_POST[$post_key]) && !empty($_POST[$post_key])) {
			update_user_meta($user_id, $meta_key, $_POST[$post_key]);
		} 
		else if(in_array($post_key, $required_fields)){
			echo "Field $post_key is required";			
			exit();
		}		
	}

	if(!is_wp_error( $user_id )){
		echo "Your profile was successfully saved.";	
	}
	else {
		echo $user_id->get_error_message();
	}

	exit();

}



// UPLOAD SLIKA AJAX HANDLER /****USER AVATAR****/
add_action('wp_ajax_upload_user_photo', 'upload_user_photo');
//for none logged-in users
//add_action('wp_ajax_nopriv_orders_upload_action', 'orders_upload_action');
function upload_user_photo(){
	
 	require_once($_SERVER['DOCUMENT_ROOT']. '/wp-load.php');
    include_once($_SERVER['DOCUMENT_ROOT']. '/wp-admin/includes/media.php');
    include_once($_SERVER['DOCUMENT_ROOT']. '/wp-admin/includes/file.php');
    include_once($_SERVER['DOCUMENT_ROOT']. '/wp-admin/includes/image.php');

	global $current_user;

	$user = get_user_by('id', $_POST['user_id']);

	if(!$_FILES) exit();
	if(isset($_FILES['qqfile'])) {$files = $_FILES['qqfile'];}
	
	$upload_dir = wp_upload_dir();
	$file_name = $files['name'];
	$file_name = $upload_dir['path'] . '/' . basename($file_name);
	
	$upload_overrides = array( 'test_form' => false );
	$file_post = wp_handle_upload($files,$upload_overrides); //Posts File
	$file_link = $file_post['file'];
	$file_type = wp_check_filetype(basename($file_link), null); //File Extension
	$post_name = preg_replace('/.[^.]+$/', '', basename($file_link)); //Post Name
	$attachment = array(
		'guid' => $file_link,
		'post_mime_type' => $file_type['type'],
		'post_title' => $post_name,
		'post_content' => '',
		'post_status' => 'inherit'
	);
	$attach_id = wp_insert_attachment($attachment, $file_post['file']);
	$attach_data = wp_generate_attachment_metadata($attach_id, $file_post['file']);
	$attach_final = wp_update_attachment_metadata($attach_id, $attach_data);
	$attach_url = wp_get_attachment_image_src( $attach_id, 'medium' );
	//update_user_meta($_POST['user_id'],$_POST['field'],$attach_id);	

	if($user->ID == $current_user->ID || $user->franchisee == $current_user->ID){    	

		update_user_meta($user->ID ,'user_photo', $attach_id);

		$response['success'] = 'true';
		$response['file_id'] = $attach_id;
		$response['file_url'] = $attach_url[0];
		$response['file_name'] = basename($files['name']);
		$response['data'] = $_FILES;
	}
	else {
		$response['success'] = 'false';
		$response['file_id'] = $attach_id;
		$response['file_url'] = $attach_url[0];
		$response['file_name'] = basename($files['name']);
		$response['data'] = $_FILES;
	}	   	
   
    echo json_encode($response);
    exit();
}
// END UPLOAD SLIKA

// Funkcija kojom brišemo slike spremljene u meta fieldove!
function ajax_delete_field() {
	$attachmentid = $_POST['attachid'];
	wp_delete_attachment( $attachmentid, true ); // brišemo sliku
	global $current_user;

	$user = get_user_by('id', $_POST['user_id']);

	if($user->ID == $current_user->ID || $user->franchisee == $current_user->ID){	
		var_dump(delete_user_meta($user->ID, 'user_photo', $attachmentid));
	}
	
	exit();
}
add_action('wp_ajax_ajax_delete_field', 'ajax_delete_field');

add_action('wp_ajax_am2_edit_location', 'am2_edit_location');

function am2_edit_location() {
	$user = wp_get_current_user();
	$user_id = $user->ID;

	if (!isset($_POST['loc_id']) || empty($_POST['loc_id'])) {
		$loc_id = wp_insert_post(
			array(
				'post_type' => 'location',
				'post_status' => 'publish',
				'post_title' => $_POST['location_name'],							
			)
		);
		$loc_verb = 'added';
	} else {
		$loc_id = $_POST['loc_id'];
		$loc_verb = 'edited';		
	}		

	$fields = array('location_type', /*'location_name',*/ 'address', 'city__state', 'zip', 'zip_areas', 'telephone', 'fax', 'email', 'website', 'director', 'latlng', 'coaches');

	$required_fields = array('location_type', /*'location_name',*/ 'address', 'city__state', 'zip', 'telephone', 'director');

	foreach ($fields as $post_key) {
		if (isset($_POST[$post_key]) && !empty($_POST[$post_key])) {
			update_post_meta($loc_id, $post_key, $_POST[$post_key]);			
		} 
		else if(in_array($post_key, $required_fields)){
			echo "Field $post_key is required";			
			exit();
		}		
	}	

	header("Content-Type: application/json; charset=UTF-8");
	echo json_encode(array("message"=>"Your location was successfully $loc_verb.", "loc_id" => $loc_id));;	
	exit();

}


add_action('wp_ajax_am2_add_coach', 'am2_add_coach');

function am2_add_coach() {
	header("Content-Type: application/json; charset=UTF-8");	

	$userdata = array(
		'user_login'  =>  $_POST['coach_email'],
		'user_email'  => $_POST['coach_email'],	   
		'user_pass'   => wp_generate_password(),
		'role'		  => 'coach',
	);

	$location = get_post($_POST['loc_id']);

	$user_id = wp_insert_user( $userdata ) ;

	//On success
	if ( ! is_wp_error( $user_id ) ) {
	    update_user_meta($user_id, 'first_name', $_POST['first_name']);
	    update_user_meta($user_id, 'last_name', $_POST['last_name']);
		update_user_meta($user_id, 'franchisee', $location->post_author);
	    $status = 'success';
	} else {
		$status = 'error';
	}

	echo json_encode( array('status' => $status, 'user_id' => $user_id) );

	exit();
}

add_action('wp_ajax_am2_edit_staff', 'am2_edit_staff');

function am2_edit_staff() {
	$franchisee = get_current_user_id();
	header("Content-Type: application/json; charset=UTF-8");

	$user_id = $_POST['user_id']; // wp_update_post($userdata);		

	if(empty($user_id) || $user_id == 0){
		$userdata = array(
			'user_login'  =>  $_POST['coach_email'],
			'user_email'  => $_POST['coach_email'],	   
			'user_pass'   => wp_generate_password(),
			'role'		  => 'coach',
		);
		$user_id = wp_insert_user($userdata, true);
		//var_dump($user_id);
	}	

	//On success
	if ( ! is_wp_error( $user_id ) ) {
	    update_user_meta($user_id, 'first_name', $_POST['first_name']);
	    update_user_meta($user_id, 'last_name', $_POST['last_name']);
	    update_user_meta($user_id, 'description', $_POST['coach_description']);
		update_user_meta($user_id, 'user_photo', $_POST['attid']);
		update_user_meta($user_id, 'franchisee', get_current_user_id() );
		//update_user_meta($user_id, 'franchisee', $franchisee);
	    $status = 'success'; 
	} else {
		$status = 'error';
	}

	echo json_encode( array('status' => $status, 'user_id' => $user_id) );

	exit();
}

function am2_user_social($user_id=null){
$user_id = empty($user_id) ? get_current_user_id() : $user_id;

$facebook_url = get_user_meta($user_id, 'facebook_page', true);
$youtube_url = get_user_meta($user_id, 'youtube_page', true);
$twitter_url = get_user_meta($user_id, 'twitter_page', true);
$pinterest_url = get_user_meta($user_id, 'pinterest_page', true);

$facebook_url = !empty($facebook_url) ? $facebook_url : "https://www.facebook.com/AmazingAthletes/";
$youtube_url = !empty($youtube_url) ? $youtube_url : "https://www.facebook.com/AmazingAthletes/";
$twitter_url = !empty($twitter_url) ? $twitter_url : "https://twitter.com/AmazingAthlete";
$pinterest_url = !empty($pinterest_url) ? $pinterest_url : "https://www.pinterest.com/amazingathletes/";
?>


<div class="widget widget_text">			<div class="textwidget"><div class="vc_row wpb_row section vc_row-fluid " style=" text-align:left;"><div class=" full_section_inner clearfix"><div class="wpb_column vc_column_container vc_col-sm-12"><div class="vc_column-inner "><div class="wpb_wrapper"><span class="q_social_icon_holder circle_social" data-hover-background-color="#fad000" data-hover-color="#ffffff"><a href="<?php echo $facebook_url;?>" target="_self"><span class="fa-stack " style="background-color: #fd0000;"><i class="qode_icon_font_awesome fa fa-facebook " style="color: #ffffff;"></i></span></a></span><span class="q_social_icon_holder circle_social" data-hover-background-color="#fad000" data-hover-color="#ffffff"><a href="#" target="_self"><span class="fa-stack " style="background-color: #fd0000;"><i class="qode_icon_font_awesome fa fa-google-plus " style="color: #ffffff;"></i></span></a></span><span class="q_social_icon_holder circle_social" data-hover-background-color="#fad000" data-hover-color="#ffffff"><a href="#" target="_self"><span class="fa-stack " style="background-color: #fd0000;"><i class="qode_icon_font_awesome fa fa-instagram " style="color: #ffffff;"></i></span></a></span><span class="q_social_icon_holder circle_social" data-hover-background-color="#fad000" data-hover-color="#ffffff"><a href="<?php echo $pinterest_url;?>" target="_self"><span class="fa-stack " style="background-color: #fd0000;"><i class="qode_icon_font_awesome fa fa-pinterest " style="color: #ffffff;"></i></span></a></span><span class="q_social_icon_holder circle_social" data-hover-background-color="#fad000" data-hover-color="#ffffff"><a href="<?php echo $twitter_url;?>" target="_self"><span class="fa-stack " style="background-color: rgb(253, 0, 0);"><i class="qode_icon_font_awesome fa fa-twitter " style="color: #ffffff;color: rgb(255, 255, 255);"></i></span></a></span></div></div></div></div></div></div>
		</div>
<?php
}

function am2_franchisee_info(){
$user_id = get_current_user_id();
$user = wp_get_current_user();

$franchise_name = get_user_meta($user_id, 'franchise_name',true);
$email_address = $user->user_email; //get_user_meta($user_id, 'email_address',true);
$telephone = get_user_meta($user_id, 'telephone',true);
$address = get_user_meta($user_id, 'mailing_address', true);
$city_state = get_user_meta($user_id, 'city__state', true);
if(!empty($city_state)){
	$city_state = explode('|', $city_state);	
} else {
	$city_state = array("","");
}

$zip_code = get_user_meta($user_id, 'zip_code', true);
?>
<div class="widget widget_text">			
	<div class="textwidget">
		<div class="sidebar-text">
			<h3><?php echo $franchise_name;?></h3>
			<?php echo "$address, {$city_state[1]}, {$city_state[0]} $zip_code";?><br/>
			email: <a href="<?php echo $email_address;?>"><?php echo $email_address;?></a><br/>
			phone: <a href="<?php echo $telephone;?>"><?php echo $telephone;?></a><br/>
		</div>
	</div>
</div>
<?php 
}

add_action('wp_ajax_am2_edit_mypage', 'am2_edit_mypage');

function am2_edit_mypage() {
	global $mypages, $mypages_multi;

	$user_id = get_current_user_id();	
	$post_id = (isset($_POST['post_id']) ? $_POST['post_id'] : 0);
	$category = array_search ($_POST['mypage'], $mypages);

	if(!in_array($_POST['mypage'], $mypages_multi)){
		$page_content = get_user_meta($user_id, 'page_content', true); 
		if(!is_array($page_content)) $page_content = array();

		foreach($mypages as $key => $page) {			
			if($page == $_POST['mypage']){				
				$page_content[$page] = $_POST[$page];
				break;
			}			
		}

		update_user_meta($user_id, 'page_content', $page_content);
	}	
	else if(!empty($post_id)){
		$args = array(
			'ID' => $post_id,
			'post_content' => $_POST[$_POST['mypage']],			
		);

		wp_update_post($args);
	}
	else {
		$ctg_id = wp_insert_category( array('cat_name' => $category) );

		if(empty($ctg_id)){
			$ctg_id = get_term_by('name', $category, 'category')->term_id;
		}

		//var_dump($ctg_id);

		$args = array(			
			'post_title' => $_POST['mypage'], 
			'post_content' => $_POST[$_POST['mypage']],
			'post_category' => array($ctg_id) ,
			'post_status' => 'publish',
		);

		$post_id = wp_insert_post($args);
	}

	header("Content-Type: application/json; charset=UTF-8");	
	echo json_encode( array('status' => 'success', 'user_id' => $user_id, 'post_id' => $post_id) );

	exit();
}
?>