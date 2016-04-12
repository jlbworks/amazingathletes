<?php $umeta = get_user_meta($user->ID); //, 'city__state',true);
$city_state = explode('|', $umeta['city__state'][0]);
?>

<form id="frm_franchisee_account" action="<?php echo admin_url('admin-ajax.php') ?>" method="POST">
		<label>Franchise Name *</label>
		<input type="text" name="franchise_name" required maxlength="128" style="width: 98%; background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGP6zwAAAgcBApocMXEAAAAASUVORK5CYII=&quot;);" value="<?=$umeta['franchise_name'][0];?>"><br/>


		<label>Owners *</label>
		<input type="text" name="franchise_owner" required maxlength="128" style="width:98%;" value="<?=$umeta['owners'][0];?>"><br/>


		<label>Mailing Address *</label>
		<input type="text" name="franchise_address" required maxlength="128" style="width:98%;" value="<?=$umeta['mailing_address'][0];?>"><br/>


		


		<label>State *</label>
		<select name="franchise_state" required placeholder="Select a state...">
			<option value=""></option>		
			<option value="">Select a state...</option>
			<?php 
			$states_db = $wpdb->get_results("SELECT DISTINCT * FROM states ORDER BY state ASC");
			$states = array();
			if ($states_db) {
				foreach ($states_db AS $state) {?>
				<option <?php echo ($state->state_code == $city_state[0] ? 'selected' : '' );?> value="<?php echo $state->state_code;?>"><?php echo $state->state;?></option>						
				<?php }
			}
			?>
			
		</select>

		</select><br/>
		
		<label>City *</label>
		<input type="text" name="franchise_city" required maxlength="128" style="width:98%;" value="<?php echo $city_state[1];?>"><br/>

		<input type="hidden" name="franchise_city_state" class="cc_city_state" />


		<label>ZIP Code *</label>
		<input type="text" name="franchise_zip" required maxlength="10" size="10" value="<?php echo $umeta['zip_code'][0];?>"><br/>


		<label>Telephone *</label>
		<input type="text" name="franchise_telephone" required maxlength="20" size="20" value="<?php echo $umeta['telephone'][0];?>"><br/>


		<label>Fax</label>
		<input type="text" name="franchise_fax" maxlength="20" size="20" value="<?php echo $umeta['fax'][0];?>"><br/>


		<label>Email Address *</label>
		<input type="text" name="franchise_email" required data-rule-email="true" maxlength="128" style="width:98%;" value="<?php echo $umeta['email_address'][0];?>"><br/>


		<label>AA Email Address</label>
		<input type="text" name="franchise_aaemail" data-rule-email="true" maxlength="128" style="width:98%;" value="<?php echo $umeta['aa_email_address'][0];?>"><br/>


		<label>Website Address</label>
		<input type="text" name="franchise_website" maxlength="128" style="width:98%;" value="<?php echo $umeta['website_address'][0];?>"><br/>


		<?php /*<label>Login Password</label>
		<input type="text" name="franchise_password" maxlength="8" size="8;" value="kardio"><br/>*/ ?>


		<label>Market Area</label>
		<td><textarea name="franchise_market" rows="2" style="width:98%;"><?php echo $umeta['market_area'][0];?></textarea></td>


		<label> Facebook Page</label>
		<input type="text" name="franchise_facebook" maxlength="255" style="width:98%;" value="<?php echo $umeta['facebook_page'][0];?>"><br/>


		<label> YouTube Page</label>
		<input type="text" name="franchise_youtube" maxlength="255" style="width:98%;" value="<?php echo $umeta['youtube_page'][0];?>"><br/>


		<label> Twitter Page</label>
		<input type="text" name="franchise_twitter" maxlength="255" style="width:98%;" value="<?php echo $umeta['twitter_page'][0];?>"><br/>


		<label> Pinterest Page</label>
		<input type="text" name="franchise_pinterest" maxlength="255" style="width:98%;" value="<?php echo $umeta['pinterest_page'][0];?>"><br/>

		<input type="hidden" name="user_id" value="<?php echo $user->ID; ?>"/>
		<input type="hidden" name="action" value="am2_franchisee_account" />

		<input type="submit" value="submit"/>

</form>