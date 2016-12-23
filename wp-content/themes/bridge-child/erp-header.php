<?php
global $current_user;
get_currentuserinfo();

?>
<!doctype html>
<html class="fixed">
	<head>
<link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/images/favicon.png" type="image/x-icon" />
<!-- Mobile Specific Metas
  ================================================== -->
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta charset="<?php bloginfo('charset'); ?>">
<?php if (is_search() || is_attachment()) { ?>
<meta name="robots" content="noindex, nofollow" />
<?php } ?>
<title>
<?php
	if (function_exists('is_tag') && is_tag()) {
	     single_tag_title("Tag Archive for &quot;"); echo '&quot; - '; }
	  elseif (is_archive()) {
		  wp_title(''); echo ' - ';  }
	  elseif (is_category()) {
		  wp_title(''); echo ' - '; }
	  elseif (is_search()) {
	     echo 'Traženi pojam &quot;'.wp_specialchars($s).'&quot; - '; }
	  elseif (!(is_404()) && (is_single()) || (is_page())) {
		  if(!is_front_page()){
	     wp_title(''); echo ' - '; }}
	  elseif (is_404()) {
	     echo 'Not Found - '; }
	  if (is_front_page()) {
	     bloginfo('name');  }
	  elseif (is_home()) {
	      echo('Ponuda - '); bloginfo('name'); }
	  else {
	      bloginfo('name'); }
	  if ($paged>1) {
	     echo ' - page '. $paged; }
?>
</title>
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/assets_new/css/style.css" />
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/style.css" />
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/assets_new/style-erp-customize.css?ver=1" />

		<link rel="stylesheet" href="https://cdn.datatables.net/v/dt/dt-1.10.12/b-1.2.2/b-flash-1.2.2/b-html5-1.2.2/r-2.1.0/datatables.min.css" />

		<!-- Head Libs -->
		<script src="<?php bloginfo('stylesheet_directory'); ?>/js-erp/vendor/modernizr/modernizr.js"></script>

		<script type="text/javascript">
			var am2 = {};
			am2.current_domain = '<?php echo home_url(); ?>';
		</script>

<?php //wp_head(); ?>

</head>
<body>
<div id="main">
	<!-- HEADER -->
	<div class="header clearfix">
		<div class="header-table">
			<div class="header-cell is-left">
				<div class="header__logo">
					<a href="../">
						<h1><img src="<?php bloginfo('stylesheet_directory'); ?>/images/logo.png"></h1>
					</a>
				</div> 
			</div>
			<div class="header-cell">
				<div class="clearfix">
					<!-- PROFILE -->
					<div class="profile-top">
						<div class="cell">
							<div class="img-wrapper">
								<?php
									$current_user = wp_get_current_user();
									$avatar_image = get_user_meta($current_user->ID, 'profile_photo', true);

									if(!empty($avatar_image)){
										$image_url = wp_get_attachment_image_src($avatar_image, 'thumbnail');
										$avatar_image_url = $image_url[0];
								?>
									<img src="<?php echo $avatar_image_url; ?>" alt="" data-lock-picture="<?php bloginfo('stylesheet_directory'); ?>/images/!logged-user.jpg" />
								<?php } else { ?>
									<img src="<?php bloginfo('stylesheet_directory'); ?>/images/!logged-user.jpg" data-lock-picture="<?php bloginfo('stylesheet_directory'); ?>/images/!logged-user.jpg" />
								<?php }; ?>
							</div>
						</div>
						<div class="cell">
							<span class="username"><?php echo $current_user->first_name.' '.$current_user->last_name; ?> | <?php echo ucfirst(get_user_role()); ?></span>
							<ul class="user-options">
								<li><a href="#profile" class="profile-icon">Profile</a></li>
								<li><a href="<?php echo wp_logout_url(); ?>" class="logout-icon">Logout</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>