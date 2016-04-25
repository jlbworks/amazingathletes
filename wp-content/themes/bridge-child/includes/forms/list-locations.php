<?php
$locations = get_posts(
	array(
		'post_type' => 'location',
		'post_status' => 'any',
		'posts_per_page' => -1,
		'author' => $user->ID,
	)
);
?>
<div class="user_form">
	<button><a href="<?php the_permalink();?>?add">Add location</a></button>
<?php
echo "<ul>";
foreach ($locations as $location) {
	echo '<li><a href="' . get_permalink() . '?loc_id=' . $location->ID . '">' . $location->post_title . '</a></li>';
}
echo "</ul>";
?>
</div>