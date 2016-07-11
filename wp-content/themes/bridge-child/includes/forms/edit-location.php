<?php
global $wpdb;
$loc_id = 0;
$city_state = array('', '');

if (!empty($_GET['loc_id'])) {
	$loc_id = (int) $_GET['loc_id'];
	$pmeta = get_post_meta($loc_id);
	if (!empty($pmeta['city__state'][0])) {
		$city_state = explode('|', $pmeta['city__state'][0]);
	}

	$location = get_post($loc_id);

	$classes = get_posts(array(
		'post_type' 		=> 'location_class',
		'post_status' 		=> 'any',
		'posts_per_page' 	=> -1,
		'author' 			=> $user->ID,
		'meta_query' 		=> array(
			array(
				'key'	=> 'location_id',
				'value'	=> $location->ID,
			)
		)
	));
}

if ((!empty($location) && $location->post_author == $user->ID) || isset($_GET['add'])) { ?>

<div class="user_form">
	<a class="button" href="<?php the_permalink();?>">Back</a>
	<form id="frm_edit_location" action="<?php echo admin_url('admin-ajax.php') ?>" method="POST" >
		<label>Location Type *</label>
		<?php
		$field_key = "field_570b6ef56c895";
		$field = get_field_object($field_key);
		$location_type = get_post_meta($loc_id, 'location_type', true);

		if ($field) {
			echo '<select name="location_type" required>';
			foreach ($field['choices'] as $k => $v) {
				echo '<option ' . ($k == $location_type ? 'selected' : '') . ' value="' . $k . '">' . $v . '</option>';
			}
			echo '</select>';
		}?><br/>

		<label>Location Name *</label>
		<input type="text" name="location_name"  style="" value="<?php echo get_the_title($loc_id); ?>" required><br/>

		<div class="form--section">

			<h2>Location Address</h2>
			<label>Address *</label>
			<input type="text" name="address"  style="" value="<?php echo get_post_meta($loc_id, 'address', true); ?>" required><br/>

			<label>State *</label>
			<select name="state"  placeholder="Select a state..." class="am2_cc_state" required style="">
				<option value=""></option>
				<option value="">Select a state...</option>
				<?php
				$states_db = $wpdb->get_results("SELECT DISTINCT * FROM states ORDER BY state ASC");
				$states = array();
				if ($states_db) {
					foreach ($states_db AS $state) {?>
						<option <?php echo ($state->state_code == $city_state[0] ? 'selected' : ''); ?> value="<?php echo $state->state_code; ?>"><?php echo $state->state; ?></option>
						<?php }

				} ?>
			</select>

			<label>City *</label>
			<input type="text" name="city" required  style="" value="<?php echo $city_state[1]; ?>" class="am2_cc_city" required>

			<input type="hidden" name="city__state" class="cc_city_state" required/>
			<input type="hidden" name="latlng" class="latlng" />

			<label>Zip *</label>
			<input type="text" name="zip"  size="10" value="<?php echo get_post_meta($loc_id, 'zip', true); ?>" required><br/>
		</div>

		<label>Zip area covered</label>
		<input type="text" name="zip_areas"  size="10" value="<?php echo get_post_meta($loc_id, 'zip_areas', true); ?>" ><br/>
		<p class="helper-text--small">Please enter all zip codes covered by this location. This will be used in the front end locatons page where we allow customers to search by zip code.</p>

		<label>Director Email</label>
		<input type="text" name="email"  style="" value="<?php echo get_post_meta($loc_id, 'email', true); ?>"><br/>

		<label>Location Website</label>
		<input type="text" name="website"  style="" value="<?php echo get_post_meta($loc_id, 'website', true); ?>"><br/>

		<label>Location Contact Name *</label>
		<input type="text" name="location_contact_name"  style="" value="<?php echo get_post_meta($loc_id, 'location_contact_name', true); ?>" required><br/>

		<label>Location Contact Number *</label>
		<input type="text" name="location_contact_number"  size="20" value="<?php echo get_post_meta($loc_id, 'telephone', true); ?>" required><br/>

		<label>Enable Kickback</label>
		<?php $enable_kickback = get_post_meta($loc_id, 'enable_kickback', true) == 'yes';?>
		<label><input type="radio" name="enable_kickback"  style="" value="yes" <?php echo ($enable_kickback ? 'checked' : '' ) ?>>yes</label><label><input type="radio" name="enable_kickback"  style="" value="no" <?php echo (!$enable_kickback ? 'checked' : '' ) ?>>no</label><br/>

		<label>Kickback %</label>
		<input type="text" name="kickback"  style="" value="<?php echo get_post_meta($loc_id, 'kickback', true); ?>"><br/>

		<?php /*<input type="hidden" name="user_id" value="<?php echo $user->ID; ?>"/>*/?>
		<input type="hidden" name="loc_id" value="<?php echo $loc_id; ?>"/>
		<input type="hidden" name="action" value="am2_edit_location" />

		<input type="submit" value="Submit"/>
	</form>

<?php if(!empty($loc_id)) { ?>
	<hr>
	<br>
	<div>
		<h1 class="title-align">Classes</h1>
		<a href="?looc_id=<?php echo $loc_id; ?>&add-class=1" class="button add_new_class">Add new class</a>
		<?php if(empty($classes)): ?>
			<p>No classes found...</p>
		<?php else: ?>
		<table class="basic small" width="100%">
			<tbody>
				<tr>
					<th>Day</th>
					<th>Time</th>
					<th>Program</th>
					<th>Type</th>
					<th>Coach Pay scale</th>
					<th>Payment Information</th>
					<!--<th>Length</th>-->
					<th>Ages</th>
					<th>Actions</th>
				</tr>
				<?php foreach ($classes as $c):
					$classes_meta 	= get_post_meta($c->ID);
					$class_type 	= am2_get_meta_value('type',	$classes_meta);
					$has_date 		= array('Demo', 'Parent-Pay Session', 'Camp', 'Event');
					$has_day 		= array('Parent-Pay Monthly', 'Annual Contract');
					$when 			= '';

					if (in_array($class_type, $has_date)) {
						$when = am2_get_meta_value('date', 	$classes_meta);
					}

					if (in_array($class_type, $has_day)) {
						$when = am2_get_meta_value('day', 	$classes_meta);
					}

				?>
				<tr>
					<td><?php echo $when; ?></td>
					<td><?php echo am2_get_meta_value('time', 	$classes_meta); ?></td>
					<td><?php echo am2_get_meta_value('program', 	$classes_meta); ?></td>
					<td><?php echo am2_get_meta_value('type', 	$classes_meta); ?></td>
					<td><?php echo am2_get_meta_value('coach_pay_scale', 	$classes_meta); ?></td>
					<td><?php echo am2_get_meta_value('class_paynent_information', 	$classes_meta); ?></td>
					<!--<td><?php /*echo am2_get_meta_value('length', $classes_meta);*/ ?></td>-->
					<td><?php echo am2_get_meta_value('ages', 	$classes_meta); ?></td>
					<td><a href="?looc_id=<?php echo $loc_id; ?>&class_id=<?php echo $c->ID; ?>&add-class=1">Edit</a> <a href="?looc_id=<?php echo $loc_id; ?>&class_id=<?php echo $c->ID; ?>&add-class=1&confirm_delete=1">Delete</a></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php endif; ?>
	</div>
<?php } ?>

</div>
<div id="map"></div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA4rcwbMAQu0UW62G-dQpZTlBcJXj-rMXE"></script>

<?php }?>
