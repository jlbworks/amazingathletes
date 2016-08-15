<!doctype html>
<html class="fixed">
	<head>

		<!-- Basic -->
		<meta charset="UTF-8">

        <title>Log In - Amazing Athletes</title>

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<!-- Web Fonts  -->
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">


		<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/assets_new/css/style.css" />
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/style.css" />

		<!-- Head Libs -->
		<script src="<?php bloginfo('stylesheet_directory'); ?>/js-erp/vendor/modernizr/modernizr.js"></script>
        <?php wp_head(); ?>

	</head>

	<body class="login-page">
		<!-- LOGIN -->
		<div class="login-table">
			<div class="login-cell">
				<div class="login-form">
					<span class="login-title">Log in</span>
					<?php login_with_ajax('divs-only'); ?>
				</div>
			</div>
		</div>
	<body>
	
	<!-- Vendor -->
	<script src="<?php bloginfo('stylesheet_directory'); ?>/assets_new/js/plugins.js"></script>   
	<script src="<?php bloginfo('stylesheet_directory'); ?>/assets_new/js/functions.js"></script>   
    <?php //wp_footer(); ?>
	</body>
</html>