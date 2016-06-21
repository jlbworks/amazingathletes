<?php
$user = wp_get_current_user();
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
	<a class="button" href="<?php the_permalink();?>?add">Add location</a>

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

			$classes = get_posts(array(
				'post_type' 		=> 'location_class',
				'post_status' 		=> 'any',
				'posts_per_page' 	=> -1,
				'author' 			=> $user->ID,
				'meta_query' 		=> array(
					array(
						'key'	=> 'location_id',
						'value'	=> $loc->ID,
					)			
				)
			));

			foreach($meta_franchisee as $key => $val){
				$meta_franchisee[$key] = $val[0];
			} ?>
			<li class="franchise">
				<a><?php echo get_the_title( $loc->ID );?>&nbsp;-&nbsp;<span class="franchise_address"><?php echo implode("-", array(get_post_meta($loc->ID, 'address',true)));?></span></a>
				<ul class="franchise_details">					
				<?php foreach($classes as $c){?>
				<li>
					<a href="?looc_id=<?php echo $loc->ID; ?>&class_id=<?php echo $c->ID; ?>&add-class=1"><?php echo implode(' - ', array($c->time, $c->day, $c->type) ); ?></a>
				</li>
				<?php } ?>
				</ul>
			</li>
	<?php
		endforeach; ?>
		</ul>
	</div>
</div>