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
<?php
global $image_fields;
function generate_image_field($field_name, $context, $context_id){

	global $image_fields;
	$new_field['key'] = $field_name;
	$new_field['context'] = $context;

	$image_fields[] = $new_field;

	if(empty($context)) return;
	//if(empty($context_id)) return;

	if($context == 'post')
	$custom_image_id = get_post_meta($context_id, $field_name, true);

	if($context == 'user')
	$custom_image_id = get_user_meta($context_id, $field_name, true);

	$output = '';
	if ($custom_image_id) {
		$custom_image_url = wp_get_attachment_image_src($custom_image_id, 'medium');
		$output .= '<img class="photo_preview" src="'.$custom_image_url[0].'" width="175"/>';
		$output .= '<a class="delete_button button small-button" id="btn_delete_'.$field_name.'" data-attid="'.$custom_image_id.'" data-context-id="'.$context_id.'" data-context="'.$context.'" data-custom_field_key="'.$field_name.'">x</a>';
	 } else {
		$output .= '<div id="digital_image_upload_'.$field_name.'"></div>';
	}
	$output .= '<input name="'.$field_name.'" type="hidden" value="'.(!empty($custom_image_id) ? $custom_image_id : '') .'" />';

	echo $output;
	return;
}

?>

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
		<div class="form--section">
		<h2>Contact Information</h2>

			<label>First Name *</label>
			<input type="text" id="first_name" name="first_name"  style="" value="<?php echo $staff->first_name; ?>" required><br/>

			<label>Last Name *</label>
			<input type="text" id="last_name" name="last_name"  style="" value="<?php echo $staff->last_name; ?>" required><br/>

			<label>Street Address</label>
			<input type="text" id="street_address" name="street_address" style="" value="<?php echo  $staff->street_address; ?>"><br/>
			
			<?php
			$pmeta = get_user_meta($staff_id);
			if (!empty($pmeta['city__state'][0])) {
				$city_state = explode('|', $pmeta['city__state'][0]);
			}
			?>
			<label>State *</label>
			<select name="state"  placeholder="Select a state..." class="am2_cc_state" style="">
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
			<input type="text" name="city" required  style="" value="<?php echo $city_state[1]; ?>" class="am2_cc_city" >
			<input type="hidden" name="city__state" class="cc_city_state" />

			<label>Zip Code</label>
			<input type="text" id="zip_code" name="zip_code"  style="" value="<?php echo get_user_meta($staff_id, 'zip_code', true); ?>"><br/>

			<label>Personal Email *</label>
			<input type="text" id="coach_email" data-rule-email="true" name="coach_email"  style="" value="<?php echo $staff->user_email; ?>" required><br/>
			
			<label>Amazing Athletes forward</label>
			<input type="text" id="amazing_athletes_forward" name="amazing_athletes_forward" style="" value="<?php echo  $staff->amazing_athletes_forward; ?>"><br/>
			
			<label>Forwarding aa to e-mail</label>
			<input type="text" id="forwarding_aa_to_email" name="forwarding_aa_to_email" style="" value="<?php echo  $staff->forwarding_aa_to_email; ?>"><br/>
			
			<label>Contact Number</label>
			<input type="text" id="contact_number" name="contact_number" style="" value="<?php echo  $staff->contact_number; ?>"><br/>
			
			<label>Emergency Contact Name</label>
			<input type="text" id="emergency_contact_name" name="emergency_contact_name" style="" value="<?php echo  $staff->emergency_contact_name; ?>"><br/>
			
			<label>Emergency Contact Number</label>
			<input type="text" id="emergency_contact_email" name="emergency_contact_email" style="" value="<?php echo  $staff->emergency_contact_name; ?>"><br/>
			
			<label>Birthday</label>
			<input type="text" id="birthday" class="datepicker" name="birthday" style="" value="<?php echo $staff->birthday; ?>"><br/>
		</div>
		
		<div class="form--section">
			<h2>Staff Legal Details</h2>

			<label>Title</label>
			<input type="text" id="title" name="title" style="" value="<?php echo  $staff->title; ?>"><br/>
			
			<label>Employment Type</label>
			<select name="employment_type">	
				<option<?php if($class_type == 'Independent Contractor'){ ?> selected="selected"<?php } ?>>Independent Contractor</option>	
				<option<?php if($class_type == 'Employee'){ ?> selected="selected"<?php } ?> >Employee</option>
			</select>

			<label>Coach Photo </label>
			<div class="photo_wrap">
				<?php
					generate_image_field('user_photo', 'user', (empty($staff->ID) ? -1 : $staff->ID) );
				?>
			</div>	
	
			<label>Coach Bio </label>
			<!--<textarea id="coach_description"  name="coach_description"  style=""  ><?php echo $staff->coach_description; ?></textarea><br/>-->			
			<?php wp_editor( $staff->coach_description, 'coach_description', array(
				'media_buttons' => true,
				'dfw' => true,
				'textarea_name' => 'coach_description',
				"drag_drop_upload" => true
				) ); ?>			
		</div>
		<div class="form--section">
			<h2>Coaching Documents</h2>
			
			<select id="class-registration-options" class="js-induce-change-select-class" name="registration_option" <?php if (true === $please_confirm_delete): ?>disabled<?php endif; ?> >
				<option value="-">... Choose document type</option>
				<?php 
				$possible_coaching_documents = array(
					'non_disclosure_agreement' => 'Non-disclosure Agrreement',
					'background_check' => 'Background Check',
					'independent_contractor_agreement' => 'Independent Contractor Agreement',
					'employee_noncompete_agreement' => 'Employee Non-compete Agreement',
					'fingerprint_compliance' => 'Fingerprint Compliance',
					'tb_test' => 'TB Test',
					'study_transcripts' => 'Study Transcripts',
					'cpr_certification' => 'CPR certification',
					'certificate_of_liability' => 'Certificate of Liability',
					'copy_of_drivers_license' => 'Copy of Drivers License',
					'inventory_checklist' => 'Inventory Checklist',
				);
				foreach ($possible_coaching_documents as $key => $value):
					/*$if_selected = '';
					if ($registration_option == $class_registration_option) {
						$if_selected = "selected=selected";
					}*/
				?>
				<option <?php echo $if_selected; ?> 
				
				data-change-to-id="<?php echo $key; ?>"
				data-change-to-section="class_change_document"
				value="<?php echo $key; ?>"><?php echo $value; ?></option>
				<?php endforeach ?>
			</select>
			<?php
			foreach ($possible_coaching_documents as $key => $value): ?>
				<div id="<?php echo $key; ?>" data-section="class_change_document" style="display:none;">
					<label><?php echo $value; ?></label>
					<div class="photo_wrap">
					<?php 
						generate_image_field($key, 'user', (empty($staff->ID) ? -1 : $staff->ID) );
					?>
					</div>
				</div>
			<?php endforeach ?>

			
		</div>
		

		


		<input type="hidden" id="user_id" name="user_id" value="<?php echo $staff_id;?>" />	
		
		<input type="hidden" name="action" value="am2_edit_staff" />

		<input type="submit" value="Submit"/>
	</form>

</div>
<?php 
//print_r($image_fields);
?>
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

	function changeTo(target_id, section) {

		jQuery('[data-section="'+section+'"]').hide();
		jQuery('#'+target_id).show();
	}
</script>
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
	        action: 'upload_file',
			//context_id: '<?php echo $staff_id; ?>',
	    }
	},
	validation: {
	      allowedExtensions: ['jpeg', 'jpg', 'gif', 'png', 'zip', 'ai', 'psd', 'rar', 'pdf'],
		  sizeLimit: 10485760
	  },
  	multiple: false
}

function delete_digital_artwork_multiple(attach_id, context, context_id, field_name){

   jQuery.ajax({
        url:ajax_login_object.ajaxurl,
        type:'POST',
        data:'action=ajax_delete_image&attachid=' + attach_id + '&context_id=' + context_id + '&context=' + context+ '&custom_field_key=' + field_name,
        success:function(response)
        {       
        console.log(response); 
        	if(response.success){
	            jQuery('#btn_delete_'+field_name+'').fadeOut(400, function(){ 
	                jQuery(this).parent().empty().append('<div id="digital_image_upload_'+field_name+'" style="display:none;">Upload</div>'); 
	                jQuery('#digital_image_upload_'+field_name+'').fadeIn(); 
	                loadDigitalArtwork_multiple(field_name, context, context_id);
	            });
        	}
            
        }
    });
}

function loadDigitalArtwork_multiple(field_name, context, context_id){
    console.log('loadDigitalArtwork');
    if(typeof uploadOptions === 'undefined') return;
    console.log('loadDigitalArtwork continued');
    
    uploadOptions['request']['params']['custom_field_key'] = field_name;
    uploadOptions['request']['params']['context'] = context;
    uploadOptions['request']['params']['context_id'] = context_id; console.log(uploadOptions);
    jQuery('#digital_image_upload_'+field_name).fineUploader(uploadOptions).on('complete', function(event, id, fileName, responseJSON) {
       if (responseJSON.success) {
		   	//jQuery('input[name="'+responseJSON.custom_field_key+'"]').val(responseJSON.file_id);
         	  jQuery(this).parent().delay(1000).fadeOut(400, function(){
              jQuery(this).empty().append('<div class="upload_success"><img class="photo_preview" src="'+responseJSON.file_url+'" width="175"/><a class="delete_button button small-button" id="btn_delete_'+responseJSON.custom_field_key+'" data-attid="'+responseJSON.file_id+'" data-context-id="'+responseJSON.context_id+'" data-context="'+responseJSON.context+'" data-custom_field_key="'+responseJSON.custom_field_key+'">x</a><input name="'+responseJSON.custom_field_key+'" type="hidden" value="'+responseJSON.file_id+'" /></div>').fadeIn();
              jQuery(document).on('click','#btn_delete_'+responseJSON.custom_field_key, function(e){
			    e.preventDefault();
			    jQuery(this).empty().append('Deleting...');
			    delete_digital_artwork_multiple(jQuery(this).data('attid'), jQuery(this).data('context'), jQuery(this).data('context-id'), jQuery(this).data('custom_field_key'));
			});
          });
       }
    });
} 

jQuery(document).ready(function(){
	<?php foreach($image_fields as $image_field): ?>
		loadDigitalArtwork_multiple('<?php echo $image_field["key"]; ?>', '<?php echo $image_field["context"]; ?>', '<?php echo $staff->ID; ?>');
		jQuery(document).on('click','#btn_delete_<?php echo $image_field["key"]; ?>', function(e){
		    e.preventDefault();
		    jQuery(this).empty().append('Deleting...');
		    delete_digital_artwork_multiple(jQuery(this).data('attid'), jQuery(this).data('context'), jQuery(this).data('context-id'), jQuery(this).data('custom_field_key'));
		});
	<?php endforeach; ?>
});


</script>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('.datepicker').datetimepicker({
		  timepicker:false,
  		  format:'d/m/Y'
	});
});
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