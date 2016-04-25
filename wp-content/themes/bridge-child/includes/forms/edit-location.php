<?php
global $wpdb;
$loc_id = 0;
$city_state = array('', '');

if (!empty($_GET['loc_id'])) {
	$loc_id = $_GET['loc_id'];
	$pmeta = get_post_meta($loc_id); //, 'city__state',true);
	if (!empty($pmeta['city__state'][0])) {
		$city_state = explode('|', $pmeta['city__state'][0]);
	}

	$location = get_post($loc_id);
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
		<input type="text" name="location_name" maxlength="128" style="" value="<?php echo get_post_meta($loc_id, 'location_name', true); ?>" required><br/>

		<label>Address *</label>
		<input type="text" name="address" maxlength="128" style="" value="<?php echo get_post_meta($loc_id, 'address', true); ?>" required><br/>

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
			}
			?>
		</select><br/>

		<label>City *</label>
		<input type="text" name="city" required maxlength="128" style="" value="<?php echo $city_state[1]; ?>" class="am2_cc_city" required><br/>

		<input type="hidden" name="city__state" class="cc_city_state" required/>
		<input type="hidden" name="latlng" class="latlng" />

		<label>Zip *</label>
		<input type="text" name="zip" maxlength="10" size="10" value="<?php echo get_post_meta($loc_id, 'zip', true); ?>" required><br/>


		<label>Telephone *</label>
		<input type="text" name="telephone" maxlength="20" size="20" value="<?php echo get_post_meta($loc_id, 'telephone', true); ?>" required><br/>


		<label>Fax</label>
		<input type="text" name="fax" maxlength="20" size="20" value="<?php echo get_post_meta($loc_id, 'fax', true); ?>"><br/>


		<label>Email</label>
		<input type="text" name="email" maxlength="255" style="" value="<?php echo get_post_meta($loc_id, 'email', true); ?>"><br/>


		<label>Website</label>
		<input type="text" name="website" maxlength="255" style="" value="<?php echo get_post_meta($loc_id, 'website', true); ?>"><br/>


		<label>Director *</label>
		<input type="text" name="director" maxlength="128" style="" value="<?php echo get_post_meta($loc_id, 'director', true); ?>" required><br/>

		<label>Choose Coach</label>
		<select name="coaches[]"  placeholder="Select a coach..." class="am2_coaches" required style="" multiple="multiple">		
			<option value="">Select a coach...</option>
			<?php

			$coaches = get_users( array('role' => 'coach') ); 		
			$sel_coaches = get_post_meta($loc_id, 'coaches', true);

			if(!is_array($sel_coaches)) {
				$sel_coaches = array();
			}
			if (!empty($coaches)) {
				foreach ($coaches AS $coach) {?>
					<option <?php echo ( in_array( $coach->ID, $sel_coaches ) ? 'selected' : ''); ?> value="<?php echo $coach->ID; ?>"><?php echo implode(' ', array(get_user_meta($coach->ID, 'first_name', true), get_user_meta($coach->ID, 'last_name', true) ) ); ?></option>
				<?php }
			}
			?>
		</select>

		<a class="btn_toggle_add_coach">Add coach</a>
		<div class="hidden add_coach_wrap">
			<label>First name</label>
			<input type="text" id="first_name" /><br/>
			<label>Last name</label>
			<input type="text" id="last_name" /><br/>
			<label>Coach email</label>
			<input type="text" id="coach_email" /><br/>
			<a class="btn_add_coach">Add</a>
		</div><br/><br/>

		<?php /*<input type="hidden" name="user_id" value="<?php echo $user->ID; ?>"/>*/?>
		<input type="hidden" name="loc_id" value="<?php echo $loc_id; ?>"/>
		<input type="hidden" name="action" value="am2_edit_location" />

		<input type="submit" value="submit"/>
	</form>
</div>
<div id="map"></div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA4rcwbMAQu0UW62G-dQpZTlBcJXj-rMXE"></script>
<script>
var permalink = '<?php echo get_permalink(); ?>';
</script>
<?php }?>