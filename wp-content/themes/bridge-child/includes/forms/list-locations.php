<?php
$user = wp_get_current_user();
$locations = get_posts(
	array(
		'post_type' => 'location',
		'post_status' => 'any',
		'posts_per_page' => -1,
		'author' => $user->ID,
		'orderby' => 'title',
		'order' => 'ASC',
	)
);
?>
<div class="my_account user_form">
<div style="text-align:center;">
	<a class="button" href="<?php the_permalink();?>?add">Add A Location</a>
</div>
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

			$class_dates = array();

			foreach($classes as $c){
				$date = get_class_date($c);
				$date = explode(' - ', $date);
				$date = explode('/', $date[0]);

				if(count($date)>1){
					$day = $date[1];
					$month = $date[0];
					$year = $date[2];

					$date = date('m/d/Y', strtotime(implode('/',array($month, $day, $year))));
				}
				else {
					$date = date('m/d/Y', strtotime($date[0]));
				}			

				$class_dates[$date . ' ' . $c->time] = $c;
			}

			ksort($class_dates);

			foreach($meta_franchisee as $key => $val){
				$meta_franchisee[$key] = $val[0];
			} ?>
			<li class="franchise">
				<h3>
					<span class="location_name"><?php echo get_the_title( $loc->ID );?>&nbsp;-&nbsp;<span class="franchise_address"><?php echo implode("-", array(get_post_meta($loc->ID, 'address',true)));?></span></span>					
					<br class="clear"/>
					<span class="edit-btn"><a href="<?php echo get_permalink() . '?loc_id=' . $loc->ID;?>">Edit</a></span>					
					<form id="frm_delete_location" data-form="frm_delete_location" action="<?php echo admin_url('admin-ajax.php') ?>" method="POST" >
						<input type="hidden" name="action" value="am2_delete_location">
						<input type="hidden" name="loc_id" value="<?php echo $loc->ID; ?>"/>
						<input class="delete-btn" type="submit" data-button="delete" value="Delete"/>
					</form>
					<br class="clear"/>					
				</h3>

					

				<ul class="franchise_details_visible">
				<?php foreach($class_dates as $c){?>
				<li class="class">
					<?php /*** when array_filter is called without second parameter it removes empty values from the array ***/?>
					<?php 
					$title = "{$c->program}";
					if(trim($c->special_event_title) != ''){
						$title .= ' - ' . $c->special_event_title;
					}
					?>					
					<a target="_blank" class="roster_link" href="<?php echo site_url() . '/amp/#roster/?f_class_id=' . $c->ID ;  ?>"><img src="<?php echo get_stylesheet_directory_uri();?>/img/roster.png" width="40px"/></a>
					<a href="?looc_id=<?php echo $loc->ID; ?>&class_id=<?php echo $c->ID; ?>&add-class=1"><?php echo implode(' - ', array_filter(array( get_class_date($c), $c->time, $title)) ); ?></a>
					<br class="clear"/>
				</li>
				<?php } ?>				
				<a class="add_class" href="<?php echo site_url();?>/my-account/locations/?looc_id=<?php echo $loc->ID;?>&add-class=1">+ Add a Class</a>
				</ul>
			</li>
	<?php
		endforeach; ?>
		</ul>		
	</div>
</div>
