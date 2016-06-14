<?php
global $wpdb;
$staff_id = 0;
$current_user_id = get_current_user_id();

if (!empty($_GET['user_id'])) {
	$staff_id = (int) $_GET['user_id'];
	$umeta = get_user_meta($staff_id);	
	
	$staff = get_user_by('id',$staff_id);
}

if ((!empty($staff) && $staff->franchisee == $current_user_id) || isset($_GET['add'])) { ?>

<div class="user_form">
	<a class="button" href="<?php the_permalink();?>">Back</a>
	<form id="frm_edit_staff" action="<?php echo admin_url('admin-ajax.php') ?>" method="POST" >
		<?php /*<label>Staff member Type *</label>
		<?php
		$field_key = "field_570b6ef56c895";
		$field = get_field_object($field_key);
		$staff_type = get_user_meta($staff_id, 'staff_type', true);

		if ($field) {
			echo '<select name="staff_type" required>';
			foreach ($field['choices'] as $k => $v) {
				echo '<option ' . ($k == $staff_type ? 'selected' : '') . ' value="' . $k . '">' . $v . '</option>';
			}
			echo '</select>';
		}?><br/>*/?>

		<label>First Name *</label>
		<input type="text" id="first_name" name="first_name"  style="" value="<?php echo $staff->first_name; ?>" required><br/>

		<label>Last Name *</label>
		<input type="text" id="last_name" name="last_name"  style="" value="<?php echo $staff->last_name; ?>" required><br/>

		<label>Email *</label>
		<input type="text" id="coach_email" name="coach_email"  style="" value="<?php echo $staff->user_email; ?>" required><br/>

		<label>Description </label>
		<textarea id="coach_description"  name="coach_description"  style=""  ><?php echo $staff->description; ?></textarea><br/>

		<div class="user_photo_wrap">
			<?php
			$custom_image = get_field('user_photo', 'user_' . $staff_id);
			
			if ($custom_image) {$custom_image_url = wp_get_attachment_image_src($custom_image, 'medium');?>
				<img src="<?php echo $custom_image_url[0]; ?>" width="175"/>
				<br/>
				<a class='delete_button button small-button' id='btn_delete_user_photo' data-attid="<?php echo $custom_image; ?>" data-user-id="<?php echo $staff_id;?>" >Delete image</a>
			<?php } else {?>
				<div id="digital_image_upload"></div>
			<?php }?>

		</div>			

		<input type="hidden" id="user_id" name="user_id" value="<?php echo $staff_id;?>" />	
		
		<input type="hidden" name="action" value="am2_edit_staff" />

		<input type="submit" value="Submit"/>
	</form>

</div>

<script type="text/javascript">
				//Options field
uploadOptions = {
	template: "qq-simple-thumbnails-template",
	thumbnails: {
	    placeholders: {
			//waitingPath: "<?php bloginfo('template_directory');?>/img/waiting-generic.png",
	        //notAvailablePath: "<?php bloginfo('template_directory');?>/img/not_available-generic.png"
		}
	},
	request: {
	    endpoint: '<?php echo admin_url('admin-ajax.php'); ?>',
	    params: {
	        action: 'upload_user_photo',
			user_id: '<?php echo $staff_id; ?>',
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
<?php }?>