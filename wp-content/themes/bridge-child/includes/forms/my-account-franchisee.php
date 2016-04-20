<?php $umeta = get_user_meta($user->ID); //, 'city__state',true);
$city_state = explode('|', $umeta['city__state'][0]);
?>

<form id="frm_franchisee_account" action="<?php echo admin_url('admin-ajax.php') ?>" method="POST">
		<label>Franchise Name *</label>
		<input type="text" name="franchise_name" required maxlength="128" style="width: 98%; " value="<?=$umeta['franchise_name'][0];?>"><br/>


		<label>Owners *</label>
		<input type="text" name="franchise_owner" required maxlength="128" style="width:98%;" value="<?=$umeta['owners'][0];?>"><br/>


		<label>Mailing Address *</label>
		<input type="text" name="franchise_address" required maxlength="128" style="width:98%;" value="<?=$umeta['mailing_address'][0];?>"><br/>

		<label>State *</label>
		<select name="franchise_state" required placeholder="Select a state..." class="am2_cc_state" style="width:98%;">
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

		<label>City *</label>
		<input type="text" name="franchise_city" required maxlength="128" style="width:98%;" value="<?php echo $city_state[1]; ?>" class="am2_cc_city"><br/>

		<input type="hidden" name="franchise_city_state" class="cc_city_state" />


		<label>ZIP Code *</label>
		<input type="text" name="franchise_zip" required maxlength="10" size="10" value="<?php echo $umeta['zip_code'][0]; ?>"><br/>


		<label>Telephone *</label>
		<input type="text" name="franchise_telephone" required maxlength="20" size="20" value="<?php echo $umeta['telephone'][0]; ?>"><br/>


		<label>Fax</label>
		<input type="text" name="franchise_fax" maxlength="20" size="20" value="<?php echo $umeta['fax'][0]; ?>"><br/>


		<label>Email Address *</label>
		<input type="text" name="franchise_email" required data-rule-email="true" maxlength="128" style="width:98%;" value="<?php echo $user->user_email; ?>"><br/>

		<label>Password *</label>
		<input type="password" name="password" id="password" required  maxlength="128" style="width:98%;" ><br/>

		<label>Repeat Password *</label>
		<input type="password" name="password2" id="password2" required maxlength="128" style="width:98%;" ><br/>

		<label>AA Email Address</label>
		<input type="text" name="franchise_aaemail" data-rule-email="true" maxlength="128" style="width:98%;" value="<?php echo $umeta['aa_email_address'][0]; ?>"><br/>


		<label>Website Address</label>
		<input type="text" name="franchise_website" maxlength="128" style="width:98%;" value="<?php echo $umeta['website_address'][0]; ?>"><br/>


		<?php /*<label>Login Password</label>
<input type="text" name="franchise_password" maxlength="8" size="8;" value="kardio"><br/>*/?>


		<label>Market Area</label>
		<td><textarea name="franchise_market" rows="2" style="width:98%;"><?php echo $umeta['market_area'][0]; ?></textarea></td>


		<label> Facebook Page</label>
		<input type="text" name="franchise_facebook" maxlength="255" style="width:98%;" value="<?php echo $umeta['facebook_page'][0]; ?>"><br/>


		<label> YouTube Page</label>
		<input type="text" name="franchise_youtube" maxlength="255" style="width:98%;" value="<?php echo $umeta['youtube_page'][0]; ?>"><br/>


		<label> Twitter Page</label>
		<input type="text" name="franchise_twitter" maxlength="255" style="width:98%;" value="<?php echo $umeta['twitter_page'][0]; ?>"><br/>


		<label> Pinterest Page</label>
		<input type="text" name="franchise_pinterest" maxlength="255" style="width:98%;" value="<?php echo $umeta['pinterest_page'][0]; ?>"><br/>

		<div class="franchisee_photo_wrap">
			<?php
$custom_image = get_field('franchisee_photo', 'user_' . $user->ID);
if ($custom_image) {$custom_image_url = wp_get_attachment_image_src($custom_image, 'thumbnail');?>
				<img src="<?php echo $custom_image_url[0]; ?>" width="175"/>
				<br/>
				<a class='delete_button button small-button' id='btn_delete_franchisee_photo' data-attid="<?php echo $custom_image; ?>" >Delete image</a>
			<?php } else {?>
				<div id="digital_image_upload"></div>
			<?php }?>

		</div>

		<?php /*<input type="hidden" name="user_id" value="<?php echo $user->ID; ?>"/> */?>
		<input type="hidden" name="action" value="am2_franchisee_account" />

		<input type="submit" value="submit"/>

</form>

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
	        action: 'upload_franchise_photo',
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