<?php /*Template name: My Account/Dashboard*/?>
<?php 
$user = wp_get_current_user();

if (!is_user_logged_in()) {
	wp_redirect(site_url() . '/login');
} else {	
}

get_header();
?>
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
			<h1 class="entry-title" style="text-align: center;">Dashboard</h1>
<?php 
$notifications = get_field('notifications', 'user_'.$user->ID); // 'option');
$dates = get_field('important_dates', 'user_'.$user->ID); // 'option');
$info_pages = get_field('info_pages', 'user_'.$user->ID); // 'option');
$submit_pl_statement = get_field('submit_pl_statement', 'user_'.$user->ID); // 'option');
$submit_certificate_of_liability_insurance = get_field('submit_certificate_of_liability_insurance', 'user_'.$user->ID); // 'option');?>

<ul class="tabs">
	<li id="tab_notifications" class="tab">Notifications</li>
	<li id="tab_dates" class="tab">Important dates</li>
	<li id="tab_files" class="tab">Files</li>
	<li id="tab_fees" class="tab">Fees</li>
</ul>
<br/>
<?php if(is_array($notifications)) {?>
<div class="ip_notifications tab_content tab_content_notifications">
	<?php foreach($notifications as $notification){?>
	<div>
		<h3><?php echo $notification['title'];?><span class="date"><?php echo $notification['date'];?></span></h3>
		<?php echo $notification['notification'];?>
	</div>
	<?php }?>
</div>
<?php } ?>
<?php if(is_array($dates)) {?>
<div class="ip_dates tab_content tab_content_dates">
	<?php foreach($dates as $date){?>
	<div>
		<h3><?php echo $date['title'];?><span class="date"><?php echo $date['date'];?></span></h3>
		<?php echo $date['notification'];?>
	</div>
	<?php }?>
</div>
<?php } ?>
<div class="ip_files tab_content tab_content_files">
	<?php if($submit_pl_statement) echo '<a href="'.$submit_pl_statement.'">Submit P&L Statement</a>'; ?><br/>
	<?php if($submit_certificate_of_liability_insurance) echo '<a href="'.$submit_certificate_of_liability_insurance.'">Submit Certificate of Liability Insurance</a>'; ?>
</div>
<div class="ip_pages tab_content tab_content_fees">
	<?php if(is_array($info_pages)) {?>
	<?php foreach($info_pages as $key => $ip) {?>
		<h3 id="accord_<?php echo $key; ?>" class="accord"><?php echo $ip['title'];?></h3>
		<div  class="accord_content accord_content_<?php echo $key; ?>" >
			<?php echo $ip['content'];?>
		</div>
	<?php } ?>
	<?php } ?>
</div>
</div> 
	</div> 	<div id="e-space" class="vc_empty_space" style="height: 50px"><span class="vc_empty_space_inner">
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
<?php /*    	<div class="container_inner default_template_holder clearfix" >
			<div class="blog_holder blog_large_image">
				<article id="post-1" class="post-1 post type-post status-publish format-standard hentry category-uncategorized">
					<div class="post_content_holder">
						<div class="post_text">
							<div class="post_text_inner">*/?>
							
							<?php /*</div>
						</div>
					</div>
				</article>
			</div>
		</div>*/?>

<?php get_footer();?>