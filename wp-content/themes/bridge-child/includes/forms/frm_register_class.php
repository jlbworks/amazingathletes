<?php
  $location_id = (isset($_GET['location_id']) ? $_GET['location_id'] : null);
  $class_id = (isset($_GET['class_id']) ? $_GET['class_id'] : null);
  $class = get_post($class_id);

  $registration_option = $class->registration_option;

  $location_name = get_the_title($location_id);
  $class_type = $class->type;
  $special_event_title = get_post_meta($class_id, 'special_event_title', true);
  $class_title = get_the_title($class_id);
  $class_program = (!empty($special_event_title) ? $special_event_title : $class_title ); //get_post_meta($class_id, 'program', true);
  $class_time = get_post_meta($class_id, 'time', true);
  $class_date = get_class_date($class, 'date', true);
  $class_display_day = get_post_meta($class->ID, 'display_day', true);
  $class_display_time = get_post_meta($class->ID, 'display_time', true);
  $class_program = get_post_meta($class->ID, 'program', true);
  $class_coaches = array_map(function($coach){
    $_coach = get_user_by('id', $coach);
    return ( !empty($_coach->first_name) || !empty($_coach->last_name) ? implode(' ', array($_coach->first_name, $_coach->last_name) ) : $_coach->diplay_name );
  }, (array)$class->coaches);

  // var_dump($class_type);
?>

<?php if($registration_option!='None Needed') { //if($class_type != 'Contract') { ?>

<div role="form" class="wpcf7" id="frm_registration_wrap" lang="en-US" dir="ltr">

  <?php if(!empty($location_id) && !empty($class_id)){?>
  <div class="location_class_info">
    <h1>Register for <span><?php echo $class_program;?></span></h1>
    <h2>Location: <span><?php echo $location_name;?></span></h2>
    <h2>Day: <span><?php echo $class_display_day;?></span></h2>
    <h2>Time: <span><?php echo !empty($class_display_time) ? $class_display_time : $class_time;?></span></h2>   
    <h2>Program: <span><?php echo $class_program ;?></span></h2> 
    <h2>Coach: <span><?php echo implode(', ', $class_coaches) ;?></span></h2> 
  </div>
  <?php } ?>
  <br/>

  <h1 class="thanks" style="display:none;">Thank You For Registering!</h1>

  <form id="frm_registration" action="<?php echo admin_url('admin-ajax.php');?>" method="post" class="wpcf7-form" >
    <p>Child's First Name *<br>
      <span class="wpcf7-form-control-wrap child-first-name">
      <input type="text" name="child-first-name" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" aria-required="true" aria-invalid="false" required>
      </span> </p>
    <p>Child's Last Name *<br>
      <span class="wpcf7-form-control-wrap child-last-name">
      <input type="text" name="child-last-name" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" aria-required="true" aria-invalid="false" required>
      </span> </p>
    <p>Child's Birthday *<br>
      <span class="wpcf7-form-control-wrap child-birthday">
      <input type="text" name="child-birthday" value="" placeholder="01/01/2017" class="datepicker wpcf7-form-control wpcf7-date wpcf7-validates-as-required wpcf7-validates-as-date" aria-required="true" aria-invalid="false" required>
      </span> </p>
    <p>Child's Gender *<br>
      <span class="wpcf7-form-control-wrap child-gender">
      <select name="child-gender" class="wpcf7-form-control wpcf7-select wpcf7-validates-as-required" aria-required="true" aria-invalid="false" required>
        <option value="M">M</option>
        <option value="F">F</option>
      </select>
      </span> </p>
    <?php if($class_type != "Session") { ?>
    <p>Child's Shirt Size *<br>
      <br>
      <span class="wpcf7-form-control-wrap child-shirt-size">
      <select name="child-shirt-size" class="wpcf7-form-control wpcf7-select wpcf7-validates-as-required" aria-required="true" aria-invalid="false" required>
        <option value="Child X-Small (2-4)">Child X-Small (2-4)</option>
        <option value="Child Small (6-8)">Child Small (6-8)</option>
        <option value="Child Medium (10-12)">Child Medium (10-12)</option>
      </select>
      </span> </p>
    <?php } ?>
    <p>Classroom # or Teacher's Name<br>
      <span class="wpcf7-form-control-wrap classroom-teacher">
      <input type="text" name="classroom-teacher" value="" size="40" class="wpcf7-form-control wpcf7-text" aria-invalid="false">
      </span> </p>
    <p>Parent's Name *<br>
      <span class="wpcf7-form-control-wrap parent-name">
      <input type="text" name="parent-name" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" aria-required="true" aria-invalid="false" required>
      </span> </p>
    <p>Address *<br>
      <span class="wpcf7-form-control-wrap address">
      <input type="text" name="address" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" aria-required="true" aria-invalid="false" required>
      </span> </p>
	<p>City *<br>
     <span class="wpcf7-form-control-wrap city">
     <input type="text" name="city" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" aria-required="true" aria-invalid="false" required>
     </span> </p>
	 <p>State *<br>
    </p>
    <p><span class="wpcf7-form-control-wrap state">
      <select name="state" class="wpcf7-form-control wpcf7-select wpcf7-validates-as-required" aria-required="true" aria-invalid="false" required>
        <option value="">---</option>
        <option value="Alabama">Alabama</option>
        <option value="Alaska">Alaska</option>
        <option value="Arizona">Arizona</option>
        <option value="Arkansas">Arkansas</option>
        <option value="California">California</option>
        <option value="Colorado">Colorado</option>
        <option value="Connecticut">Connecticut</option>
        <option value="Delaware">Delaware</option>
        <option value="District of Columbia">District of Columbia</option>
        <option value="Florida">Florida</option>
        <option value="Georgia">Georgia</option>
        <option value="Hawaii">Hawaii</option>
        <option value="Idaho">Idaho</option>
        <option value="Illinois">Illinois</option>
        <option value="Indiana">Indiana</option>
        <option value="Iowa">Iowa</option>
        <option value="Kansas">Kansas</option>
        <option value="Kentucky">Kentucky</option>
        <option value="Louisiana">Louisiana</option>
        <option value="Maine">Maine</option>
        <option value="Maryland">Maryland</option>
        <option value="Massachusetts">Massachusetts</option>
        <option value="Michigan">Michigan</option>
        <option value="Minnesota">Minnesota</option>
        <option value="Mississippi">Mississippi</option>
        <option value="Missouri">Missouri</option>
        <option value="Montana">Montana</option>
        <option value="Nebraska">Nebraska</option>
        <option value="Nevada">Nevada</option>
        <option value="New Hampshire">New Hampshire</option>
        <option value="New Jersey">New Jersey</option>
        <option value="New Mexico">New Mexico</option>
        <option value="New York">New York</option>
        <option value="North Carolina">North Carolina</option>
        <option value="North Dakota">North Dakota</option>
        <option value="Ohio">Ohio</option>
        <option value="Oklahoma">Oklahoma</option>
        <option value="Oregon">Oregon</option>
        <option value="Pennsylvania">Pennsylvania</option>
        <option value="Rhode Island">Rhode Island</option>
        <option value="South Carolina">South Carolina</option>
        <option value="South Dakota">South Dakota</option>
        <option value="Tennessee">Tennessee</option>
        <option value="Texas">Texas</option>
        <option value="Utah">Utah</option>
        <option value="Vermont">Vermont</option>
        <option value="Virginia">Virginia</option>
        <option value="Washington">Washington</option>
        <option value="West Virginia">West Virginia</option>
        <option value="Wisconsin">Wisconsin</option>
        <option value="Wyoming">Wyoming</option>
      </select>
      </span> </p>
    <p>ZIP Code *<br>
      <span class="wpcf7-form-control-wrap zipcode">
      <input type="text" name="zipcode" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" aria-required="true" aria-invalid="false" required>
      </span> </p>
    <p>Primary Phone Number *<br>
      <span class="wpcf7-form-control-wrap primary-phone">
      <input type="text" name="primary-phone" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" aria-required="true" aria-invalid="false" required>
      </span> </p>
    <p>E-mail address *<br>
      <span class="wpcf7-form-control-wrap email">
      <input type="text" name="email" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" aria-required="true" aria-invalid="false" required>
      </span> </p>
    <h3>Liability &amp; Photo Release</h3>
    <p><span class="wpcf7-form-control-wrap liability"><span class="wpcf7-form-control wpcf7-checkbox wpcf7-validates-as-required wpcf7-exclusive-checkbox"><span class="wpcf7-list-item first last">
      <input type="checkbox" name="liability" value="Yes" required>
      &nbsp;<span class="wpcf7-list-item-label">I Agree to the Liability Release *</span></span></span></span> </p>
    <p>Your child will remain under the care, direction and supervision of the school while receiving instruction from AMAZING ATHLETES. I hereby release and discharge AMAZING ATHLETES, the Childcare Facility and its members from all actions, claims, demands, injury or damage resulting from my child"s participation in this activity.</p>
    <p><span class="wpcf7-form-control-wrap photo_release"><span class="wpcf7-form-control wpcf7-checkbox wpcf7-exclusive-checkbox"><span class="wpcf7-list-item first last">
      <input type="checkbox" name="photo_release" value="Yes">
      &nbsp;<span class="wpcf7-list-item-label">I Agree to the Photo Release</span></span></span></span> </p>
    <p>I give AMAZING ATHLETES permission to publish pictures and/or videos of my child participating in the Amazing Athletes program.<br>
      Comments or Questions</p>
    <h3>Comments or Questions</h3>
    <p><span class="wpcf7-form-control-wrap comments">
      <textarea name="comments" cols="40" rows="10" class="wpcf7-form-control wpcf7-textarea" aria-invalid="false"></textarea>
      </span></p>
    <p>
      <?php /*<span class="wpcf7-form-control-wrap paid_tuition">
        <span class="wpcf7-form-control wpcf7-checkbox wpcf7-exclusive-checkbox">
          <span class="wpcf7-list-item first last">
            <input type="checkbox" name="paid_tuition" value="Yes"/>&nbsp; <span class="wpcf7-list-item-label">Have you paid a tuition for this class already?</span> 
          </span>
        </span>
      </span> */?>
    </p>
    <div class="wpcf7-response-output wpcf7-display-none"></div>
    <input type="hidden" name="action" value="am2_ajax_register_for_class" />
    <input type="hidden" name="location_id" value="<?php echo $_GET['location_id'];?>" />
    <input type="hidden" name="class_id" value="<?php echo $_GET['class_id'];?>" />
    <input type="submit" value="Register" >
  </form>

  <a style="display:none;font-size:22px;" data-fancybox-type="iframe" class="fancybox-iframe payment_options_popup" data-href="<?php echo site_url();?>/post_registration_details/?class_id=<?php echo $_GET['class_id'];?>&paid_tuition=" href="<?php echo site_url();?>/post_registration_details/?class_id=<?php echo $_GET['class_id'];?>&paid_tuition=" >View Payment Options</a>
</div>

<?php } 
else { ?>
  <h2>No registration needed for this class, this class is provided free of charge thanks to <?php echo $location_name;?></h2>
<?php }
?>