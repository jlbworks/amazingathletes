<form id="frm_franchisee_account" action="<?php echo admin_url('admin-ajax.php') ?>" method="POST">
		<label>Franchise Name *</label>
		<input type="text" name="franchise_name" required maxlength="128" style="width: 98%; background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGP6zwAAAgcBApocMXEAAAAASUVORK5CYII=&quot;);" value="Amazing Athletes Corporate"><br/>


		<label>Owners *</label>
		<input type="text" name="franchise_owner" required maxlength="128" style="width:98%;" value="Glen &amp; Janee Henderson"><br/>


		<label>Mailing Address *</label>
		<input type="text" name="franchise_address" required maxlength="128" style="width:98%;" value="200 Watson View Drive"><br/>


		<label>City *</label>
		<input type="text" name="franchise_city" required maxlength="128" style="width:98%;" value="Franklin"><br/>


		<label>State *</label>
		<select name="franchise_state" required><option value=""></option><option value="AL">Alabama</option><option value="AK">Alaska</option><option value="AZ">Arizona</option><option value="AR">Arkansas</option><option value="CA">California</option><option value="CO">Colorado</option><option value="CT">Connecticut</option><option value="DE">Delaware</option><option value="DC">District of Columbia</option><option value="FL">Florida</option><option value="GA">Georgia</option><option value="GU">Guam</option><option value="HI">Hawaii</option><option value="ID">Idaho</option><option value="IL">Illinois</option><option value="IN">Indiana</option><option value="IA">Iowa</option><option value="KS">Kansas</option><option value="KY">Kentucky</option><option value="LA">Louisiana</option><option value="ME">Maine</option><option value="MD">Maryland</option><option value="MA">Massachusetts</option><option value="MI">Michigan</option><option value="MN">Minnesota</option><option value="MS">Mississippi</option><option value="MO">Missouri</option><option value="MT">Montana</option><option value="NE">Nebraska</option><option value="NV">Nevada</option><option value="NH">New Hampshire</option><option value="NJ">New Jersey</option><option value="NM">New Mexico</option><option value="NY">New York</option><option value="NC">North Carolina</option><option value="ND">North Dakota</option><option value="OH">Ohio</option><option value="OK">Oklahoma</option><option value="OR">Oregon</option><option value="PA">Pennsylvania</option><option value="PR">Puerto Rico</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option><option value="SD">South Dakota</option><option value="TN" selected="">Tennesse</option><option value="TX">Texas</option><option value="VI">US Virgin Islands</option><option value="UT">Utah</option><option value="VT">Vermont</option><option value="VA">Virginia</option><option value="WA">Washington</option><option value="WV">West Virginia</option><option value="WI">Wisconsin</option><option value="WY">Wyoming</option><option value=""></option><option value="AF">AF Africas</option><option value="AA">AF Americas</option><option value="AC">AF Canada</option><option value="AE">AF Europe</option><option value="AM">AF Middle East</option><option value="AP">AF Pacific</option><option value=""></option></select><br/>


		<label>ZIP Code *</label>
		<input type="text" name="franchise_zip" required maxlength="10" size="10" value="37067"><br/>


		<label>Telephone *</label>
		<input type="text" name="franchise_telephone" required maxlength="20" size="20" value="1-949-291-3147"><br/>


		<label>Fax</label>
		<input type="text" name="franchise_fax" maxlength="20" size="20" value="1-615-465-6656"><br/>


		<label>Email Address *</label>
		<input type="text" name="franchise_email" required data-rule-email="true" maxlength="128" style="width:98%;" value="janee@amazingathletes.com"><br/>


		<label>AA Email Address</label>
		<input type="text" name="franchise_aaemail" data-rule-email="true" maxlength="128" style="width:98%;" value="janee@amazingathletes.com"><br/>


		<label>Website Address</label>
		<input type="text" name="franchise_website" maxlength="128" style="width:98%;" value="www.amazingathletes.com/franchise"><br/>


		<label>Login Password</label>
		<input type="text" name="franchise_password" maxlength="8" size="8;" value="kardio"><br/>


		<label>Market Area</label>
		<td><textarea name="franchise_market" rows="2" style="width:98%;">Franchises Available Nationally</textarea></td>


		<label> Facebook Page</label>
		<input type="text" name="franchise_facebook" maxlength="255" style="width:98%;" value="https://www.facebook.com/AmazingAthletes"><br/>


		<label> YouTube Page</label>
		<input type="text" name="franchise_youtube" maxlength="255" style="width:98%;" value="http://www.youtube.com/channel/UCdJBfVZhc8FautsCagCsEjg"><br/>


		<label> Twitter Page</label>
		<input type="text" name="franchise_twitter" maxlength="255" style="width:98%;" value="https://twitter.com/AmazingAthlete"><br/>


		<label> Pinterest Page</label>
		<input type="text" name="franchise_pinterest" maxlength="255" style="width:98%;" value="http://www.pinterest.com/amazingathletes/"><br/>

		<input type="hidden" name="user_id" value="<?php echo $user->ID; ?>"/>
		<input type="hidden" name="action" value="am2_franchisee_account" />

		<input type="submit" value="submit"/>

</form>