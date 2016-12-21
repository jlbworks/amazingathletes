<?php
$user = wp_get_current_user();

$args = array(
		'post_type' 		=> 'location',
		'post_status' 		=> 'any',
		'posts_per_page' 	=> -1,
		'author' 			=> $curauth->ID,
		'orderby' => 'title',
		'order' => 'ASC',
	);

if(isset($_GET['type'])){	
	$slugs = array(
		'community-classes' => array('Open Enrollment', 'Special Event'),
		'on-site' => array('Member Only'),
	);

	$args['meta_query'][] = array(
		'key'		=> 'location_type',
		'value'		=> $slugs[$_GET['type']],
		'compare'	=> 'IN',
	);
}

if(!empty($_GET['city'])){
	$args['meta_query'][] = array( 'key' => 'city__state' , 'value' => '|' . $_GET['city'], 'compare' => 'LIKE' );
}

$locations = get_posts($args);

$_locations = array();

foreach ($locations as $l) {
	$_locations[$l->ID] = $l->ID;
}

$args = array(
	'post_type' 		=> 'location_class',
	'post_status' 		=> 'any',
	'posts_per_page' 	=> -1,
	'meta_query' 		=> array(
		array(
			'key'		=> 'location_id',
			'value'		=> array_values($_locations),
			'compare'	=> 'IN',
		),		
	),	

);

$classes = get_posts($args);

$location_class = array();

foreach ($classes as $c) {
	$location_class[$c->location_id][get_class_date($c,true). ' ' . $c->time] = $c;
}

 //var_dump($location_class);
 //var_dump(456456);
?>
<div class="state">
	<ul class="locations">
	<?php
	foreach ($locations as $key => $loc):
		$meta = get_post_meta($loc->ID);
		$franchisee = get_post_field( 'post_author', $loc->ID );
		$city_state = get_post_meta($loc->ID, 'city__state', true);
		$city_state = !empty($city_state) ? explode('|', $city_state) : array('','');		

		foreach($meta as $key => $val){
		    $meta[$key] = $val[0];
		}

		$meta_franchisee = get_user_meta($franchisee);

		foreach($meta_franchisee as $key => $val){
		    $meta_franchisee[$key] = $val[0];
		} ?>
		<li class="franchise">
			<a><b><?php echo get_the_title( $loc->ID );?></b> - <?php echo implode(" - ", array(get_post_meta($loc->ID, 'address',true), $city_state[1], $city_state[0], get_post_meta($loc->ID, 'zip', true)));?></a>
			<div class="franchise_details" style="display:none;">
				<span class="franchise_address"><?php echo implode(" - ", array(get_post_meta($loc->ID, 'address',true), $city_state[1], $city_state[0], get_post_meta($loc->ID, 'zip', true)));?></span><br/>
				<a class="h1 franchise_register" data-fancybox-type="iframe"  href="<?php echo site_url();?>/choose-class/?location_id=<?php echo $loc->ID;?>&iframe">Register Now</a><br/>
				<?php /* if (isset($location_class[$loc->ID])): ?>
				<?php krsort ($location_class[$loc->ID]);?>
				<?php foreach($location_class[$loc->ID] as $datetime => $loc_class) { ?>
				<a href="<?php echo site_url()."/register/?location_id=$loc->ID&class_id=$loc_class->ID"; ?>" class="franchise_register"><?php echo implode( ' - ', array_filter(array(date('m/d/Y', strtotime($datetime)), ($c->time), 
				(!empty($special_event_title) ? $special_event_title : get_the_title($loc_class->ID) ) ) ) ) ;?></a><br/>
				<?php } ?>
				<?php endif;*/ ?>
				<span class="franchise_name"><?php echo (isset($meta_franchisee['franchise_name']) ? $meta_franchisee['franchise_name'] : '');?></span><br/>
				<span class="franchise_footer"><?php echo implode("", array($meta_franchisee['display_name'], ' | ', $meta_franchisee['telephone'] ) );?></span><br/>
			</div>
		</li>
<?php
	endforeach; ?>
	</ul>
</div>

<script>
	(function($){
		$(document).ready(function(){
			$('a[data-fancybox-type="iframe"]').fancybox();
		});
	})(jQuery);
	
</script>
