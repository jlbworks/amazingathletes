<?php /*Template name: My appointments*/

$user = wp_get_current_user();

if (!is_user_logged_in()) {
	wp_redirect(site_url() . '/login');
}

global $wpdb;

$my_locations = get_posts(
	array(
		'post_type' => 'location',
		'post_status' => 'any',
		'posts_per_page' => -1,
		'author' => $user->ID,
	)
);

$my_location_ids = array();

foreach ($my_locations as $l) {
	$my_location_ids[] = $l->ID;
}

$sql = "SELECT DISTINCT 
  p.post_title as location_name
, pivot. location_id
, pivot.class_id
, pivot.submit_time
, pivot.child_first_name
, pivot.child_last_name
, pivot.child_birthday
, pivot.child_gender
, pivot.child_shirt_size
, pivot.child_classroom_teacher
, pivot.child_parent_name
, pivot.address
, pivot.state
, pivot.city
, pivot.zipcode
, pivot.primary_phone
, pivot.email
FROM (
	SELECT 
		  (SELECT field_value FROM amat_cf7dbplugin_submits aa WHERE field_name = 'location_id'         AND aa.submit_time = a.submit_time ) as location_id
        , (SELECT field_value FROM amat_cf7dbplugin_submits aa WHERE field_name = 'class_id' 			AND aa.submit_time = a.submit_time ) as class_id
        , (SELECT field_value FROM amat_cf7dbplugin_submits aa WHERE field_name = 'child-first-name' 	AND aa.submit_time = a.submit_time ) as child_first_name
        , (SELECT field_value FROM amat_cf7dbplugin_submits aa WHERE field_name = 'child-last-name' 	AND aa.submit_time = a.submit_time ) as child_last_name
        , (SELECT field_value FROM amat_cf7dbplugin_submits aa WHERE field_name = 'child-birthday' 		AND aa.submit_time = a.submit_time ) as child_birthday
        , (SELECT field_value FROM amat_cf7dbplugin_submits aa WHERE field_name = 'child-gender' 		AND aa.submit_time = a.submit_time ) as child_gender
        , (SELECT field_value FROM amat_cf7dbplugin_submits aa WHERE field_name = 'child-shirt-size' 	AND aa.submit_time = a.submit_time ) as child_shirt_size
        , (SELECT field_value FROM amat_cf7dbplugin_submits aa WHERE field_name = 'classroom-teacher' 	AND aa.submit_time = a.submit_time ) as child_classroom_teacher
        , (SELECT field_value FROM amat_cf7dbplugin_submits aa WHERE field_name = 'parent-name' 		AND aa.submit_time = a.submit_time ) as child_parent_name
        , (SELECT field_value FROM amat_cf7dbplugin_submits aa WHERE field_name = 'address' 			AND aa.submit_time = a.submit_time ) as address
        , (SELECT field_value FROM amat_cf7dbplugin_submits aa WHERE field_name = 'state' 				AND aa.submit_time = a.submit_time ) as state
        , (SELECT field_value FROM amat_cf7dbplugin_submits aa WHERE field_name = 'city' 				AND aa.submit_time = a.submit_time ) as city
        , (SELECT field_value FROM amat_cf7dbplugin_submits aa WHERE field_name = 'zipcode' 			AND aa.submit_time = a.submit_time ) as zipcode
        , (SELECT field_value FROM amat_cf7dbplugin_submits aa WHERE field_name = 'primary-phone' 		AND aa.submit_time = a.submit_time ) as primary_phone
        , (SELECT field_value FROM amat_cf7dbplugin_submits aa WHERE field_name = 'email' 				AND aa.submit_time = a.submit_time ) as email
        , a.submit_time        
	FROM amat_cf7dbplugin_submits a
	WHERE 1=1
) as pivot
INNER JOIN amat_posts p ON p.ID = pivot.location_id
WHERE location_id IN (".implode(', ', array_fill(0, count($my_location_ids), '%s')).")
ORDER BY submit_time DESC
";

$query = call_user_func_array(array($wpdb, 'prepare'), array_merge(array($sql), $my_location_ids));

$appointments = $wpdb->get_results($query);

get_header();
?>
<style type="text/css">
.table {
    border-collapse: collapse !important;
}
.table td,
.table th {
	background-color: #fff !important;
}
.table-bordered th,
.table-bordered td {
	border: 1px solid #ddd !important;
}
.table {
  width: 100%;
  max-width: 100%;
  margin-bottom: 20px;
}
.table > thead > tr > th,
.table > tbody > tr > th,
.table > tfoot > tr > th,
.table > thead > tr > td,
.table > tbody > tr > td,
.table > tfoot > tr > td {
  padding: 8px;
  line-height: 1.42857143;
  vertical-align: top;
  border-top: 1px solid #ddd;
}
.table > thead > tr > th {
  vertical-align: bottom;
  border-bottom: 2px solid #ddd;
}
.table > caption + thead > tr:first-child > th,
.table > colgroup + thead > tr:first-child > th,
.table > thead:first-child > tr:first-child > th,
.table > caption + thead > tr:first-child > td,
.table > colgroup + thead > tr:first-child > td,
.table > thead:first-child > tr:first-child > td {
  border-top: 0;
}
.table > tbody + tbody {
  border-top: 2px solid #ddd;
}
.table .table {
  background-color: #fff;
}
.table-bordered {
  border: 1px solid #ddd;
}
.table-bordered > thead > tr > th,
.table-bordered > tbody > tr > th,
.table-bordered > tfoot > tr > th,
.table-bordered > thead > tr > td,
.table-bordered > tbody > tr > td,
.table-bordered > tfoot > tr > td {
  border: 1px solid #ddd;
}
</style>
<div class="content " style="min-height: 758px;">
						<div class="content_inner  ">
											<div class="full_width">
	<div class="full_width_inner">
							
					<div class="two_columns_25_75 clearfix grid2">
						<div class="column1">	<div class="column_inner">
		<aside class="sidebar"><?php include 'includes/my-account-sidebar.php';  ?></aside>
	</div>
</div>
						<div class="column2">
																	<div class="column_inner">
							<div class="vc_row wpb_row section vc_row-fluid " style=" text-align:left;"><div class=" full_section_inner clearfix"><div class="wpb_column vc_column_container vc_col-sm-12"><div class="vc_column-inner "><div class="wpb_wrapper">	<div class="vc_empty_space" style="height: 50px"><span class="vc_empty_space_inner">
			<span class="empty_space_image"></span>
		</span></div>

<div class="qode_carousels_holder clearfix"><div class="qode_carousels" data-number-of-visible-items="4"><div class="caroufredsel_wrapper" style="display: block; text-align: left; float: none; position: relative; top: auto; right: auto; bottom: auto; left: auto; z-index: 0; width: 1407px; margin: 0px; overflow: hidden; cursor: move; height: 302px;"><ul class="slides" style="text-align: left; float: none; position: absolute; top: 0px; right: auto; bottom: auto; left: 0px; margin: 0px; width: 6097px; opacity: 1; z-index: 0;"><li class="item" style="width: 454px;"><div class="carousel_item_holder"><span class="first_image_holder "><img src="<?php echo site_url();?>/wp-content/uploads/2016/03/DSC_0295.jpg" alt="carousel image"></span></div></li><li class="item" style="width: 454px;"><div class="carousel_item_holder"><span class="first_image_holder "><img src="<?php echo site_url();?>/wp-content/uploads/2016/03/duck-walks-e1458854686480.jpg" alt="carousel image"></span></div></li><li class="item" style="width: 454px;"><div class="carousel_item_holder"><span class="first_image_holder "><img src="<?php echo site_url();?>/wp-content/uploads/2016/03/DSC_0652.jpg" alt="carousel image"></span></div></li><li class="item" style="width: 454px;"><div class="carousel_item_holder"><span class="first_image_holder "><img src="<?php echo site_url();?>/wp-content/uploads/2016/03/DSC_0375.jpg" alt="carousel image"></span></div></li><li class="item" style="width: 454px;"><div class="carousel_item_holder"><span class="first_image_holder "><img src="<?php echo site_url();?>/wp-content/uploads/2016/03/DSC_0238.jpg" alt="carousel image"></span></div></li></ul></div></div></div><div class="vc_row wpb_row section vc_row-fluid vc_inner " style=" text-align:left;"><div class=" full_section_inner clearfix"><div class="wpb_column vc_column_container vc_col-sm-12"><div class="vc_column-inner "><div class="wpb_wrapper">
	<!--<div class="wpb_text_column wpb_content_element  copy-child-page">-->
	<div class="">
		<div class="wpb_wrapper">
			<h1 class="entry-title" style="text-align: center;">My appointments</h1>
			<?php if (count($appointments) < 1): ?>
				<p>You have no appointments.</p>
			<?php else: ?>
			<table class="basic small table table-bordered" width="100%">
				<tbody>
					<tr>
						<th>Location</th>
						<th>Submitted on</th>
						<th>Child's Name</th>						
						<th>Birthday</th>
						<th>Gender</th>
						<th>Shirt Size</th>
						<th>Classroom Teacher</th>
						<th>Parent's Name</th>
						<th>Address</th>
						<th>State</th>
						<th>City</th>
						<th>Zipcode</th>
						<th>Primary Phone nr.</th>
						<th>Email</th>						
					</tr>
					<?php foreach ($appointments as $appointment): ?>
					<tr>
						<td><?php echo $appointment->location_name; ?></td>						
						<td><?php echo date('m/d/Y g:i a', $appointment->submit_time); ?></td>
						<td><?php echo "{$appointment->child_first_name} {$appointment->child_last_name}"; ?></td>
						<td><?php echo date('m/d/Y', strtotime($appointment->child_birthday)); ?></td>
						<td><?php echo $appointment->child_gender; ?></td>
						<td><?php echo $appointment->child_shirt_size; ?></td>
						<td><?php echo $appointment->child_classroom_teacher; ?></td>
						<td><?php echo $appointment->child_parent_name; ?></td>
						<td><?php echo $appointment->address; ?></td>
						<td><?php echo $appointment->state; ?></td>
						<td><?php echo $appointment->city; ?></td>
						<td><?php echo $appointment->zipcode; ?></td>
						<td><?php echo $appointment->primary_phone; ?></td>
						<td><?php echo $appointment->email; ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<?php endif; ?>
			
</div> 
	</div> 	<div class="vc_empty_space" style="height: 50px"><span class="vc_empty_space_inner">
			<span class="empty_space_image"></span>
		</span></div>

</div></div></div></div></div>
		
														 
							</div>
														
								
						</div>
						
					</div>
				</div>
	</div>	
			
	</div>
</div>

<!-- start:message -->
<div class="clearfix remodal remodal_user" id="remodal-message" data-remodal-id="message" >
	<button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	<div class="col-1">
		<h3 class="title">
		</h3>
		<div class="message">
		</div>
		<a href="#ok" class="button remodal-confirm" data-remodal-action="confirm">OK</a>
	</div>

</div>
<?php get_footer();