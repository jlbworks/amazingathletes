<?php /*Template name: Register Page*/
if (!isset($_GET['location_id']) and !isset($_GET['franchisee_id']) and !isset($_GET['class_id'])) {
	wp_redirect(get_site_url().'/map/');
}
$page_title 		= 'Register';
$show_register_form = true;
$show_classes 		= false;
$show_franchise_locations = false;

$location   = false;
$_locations = false;
$locations 	= array();
$classes 	= array();

if (isset($_GET['franchisee_id']) and !empty($_GET['franchisee_id'])) {
	$page_title 				= 'Choose a location';
	$show_register_form 		= false;
	$show_classes 				= false;
	$show_franchise_locations 	= true;
	$franchisee_id 				= (int) $_GET['franchisee_id'];
	$franchisee 				= get_userdata($franchisee_id);
	$franchisee_meta 			= get_user_meta($franchisee->ID);
}

if (isset($_GET['location_id']) and !empty($_GET['location_id'])) {
	
	$page_title 				= 'Choose a class';
	$show_register_form 		= false;
	$show_franchise_locations 	= false;
	$show_classes 				= true;

	$location 			= get_post($_GET['location_id']);
	$franchisee			= get_userdata($location->post_author);
	$franchisee_meta	= get_user_meta($franchisee->ID);
	$_locations[] 		= $location->ID;	
	
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
}

if (isset($_GET['class_id']) and !empty($_GET['class_id'])) {
	$show_register_form = true;
	$show_classes 		= false;
	$show_franchise_locations = false;
	$page_title = 'Register Now';
	$_class = get_post_meta();
	$classes_meta = get_post_meta((int) $_GET['class_id']);
}

get_header();
if (have_posts()) : while (have_posts()) : the_post();?>
<div class="content " style="min-height: 292px;">
	<div class="content_inner">
		<div class="title_outer title_without_animation" data-height="200">
			<div class="title title_size_small  position_left " style="height:200px;">
				<div class="image not_responsive"></div>
				<div class="title_holder" style="padding-top:39px;height:161px;">
					<div class="container">
						<div class="container_inner clearfix">
							<div class="title_subtitle_holder">
								<h1 style="text-align: center"><span><?php echo $page_title; ?></span></h1>								
								<?php if (isset($franchisee_meta['franchise_name'])): ?>
									<div style="text-align: center;"><span><?php echo am2_get_meta_value('franchise_name', $franchisee_meta); ?></span></div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	
		<div class="container">
			<div class="container_inner default_template_holder clearfix page_container_inner">														 							
			<?php 
				if (true === $show_franchise_locations)       	include 'includes/register_show_franchise_locations.php';
				if (true === $show_classes)       				include 'includes/register_for_class.php';				
				if (true === $show_register_form): ?>
					<table class="basic small" width="100%">
						<tbody>
							<tr>
								<th>Day</th>
								<th>Time</th>
								<th>Type</th>
								<th>Length</th>
								<th>Ages</th>								
							</tr>		
							<tr>
								<td><?php echo am2_get_meta_value('day', 	$classes_meta); ?></td>
								<td><?php echo am2_get_meta_value('time', 	$classes_meta); ?></td>
								<td><?php echo am2_get_meta_value('type', 	$classes_meta); ?></td>
								<td><?php echo am2_get_meta_value('length', $classes_meta); ?></td>
								<td><?php echo am2_get_meta_value('ages', 	$classes_meta); ?></td>								
							</tr>		
						</tbody>
					</table>
					<br>
			<?php 
				the_content(); 
				endif;
			?>
			</div>
		</div>			

	</div>
</div>
<?php endwhile; endif;
get_footer();