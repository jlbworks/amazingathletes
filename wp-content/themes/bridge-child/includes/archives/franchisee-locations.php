<?php
$locations = get_posts(
	array(
		'post_type' => 'location',
		'post_status' => 'publish',
		'posts_per_page' => -1
	)
);
?>
<div class="state">
	<ul class="locations">
	<?php 
	foreach ($locations as $key => $loc) { 
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
		}
	?>
		<li class="franchise">
			<a><?php echo get_the_title( $loc->ID );?></a>
			<div class="franchise_details">
				<span class="franchise_address"><?php echo implode(",", array(get_post_meta($loc->ID, 'address',true), $city_state[1], $city_state[0], get_post_meta($loc->ID, 'zip', true)));?></span><br/>
				<a class="h1 franchise_register">Register Now</a><br/>
				<span class="franchise_name"><?php echo (isset($meta_franchisee['franchise_name']) ? $meta_franchisee['franchise_name'] : '');?></span><br/>
				<span class="franchise_footer"><?php echo implode("", array(get_post_meta($loc->ID, 'director', true), ' | ', get_post_meta($loc->ID, 'telephone', true) ) );?></span><br/>
			</div>
		</li>
	<?php } ?>
	</ul>
</div>