<?php
$user_id = $user->ID;
$umeta = get_user_meta($user->ID); //, 'city__state',true);
$city_state = get_user_meta($user_id,'city__state',true);

if(isset($city_state) && !empty($city_state)){				
	$city_state = explode('|', $city_state);
}
else {
	$city_state = array('','');	
}
?>

<div class="user_form">

<h3>Account information</h3>

<form id="frm_franchisee_account" action="<?php echo admin_url('admin-ajax.php') ?>" method="POST" >
		<label>Franchise Name *</label>
		<input type="text" name="franchise_name" required  style="" value="<?=get_user_meta($user_id,'franchise_name',true);?>"><br/>
		
		<label>Display Name *</label>
		<input type="text" name="display_name" required  style="" value="<?=get_user_meta($user_id,'display_name',true);?>"><br/>

		<label>Display Title</label>
		<input type="text" name="display_title"  style="" value="<?=get_user_meta($user_id,'display_title',true);?>"><br/>
		
		<label>Display Number *</label>
		<input type="text" name="franchise_telephone" required  size="20" value="<?php echo get_user_meta($user_id,'telephone',true); ?>"><br/>

		<label>Display Email</label>
		<input type="text" name="franchise_aaemail" data-rule-email="true"  style="" value="<?php echo get_user_meta($user_id,'aa_email_address',true); ?>"><br/>

		<label>Display Market</label>
		<input type="text" name="display_market"  style="" value="<?php echo get_user_meta($user_id,'display_market',true); ?>"><br/>		

		<label>Display Photo</label>
		<div class="user_photo_wrap">
			<?php
			$custom_image = get_field('user_photo', 'user_' . $user_id);
			
			if ($custom_image) {$custom_image_url = wp_get_attachment_image_src($custom_image, 'medium');?>
				<img src="<?php echo $custom_image_url[0]; ?>" width="175"/>
				<br/>
				<a class='delete_button button small-button' id='btn_delete_user_photo' data-attid="<?php echo $custom_image; ?>" data-user-id="<?php echo $user_id;?>" >Delete image</a>
			<?php } else {?>
				<div id="digital_image_upload"></div>
			<?php }?>

		</div>

		<label>Display Bio</label>
		<textarea name="display_bio"><?php echo get_user_meta($user_id,'display_bio',true); ?></textarea>

		<div class="form--section">
			<h2>Social Media</h2>

			<label> Facebook Page</label>
			<?php 
			$link = get_user_meta($user_id,'facebook_page',true); 
			if(empty($link)) {
				$link = 'https://www.facebook.com/AmazingAthletes/';
			}
			?>
			<input type="text" name="franchise_facebook"  style="" value="<?php echo $link; ?>"><br/>
			
			<label> YouTube Page</label>
			<?php 
			$link = get_user_meta($user_id,'youtube_page',true); 
			if(empty($link)) {
				$link = 'https://www.youtube.com/user/TheAmazingAthletes';
			}
			?>
			<input type="text" name="franchise_youtube"  style="" value="<?php echo $link; ?>"><br/>

			<label> Twitter Page</label>
			<?php 
			$link = get_user_meta($user_id,'twitter_page',true); 
			if(empty($link)) {
				$link = 'https://twitter.com/AmazingAthlete';
			}
			?>
			<input type="text" name="franchise_twitter"  style="" value="<?php echo $link; ?>"><br/>

			<label> Pinterest Page</label>
			<?php 
			$link = get_user_meta($user_id,'pinterest_page',true); 
			if(empty($link)) {
				$link = 'https://www.pinterest.com/amazingathletes/';
			}
			?>
			<input type="text" name="franchise_pinterest"  style="" value="<?php echo $link; ?>"><br/>

		</div>

		<label>Individual 1 First Name *</label>
		<input type="text" name="individual_1_first_name" style="" value="<?php echo get_user_meta($user_id,'individual_1_first_name',true); ?>"><br/>
		
		<label>Individual 1 Last Name *</label>
		<input type="text" name="individual_1_last_name" style="" value="<?php echo get_user_meta($user_id,'individual_1_last_name',true); ?>"><br/>
		
		<label>Individual 2 First Name *</label>
		<input type="text" name="individual_2_first_name" style="" value="<?php echo get_user_meta($user_id,'individual_2_first_name',true); ?>"><br/>
		
		<label>Individual 2 Last Name *</label>
		<input type="text" name="individual_2_last_name" style="" value="<?php echo get_user_meta($user_id,'individual_2_last_name',true); ?>"><br/>
		
		<div class="form--section">
			<h2>Franchise Location Info</h2>

			<label>Franchise Mailing Address *</label>
			<input type="text" name="franchise_address" required  style="" value="<?=get_user_meta($user_id,'mailing_address',true);?>"><br/>

			<label>Franchise Mailing State *</label>
			<select name="franchise_state" required placeholder="Select a state..." class="am2_cc_state" style="">
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
			</select>

			</select><br/>

			<label>Franchise Mailing City *</label>
			<input type="text" name="franchise_city" required  style="" value="<?php echo $city_state[1]; ?>" class="am2_cc_city"><br/>

			<input type="hidden" name="franchise_city_state" class="cc_city_state" />


			<label>Franchise Mailing ZIP *</label>
			<input type="text" name="franchise_zip" required  size="10" value="<?php echo get_user_meta($user_id,'zip_code',true); ?>"><br/>

		</div>
		
		<label>Franchise Contact Number *</label>
		<input type="text" name="franchise_telephone" required  size="20" value="<?php echo get_user_meta($user_id,'telephone',true); ?>"><br/>

		<label>Franchise Contact E-Mail *</label>
		<input type="text" name="franchise_email" required data-rule-email="true"  style="" value="<?php echo $user->user_email; ?>"><br/>		

		<label>Franchise Website</label>
		<input type="text" name="franchise_website"  style="" value="<?php echo get_user_meta($user_id,'website_address',true); ?>"><br/>

		<?php /*<label>Login Password</label>
<input type="text" name="franchise_password"  size="8;" value="kardio"><br/>*/?>

		<label> Video </label>
		<input type="text" id="video" name="video" value="<?php echo get_user_meta($user->ID, 'video', true);?>" />

		<?php /*<input type="hidden" name="user_id" value="<?php echo $user->ID; ?>"/> */?>
		<input type="hidden" name="action" value="am2_franchisee_account" />

		<input type="submit" value="Submit"/>

</form>

<div class="hr"></div>

<div class="form--section">
	<h2>Change your password</h2>
	<form id="frm_user_password" action="<?php echo admin_url('admin-ajax.php') ?>" method="POST" >
		<label>Password </label>
		<input type="password" name="password" id="password"    style="" ><br/>

		<label>Repeat Password </label>
		<input type="password" name="password2" id="password2"   style="" ><br/>

		<input type="hidden" name="action" value="am2_user_password" />
		<input type="submit" value="Submit"/>
	</form>
</div>

</div>

<script type="text/javascript">
				//Options field
uploadOptions = {
	template: "qq-simple-thumbnails-template",
	thumbnails: {
	    placeholders: {
			waitingPath: "<?php bloginfo('template_directory');?>/img/waiting-generic.png",
	        notAvailablePath: "<?php bloginfo('template_directory');?>/img/not_available-generic.png"
		}
	},
	request: {
	    endpoint: '<?php echo admin_url('admin-ajax.php'); ?>',
	    params: {
	        action: 'upload_user_photo',
			user_id: '<?php echo $user->ID; ?>',
	    }
	},
	validation: {
	      allowedExtensions: ['jpeg', 'jpg', 'gif', 'png', 'zip', 'ai', 'psd', 'rar', 'pdf'],
		  sizeLimit: 10485760
	  },
  	multiple: false
}

</script>

<!-- Fine Uploader template
====================================================================== -->
<script type="text/template" id="qq-simple-thumbnails-template">
	<div class="qq-uploader-selector qq-uploader">
    <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
      <span>Drop files here to upload</span>
    </div>
    <div class="qq-upload-button-selector qq-upload-button">
      <div class="button small-button">Upload image</div>
    </div>
    <ul class="qq-upload-list-selector qq-upload-list">
      <li>
		<span class="qq-drop-processing-selector qq-drop-processing">
			<span>Processing dropped files...</span>
			<span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
		</span>
        <div class="qq-progress-bar-container-selector">
          <div class="qq-progress-bar-selector qq-progress-bar"></div>
        </div>
        <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
        <img class="qq-thumbnail-selector" qq-max-size="100" qq-server-scale>
        <span class="qq-edit-filename-icon-selector qq-edit-filename-icon"></span>
        <span class="qq-upload-file-selector qq-upload-file"></span>
        <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
        <span class="qq-upload-size-selector qq-upload-size"></span>
        <a class="qq-upload-cancel-selector qq-upload-cancel" href="#">Cancel</a>
        <a class="qq-upload-retry-selector qq-upload-retry" href="#">Retry</a>
        <a class="qq-upload-delete-selector qq-upload-delete" href="#">Delete</a>
        <span class="qq-upload-status-text-selector qq-upload-status-text"></span>
      </li>
    </ul>
  </div>
</script>