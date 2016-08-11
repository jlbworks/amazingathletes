<?php 
/*
 * This is the page users will see logged out. 
 * You can edit this, but for upgrade safety you should copy and modify this file into your template folder.
 * The location from within your template folder is plugins/login-with-ajax/ (create these directories if they don't exist)
*/
?>
<div class="lwa lwa-divs-only"> 
	<span class="lwa-status"></span>
    <form action="<?php echo esc_attr(LoginWithAjax::$url_login); ?>" method="post" class="lwa-form">
							<div class="form-group mb-lg">
								<label>Username</label>
								<div class="input-group input-group-icon">
                                	<input type="text" name="log" id="lwa_user_login" class="form-control input-lg" />
									<span class="input-group-addon">
										<span class="icon icon-lg">
											<i class="fa fa-user"></i>
										</span>
									</span>
								</div>
							</div>

							<div class="form-group mb-lg">
								<div class="clearfix">
									<label class="pull-left">Password</label>
                                    <a class="lwa-links-remember pull-right" tabindex="-1" href="<?php echo esc_attr(LoginWithAjax::$url_remember); ?>" title="Lost Password?">Lost Password?</a>
								</div>
								<div class="input-group input-group-icon">
                                	<input type="password" name="pwd" id="lwa_user_pass" class="form-control input-lg" />
									<span class="input-group-addon">
										<span class="icon icon-lg">
											<i class="fa fa-lock"></i>
										</span>
									</span>
								</div>
							</div>

							<div class="row">

                            	<div class="lwa-submit-button">
                                    <input type="hidden" name="lwa_profile_link" value="<?php echo esc_attr($lwa_data['profile_link']); ?>" />
                                    
                                    
                                </div>

								<div class="col-sm-8">
									<div class="checkbox-custom checkbox-default">
                                    	<input name="rememberme" id="rememberme" type="checkbox" class="lwa-rememberme" value="forever" />
										<label for="rememberme">Remember Me</label>
									</div>
								</div>
								<div class="col-sm-4 text-right">
                                <!--id="lwa_wp-submit" -->
                                	<button type="submit" name="wp-submit"  class="btn btn-primary hidden-xs">Sign In</button>
                                    <button type="submit" name="wp-submit"  class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Sign In</button>
									<input type="hidden" name="login-with-ajax" value="login" />
                                    <?php if( !empty($lwa_data['redirect']) ): ?>
                                    <input type="hidden" name="redirect_to" value="<?php echo esc_url($lwa_data['login_redirect']); ?>" />
                                    <?php endif; ?>
								</div>
							</div>
                            
                            <div class="lwa-login_form">
								<?php do_action('login_form'); ?>
                            </div>

							<span class="mt-lg mb-lg line-thru text-center text-uppercase">
								<span>or</span>
							</span>

							<?php /*<p class="text-center">Don't have an account yet? <a href="pages-signup.html">Sign Up!</a>*/ ?>

						</form>
                        
                        <?php if( !empty($lwa_data['remember']) ): ?>
                        <form class="lwa-remember" action="<?php echo esc_attr(LoginWithAjax::$url_remember); ?>" method="post" style="display:none;">
                            <h4>Forgott Your Password?</h4>
                            <div class="form-group mb-lg"> 
								<div class="input-group input-group-icon">
                                	 <?php $msg = __("Enter your email",'login-with-ajax'); ?>
                                	<input type="text" class="form-control input-lg" name="user_login" id="lwa_user_remember" value="<?php echo esc_attr($msg); ?>" onfocus="if(this.value == '<?php echo esc_attr($msg); ?>'){this.value = '';}" onblur="if(this.value == ''){this.value = '<?php echo esc_attr($msg); ?>'}" />
									<span class="input-group-addon">
										<span class="icon icon-lg">
											<i class="fa fa-lock"></i>
										</span>
									</span>
								</div>
							</div>
                            <?php do_action('lostpassword_form'); ?>
							<div class="row">
                                <div class="col-sm-8 lwa-submit-button">
                                    <button type="submit" name="wp-submit"  class="btn btn-primary hidden-xs">Get New Password</button>
                                    <button type="submit" name="wp-submit"  class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Get New Password</button>
                                    <a href="#" class="lwa-links-remember-cancel"><?php esc_attr_e("Cancel", 'login-with-ajax'); ?></a>
                                    <input type="hidden" name="login-with-ajax" value="remember" />         
                                </div>
                            </div>
                        </form>
                        <?php endif; ?>
	
		
	
	<?php /* if ( $lwa_data['registration'] == true ) : ?>
	<div class="lwa-register" style="display:none;" >
		<form class="registerform" action="<?php echo esc_attr(LoginWithAjax::$url_register); ?>" method="post">
			<p><strong><?php esc_html_e('Register For This Site','login-with-ajax'); ?></strong></p>         
			<div class="lwa-username">
				<?php $msg = __('Username','login-with-ajax'); ?>
				<input type="text" name="user_login" id="user_login"  value="<?php echo esc_attr($msg); ?>" onfocus="if(this.value == '<?php echo esc_attr($msg); ?>'){this.value = '';}" onblur="if(this.value == ''){this.value = '<?php echo esc_attr($msg); ?>'}" />   
		  	</div>
		  	<div class="lwa-email">
		  		<?php $msg = __('E-mail','login-with-ajax'); ?>
				<input type="text" name="user_email" id="user_email"  value="<?php echo esc_attr($msg); ?>" onfocus="if(this.value == '<?php echo esc_attr($msg); ?>'){this.value = '';}" onblur="if(this.value == ''){this.value = '<?php echo esc_attr($msg); ?>'}"/>   
			</div>
			<?php
				//If you want other plugins to play nice, you need this: 
				do_action('register_form'); 
			?>
			<p class="lwa-submit-button">
				<?php esc_html_e('A password will be e-mailed to you.','login-with-ajax') ?>
				<input type="submit" name="wp-submit" id="wp-submit" class="button-primary" value="<?php esc_attr_e('Register', 'login-with-ajax'); ?>" tabindex="100" />
				<a href="#" class="lwa-links-register-inline-cancel"><?php esc_html_e("Cancel", 'login-with-ajax'); ?></a>
				<input type="hidden" name="login-with-ajax" value="register" />
			</p>
		</form>
	</div>
	<?php endif; */ ?>
</div>