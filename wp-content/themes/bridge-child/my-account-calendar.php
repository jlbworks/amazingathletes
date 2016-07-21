<?php /*Template name: My Calendar */
$user = wp_get_current_user();

if (!is_user_logged_in()) {
    wp_redirect(site_url() . '/login');
} else {
    wp_enqueue_media();
}

get_header();
?>
<div class="content " style="min-height: 758px;">
    <div class="content_inner  ">
        <div class="full_width">
            <div class="full_width_inner">

                <div class="two_columns_25_75 clearfix grid2">
                    <div class="column1">
                        <div class="column_inner">
                            <aside class="sidebar"><?php include 'includes/my-account-sidebar.php'; ?></aside>
                        </div>
                    </div>

                    <div class="column2">
                        <div class="column_inner">
                            <div class="vc_row wpb_row section vc_row-fluid " style=" text-align:left;">
                                <div class=" full_section_inner clearfix">
                                    <div class="wpb_column vc_column_container vc_col-sm-12">
                                        <div class="vc_column-inner">
                                            <div class="wpb_wrapper">
                                                <div class="vc_empty_space" style="height: 50px">
                                                    <span class="vc_empty_space_inner">
                                                        <span class="empty_space_image"></span>
                                                    </span>
                                                </div>

                                                <div class="qode_carousels_holder clearfix">
                                                    <div class="qode_carousels" data-number-of-visible-items="4">
                                                        <div class="caroufredsel_wrapper" style="display: block; text-align: left; float: none; position: relative; top: auto; right: auto; bottom: auto; left: auto; z-index: 0; width: 1407px; margin: 0px; overflow: hidden; cursor: move; height: 302px;">
                                                            <ul class="slides" style="text-align: left; float: none; position: absolute; top: 0px; right: auto; bottom: auto; left: 0px; margin: 0px; width: 6097px; opacity: 1; z-index: 0;">
                                                                <li class="item" style="width: 454px;">
                                                                    <div class="carousel_item_holder"><span class="first_image_holder "><img src="<?php echo site_url();?>/wp-content/uploads/2016/03/DSC_0295.jpg" alt="carousel image"></span></div></li><li class="item" style="width: 454px;"><div class="carousel_item_holder"><span class="first_image_holder "><img src="<?php echo site_url();?>/wp-content/uploads/2016/03/duck-walks-e1458854686480.jpg" alt="carousel image"></span></div></li><li class="item" style="width: 454px;"><div class="carousel_item_holder"><span class="first_image_holder "><img src="<?php echo site_url();?>/wp-content/uploads/2016/03/DSC_0652.jpg" alt="carousel image"></span></div></li><li class="item" style="width: 454px;"><div class="carousel_item_holder"><span class="first_image_holder "><img src="<?php echo site_url();?>/wp-content/uploads/2016/03/DSC_0375.jpg" alt="carousel image"></span></div></li><li class="item" style="width: 454px;"><div class="carousel_item_holder"><span class="first_image_holder "><img src="<?php echo site_url();?>/wp-content/uploads/2016/03/DSC_0238.jpg" alt="carousel image"></span></div></li></ul></div>
                                                    </div>
                                                </div>

                                                <div class="vc_row wpb_row section vc_row-fluid vc_inner " style=" text-align:left;">
                                                    <div class=" full_section_inner clearfix">
                                                        <div class="wpb_column vc_column_container vc_col-sm-12">
                                                            <div class="vc_column-inner ">
                                                                <div class="wpb_wrapper">
                                                                    <div class="wpb_text_column wpb_content_element  copy-child-page">
                                                                        <div class="wpb_wrapper">
                                                                            <h1 class="entry-title" style="text-align: center;">My Calendar</h1>
                                                                            <?php include 'includes/my-account-calendar.php'; ?>
                                                                        </div>
                                                                    </div>

                                                                    <div class="vc_empty_space" style="height: 50px">
                                                                        <span class="vc_empty_space_inner">
                                                                            <span class="empty_space_image"></span>
                                                                        </span>
                                                                    </div>

                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

<?php get_footer();
