<?php
/**
 * AM2 Image function
 *
 * array $args dummy_width, dummy_height, image_id, image_size, return, override_alt
 *
 * string
 */
/*function am2_image( $args ) {

	if ( empty( $args['dummy_width'] ) || empty( $args['dummy_height'] ) ) {
		return false;
	}
	if ( empty( $args['image_size'] ) ) {
		$args['image_size'] = 'medium';
	}
	if ( empty( $args['return'] ) ) {
		$args['return'] = 'class';
	}
	if ( empty( $args['alt'] ) ) {
		$args['alt'] = get_post_meta( $args['image_id'], '_wp_attachment_image_alt', true );
	}

	$image_class   = null;
	$article_image = null;
	$html          = '';
	$article_image = wp_get_attachment_image_src( $args['image_id'], $args['image_size'] );

	if ( empty( $article_image ) ) {
		$article_image[0] = get_stylesheet_directory_uri() . '/images/no_image.png';
		$article_image[1] = 300;
		$article_image[2] = 200;
	}

	$dummy_ratio         = $args['dummy_width'] / $args['dummy_height'].PHP_EOL;
	$article_image_ratio = $article_image[1] / $article_image[2].PHP_EOL;

	if ( $article_image_ratio > $dummy_ratio ) {
		$image_class = 'taller';
	} else {
		$image_class = 'wider';
	}

	//RETURNING HTML OR CSS CLASS
	if ( $args['return'] == 'class' ) {
		return $image_class;
	} elseif ( $args['return'] == 'html' ) {
		//$html .= '<div class="am2--image__holder">';
		$html .= '<img src="data:image/png;base64,'.am2_generate_base64_dummy( $args['dummy_width'], $args['dummy_height'] ).'" class="dummy" width="' . $args['dummy_width'] . '" height="' . $args['dummy_height'] . '" alt="" />';
		//$html .= '<div class="real_img"><img src="' . $article_image[0] . '" class="' . $image_class . '" alt="' . $args['alt'] . '" width="' . $args['dummy_width'] . '" height="' . $args['dummy_height'] . '" /></div>';
		$html .= '<img src="' . $article_image[0] . '" class="real_img ' . $image_class . '" alt="' . $args['alt'] . '" width="' . $args['dummy_width'] . '" height="' . $args['dummy_height'] . '" />';
		//$html .= '</div>';

		return $html;
	}

	return null;

}

/**
 * Generate base64 dummy image
 *
 * $width, $height
 *
 * string
 */
/*function am2_generate_base64_dummy( $width, $height ) {

	$new_dummy = imagecreatetruecolor($width, $height);
	imageAlphaBlending($new_dummy, false);
	imageSaveAlpha($new_dummy, true);
	$dummy_source = imagecreatefrompng( realpath(dirname(__FILE__) . '/../images/dummy-source.png') );
	imagecopyresampled($new_dummy, $dummy_source, 0, 0, 0, 0, $width, $height, 10, 10);
	
	ob_start();
	imagepng($new_dummy);
	$imagedata = ob_get_clean();
	
	return base64_encode($imagedata);

}
*/
?>