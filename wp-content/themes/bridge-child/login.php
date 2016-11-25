<?php /*Template name: Login*/?>
<?php if(is_user_logged_in()) {wp_redirect( site_url() . '/my-account'); exit(); }?>
<?php get_header();?>
<?php if(!is_user_logged_in()){?>
<div class="content " style="min-height: 758px;">
						<div class="content_inner  ">
											<div class="full_width">
	<div class="full_width_inner">
							
					<div class="two_columns_25_75 clearfix grid2">
						<div class="column1">	<div class="column_inner">
		<aside class="sidebar">
							
			<div class="widget widget_text">			<div class="textwidget"><span class="icon-row">

    <div class="side-nav">
    </div>
	<?php /*<div class="side-nav"><a href="#" class="sidebar-link">
                         <span>
                             <img src="<?php echo site_url();?>/wp-content/uploads/2016/03/rescources-golf-icon.png" width="30px" class="spt-icons" id="golf2">
                         </span>
                         <span class="sidebar-nav">
                             <h2>MEET THE TEAM</h2>
                         </span></a>
    </div>
	<div class="side-nav"><a href="#" class="sidebar-link">
                         <span>
                             <img src="<?php echo site_url();?>/wp-content/uploads/2016/03/logout-baseball-icon.png" width="30px" class="spt-icons" id="bsball2">
                         </span>
                         <span class="sidebar-nav">
                             <h2>GET STARTED</h2>
                         </span></a>
    </div>*/ ?>
	
</span> </div>
		</div><?php am2_user_social();?><?php am2_franchisee_info();?><div class="widget widget_text">			<div class="textwidget"><div class="vc_row wpb_row section vc_row-fluid " style=" text-align:left;"><div class=" full_section_inner clearfix"><div class="wpb_column vc_column_container vc_col-sm-12"><div class="vc_column-inner "><div class="wpb_wrapper">	<div class="vc_empty_space  sidebar-spacer" style="height: 100px"><span class="vc_empty_space_inner">
			<span class="empty_space_image"></span>
		</span></div>

</div></div></div></div></div></div>
		</div>		</aside>
	</div>
</div>
						<div class="column2">
																	<div class="column_inner">
							<div class="vc_row wpb_row section vc_row-fluid " style=" text-align:left;"><div class=" full_section_inner clearfix"><div class="wpb_column vc_column_container vc_col-sm-12"><div class="vc_column-inner "><div class="wpb_wrapper">	<div class="vc_empty_space" style="height: 50px"><span class="vc_empty_space_inner">
			<span class="empty_space_image"></span>
		</span></div>

<div class="qode_carousels_holder clearfix"><div class="qode_carousels" data-number-of-visible-items="4"><div class="caroufredsel_wrapper" style="display: block; text-align: left; float: none; position: relative; top: auto; right: auto; bottom: auto; left: auto; z-index: 0; width: 1407px; margin: 0px; overflow: hidden; cursor: move; height: 302px;"><ul class="slides" style="text-align: left; float: none; position: absolute; top: 0px; right: auto; bottom: auto; left: 0px; margin: 0px; width: 6097px; opacity: 1; z-index: 0;"><li class="item" style="width: 454px;"><div class="carousel_item_holder"><span class="first_image_holder "><img src="<?php echo site_url();?>/wp-content/uploads/2016/03/DSC_0295.jpg" alt="carousel image"></span></div></li><li class="item" style="width: 454px;"><div class="carousel_item_holder"><span class="first_image_holder "><img src="<?php echo site_url();?>/wp-content/uploads/2016/03/duck-walks-e1458854686480.jpg" alt="carousel image"></span></div></li><li class="item" style="width: 454px;"><div class="carousel_item_holder"><span class="first_image_holder "><img src="<?php echo site_url();?>/wp-content/uploads/2016/03/DSC_0652.jpg" alt="carousel image"></span></div></li><li class="item" style="width: 454px;"><div class="carousel_item_holder"><span class="first_image_holder "><img src="<?php echo site_url();?>/wp-content/uploads/2016/03/DSC_0375.jpg" alt="carousel image"></span></div></li><li class="item" style="width: 454px;"><div class="carousel_item_holder"><span class="first_image_holder "><img src="<?php echo site_url();?>/wp-content/uploads/2016/03/DSC_0238.jpg" alt="carousel image"></span></div></li></ul></div></div></div><div class="vc_row wpb_row section vc_row-fluid vc_inner " style=" text-align:left;"><div class=" full_section_inner clearfix"><div class="wpb_column vc_column_container vc_col-sm-12"><div class="vc_column-inner "><div class="wpb_wrapper">
	<div class="wpb_text_column wpb_content_element  copy-child-page">
		<div class="wpb_wrapper">
			<h1 class="entry-title" style="text-align: center;">Login</h1>

<div class="col-1 user_form">
	<!--<h1>Welcome to Unbuckled</h1>-->
	
	

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


	<div class="divider"></div>				

</div>

</div> 
	</div> 	<div class="vc_empty_space" style="height: 50px"><span class="vc_empty_space_inner">
			<span class="empty_space_image"></span>
		</span></div>

</div></div></div></div></div>
		
														 
							</div>
														
								
						</div>
						
					</div>
				</div>
	</div>	
			
	</div>
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
<?php }?>
<?php get_footer();?>