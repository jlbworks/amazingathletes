<?php
$user = wp_get_current_user();
$staff = get_users(
	array(
		'role' => 'coach',
		'meta_key' => 'franchisee',		
		'meta_value' => $user->ID,
	)
);

?>
<div class="user_form">
	<a class="button" href="<?php the_permalink();?>?add">Add Staff Member</a>
<?php
echo "<ul>";
foreach ($staff as $member) {
	echo '<li><a href="' . get_permalink() . '?user_id=' . $member->ID . '">' . $member->display_name . '</a></li>';
}
echo "</ul>";
?>
</div>