<?php /*Template name: My account*/
$user = wp_get_current_user();

if (!is_user_logged_in()) {
	wp_redirect(site_url() . '/login');
} else {

}

wp_head();
?>
    	<div class="container_inner default_template_holder clearfix" >
			<div class="blog_holder blog_large_image">
				<article id="post-1" class="post-1 post type-post status-publish format-standard hentry category-uncategorized">
					<div class="post_content_holder">
						<div class="post_text">
							<div class="post_text_inner">
							<?php
							if (!empty($user->roles) && is_array($user->roles)) {
								foreach ($user->roles as $role) {
									if ($role == 'administrator') {
										break;
									} else if ($role == 'franchisee') {
										include_once 'includes/forms/my-account-franchisee.php';
										break;
									} else if ($role == 'coach') {
										include_once 'includes/forms/my-account-coach.php';
										break;
									}
								}
							}
							?>
							</div>
						</div>
					</div>
				</article>
			</div>
		</div>

<?php wp_footer();?>