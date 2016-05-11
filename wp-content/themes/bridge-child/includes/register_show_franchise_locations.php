<?php
$locations = get_posts(
	array(
		'post_type' 		=> 'location',
		'post_status' 		=> 'any',
		'posts_per_page' 	=> -1,
		'author' 			=> $franchisee_id,
	)
);

$_locations = array();

foreach ($locations as $l) {
	$_locations[$l->ID] = $l->ID;
}

$classes = get_posts(array(
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
));

$location_class = array();

foreach ($classes as $c) {
	$location_class[$c->location_id] = $c->ID;
}

if (empty($locations) and empty($franchisee)): ?>
<strong>Invalid franchisee id.</strong>
<?php elseif (empty($locations) and !empty($franchisee)): ?>
<strong>There are no set locations for "<?php echo am2_get_meta_value('franchise_name', $franchisee_meta); ?>"</strong>
<?php else:
?>
<div class="state" style="display: block !important;">
	<ul class="locations" style="display: block !important;">
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
		<li class="franchise" style="display: block !important;">
			<a><?php echo get_the_title( $loc->ID );?></a>
			<div class="franchise_details" style="display: block !important;">
				<span class="franchise_address"><?php echo implode(",", array(get_post_meta($loc->ID, 'address',true), $city_state[1], $city_state[0], get_post_meta($loc->ID, 'zip', true)));?></span><br/>
				<?php if (isset($location_class[$loc->ID])): ?>
				<a href="<?php echo site_url()."/register/?location_id=$loc->ID"; ?>" class="h1 franchise_register">Register Now</a><br/>
				<?php endif; ?>
				<span class="franchise_name"><?php echo (isset($meta_franchisee['franchise_name']) ? $meta_franchisee['franchise_name'] : '');?></span><br/>
				<span class="franchise_footer"><?php echo implode("", array(get_post_meta($loc->ID, 'director', true), ' | ', get_post_meta($loc->ID, 'telephone', true) ) );?></span><br/>
			</div>
		</li>
<?php
	endforeach; ?>
	</ul>
</div>
<?php
endif;