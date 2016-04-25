<?php

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

add_action('wp_ajax_am2_franchisee_account', 'am2_franchisee_account');
//add_action('wp_ajax_nopriv_am2_franchisee_account', 'am2_franchisee_account');

function am2_franchisee_account() {
	/*if (!isset($_POST['user_id']) || empty($_POST['user_id'])) {
		return;
	} else {
		$user_id = $_POST['user_id'];
	}*/
	$user = wp_get_current_user();
	$user_id = $user->ID;

	$fields = array('franchise_name' => 'franchise_name', 'franchise_owner' => 'owners', 'franchise_address' => 'mailing_address', 'franchise_zip' => 'zip_code', 'franchise_telephone' => 'telephone', 'franchise_fax' => 'fax', 'franchise_email' => 'email_address', 'franchise_aaemail' => 'aa_email_address', 'franchise_website' => 'website_address', 'franchise_market' => 'market_area', 'franchise_facebook' => 'facebook_page', 'franchise_youtube' => 'youtube_page', 'franchise_twitter' => 'twitter_page', 'franchise_pinterest' => 'pinterest_page', 'franchise_city_state' => 'city__state', 'password' => 'password' );

	$required_fields = array('franchise_name', 'franchise_owner', 'franchise_address', 'franchise_city_state', 'franchise_zip', 'franchise_telephone', 'franchise_email');

	foreach ($fields as $post_key => $meta_key) {
		if($post_key == 'password' && isset($_POST[$post_key]) && !empty($_POST[$post_key]) && isset($_POST['password2']) && !empty($_POST['password2'])){
			if($_POST['password'] === $_POST['password2']) {
				wp_update_user(array(
					'ID' => $user_id,
					'user_pass' => $_POST[$post_key],				
					)
				);
			}			
		}	
		else if($post_key == 'franchise_email' && isset($_POST[$post_key]) && !empty($_POST[$post_key])){
			wp_update_user(array(
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

	echo "Your profile was successfully saved.";
	exit();

}

add_action('wp_ajax_am2_user_account', 'am2_user_account');
//add_action('wp_ajax_nopriv_am2_user_account', 'am2_user_account');

function am2_user_account() {
	/*if (!isset($_POST['user_id']) || empty($_POST['user_id'])) {
		return;
	} else {
		$user_id = $_POST['user_id'];
	}*/
	$user = wp_get_current_user();
	$user_id = $user->ID;

	$fields = array('first_name' => 'first_name', 'last_name' => 'last_name', 'email' => 'email', 'password' => 'password',  );

	$required_fields = array('name', 'email');

	foreach ($fields as $post_key => $meta_key) {
		if($post_key == 'password' && isset($_POST[$post_key]) && !empty($_POST[$post_key]) && isset($_POST['password2']) && !empty($_POST['password2'])){
			if($_POST['password'] === $_POST['password2']) {
				wp_update_user(array(
					'ID' => $user_id,
					'user_pass' => $_POST[$post_key],				
					)
				);
			}			
		}	
		else if($post_key == 'email' && isset($_POST[$post_key]) && !empty($_POST[$post_key])){
			wp_update_user(array(
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

	echo "Your profile was successfully saved.";
	exit();

}



// UPLOAD SLIKA AJAX HANDLER /****USER AVATAR****/
add_action('wp_ajax_upload_franchise_photo', 'upload_franchise_photo');
//for none logged-in users
//add_action('wp_ajax_nopriv_orders_upload_action', 'orders_upload_action');
function upload_franchise_photo(){
	
 	require_once($_SERVER['DOCUMENT_ROOT']. '/wp-load.php');
    include_once($_SERVER['DOCUMENT_ROOT']. '/wp-admin/includes/media.php');
    include_once($_SERVER['DOCUMENT_ROOT']. '/wp-admin/includes/file.php');
    include_once($_SERVER['DOCUMENT_ROOT']. '/wp-admin/includes/image.php');
	
	
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
	$attach_url = wp_get_attachment_image_src( $attach_id, 'thumbnail' );
	//update_user_meta($_POST['user_id'],$_POST['field'],$attach_id);
	
	global $current_user;
	update_user_meta($current_user->ID,'franchisee_photo',$attach_id);
	
	$response['data'] = $_FILES;
	$response['success'] = 'true';
   	$response['file_id'] = $attach_id;
	$response['file_url'] = $attach_url[0];
	$response['file_name'] = basename($files['name']);
   
    echo json_encode($response);
    exit();
}
// END UPLOAD SLIKA

// Funkcija kojom brišemo slike spremljene u meta fieldove!
function ajax_delete_field() {
	$attachmentid = $_POST['attachid'];
	wp_delete_attachment( $attachmentid, true ); // brišemo sliku
	global $current_user;
	
	delete_user_meta($current_user->ID, 'franchisee_photo', $attachmentid);
	
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
				'post_type' => 'locations',
				'post_status' => 'publish',
				'post_title' => $_POST['location_name'],
			)
		);
		$loc_verb = 'added';
	} else {
		$loc_id = $_POST['loc_id'];
		$loc_verb = 'edited';		
	}		

	$fields = array('location_type', 'location_name', 'address', 'city__state', 'zip', 'telephone', 'fax', 'email', 'website', 'director', 'latlng', 'coaches');

	$required_fields = array('location_type', 'location_name', 'address', 'city__state', 'zip', 'telephone', 'director');

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

	$user_id = wp_insert_user( $userdata ) ;

	//On success
	if ( ! is_wp_error( $user_id ) ) {
	    update_user_meta($user_id, 'first_name', $_POST['first_name']);
	    update_user_meta($user_id, 'last_name', $_POST['last_name']);
	    $status = 'success';
	} else {
		$status = 'error';
	}

	echo json_encode( array('status' => $status, 'user_id' => $user_id) );

	exit();
}
?>