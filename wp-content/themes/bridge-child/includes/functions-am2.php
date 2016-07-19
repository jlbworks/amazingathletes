<?php 
add_action('wp_ajax_am2_ajax_get_postmeta', 'am2_ajax_get_postmeta');
add_action('wp_ajax_nopriv_am2_ajax_get_postmeta', 'am2_ajax_get_postmeta');

function am2_ajax_get_postmeta() {
	header('Content-Type: application/json');

	if(!isset($_POST['post_id'])) {
		echo json_encode(array('success'=>'false', 'status' => 'Please send the post_id'));
		exit();
	} 
	
	$post_id = $_POST['post_id'];

	$_postmeta = get_post_meta($post_id);
	$postmeta = array();

	foreach($_postmeta as $key => $_pm) {
		$postmeta[$key] = $_pm[0];
	}

	echo json_encode(array('success' => true, 'meta' => $postmeta));
	exit();
}

add_action('wp_ajax_am2_ajax_get_authormeta', 'am2_ajax_get_authormeta');
add_action('wp_ajax_nopriv_am2_ajax_get_authormeta', 'am2_ajax_get_authormeta');

function am2_ajax_get_authormeta() {
	header('Content-Type: application/json');

	if(!isset($_POST['post_id'])) {
		echo json_encode(array('success'=>'false', 'status' => 'Please send the post_id'));
		exit();
	} 

	$post_id = $_POST['post_id'];
	$user_id = get_post($post_id)->post_author;

	$_usermeta = get_user_meta($user_id);
	$usermeta = array();

	foreach($_usermeta as $key => $_um) {
		$usermeta[$key] = $_um[0];
	}

	echo json_encode(array('success' => true, 'meta' => $usermeta));
	exit();
}
?>