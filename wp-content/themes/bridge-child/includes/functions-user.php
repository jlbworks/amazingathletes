<?php

function am2_user_ajax_init() {
	wp_register_script('user-ajax-script', get_stylesheet_directory_uri() . '/js/user-ajax.js', array('jquery'));
	wp_enqueue_script('user-ajax-script');

	wp_localize_script('user-ajax-script', 'ajax_login_object', array(
		'ajaxurl' => admin_url('admin-ajax.php'),
	));
}

add_action('wp_enqueue_scripts', 'am2_user_ajax_init', 12);

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

		$redirect = site_url() . "/user-profile/";

		echo json_encode(array('loggedin' => true, 'message' => __("Welcome <span class='txt-blue'>" . $user->first_name . " " . $user->last_name . "</span>"), 'redirect' => $redirect));
	}

	exit();
}

add_action('wp_ajax_am2_franchisee_account', 'am2_franchisee_account');
add_action('wp_ajax_nopriv_am2_franchisee_account', 'am2_franchisee_account');

function am2_franchisee_account() {
	if (!isset($_POST['user_id']) || empty($_POST['user_id'])) {
		return;
	} else {
		$user_id = $_POST['user_id'];
	}

	$fields = array('franchise_name' => 'franchise_name', 'franchise_owner' => 'owners', 'franchise_address' => 'mailing_address', 'franchise_zip' => 'zip_code', 'franchise_telephone' => 'telephone', 'franchise_fax' => 'fax', 'franchise_email' => 'email_address', 'franchise_aaemail' => 'aa_email_address', 'franchise_website' => 'website_address', 'franchise_market' => 'market_area');

	foreach ($fields as $post_key => $meta_key) {
		if (isset($_POST[$post_key])) {
			update_user_meta($user_id, $meta_key, $_POST[$post_key]);
		}
	}

}
?>