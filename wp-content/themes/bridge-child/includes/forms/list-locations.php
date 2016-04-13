<?php
	$locations = get_posts(
		array(
			'post_type' => 'locations',
			'post_status' => 'any',
			'posts_per_page' => -1,
		)
	);

	echo "<ul>";
	foreach($locations as $location) {
		echo '<li><a href="' . get_permalink() . '?loc_id='.$location->ID.'">'.$location->post_title.'</a></li>';
	}
	echo "</ul>";
?>