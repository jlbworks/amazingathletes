<?php
$location_id = (int) $_GET['location_id'];


if (empty($location_id)) {
	//echo "<script>window.location='".site_url()."/map/';</script>";
	wp_redirect(site_url() . '/map');
	exit();
}

$classes = get_posts(array(
	'post_type' 		=> 'location_class',
	'post_status' 		=> 'any',
	'posts_per_page' 	=> -1,		
	'meta_query' 		=> array(
		array(
			'key'	=> 'location_id',
			'value'	=> $location_id,
		)			
	)
));

get_header();
?>
<div style="margin-top: 100px">
<?php if(empty($classes)): ?>
<p>This location has no classes.</p>
<?php else: ?>
<table class="basic small" width="100%">
	<tbody>
		<tr>
			<th>Day</th>
			<th>Time</th>
			<th>Program</th>
			<th>Type</th>
			<th>Coach Pay scale</th>
			<th>Payment Information</th>
			<th>Length</th>
			<th>Ages</th>
			<th>Actions</th>
		</tr>
		<?php foreach ($classes as $c): 
			$classes_meta = get_post_meta($c->ID);					
		?>
		<tr>
			<td><?php echo am2_get_meta_value('day', 	$classes_meta); ?></td>
			<td><?php echo am2_get_meta_value('time', 	$classes_meta); ?></td>
			<td><?php echo am2_get_meta_value('program', 	$classes_meta); ?></td>
			<td><?php echo am2_get_meta_value('type', 	$classes_meta); ?></td>
			<td><?php echo am2_get_meta_value('coach_pay_scale', 	$classes_meta); ?></td>
			<td><?php echo am2_get_meta_value('class_paynent_information', 	$classes_meta); ?></td>
			<td><?php echo am2_get_meta_value('length', $classes_meta); ?></td>
			<td><?php echo am2_get_meta_value('ages', 	$classes_meta); ?></td>
			<td><a href="<?php echo site_url(); ?>/register/?location_id=<?php echo $location_id; ?>&class_id=<?php echo $c->ID; ?>">Register</a></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>
</div>

<?php get_footer();
