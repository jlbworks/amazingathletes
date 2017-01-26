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
    <?php if(in_array('franchisee',$user->roles)): ?>
		<a class="button" href="<?php the_permalink();?>?add">Add Staff Member</a>
	<?php endif; ?>
<?php
echo "<ul>";
foreach ($staff as $member) {
	$member_name = $member->display_name;
	if(!empty($member->first_name) || !empty($member->last_name)) {
		$member_name = $member->first_name . ' ' . $member->last_name;
	}
	echo '<li><a href="' . get_permalink() . '?user_id=' . $member->ID . '">' . $member_name . '</a></li>';
}
echo "</ul>";
?>
</div>