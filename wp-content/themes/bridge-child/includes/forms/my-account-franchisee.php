<?php
$user_id = $user->ID;
$umeta = get_user_meta($user->ID); //, 'city__state',true);
$city_state = get_user_meta($user_id,'city__state',true);

global $image_fields;

function generate_image_field($field_name, $context, $context_id){

	global $image_fields;
	$new_field['key'] = $field_name;
	$new_field['context'] = $context;

	$image_fields[] = $new_field;

	if(empty($context)) return;
	if(empty($context_id)) return;

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

	echo $output;
	return;
}

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
		<label>DBA *</label>
		<input type="text" name="franchise_name" required  style="" value="<?=get_user_meta($user_id,'franchise_name',true);?>"><br/>

		<label>Display Name</label>
		<input type="text" name="display_name"  style="" value="<?=get_user_meta($user_id,'display_name',true);?>"><br/>

		<label>Display Title</label>
		<input type="text" name="display_title"  style="" value="<?=get_user_meta($user_id,'display_title',true);?>"><br/>	

		<label>Display Email</label>
		<input type="text" name="franchise_aaemail" data-rule-email="true"  style="" value="<?php echo get_user_meta($user_id,'aa_email_address',true); ?>"><br/>

		<label>Display Phone Number *</label>
		<input type="text" name="franchise_telephone" required  size="20" value="<?php echo get_user_meta($user_id,'telephone',true); ?>"><br/>			

		<?php /*<label>Display Market</label>
		<input type="text" name="display_market"  style="" value="<?php echo get_user_meta($user_id,'display_market',true); ?>"><br/>*/?>		

		<label>Upload Provider Photo</label>
		<div class="photo_wrap">
			<?php
			/*$custom_image = get_field('user_photo', 'user_' . $user_id);
			
			if ($custom_image) {$custom_image_url = wp_get_attachment_image_src($custom_image, 'medium');?>
				<img src="<?php echo $custom_image_url[0]; ?>" width="175"/>
				<br/>
				<a class='delete_button button small-button' id='btn_delete_user_photo' data-attid="<?php echo $custom_image; ?>" data-user-id="<?php echo $user_id;?>" >Delete image</a>
			<?php } else {?>
				<div id="digital_image_upload"></div>
			<?php }?>*/
			?>
			<?php generate_image_field('user_photo', 'user', $user_id); ?>

		</div>

		<label>Display Bio</label>
		<?php 
			$display_bio = get_user_meta($user_id,'display_bio',true);
			wp_editor( $display_bio, 'display_bio' );
		?>
		<?php /*<textarea name="display_bio"><?php echo get_user_meta($user_id,'display_bio',true); ?></textarea>*/?>

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

			<label> Instagram Page</label>
			<?php 
			$link = get_user_meta($user_id,'instagram_page',true); 
			if(empty($link)) {
				$link = 'https://www.instagram.com/amazingathletes/';
			}
			?>
			<input type="text" name="franchise_instagram"  style="" value="<?php echo $link; ?>"><br/>

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
		
		<?php /*<label>Franchise Contact Number *</label>
		<input type="text" name="franchise_telephone" required  size="20" value="<?php echo get_user_meta($user_id,'telephone',true); ?>"><br/>*/?>

		<label>Franchise Contact E-Mail *</label>
		<input type="text" name="franchise_email" required data-rule-email="true"  style="" value="<?php echo $user->user_email; ?>"><br/>		

		<?php /*<label>Franchise Website</label>
		<input type="text" name="franchise_website"  style="" value="<?php echo get_user_meta($user_id,'website_address',true); ?>"><br/>*/ ?>

		<?php /*<label>Login Password</label>
<input type="text" name="franchise_password"  size="8;" value="kardio"><br/>*/?>

		<label> Video </label>
		<input type="text" id="video" name="video" value="<?php echo get_user_meta($user->ID, 'video', true);?>" />

		<div class="form--section" id="payment_intro" >
			<h3>Payment Popup Intro</h3>
			<?php
				$payment_intro_msg = get_user_meta( $user_id, 'payment_intro_msg'  , true );					

				wp_editor( $payment_intro_msg, 'payment_intro_msg' );
			?>
		</div>

		<div class="form--section" id="personal_check_of_cash_payment" data-section="class-payment-option" >
			<h3>Personal Check Or Cash Payments</h3>
			<?php										
				$personal_check_payment_msg = get_user_meta( $user_id, 'personal_check_payment_msg'  , true );					

				wp_editor( $personal_check_payment_msg, 'personal_check_payment_msg' );
			?>
		</div>
		<div class="form--section" id="one_time_credit_card_payment" data-section="class-payment-option" >
			<h3>One Time Credit Card Payment</h3>
			<?php
				$one_time_credit_card_payment_msg = get_user_meta( $user_id, 'one_time_credit_card_payment_msg'  , true );					

				wp_editor( $one_time_credit_card_payment_msg, 'one_time_credit_card_payment_msg' );
			?>
		</div>
		<div class="form--section" id="recurring_credit_card_payments" data-section="class-payment-option" >
			<h3>Recurring Credit Card Payments</h3>
			<?php
				$recurring_payment_msg = get_user_meta( $user_id, 'recurring_payment_msg'  , true );					

				wp_editor( $recurring_payment_msg, 'recurring_payment_msg' );
			?>
		</div>

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
         	  jQuery(this).parent().delay(1000).fadeOut(400, function(){
              jQuery(this).empty().append('<div class="upload_success"><img class="photo_preview" src="'+responseJSON.file_url+'" width="175"/><a class="delete_button button small-button" id="btn_delete_'+responseJSON.custom_field_key+'" data-attid="'+responseJSON.file_id+'" data-context-id="'+responseJSON.context_id+'" data-context="'+responseJSON.context+'" data-custom_field_key="'+responseJSON.custom_field_key+'">x</a></div>').fadeIn();
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
		loadDigitalArtwork_multiple('<?php echo $image_field["key"]; ?>', '<?php echo $image_field["context"]; ?>', '<?php echo $user->ID; ?>');
		jQuery(document).on('click','#btn_delete_<?php echo $image_field["key"]; ?>', function(e){
		    e.preventDefault();
		    jQuery(this).empty().append('Deleting...');
		    delete_digital_artwork_multiple(jQuery(this).data('attid'), jQuery(this).data('context'), jQuery(this).data('context-id'), jQuery(this).data('custom_field_key'));
		});
	<?php endforeach; ?>
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