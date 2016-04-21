<?php 
	$umeta = get_user_meta($user->ID,$user->ID); //, 'city__state',true);	

	$city_state = get_user_meta($user->ID,'city__state');

	if(!empty($city_state)){
		$city_state  = explode('|', $city_state);
	} 
	else {
		$city_state = array('','');
	}
?>

<form id="frm_user_account" action="<?php echo admin_url('admin-ajax.php') ?>" method="POST" class="user_form">
	<label>First name *</label>
	<input type="text" name="first_name" required maxlength="128" style="" value="<?=implode(" ", array(get_user_meta($user->ID,'first_name',true) )) ;?>"><br/>

	<label>Last name *</label>
	<input type="text" name="last_name" required maxlength="128" style="" value="<?=implode(" ", array(get_user_meta($user->ID,'last_name',true) )) ;?>"><br/>

	<label>Email Address *</label>
	<input type="text" name="email" required data-rule-email="true" maxlength="128" style="" value="<?php echo $user->user_email ?>"><br/>

	<label>Password</label>
	<input type="password" name="password" id="password"   maxlength="128" style="" ><br/>

	<label>Repeat Password</label>
	<input type="password" name="password2" id="password2"  maxlength="128" style="" ><br/>

	<?php /*<input type="hidden" name="user_id" value="<?php echo $user->ID; ?>"/> */?>
	<input type="hidden" name="action" value="am2_user_account" />

	<input type="submit" value="submit"/>

</form>