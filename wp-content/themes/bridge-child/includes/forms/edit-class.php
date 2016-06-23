<style type="text/css">
.alert-success {
    color: #3c763d;
    background-color: #dff0d8;
    border-color: #d6e9c6;
}

.alert-danger {
    color: #a94442;
    background-color: #f2dede;
    border-color: #ebccd1;
}

.alert {
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 4px;
}

.ui-timepicker-wrapper {
	overflow-y: auto;
	height: 150px;
	width: 6.5em;
	background: #fff;
	border: 1px solid #ddd;
	-webkit-box-shadow:0 5px 10px rgba(0,0,0,0.2);
	-moz-box-shadow:0 5px 10px rgba(0,0,0,0.2);
	box-shadow:0 5px 10px rgba(0,0,0,0.2);
	outline: none;
	z-index: 10001;
	margin: 0;
}

.ui-timepicker-wrapper.ui-timepicker-with-duration {
	width: 13em;
}

.ui-timepicker-wrapper.ui-timepicker-with-duration.ui-timepicker-step-30,
.ui-timepicker-wrapper.ui-timepicker-with-duration.ui-timepicker-step-60 {
	width: 11em;
}

.ui-timepicker-list {
	margin: 0;
	padding: 0;
	list-style: none;
}

.ui-timepicker-duration {
	margin-left: 5px; color: #888;
}

.ui-timepicker-list:hover .ui-timepicker-duration {
	color: #888;
}

.ui-timepicker-list li {
	padding: 3px 0 3px 5px;
	cursor: pointer;
	white-space: nowrap;
	color: #000;
	list-style: none;
	margin: 0;
}

.ui-timepicker-list:hover .ui-timepicker-selected {
	background: #fff; color: #000;
}

li.ui-timepicker-selected,
.ui-timepicker-list li:hover,
.ui-timepicker-list .ui-timepicker-selected:hover {
	background: #1980EC; color: #fff;
}

li.ui-timepicker-selected .ui-timepicker-duration,
.ui-timepicker-list li:hover .ui-timepicker-duration {
	color: #ccc;
}

.ui-timepicker-list li.ui-timepicker-disabled,
.ui-timepicker-list li.ui-timepicker-disabled:hover,
.ui-timepicker-list li.ui-timepicker-selected.ui-timepicker-disabled {
	color: #888;
	cursor: default;
}

.ui-timepicker-list li.ui-timepicker-disabled:hover,
.ui-timepicker-list li.ui-timepicker-selected.ui-timepicker-disabled {
	background: #f2f2f2;
}
</style>
<?php
global $wpdb;

if (!isset($_GET['looc_id']) or empty($_GET['looc_id'])) {
	echo 'Error, missing location';
	exit();
}

$loc_id 	= (int) $_GET['looc_id'];
$location 	= get_post($loc_id);
if (empty($location)) {
	echo 'Error, missing location';
	exit();	
}

if (isset($_POST['looc_id'])) {
	
	if (isset($_POST['class_id']) and !empty($_POST['class_id'])) {
		// UPDATE
		$class_id = $_POST['class_id'];

		// DELETE
		if (isset($_POST['do_delete']) and !empty($_POST['do_delete'])) {
			$_class = get_post($class_id);
			
			if ($_class->post_author != $user->ID) {
				echo "<div class=\"alert alert-danger\" role=\"alert\"> <strong>Naughty Naughty!</strong>Please wait, redirecting You in a moment...</div>";
				echo "<script>window.location='".site_url()."/my-account/locations/?loc_id={$location->ID}';</script>";
				exit();
			}

			wp_delete_post($class_id, true);
			echo "<div class=\"alert alert-success\" role=\"alert\"> <strong>Your class is deleted!</strong> Please wait, redirecting You in a moment...</div>";
			echo "<script>window.location='".site_url()."/my-account/locations/?loc_id={$location->ID}';</script>";
			exit();
		}
	} else {
		// CREATE
		$class_id = wp_insert_post(
			array(
				'post_type' 	=> 'location_class',
				'post_status' 	=> 'publish',
				'post_title' 	=> "{$location->post_title} {$_POST['type']}",
			)
		);		
	}

	//var_dump($_POST, $class_id);
	//	exit();

	update_post_meta($class_id, 'location_id',	$_POST['looc_id']);
	update_post_meta($class_id, 'day', 			$_POST['day']);
	update_post_meta($class_id, 'time', 		$_POST['time']);
	update_post_meta($class_id, 'registration_option', 		$_POST['registration_option']);
	
	update_post_meta($class_id, 'program', 		$_POST['program']);
	update_post_meta($class_id, 'type', 		$_POST['type']);
	update_post_meta($class_id, 'coach_pay_scale', 		$_POST['coach_pay_scale']);
	update_post_meta($class_id, 'class_paynent_information', 		$_POST['class_paynent_information']);
	update_post_meta($class_id, 'ages', 		$_POST['ages']);
	update_post_meta($class_id, 'coaches', 		$_POST['coaches']);
	update_post_meta($class_id, 'class_costs', 		$_POST['class_costs']);

	update_post_meta($class_id, 'parent_pay_monthly_registration_fee', 		$_POST['parent_pay_monthly_registration_fee']);
	update_post_meta($class_id, 'parent_pay_monthly_monthly_tuition', 		$_POST['parent_pay_monthly_monthly_tuition']);
	update_post_meta($class_id, 'parent_pay_monthly_classes_monthly', 		$_POST['parent_pay_monthly_classes_monthly']);

	update_post_meta($class_id, 'parent_pay_session_registration_fee', 		$_POST['parent_pay_session_registration_fee']);
	update_post_meta($class_id, 'parent_pay_session_session_tuition', 		$_POST['parent_pay_session_session_tuition']);
	update_post_meta($class_id, 'parent_pay_sessions_weeks_in_session', 		$_POST['parent_pay_sessions_weeks_in_session']);

	update_post_meta($class_id, 'contracts_events_type', 		$_POST['contracts_events_type']);
	update_post_meta($class_id, 'paid_per_class', 		$_POST['paid_per_class']);
	update_post_meta($class_id, 'paid_per_student', 		$_POST['paid_per_student']);
	update_post_meta($class_id, 'paid_per_hour', 		$_POST['paid_per_hour']);
	update_post_meta($class_id, 'paid_per_day', 		$_POST['paid_per_day']);

	


?> 
<div class="alert alert-success" role="alert"> <strong>Well done!</strong> Your class is saved.</div>
<?php 
}

$location_meta	= get_post_meta($loc_id);
$_title			= 'Add new class';

if (isset($_GET['class_id']) and !empty($_GET['class_id'])) {
	$class_id = $_GET['class_id'];
}

if (isset($class_id) and !empty($class_id)) {
	$_title = 'Edit class';
	$location_class = get_post($class_id);

	$_class = get_post($class_id);

	if ($_class->post_author != $user->ID) {	
		echo "<div class=\"alert alert-danger\" role=\"alert\"> <strong>Naughty Naughty!</strong> Please wait, redirecting You in a moment...</div>";
		echo "<script>window.location='".site_url()."/my-account/locations/?loc_id={$location->ID}';</script>";
		exit();
	}
}

$please_confirm_delete = false;

if (isset($class_id) and !empty($class_id) and isset($_GET['confirm_delete'])) {
	$_title = 'Delete class';
	$please_confirm_delete = true;	
}

$class_day 		= false;
$class_time 	= false;
$class_program 	= false;
$class_type 	= false;
$class_coach_pay_scale	= false;
$class_paynent_information 	= false;
$class_length 	= false;
$class_ages 	= false;
$class_costs 	= false;

$parent_pay_monthly_registration_fee 	= false;
$parent_pay_monthly_monthly_tuition 	= false;
$parent_pay_monthly_classes_monthly 	= false;
$parent_pay_session_registration_fee 	= false;
$parent_pay_session_session_tuition 	= false;
$parent_pay_sessions_weeks_in_session 	= false;

$contracts_events_type 			= false;
$paid_per_class 				= false;
$paid_per_student 				= false;
$paid_per_hour 					= false;
$paid_per_day 					= false;

if (isset($location_class)) {
	$location_class_meta = get_post_meta($class_id);	

	$class_day 		= am2_get_meta_value('day', 	$location_class_meta);
	$class_registration_option 		= am2_get_meta_value('registration_option', 	$location_class_meta);
	$class_ages 	= am2_get_meta_value('ages', 	$location_class_meta);
	$class_time 	= am2_get_meta_value('time', 	$location_class_meta);
	$class_program 	= am2_get_meta_value('program', 	$location_class_meta);
	$class_type 	= am2_get_meta_value('type', 	$location_class_meta);
	$class_coach_pay_scale 	= am2_get_meta_value('coach_pay_scale', 	$location_class_meta);
	$class_paynent_information 	= am2_get_meta_value('class_paynent_information', 	$location_class_meta);
	$class_length 	= am2_get_meta_value('length', 	$location_class_meta);	
	$class_costs 	= am2_get_meta_value('class_costs', 	$location_class_meta);

	$parent_pay_monthly_registration_fee 	= am2_get_meta_value('parent_pay_monthly_registration_fee', 	$location_class_meta);
	$parent_pay_monthly_monthly_tuition 	= am2_get_meta_value('parent_pay_monthly_monthly_tuition', 	$location_class_meta);
	$parent_pay_monthly_classes_monthly 	= am2_get_meta_value('parent_pay_monthly_classes_monthly', 	$location_class_meta);

	$parent_pay_session_registration_fee 	= am2_get_meta_value('parent_pay_session_registration_fee', 	$location_class_meta);
	$parent_pay_session_session_tuition 	= am2_get_meta_value('parent_pay_session_session_tuition', 	$location_class_meta);
	$parent_pay_sessions_weeks_in_session 	= am2_get_meta_value('parent_pay_sessions_weeks_in_session', 	$location_class_meta);

	$contracts_events_type 			= am2_get_meta_value('contracts_events_type', 	$location_class_meta);
	$paid_per_class 				= am2_get_meta_value('paid_per_class', 	$location_class_meta);
	$paid_per_student 				= am2_get_meta_value('paid_per_student', 	$location_class_meta);
	$paid_per_hour 					= am2_get_meta_value('paid_per_hour', 	$location_class_meta);
	$paid_per_day 					= am2_get_meta_value('paid_per_day', 	$location_class_meta);
	
}

$possible_days = array(
    'Sunday',
    'Monday', 
    'Tuesday', 
    'Wednesday', 
    'Thursday', 
    'Friday', 
    'Saturday', 
);

$possible_registration_options = array(
    'Standard Registration Form',
    'Session Registration Form', 
    '3rd Party Registrations',  
);

$possible_class_costs = array(
    'Parent-Pay Monthly',
    'Parent-Pay Session', 
    'Contracts/Events',  
);


global $class_programs, $class_types, $coach_pay_scales, $class_payment_informations;
?>
<div class="user_form" style="margin-top:0">
	<a href="<?php echo site_url();?>/my-account/locations/?loc_id=<?php echo $location->ID; ?>" class="button">Back</a>
	
	<h3>Location: <?php echo $location->post_title; ?></h3>
	<h4><?php echo $_title; ?></h4>	
	
	<form method="post">
	
		<label>Class Type</label>
		<select name="type" <?php if (true === $please_confirm_delete): ?>disabled<?php endif; ?> >
			<?php foreach ($class_types as $type): 
				$if_type_selected = ''; 
				if ($type == $class_type) {
					$if_type_selected = "selected=selected";
				}
			?>		
			<option <?php echo $if_type_selected; ?>><?php echo $type; ?></option>
			<?php endforeach ?>
		</select>

		<label>Program</label>		
		<select name="program" <?php if (true === $please_confirm_delete): ?>disabled<?php endif; ?>>
			<?php foreach ($class_programs as $_class): 
				$if_class_selected = ''; 
				if ($_class == $class_program) {
					$if_class_selected = "selected=selected";
				}
			?>		
			<option <?php echo $if_class_selected; ?>><?php echo $_class; ?></option>
			<?php endforeach ?>
		</select>

		<div class="form--section">
			<h2>Scheduler</h2>

		</div>
	
		<label>Registration Option</label>
		<select name="registration_option" <?php if (true === $please_confirm_delete): ?>disabled<?php endif; ?> >
			<?php foreach ($possible_registration_options as $registration_option): 
				$if_selected = ''; 
				if ($registration_option == $class_registration_option) {
					$if_selected = "selected=selected";
				}
			?>		
			<option <?php echo $if_selected; ?>><?php echo $registration_option; ?></option>
			<?php endforeach ?>
		</select>
		
		<div class="form--section">
			<h2>Class Costs</h2>
				<label><input type="radio" class="js-induce-change" data-change-to-section="class-costs" data-change-to-id="parent_pay_monthly" name="class_costs" value="Parent-Pay Monthly" <?php if($class_costs == 'Parent-Pay Monthly'){ echo 'checked="checked"'; } ?>>Parent-Pay Monthly </label>
				<label><input type="radio" class="js-induce-change" data-change-to-section="class-costs" data-change-to-id="parent_pay_session" name="class_costs" value="Parent-Pay Session" <?php if($class_costs == 'Parent-Pay Session'){ echo 'checked="checked"'; } ?>>Parent-Pay Session </label>
				<label><input type="radio" class="js-induce-change" data-change-to-section="class-costs" data-change-to-id="contracts_events" name="class_costs" value="Contracts/Events" <?php if($class_costs == 'Contracts/Events'){ echo 'checked="checked"'; } ?>>Contracts/Events </label>
				
				<div id="parent_pay_monthly" data-section="class-costs" style="display:none;">

					<label>Registration Fee</label>
					<input type="text" name="registration_fee" value="<?php echo $registration_fee; ?>" <?php if (true === $please_confirm_delete): ?>disabled<?php endif; ?>>
					<label>Monthly Tuition</label>
					<input type="text" name="monthly_tuition" value="<?php echo $monthly_tuition; ?>" <?php if (true === $please_confirm_delete): ?>disabled<?php endif; ?>>
					<label># Classes Monthly</label>
					<input type="text" name="classes_monthly" value="<?php echo $classes_monthly; ?>" <?php if (true === $please_confirm_delete): ?>disabled<?php endif; ?>>

				</div>
				<div id="parent_pay_session" data-section="class-costs" style="display:none;">

					<label>Registration Fee</label>
					<input type="text" name="registration_fee" value="<?php echo $registration_fee; ?>" <?php if (true === $please_confirm_delete): ?>disabled<?php endif; ?>>
					<label>Session Tuition</label>
					<input type="text" name="session_tuition" value="<?php echo $session_tuition; ?>" <?php if (true === $please_confirm_delete): ?>disabled<?php endif; ?>>
					<label>Weeks In Session</label>
					<input type="text" name="weeks_in_session" value="<?php echo $weeks_in_session; ?>" <?php if (true === $please_confirm_delete): ?>disabled<?php endif; ?>>

				</div>
				<div id="contracts_events_type" data-section="class-costs" style="display:none;">
					<label>Contracts/Events Type</label>
					<label><input type="radio" class="js-induce-change" data-change-to-section="class-contract-events" data-change-to-id="paid_per_class" name="contracts_events_type" value="Paid Per Class" <?php if($contract_event_type == 'Paid Per Class' || $contract_event_type === false){ echo 'checked="checked"'; } ?>>Paid Per Class</label>
					<label><input type="radio" class="js-induce-change" data-change-to-section="class-contract-events" data-change-to-id="paid_per_student" name="contracts_events_type" value="Paid Per Student" <?php if($contract_event_type == 'Paid Per Student'){ echo 'checked="checked"'; } ?>>Paid Per Student</label>
					<label><input type="radio" class="js-induce-change" data-change-to-section="class-contract-events" data-change-to-id="paid_per_hour" name="contracts_events_type" value="Paid Per Hour" <?php if($contract_event_type == 'Paid Per Hour'){ echo 'checked="checked"'; } ?>>Paid Per Hour</label>
					<label><input type="radio" class="js-induce-change" data-change-to-section="class-contract-events" data-change-to-id="paid_per_day" name="contracts_events_type" value="Paid Per Day" <?php if($contract_event_type == 'Paid Per Day'){ echo 'checked="checked"'; } ?>>Paid Per Day</label>
					
					<div id="paid_per_class" data-section="class-contract-events" style="display:none;">
						paid_per_class
					</div>

					<div id="paid_per_student" data-section="class-contract-events" style="display:none;">
						paid_per_student
					</div>

					<div id="paid_per_hour" data-section="class-contract-events" style="display:none;">
						paid_per_hour
					</div>

					<div id="paid_per_day" data-section="class-contract-events" style="display:none;">
						paid_per_day
					</div>

				</div>
			<br>
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				checkChangeToRadios();
				jQuery('.js-induce-change').on('click', function(){
					changeToSection = jQuery(this).data('change-to-section');
			        changeToId = jQuery(this).data('change-to-id');
			        changeTo(changeToId, changeToSection);
				})
			})
			function checkChangeToRadios(){
				jQuery('.js-induce-change').each(function(){
					 if (jQuery(this).is(':checked') || jQuery(this).is(':selected')) {
			            changeToSection = jQuery(this).data('change-to-section');
			            changeToId = jQuery(this).data('change-to-id');
			            changeTo(changeToId, changeToSection);
			        }
				});
			}
			function changeTo(target_id, section) {
				jQuery('[data-section="'+section+'"]').hide();
				jQuery('#'+target_id).show();
			}
		</script>

		<label>Day</label>
		<select name="day" <?php if (true === $please_confirm_delete): ?>disabled<?php endif; ?> >
			<?php foreach ($possible_days as $day): 
				$if_day_selected = ''; 
				if ($day == $class_day) {
					$if_day_selected = "selected=selected";
				}
			?>		
			<option <?php echo $if_day_selected; ?>><?php echo $day; ?></option>
			<?php endforeach ?>
		</select>
		
		<label>Time</label>
		<input type="text" name="time" id="x-timepicker" value="<?php echo $class_time; ?>" <?php if (true === $please_confirm_delete): ?>disabled<?php endif; ?>>

		<label>Pay scale</label>
		<select name="coach_pay_scale" <?php if (true === $please_confirm_delete): ?>disabled<?php endif; ?> >
			<?php foreach ($coach_pay_scales as $payscale): 
				$if_payscale_selected = ''; 
				if ($payscale == $class_coach_pay_scale) {
					$if_payscale_selected = "selected=selected";
				}
			?>		
			<option <?php echo $if_payscale_selected; ?>><?php echo $payscale; ?></option>
			<?php endforeach ?>
		</select>

		<label>Payment information</label>
		<select name="class_paynent_information" <?php if (true === $please_confirm_delete): ?>disabled<?php endif; ?> >
			<?php foreach ($class_payment_informations as $payinfo): 
				$if_payinfo_selected = ''; 
				if ($payinfo == $class_paynent_information) {
					$if_payinfo_selected = "selected=selected";
				}
			?>		
			<option <?php echo $if_payinfo_selected; ?>><?php echo $payinfo; ?></option>
			<?php endforeach ?>
		</select>

		<label>Ages</label>	
		<input type="text" name="ages" value="<?php echo $class_ages; ?>" <?php if (true === $please_confirm_delete): ?>disabled<?php endif; ?>>

		<label>Choose Coach</label>
		<select name="coaches[]"  placeholder="Select a coach..." class="am2_coaches" required style="" multiple="multiple">		
			<option value="">Select a coach...</option>
			<?php

			$coaches = get_users( array('role' => 'coach') ); 		
			$sel_coaches = get_post_meta($class_id, 'coaches', true);

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

		<input type="hidden" name="looc_id" value="<?php echo $loc_id; ?>">
		<input type="hidden" name="class_id" value="<?php echo !empty($class_id) ? $class_id : ''; ?>">

		<?php if (true === $please_confirm_delete): ?>
		<input type="hidden" name="do_delete" value="1">
		<button type="submit" class="button">I really want to delete this</button>	
		<?php else: ?>
	<button type="submit" class="button">Save</button>
		<?php endif; ?>	
	</form>
</div>

<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#x-timepicker').timepicker();
});
</script>