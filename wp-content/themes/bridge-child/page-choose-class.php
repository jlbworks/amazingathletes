<?php
$location_id = (int) $_GET['location_id'];
$location = get_post($location_id);


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

if(!isset($_GET['iframe'])) get_header(); else wp_head();
?>
<div style="background-color:#fff;" <?php if(!isset($_GET['iframe'])) {?> style="margin-top: 100px"<?php } ?>>
<?php if(empty($classes)): ?>
<p>This location has no classes.</p>
<?php else: ?>
<header class="registration_popup_header" style="">
<h4 >SELECT THE CLASS YOU WOULD LIKE TO REGISTER FOR</h4>
<a href="<?php echo '#' ;?>" class="location_name" ><?php echo $location->post_title; ?></a> | <span class="location_address"><?php echo $location->address; ?></span>
</header>
<table class="tbl_register_class basic small" width="100%" style="background-color:#fff;">
	<tbody>
		<tr>
			<!--<th>Class</th>-->
			<th>Day</th>
			<th>Time</th>
			<th>Program</th>
			<th>Ages</th>
			<th>Length</th>
			<?php /*<th>Type</th>
			<th>Coach Pay scale</th>
			<th>Payment Information</th>
			<th>Length</th>
			<th>Ages</th>*/?>
			<th>Actions</th>
		</tr>
		<?php foreach ($classes as $c):
			$classes_meta = get_post_meta($c->ID);
			$class_date = am2_get_meta_value('day', 	$classes_meta);
			$class_time = am2_get_meta_value('time', 	$classes_meta);
			$class_display_day = am2_get_meta_value('display_day', $classes_meta);
			$class_display_time = am2_get_meta_value('display_time', $classes_meta);
			$class_age_range = am2_get_meta_value('age_range', $classes_meta);
			$class_length = am2_get_meta_value('length', $classes_meta);

			/*$day = am2_get_meta_value('day', 		$classes_meta);

			if (in_array($c->type, array('Camp','Demo'))) {
				$day = am2_get_meta_value('date', $classes_meta);
			}

    		if ('Yearly' == $c->schedule_type) {
    			$this_year = date('Y');
        		$day = new DateTime(date("{$this_year}-m-d", strtotime("{$c->date_every_year}")));
        		$day = $day->format('m/d/Y');
    		}

    		if ('Session' == $c->type) {
    			$date_start = am2_get_meta_value('date_start', 	$classes_meta);
    			$date_end	= am2_get_meta_value('date_end', 	$classes_meta);
    			$day = "{$date_start} - {$date_end}";
    		}*/
			$day = get_class_date($c);
		?>
		<tr>
			<?php /*<td><?php echo (!empty($classes_meta['special_event_title'][0]) ? $classes_meta['special_event_title'][0] : get_the_title($c->ID) ); ?></td>*/?>
			<td><?php echo !empty($class_display_day) ? $class_display_day : $day;?></td>
			<td><?php echo !empty($class_display_time) ? $class_display_time : $class_time;?></td>
			<td><?php echo am2_get_meta_value('program', 	$classes_meta); ?></td>
			<td><?php echo $class_age_range;?></td>
			<td><?php echo $class_length;?></td>
			<?php /*<td><?php echo am2_get_meta_value('type', 	$classes_meta); ?></td>
			<td><?php echo am2_get_meta_value('coach_pay_scale', 	$classes_meta); ?></td>
			<td><?php echo am2_get_meta_value('class_paynent_information', 	$classes_meta); ?></td>
			<td><?php echo am2_get_meta_value('length', $classes_meta); ?></td>
			<td><?php echo am2_get_meta_value('ages', 	$classes_meta); ?></td>*/?>
			<td><a class="btn_register_class" target="_blank" href="<?php echo site_url(); ?>/register/?location_id=<?php echo $location_id; ?>&class_id=<?php echo $c->ID; ?>">Register</a></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>
</div>

<?php if(!isset($_GET['iframe'])) get_footer(); else wp_footer();

 if(isset($_GET['iframe'])) {?>
<script>
	/*(function($){
		$(document).ready(function(){
			$('a').on('click',function(e){
				e.preventDefault();
				top.location = $(this).attr('href');
				return;
			});
		});
	})(jQuery);	*/
</script>	
<?php } ?>