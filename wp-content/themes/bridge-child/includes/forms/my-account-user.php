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

<div class="user_form">

<h3>Account information</h3>

<form id="frm_user_account" action="<?php echo admin_url('admin-ajax.php') ?>" method="POST" >
	<label>First name *</label>
	<input type="text" name="first_name" required  style="" value="<?=implode(" ", array(get_user_meta($user->ID,'first_name',true) )) ;?>"><br/>

	<label>Last name *</label>
	<input type="text" name="last_name" required  style="" value="<?=implode(" ", array(get_user_meta($user->ID,'last_name',true) )) ;?>"><br/>

	<label>Email Address *</label>
	<input type="text" name="email" required data-rule-email="true"  style="" value="<?php echo $user->user_email ?>"><br/>

	<?php /*<input type="hidden" name="user_id" value="<?php echo $user->ID; ?>"/> */?>
	<input type="hidden" name="action" value="am2_user_account" />

	<input type="submit" value="Submit"/>

</form>

<div class="hr"></div>

<h3>Change your password</h3>
<form id="frm_user_password" action="<?php echo admin_url('admin-ajax.php') ?>" method="POST" >
	<label>Password </label>
	<input type="password" name="password" id="password"    style="" ><br/>

	<label>Repeat Password </label>
	<input type="password" name="password2" id="password2"   style="" ><br/>

	<input type="hidden" name="action" value="am2_user_password" />
	<input type="submit" value="Submit"/>
</form>

</div>