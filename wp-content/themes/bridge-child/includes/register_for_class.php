<?php
	$class_date = am2_get_meta_value('day', 	$classes_meta);
	$class_time = am2_get_meta_value('time', 	$classes_meta);
	$class_display_day = am2_get_meta_value('display_day', $classes_meta);
  	$class_display_time = am2_get_meta_value('display_time', $classes_meta);

?>
<div>
<?php if(empty($classes)): ?>
<p>This location has no classes.</p>
<?php else: ?>
<table class="basic small" width="100%">
	<tbody>
		<tr>
			<th>Day</th>
			<th>Time</th>
			<th>Program</th>
			<?php /*<th>Type</th>
			<th>Coach Pay scale</th>
			<th>Payment Information</th>
			<th>Length</th>
			<th>Ages</th>*/?>
			<th>Actions</th>
		</tr>
		<?php foreach ($classes as $c): 
			$classes_meta = get_post_meta($c->ID);					
		?>
		<tr>
			<td><?php echo !empty($class_display_day) ? $class_display_day : $class_date;?></td>
			<td><?php echo !empty($class_display_time) ? $class_display_time : $class_time;?></td>
			<td><?php echo am2_get_meta_value('program', 	$classes_meta); ?></td>
			<?php /*<td><?php echo am2_get_meta_value('type', 	$classes_meta); ?></td>
			<td><?php echo am2_get_meta_value('coach_pay_scale', 	$classes_meta); ?></td>
			<td><?php echo am2_get_meta_value('class_paynent_information', 	$classes_meta); ?></td>
			<td><?php echo am2_get_meta_value('length', $classes_meta); ?></td>
			<td><?php echo am2_get_meta_value('ages', 	$classes_meta); ?></td>*/ ?>
			<td><a href="<?php echo site_url(); ?>/register/?location_id=<?php echo $location->ID; ?>&class_id=<?php echo $c->ID; ?>">Register</a></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>
</div>