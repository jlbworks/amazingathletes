<?php 
/* Template Name: ERP */
if(!is_user_logged_in()){ 
	get_template_part('erp-login'); 
} else { ?>
	<?php include('erp-header.php'); ?>

    <!-- start: sidebar -->
    <?php get_template_part('erp-sidebar'); ?>
    <!-- end: sidebar -->
    <!-- CONTENT -->
    <div class="main">
        <div class="container clearfix" id="content-inner">
            <?php
                $show = trim($_REQUEST['show']);
                if( empty($show) ){
                    $show = 'dashboard';
                }
                if( file_exists( get_template_directory().'blocks/'.$show.'.php') ){
                    get_template_part('blocks/'.$show);
                } else {
                    echo '<script>var hash = window.location.hash;if( hash==\'\' ){ window.location.href=\''.site_url().'/erp/#dashboard\'; }</script>';
                }
            ?>
        </div>
    </div>
    <?php include('erp-footer.php'); ?>
<?php } ?>