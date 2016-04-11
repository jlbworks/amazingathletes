<?php
/*
 * YOAST manager
 * YOAST is administrated here
 */
/*
add_filter( 'wpseo_pre_analysis_post_content', 'am2_add_custom_to_yoast' );

function am2_add_custom_to_yoast( $content ) {
	global $post;
	$custom_content = null;
	$pid    = $post->ID;
	$custom = get_post_custom( $pid );
	unset( $custom['_yoast_wpseo_focuskw'] );
	// Don't count the keyword in the Yoast field!
	foreach ( $custom as $key => $value ) {
		if ( substr( $key, 0, 1 ) != '_' && substr( $value[0], - 1 ) != '}' && ! is_array( $value[0] ) && ! empty( $value[0] ) ) {
			$custom_content .= $value[0] . ' ';
		}
	}
	$content = $content . ' ' . $custom_content;

	return $content;
	remove_filter( 'wpseo_pre_analysis_post_content', 'add_custom_to_yoast' );
	// Don't let WP execute this twice

}
*/

?>