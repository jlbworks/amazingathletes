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

function get_next_date_by_weekday($weekday){	
     return date('Y-m-d', strtotime('next ' . $weekday ));
}

function get_class_date($c, $only_start_date = false) {
	$classes_meta = get_post_meta($c->ID);
	
	if($only_start_date){
		$day = am2_get_meta_value('day',         $classes_meta);
		$day = get_next_date_by_weekday($day);
	}
	else 
		$day = am2_get_meta_value('day',         $classes_meta);

	if (in_array($c->type, array('Camp','Demo'))) {
		if($only_start_date){
			$day = am2_get_meta_value('date', $classes_meta);
			$day = date('Y-m-d', strtotime($day));
		}
		else 
			$day = am2_get_meta_value('date', $classes_meta);
	}

	if ('Yearly' == $c->schedule_type) {
		$this_year = date('Y');
		$day = new DateTime(date("{$this_year}-m-d", strtotime("{$c->date_every_year}")));

		if($only_start_date){
			$day = $day->format('Y-m-d');
		}
		else
			$day = $day->format('m/d/Y');
	}

	if ('Session' == $c->type) {
		$date_start = am2_get_meta_value('date_start',     $classes_meta);
		$date_end    = am2_get_meta_value('date_end',     $classes_meta);

		if($only_start_date){
			$day = date('Y-m-d', strtotime("{$date_start}"));
		}
		else 
			$day = "{$date_start} - {$date_end}";
	}

	return $day;
}
?>