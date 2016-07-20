<?php
global $values;

function generateTextField($field_label, $field_name){
	global $values;
	global $please_confirm_delete;

	$output = '';
	$output .= '<label>'.$field_label.'</label>';
	$output .= '<input type="text" name="'.$field_name.'" value="'.$values[$field_name].'"';
	if (isset($please_confirm_delete) && true === $please_confirm_delete):
		$output .= ' disabled';
	endif;
	$output .= '>';

	echo $output;

	return;
}

$fieldsToGet = array(
		'class_day',
		'class_registration_option',
		'class_ages',
		'class_time',
		'class_program',
		'class_type',
		'class_coach_pay_scale',
		'class_paynent_information',
		'class_length',
		'class_costs',
		'parent_pay_monthly_registration_fee',
		'parent_pay_monthly_monthly_tuition',
		'parent_pay_monthly_classes_monthly',
		'parent_pay_session_registration_fee',
		'parent_pay_session_session_tuition',
		'parent_pay_session_weeks_in_session',
		'contract_or_event',
		'contracts_events_type',
		'amount_earned_per_class',
		'classes_per_month',
		'amount_earned_per_student',
		'amount_earned_per_hour',
		'hours_per_month',
		'amount_earned_per_day',
		'days_per_month',
		'coach_pay_scale',
		'per_student_per_class_pay',
		'new_student_bonus',
		'per_class_pay',
		'classes_per_class_day',
		'per_hour_pay',
		'hours_per_class_day',
		'date',
		'time',
		'date_start',
		'date_end',
		'schedule_type',
		'date_every_year',
		'monthly_every',
		'payment_options',
		'one_time_credit_card_payment_url',
		'recurring_credit_card_payments_url',
		'external_registration_url',
		'special_event_title',
		'enable_kickback',
	    'kickback'
	);

?>


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
	update_post_meta($class_id, 'parent_pay_session_weeks_in_session', 		$_POST['parent_pay_session_weeks_in_session']);

	update_post_meta($class_id, 'contracts_events_type', 		$_POST['contracts_events_type']);
	update_post_meta($class_id, 'contract_or_event', 		$_POST['contract_or_event']);
	update_post_meta($class_id, 'amount_earned_per_class', 		$_POST['amount_earned_per_class']);
	update_post_meta($class_id, 'classes_per_month', 		$_POST['classes_per_month']);

	foreach($fieldsToGet as $fieldToGet):
			update_post_meta($class_id, $fieldToGet, $_POST[$fieldToGet]);
	endforeach;





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

global $please_confirm_delete;
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
$parent_pay_session_weeks_in_session 	= false;

$contract_or_event 					= false;
$contracts_events_type 				= false;
$amount_earned_per_class 				= false;
$classes_per_month 				= false;

foreach($fieldsToGet as $fieldToGet):
	$values[$fieldToGet] = false;
endforeach;


if (isset($location_class)) {
	$location_class_meta = get_post_meta($class_id);

	foreach($fieldsToGet as $fieldToGet):
		$values[$fieldToGet] = am2_get_meta_value($fieldToGet, $location_class_meta);
	endforeach;

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
	$parent_pay_session_weeks_in_session 	= am2_get_meta_value('parent_pay_session_weeks_in_session', 	$location_class_meta);

	$contract_or_event 					= am2_get_meta_value('contract_or_event', 	$location_class_meta);
	$contracts_events_type 				= am2_get_meta_value('contracts_events_type', 	$location_class_meta);
	$amount_earned_per_class 			= am2_get_meta_value('amount_earned_per_class', 	$location_class_meta);
	$classes_per_month 					= am2_get_meta_value('classes_per_month', 	$location_class_meta);

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

$possible_every = array(
	'First',
	'Second',
	'Third',
	'Fourth',
	'Fifth'
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

$coaches = get_users(array(
	'role' 			=> 'coach',
	'meta_key'		=> 'franchisee',
	'meta_value' 	=> $user->ID,
));

$sel_coaches = get_post_meta($class_id, 'coaches', true);

?>
<div class="user_form" style="margin-top:0">
	<a href="<?php echo site_url();?>/my-account/locations/?loc_id=<?php echo $location->ID; ?>" class="button">Back</a>

	<h3>Location: <?php echo $location->post_title; ?></h3>
	<h1><?php echo $_title; ?></h1>

	<form method="post">

		<label>Class Type</label>
		<select name="type" class="js-induce-change-select-class">
			<option<?php if($class_type == 'Demo'){ ?> selected="selected"<?php } ?> data-change-to-id="class_schedule_single_day" data-change-to-section="class-schedule">Demo</option>
			<option<?php if($class_type == 'Parent-Pay Monthly'){ ?> selected="selected"<?php } ?> data-change-to-id="class_schedule_recurring"  data-change-to-section="class-schedule">Parent-Pay Monthly</option>
			<option<?php if($class_type == 'Parent-Pay Session'){ ?> selected="selected"<?php } ?> data-change-to-id="class_schedule_session"  data-change-to-section="class-schedule">Parent-Pay Session</option>
			<option<?php if($class_type == 'Annual Contract'){ ?> selected="selected"<?php } ?> data-change-to-id="class_schedule_recurring"  data-change-to-section="class-schedule">Annual Contract</option>
			<option<?php if($class_type == 'Camp'){ ?> selected="selected"<?php } ?> data-change-to-id="class_schedule_single_day"  data-change-to-section="class-schedule">Camp</option>
			<option<?php if($class_type == 'Event'){ ?> selected="selected"<?php } ?> data-change-to-id="class_schedule_single_day"  data-change-to-section="class-schedule">Event</option>
		</select>
		<?php /*<select name="type" class="js-induce-change-select-class" <?php if (true === $please_confirm_delete): ?>disabled<?php endif; ?> >
			<?php foreach ($class_types as $type):
				$if_type_selected = '';
				if ($type == $class_type) {
					$if_type_selected = "selected=selected";
				}
			?>
			<option <?php echo $if_type_selected; ?> data-change-to-section="class-schedule"><?php echo $type; ?></option>
			<?php endforeach ?>
		</select>*/ ?>

		<label>Program</label>
		<select id="program" name="program" <?php if (true === $please_confirm_delete): ?>disabled<?php endif; ?>>
			<?php foreach ($class_programs as $_class):
				$if_class_selected = '';
				if ($_class == $class_program) {
					$if_class_selected = "selected=selected";
				}
			?>
			<option <?php echo $if_class_selected; ?>><?php echo $_class; ?></option>
			<?php endforeach ?>
		</select>

		<span id="special_event_title"
			<?php if ('Special Event' == $class_program): ?>
						style="display:block"
					<?php else: ?>
						style="display:none"
					<?php endif; ?>>
			<label>Special Event Title:</label>
			<input 	type="text"
					name="special_event_title"
					value="<?php echo $values['special_event_title']; ?>">
		</span>

		<div class="form--section">
			<h2>Scheduler (Settings depend on Class Type)</h2>
			<div id="class_schedule_single_day" data-section="class-schedule" style="display:none;">
				<label>Date</label>
				<input type="text" name="date" class="datepicker" value="<?php echo $values['date']; ?>" class="ui-timepicker-input" autocomplete="off">

				<label>Time</label>
				<input type="text" name="time" class="timepicker" value="<?php echo $values['time']; ?>" <?php if (true === $please_confirm_delete): ?>disabled<?php endif; ?>>

			</div>
			<div id="class_schedule_recurring" data-section="class-schedule" style="display:none;">
				<label>Schedule Type</label><br>
				<label><input type="radio" class="js-induce-change" data-change-to-section="class-schedule-type" data-change-to-id="schedule_weekly" name="schedule_type" value="Weekly" <?php if($values['schedule_type'] == 'Weekly' || $values['schedule_type'] === false){ echo 'checked="checked"'; } ?>>Weekly</label>
				<label><input type="radio" class="js-induce-change" data-change-to-section="class-schedule-type" data-change-to-id="schedule_monthly" name="schedule_type" value="Monthly" <?php if($values['schedule_type'] == 'Monthly'){ echo 'checked="checked"'; } ?>>Monthly</label>
				<label><input type="radio" class="js-induce-change" data-change-to-section="class-schedule-type" data-change-to-id="schedule_yearly" name="schedule_type" value="Yearly" <?php if($values['schedule_type'] == 'Yearly'){ echo 'checked="checked"'; } ?>>Yearly</label>

				<div id="schedule_weekly" data-section="class-schedule-type" style="display:none;">
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
					<input type="text" name="time" class="timepicker" value="<?php echo $values['time']; ?>" <?php if (true === $please_confirm_delete): ?>disabled<?php endif; ?>>

				</div>
				<div id="schedule_monthly" data-section="class-schedule-type" style="display:none;">
					<label>Every</label>
					<select name="monthly_every" <?php if (true === $please_confirm_delete): ?>disabled<?php endif; ?> >
						<?php foreach ($possible_every as $every):
							$if_every_selected = '';
							if ($every == $values['monthly_every']) {
								$if_every_selected = "selected=selected";
							}
						?>
						<option <?php echo $if_every_selected; ?>><?php echo $every; ?></option>
						<?php endforeach ?>
					</select>

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
					<input type="text" name="time" class="timepicker" value="<?php echo $values['time']; ?>" <?php if (true === $please_confirm_delete): ?>disabled<?php endif; ?>>

				</div>
				<div id="schedule_yearly" data-section="class-schedule-type" style="display:none;">
					<label>Date Every Year</label>
					<input type="text" name="date_every_year" class="datepicker_noyear" value="<?php echo $values['date_every_year']; ?>" class="ui-timepicker-input" autocomplete="off">

				</div>
			</div>
			<div id="class_schedule_session" data-section="class-schedule" style="display:none;">
				<label>Date Start</label>
				<input type="text" name="date_start" class="datepicker" value="<?php echo $values['date_start']; ?>" class="ui-timepicker-input" autocomplete="off">
				<label>Date End</label>
				<input type="text" name="date_end" class="datepicker" value="<?php echo $values['date_end']; ?>" class="ui-timepicker-input" autocomplete="off">


			</div>
		</div>

		<div class="form--section">
			<h2>Registration Option</h2>
			<select id="class-registration-options" name="registration_option" <?php if (true === $please_confirm_delete): ?>disabled<?php endif; ?> >
				<?php foreach ($possible_registration_options as $registration_option):
					$if_selected = '';
					if ($registration_option == $class_registration_option) {
						$if_selected = "selected=selected";
					}
				?>
				<option <?php echo $if_selected; ?>><?php echo $registration_option; ?></option>
				<?php endforeach ?>
			</select>

			<span id="external_registration_url"
				<?php if ('3rd Party Registrations' == $class_registration_option): ?>
							style="display:block"
						<?php else: ?>
							style="display:none"
						<?php endif; ?>>
				<label>3rd Party Registration URL:</label>
				<input 	type="text"
						name="external_registration_url"
						value="<?php echo $values['external_registration_url']; ?>">
			</span>
		</div>

		<div class="form--section">
			<h2>Class Costs</h2>
				<label><input type="radio" class="js-induce-change" data-change-to-section="class-costs" data-change-to-id="parent_pay_monthly" name="class_costs" value="Parent-Pay Monthly" <?php if($class_costs == 'Parent-Pay Monthly'){ echo 'checked="checked"'; } ?>>Parent-Pay Monthly </label>
				<label><input type="radio" class="js-induce-change" data-change-to-section="class-costs" data-change-to-id="parent_pay_session" name="class_costs" value="Parent-Pay Session" <?php if($class_costs == 'Parent-Pay Session'){ echo 'checked="checked"'; } ?>>Parent-Pay Session </label>
				<label><input type="radio" class="js-induce-change" data-change-to-section="class-costs" data-change-to-id="contracts_events" name="class_costs" value="Contracts/Events" <?php if($class_costs == 'Contracts/Events'){ echo 'checked="checked"'; } ?>>Contracts/Events </label>

				<div id="parent_pay_monthly" data-section="class-costs" style="display:none;">

					<label>Registration Fee</label>
					<input type="text" name="parent_pay_monthly_registration_fee" value="<?php echo $parent_pay_monthly_registration_fee; ?>" <?php if (true === $please_confirm_delete): ?>disabled<?php endif; ?>>
					<label>Monthly Tuition</label>
					<input type="text" name="parent_pay_monthly_monthly_tuition" value="<?php echo $parent_pay_monthly_monthly_tuition; ?>" <?php if (true === $please_confirm_delete): ?>disabled<?php endif; ?>>
					<label># Classes Monthly</label>
					<input type="text" name="parent_pay_monthly_classes_monthly" value="<?php echo $parent_pay_monthly_classes_monthly;  ?>" <?php if (true === $please_confirm_delete): ?>disabled<?php endif; ?>>

				</div>
				<div id="parent_pay_session" data-section="class-costs" style="display:none;">

					<label>Registration Fee</label>
					<input type="text" name="parent_pay_session_registration_fee" value="<?php echo $parent_pay_session_registration_fee; ?>" <?php if (true === $please_confirm_delete): ?>disabled<?php endif; ?>>
					<label>Session Tuition</label>
					<input type="text" name="parent_pay_session_session_tuition" value="<?php echo $parent_pay_session_session_tuition; ?>" <?php if (true === $please_confirm_delete): ?>disabled<?php endif; ?>>
					<label>Weeks In Session</label>
					<input type="text" name="parent_pay_session_weeks_in_session" value="<?php echo $parent_pay_session_weeks_in_session; ?>" <?php if (true === $please_confirm_delete): ?>disabled<?php endif; ?>>

				</div>
				<div id="contracts_events" data-section="class-costs" style="display:none;">
					<br>
					<label>Contracts/Events Type</label><br>
					<label><input type="radio" class="js-induce-change" data-change-to-section="class-contract-events" data-change-to-id="paid_per_class" name="contracts_events_type" value="Paid Per Class" <?php if($contracts_events_type == 'Paid Per Class' || $contracts_events_type === false){ echo 'checked="checked"'; } ?>>Paid Per Class</label>
					<label><input type="radio" class="js-induce-change" data-change-to-section="class-contract-events" data-change-to-id="paid_per_student" name="contracts_events_type" value="Paid Per Student" <?php if($contracts_events_type == 'Paid Per Student'){ echo 'checked="checked"'; } ?>>Paid Per Student</label>
					<label><input type="radio" class="js-induce-change" data-change-to-section="class-contract-events" data-change-to-id="paid_per_hour" name="contracts_events_type" value="Paid Per Hour" <?php if($contracts_events_type == 'Paid Per Hour'){ echo 'checked="checked"'; } ?>>Paid Per Hour</label>
					<label><input type="radio" class="js-induce-change" data-change-to-section="class-contract-events" data-change-to-id="paid_per_day" name="contracts_events_type" value="Paid Per Day" <?php if($contracts_events_type == 'Paid Per Day'){ echo 'checked="checked"'; } ?>>Paid Per Day</label>


					<div id="paid_per_class" data-section="class-contract-events" style="display:none;">
						<select name="contract_or_event">
							<option value="Contract"<?php if($contract_or_event == 'Contract'){ ?> selected="selected"<?php } ?>>Contract</option>
							<option value="Event"<?php if($contract_or_event == 'Event'){ ?> selected="selected"<?php } ?>>Event</option>
						</select>

						<?php
						generateTextField('Amount Earned per Class', 'amount_earned_per_class');
						generateTextField('# Classes per Month', 'classes_per_month');
						?>

					</div>

					<div id="paid_per_student" data-section="class-contract-events" style="display:none;">
						<select name="contract_or_event">
							<option value="Contract"<?php if($contract_or_event == 'Contract'){ ?> selected="selected"<?php } ?>>Contract</option>
							<option value="Event"<?php if($contract_or_event == 'Event'){ ?> selected="selected"<?php } ?>>Event</option>
						</select>

						<?php
						generateTextField('Amount Earned per Student', 'amount_earned_per_student');
						generateTextField('# Classes per Month', 'classes_per_month');
						?>
					</div>

					<div id="paid_per_hour" data-section="class-contract-events" style="display:none;">
						<select name="contract_or_event">
							<option value="Contract"<?php if($contract_or_event == 'Contract'){ ?> selected="selected"<?php } ?>>Contract</option>
							<option value="Event"<?php if($contract_or_event == 'Event'){ ?> selected="selected"<?php } ?>>Event</option>
						</select>

						<?php
						generateTextField('Amount Earned per Hour', 'amount_earned_per_hour');
						generateTextField('# Hours per Month', 'hours_per_month');
						generateTextField('# Classes per Month', 'classes_per_month');
						?>
					</div>

					<div id="paid_per_day" data-section="class-contract-events" style="display:none;">
						<select name="contract_or_event">
							<option value="Contract"<?php if($contract_or_event == 'Contract'){ ?> selected="selected"<?php } ?>>Contract</option>
							<option value="Event"<?php if($contract_or_event == 'Event'){ ?> selected="selected"<?php } ?>>Event</option>
						</select>

						<?php
						generateTextField('Amount Earned per Day', 'amount_earned_per_day');
						generateTextField('# Days per Month', 'days_per_month');
						generateTextField('# Classes per Month', 'classes_per_month');
						?>
					</div>

				</div>
			<br>
		</div>

		<div class="form--section">
			<h2>Payment Options</h2>
			<?php $values['payment_options'] = unserialize($values['payment_options']); ?>
			<label><input type="checkbox" class="js-induce-change-checkboxes" data-change-to-section="class-payment-option" data-change-to-id="personal_check_of_cash_payment" name="payment_options[]" value="Personal Check Or Cash Payments" <?php if(is_array($values['payment_options']) && in_array('Personal Check Or Cash Payments',$values['payment_options'])){ echo 'checked="checked"'; } ?>>Personal Check Or Cash Payments</label>
			<label><input type="checkbox" class="js-induce-change-checkboxes" data-change-to-section="class-payment-option" data-change-to-id="one_time_credit_card_payment" name="payment_options[]" value="One Time Credit Card Payment" <?php if(is_array($values['payment_options']) && in_array('One Time Credit Card Payment',$values['payment_options'])){ echo 'checked="checked"'; } ?>>One Time Credit Card Payment</label>
			<label><input type="checkbox" class="js-induce-change-checkboxes" data-change-to-section="class-payment-option" data-change-to-id="recurring_credit_card_payments" name="payment_options[]" value="Recurring Credit Card Payments" <?php if(is_array($values['payment_options']) && in_array('Recurring Credit Card Payments',$values['payment_options'])){ echo 'checked="checked"'; } ?>>Recurring Credit Card Payments</label>

			<div class="form--section" id="personal_check_of_cash_payment" data-section="class-payment-option" style="display:none;">
				<h3>Personal Check Or Cash Payments</h3>
				No additional options.
			</div>
			<div class="form--section" id="one_time_credit_card_payment" data-section="class-payment-option" style="display:none;">
				<h3>One Time Credit Card Payment</h3>
				<?php
					generateTextField('Enter URL (Quick Link to Credit Card Payment)', 'one_time_credit_card_payment_url');
				?>
			</div>
			<div class="form--section" id="recurring_credit_card_payments" data-section="class-payment-option" style="display:none;">
				<h3>Recurring Credit Card Payments</h3>
				<?php
					generateTextField('Enter URL (Quick Link to Recurring Credit Card Payment)', 'recurring_credit_card_payments_url');
				?>
			</div>
		</div>

		<script type="text/javascript">
			jQuery(document).ready(function(){
				checkChangeToRadios();
				checkChangeToSelectClass();
				checkChangeToCheckboxes();
				jQuery('.js-induce-change').on('click', function(){
					changeToSection = jQuery(this).data('change-to-section');
			        changeToId = jQuery(this).data('change-to-id');
			        changeTo(changeToId, changeToSection);
				});

				jQuery('.js-induce-change-select-class').on('change', function(){
					changeToSection = jQuery(this).find(':selected').attr('data-change-to-section');
		            changeToId = jQuery(this).find(':selected').attr('data-change-to-id');
			        changeTo(changeToId, changeToSection);
				});

				jQuery('.js-induce-change-checkboxes').on('change', function(){
					checkChangeToCheckboxes();
				});

			})

			function checkChangeToSelectClass(){
	            changeToSection = jQuery('.js-induce-change-select-class').find(':selected').attr('data-change-to-section');
	            changeToId = jQuery('.js-induce-change-select-class').find(':selected').attr('data-change-to-id');
		        changeTo(changeToId, changeToSection);
			}

			function checkChangeToRadios(){
				jQuery('.js-induce-change').each(function(){
					 if (jQuery(this).is(':checked') || jQuery(this).is(':selected')) {
			            changeToSection = jQuery(this).data('change-to-section');
			            changeToId = jQuery(this).data('change-to-id');
			            changeTo(changeToId, changeToSection);
			        }
				});
			}
			function checkChangeToCheckboxes(){
				jQuery('.js-induce-change-checkboxes').each(function(){
					changeToSection = jQuery(this).data('change-to-section');
			        changeToId = jQuery(this).data('change-to-id');
					if (jQuery(this).is(':checked') || jQuery(this).is(':selected')) {
			            jQuery('#'+changeToId).show();
			        } else {
			        	jQuery('#'+changeToId).hide();
			        }
				});
				changeToSection = jQuery(this).find(':selected').attr('data-change-to-section');
	            changeToId = jQuery(this).find(':selected').attr('data-change-to-id');
		        changeTo(changeToId, changeToSection);
			}

			function disableDay(target_id, section) {
				var day_ids = ['schedule_weekly', 'schedule_monthly', 'schedule_yearly'];

				for (var i = day_ids.length - 1; i >= 0; i--) {
					if ( target_id != day_ids[i] ) {
						jQuery('#'+day_ids[i]+' select[name="day"]').prop('disabled', 'disabled');
						jQuery('#'+day_ids[i]+' input[name="time"]').prop('disabled', 'disabled');
					} else {
						jQuery('#'+day_ids[i]+' select[name="day"]').prop('disabled', false);
						jQuery('#'+day_ids[i]+' input[name="time"]').prop('disabled', false);
					}
				}
			}

			function changeTo(target_id, section) {

				if ('class-schedule-type' == section) {
					disableDay(target_id, section);
				}

				jQuery('[data-section="'+section+'"]').hide();
				jQuery('#'+target_id).show();
			}
		</script>
		<div class="form--section">
			<h2>Coach Pay Scale</h2>
			<label><input type="radio" class="js-induce-change" data-change-to-section="class-coach-pay-scale" data-change-to-id="unpaid" name="coach_pay_scale" value="Unpaid" <?php if($values['coach_pay_scale'] == 'Unpaid' || $values['coach_pay_scale'] === false){ echo 'checked="checked"'; } ?>>Unpaid</label>
			<label><input type="radio" class="js-induce-change" data-change-to-section="class-coach-pay-scale" data-change-to-id="coach_paid_per_student_per_class" name="coach_pay_scale" value="Per Student per Class Pay" <?php if($values['coach_pay_scale'] == 'Per Student per Class Pay'){ echo 'checked="checked"'; } ?>>Per Student per Class Pay</label>
			<label><input type="radio" class="js-induce-change" data-change-to-section="class-coach-pay-scale" data-change-to-id="coach_paid_per_class" name="coach_pay_scale" value="Per Class Pay" <?php if($values['coach_pay_scale'] == 'Per Class Pay'){ echo 'checked="checked"'; } ?>>Per Class Pay</label>
			<label><input type="radio" class="js-induce-change" data-change-to-section="class-coach-pay-scale" data-change-to-id="coach_paid_per_hour" name="coach_pay_scale" value="Paid Per Day" <?php if($values['coach_pay_scale'] == 'Paid Per Day'){ echo 'checked="checked"'; } ?>>Paid Per Day</label>


			<div id="unpaid" data-section="class-coach-pay-scale" style="display:none;">
			</div>

			<div id="coach_paid_per_student_per_class" data-section="class-coach-pay-scale" style="display:none;">
				<?php
				generateTextField('Per Student per Class Pay', 'per_student_per_class_pay');
				generateTextField('New Student Bonus', 'new_student_bonus');
				?>
			</div>

			<div id="coach_paid_per_class" data-section="class-coach-pay-scale" style="display:none;">
				<?php
				generateTextField('Per Class Pay', 'per_class_pay');
				generateTextField('# Classes per Class Day', 'classes_per_class_day');
				?>
			</div>

			<div id="coach_paid_per_hour" data-section="class-coach-pay-scale" style="display:none;">
				<?php
				generateTextField('Per Hour Pay', 'per_hour_pay');
				generateTextField('# Hours per Class Day', 'hours_per_class_day');
				?>
			</div>

		</div>




		<?php /*<label>Payment information</label>
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
*/ ?>
	<div class="form--section">
		<h2>Choose Coach</h2>
		<select name="coaches[]"  placeholder="Select a coach..." class="am2_coaches" style="" multiple="multiple">
			<option value="">Select a coach...</option>
			<?php
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
	</div>

	<div class="form--section">
		<h2>Kickback</h2>

		<label>Enable Kickback</label>
		<?php $enable_kickback = get_post_meta($class_id, 'enable_kickback', true) == 'yes'; ?>
		<label><input type="radio" name="enable_kickback"  style="" value="yes" <?php echo ($enable_kickback ? 'checked' : '' ) ?>>yes</label><label><input type="radio" name="enable_kickback"  style="" value="no" <?php echo (!$enable_kickback ? 'checked' : '' ) ?>>no</label><br/>

		<label>Kickback %</label>
		<input type="text" name="kickback"  style="" value="<?php echo get_post_meta($class_id, 'kickback', true); ?>"><br/>
	</div>

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
	jQuery('.timepicker').timepicker({
		step: 15
	});
	jQuery('.datepicker').datetimepicker({
		  timepicker:false,
  		  format:'m/d/Y'
	});
	jQuery('.datepicker_noyear').datetimepicker({
		  timepicker:false,
  		  format:'m/d/Y'
	});
});

jQuery(document).on('change', '#class-registration-options', function () {
	var $self = jQuery(this),
		$external_registration_url = jQuery('#external_registration_url');

	if ('3rd Party Registrations' === $self.val()) {
		$external_registration_url.show();
	} else {
		$external_registration_url.hide();
	}

});

jQuery(document).on('change', '#program', function () {
	var $self = jQuery(this),
		$external_registration_url = jQuery('#special_event_title');

	if ('Special Event' === $self.val()) {
		$external_registration_url.show();
	} else {
		$external_registration_url.hide();
	}

});

</script>
