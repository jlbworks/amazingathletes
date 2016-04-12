<?php /*Template name: Login*/?>
<?php wp_head();?>
<?php if(!is_user_logged_in()){?>
<div class="col-1">
	<!--<h1>Welcome to Unbuckled</h1>-->
	
	<section class="clearfix">
		<h2 class="title">Log in</h2>

		<form action="#" method="post" id="frm_login">
		<input type="hidden" name="action" value="am2_login" />
																	<input type="hidden" name="current_url" value="/join/" />
			<div class="row">
				<!--<label for="username">Username or e-mail address:</label>-->
				<input type="text" id="username" name="username" placeholder="Username or e-mail address"/>
			</div>
			<div class="row">
				<!--<label for="password">Password:</label>-->
				<input type="password" id="password" name="password" placeholder="Password" />
			</div>
			<div class="row">
				<p>Forgot your password? <a class="show_forgot_password" href="#forgot_password">Click here</a>.</p>								
			</div>
			<div class="row">
				<input type="checkbox" id="remember" name="remember" checked="checked" />
				<label for="remember"><span></span>Remember me</label>
			</div>
			<div class="row clearfix">
				<input type="submit" value="Log in" class="btn-login" />
			</div>
		</form>
		<br/>
		<div class="forgot_password_wrap hidden">
			<!--<label for="forgot_password">Enter username or email</label>							-->
			<input type="text" id="forgot_password" name="forgot_password" placeholder="Enter username or email"/>
			<button id="new_password" class="button">Request password reset</button>
		</div>
	</section>

	<div class="divider"></div>				

</div>


<!-- start:message -->
<div class="clearfix remodal remodal_user" id="remodal-message" data-remodal-id="message" >
	<button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
	<div class="col-1">
		<h3 class="title">
		</h3>
		<div class="message">
		</div>
		<a href="#ok" class="button remodal-confirm" data-remodal-action="confirm">OK</a>
	</div>

</div>
<!-- end:message -->
<?php } ?>
<?php wp_footer();?>