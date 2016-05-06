<?php /*Template name: My Pages*/
$user = wp_get_current_user();

if (!is_user_logged_in()) {
	wp_redirect(site_url() . '/login');
} else {

}

get_header();?>
<div class="content " style="min-height: 758px;">
						<div class="content_inner  ">
											<div class="full_width">
	<div class="full_width_inner">
							
					<div class="two_columns_25_75 clearfix grid2">
						<div class="column1">	<div class="column_inner">

		<aside class="sidebar"><?php include 'includes/my-account-sidebar.php'; ?></aside>
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
			<h1 class="entry-title" style="text-align: center;">My pages</h1>
<?php /*<div class="container_inner default_template_holder clearfix" >
	<div class="blog_holder blog_large_image">
		<article id="post-1" class="post-1 post type-post status-publish format-standard hentry category-uncategorized">
			<div class="post_content_holder">
				<div class="post_text">
					<div class="post_text_inner">*/?>
					<?php
					if (!empty($user->roles) && is_array($user->roles)) {
						foreach ($user->roles as $role) {
							if ($role == 'administrator') {
								if(!empty($_GET['page_id']) || isset($_GET['add'])) {
									include_once 'includes/forms/edit-franchise-page.php';	
								}
								else {
									include_once 'includes/forms/list-franchise-pages.php';
								}
								
								break;
							} else if ($role == 'franchisee') {
								if(!empty($_GET['page_id']) || isset($_GET['add'])) {
									include_once 'includes/forms/edit-franchise-page.php';	
								}
								else {
									include_once 'includes/forms/list-franchise-pages.php';
								}
								
								break;
							} else if ($role == 'coach') {
								if(!empty($_GET['page_id']) || isset($_GET['add'])) {
									include_once 'includes/forms/edit-franchise-page.php';
								}
								else {
									include_once 'includes/forms/list-franchise-pages.php';	
								}
								break;
							}
						}
					}
					?>
					<?php /*</div>
				</div>
			</div>
		</article>
	</div>
</div>*/?>
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
<?php get_footer();?>