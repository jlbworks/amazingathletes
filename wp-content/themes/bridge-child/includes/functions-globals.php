<?php
global $class_types;

$programs = get_field('programs_description', 'option');
$class_types = array(/*'Amazing Athletes', 'Amazing Tots', 'Amazing Warriors'*/);

if(is_array($programs)){
    foreach($programs as $program){
        $class_types[$program['program']] = $program['program'];
    }
}

$mypages_images = array(
site_url(). "/wp-content/uploads/2016/03/my-account-volleyball-icon.png",
site_url(). "/wp-content/uploads/2016/03/my-locations-soccerball-icon.png",
site_url(). "/wp-content/uploads/2016/03/logout-baseball-icon.png",
site_url(). "/wp-content/uploads/2016/03/my-pages-football-icon.png",
site_url(). "/wp-content/uploads/2016/03/sports-store-hockey-puck-icon.png",
site_url(). "/wp-content/uploads/2016/03/rescources-golf-icon.png",
site_url(). "/wp-content/uploads/2016/03/my-account-volleyball-icon.png",
site_url(). "/wp-content/uploads/2016/03/my-locations-soccerball-icon.png",
site_url(). "/wp-content/uploads/2016/03/logout-baseball-icon.png",
site_url(). "/wp-content/uploads/2016/03/my-pages-football-icon.png",
)

?>