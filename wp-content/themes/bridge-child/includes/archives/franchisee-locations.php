<?php
$user = wp_get_current_user();

$args = array(
		'post_type' 		=> 'location',
		'post_status' 		=> 'any',
		'posts_per_page' 	=> -1,
		'author' 			=> $curauth->ID,
	);

if(isset($_GET['type'])){
	$slugs = array(
		'community-classes' => 'Community classes',
		'on-site' => 'On-site classes',
	);

	$args['meta_query'][] = array(
		'key'		=> 'location_type',
		'value'		=> $slugs[$_GET['type']],
		'compare'	=> '=',
	);
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
		)
	)
);



$classes = get_posts($args);

$location_class = array();

foreach ($classes as $c) {
	$location_class[$c->location_id][] = $c;
}

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
			<a><?php echo get_the_title( $loc->ID );?></a>
			<div class="franchise_details">
				<span class="franchise_address"><?php echo implode(",", array(get_post_meta($loc->ID, 'address',true), $city_state[1], $city_state[0], get_post_meta($loc->ID, 'zip', true)));?></span><br/>
				<?php if (isset($location_class[$loc->ID])): ?>
				<?php foreach($location_class[$loc->ID] as $loc_class) { ?>
				<a href="<?php echo site_url()."/register/?location_id=$loc->ID&class_id=$loc_class->ID"; ?>" class="franchise_register"><?php echo (!empty(get_post_meta($loc_class->ID, 'special_event_title', true)) ? get_post_meta($loc_class->ID, 'special_event_title', true) : get_the_title($loc_class->ID) ); ?></a><br/>
				<?php } ?>
				<?php endif; ?>
				<span class="franchise_name"><?php echo (isset($meta_franchisee['franchise_name']) ? $meta_franchisee['franchise_name'] : '');?></span><br/>
				<span class="franchise_footer"><?php echo implode("", array(get_post_meta($loc->ID, 'director', true), ' | ', get_post_meta($loc->ID, 'telephone', true) ) );?></span><br/>
			</div>
		</li>
<?php
	endforeach; ?>
	</ul>
</div>
