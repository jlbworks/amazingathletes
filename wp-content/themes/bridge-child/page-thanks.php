<?php /*Template name: Thanks */?>
<?php get_header();?>
<?php while(have_posts()) { the_post();?>
<?php the_content();?>
<a href="<?php echo site_url() ;?>/post_registration_details/?iframe&class_id=760" data-fancybox-type="iframe">Registration info</a>
<?php } ?>
<script>
    (function($){
        $(document).ready(function(){
            $('.content').css({'margin':'0px auto'});
            $('a[data-fancybox-type="iframe"]').fancybox();
        });
    })(jQuery);    
</script>
<?php get_footer();?>