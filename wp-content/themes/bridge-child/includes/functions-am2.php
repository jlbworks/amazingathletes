<?php 
function custom_excerpt_length( $length ) {
	return 100;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

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

	if (in_array($c->datetype, array('dates'))) {
		if($only_start_date){
			$day = am2_get_meta_value('date', $classes_meta);
			$day = date('m/d/Y', strtotime($day));
		}
		else 
			$day = am2_get_meta_value('date', $classes_meta);
	}

	if ('Yearly' == $c->schedule_type) {
		$this_year = date('Y');
		$day = new DateTime(date("{$this_year}-m-d", strtotime("{$c->date_every_year}")));

		if($only_start_date){
			$day = $day->format('m/d/Y');
		}
		else
			$day = $day->format('m/d/Y');
	}

	if ('session' == $c->datetype) {
		$date_start = am2_get_meta_value('date_start',     $classes_meta);
		$date_end    = am2_get_meta_value('date_end',     $classes_meta);

		if($only_start_date){
			$day = date('m/d/Y', strtotime("{$date_start}"));
		}
		else 
			$day = "{$date_start} - {$date_end}";
	}

	return $day;
}

function am2_excerpt($text, $excerpt, $length)
{
    if ($excerpt) return $excerpt;

    $text = strip_shortcodes( $text );

    $text = apply_filters('the_content', $text);
    $text = str_replace(']]>', ']]&gt;', $text);
    $text = strip_tags($text);
    $excerpt_length = $length ? $length : apply_filters('excerpt_length', 45);
		
    $excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
    $words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
    if ( count($words) > $excerpt_length ) {
            array_pop($words);
            $text = implode(' ', $words);
            $text = $text . $excerpt_more;
    } else {
            $text = implode(' ', $words);
    }

    return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
}
?>