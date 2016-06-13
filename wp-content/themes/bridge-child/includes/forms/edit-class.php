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

	update_post_meta($class_id, 'location_id',	$_POST['looc_id']);
	update_post_meta($class_id, 'day', 			$_POST['day']);
	update_post_meta($class_id, 'time', 		$_POST['time']);
	update_post_meta($class_id, 'type', 		$_POST['type']);
	update_post_meta($class_id, 'length', 		$_POST['length']);
	update_post_meta($class_id, 'ages', 		$_POST['ages']);

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
$class_type 	= false;
$class_length 	= false;
$class_ages 	= false;

if ($location_class) {
	$location_class_meta = get_post_meta($class_id);	

	$class_day 		= am2_get_meta_value('day', 	$location_class_meta);
	$class_ages 	= am2_get_meta_value('ages', 	$location_class_meta);
	$class_time 	= am2_get_meta_value('time', 	$location_class_meta);
	$class_type 	= am2_get_meta_value('type', 	$location_class_meta);
	$class_length 	= am2_get_meta_value('length', 	$location_class_meta);	
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

$class_types = array('Amazing Athletes', 'Amazing Tots', 'Amazing Warriors');
?>
<div class="user_form" style="margin-top:0">
	<a href="<?php echo site_url();?>/my-account/locations/?loc_id=<?php echo $location->ID; ?>" class="button">Back</a>
	
	<h3>Location: <?php echo $location->post_title; ?></h3>
	<h4><?php echo $_title; ?></h4>	
	
	<form method="post">
		
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
		
		<label>Type</label>		
		<select name="type" <?php if (true === $please_confirm_delete): ?>disabled<?php endif; ?>>
			<?php foreach ($class_types as $_class): 
				$if_class_selected = ''; 
				if ($_class == $class_type) {
					$if_class_selected = "selected=selected";
				}
			?>		
			<option <?php echo $if_class_selected; ?>><?php echo $_class; ?></option>
			<?php endforeach ?>
		</select>

		<label>Length</label>
		<input type="text" name="length" value="<?php echo $class_length; ?>" <?php if (true === $please_confirm_delete): ?>disabled<?php endif; ?>>

		<label>Ages</label>	
		<input type="text" name="ages" value="<?php echo $class_ages; ?>" <?php if (true === $please_confirm_delete): ?>disabled<?php endif; ?>>

		<input type="hidden" name="looc_id" value="<?php echo $loc_id; ?>">
		<input type="hidden" name="class_id" value="<?php echo $class_id; ?>">

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