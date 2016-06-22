<?php
global $class_programs, $class_types, $coach_pay_scales, $class_payment_informations;

/*$programs = get_field('programs_description', 'option');
$class_programs = array(/*'Amazing Athletes', 'Amazing Tots', 'Amazing Warriors');*/

/*if(is_array($programs)){
    foreach($programs as $program){
        $class_programs[$program['program']] = $program['program'];
    }
}*/


$class_programs = array(
    'Tots',
    'Amazing Athletes',
    'Training Academy',
    'Summer Camp',
    'Special Event',
); 

$class_types = array(
    'Demo',
    'Parent-Pay Monthly',
    'Parent-Pay Session',
    'Annual Contract',
    'Camp',
    'Event'
);

$coach_pay_scales = array(
    'Per student',
    'Hourly',
);

$class_payment_informations = array(
    'Cash/Check',
    'One time payment',
    'Auto-pay Enrollment',
);

$mypages_images = array(
site_url(). "/wp-content/uploads/2016/03/my-account-volleyball-icon.png",
site_url(). "/wp-content/uploads/2016/03/my-locations-soccerball-icon.png",
site_url(). "/wp-content/uploads/2016/03/logout-baseball-icon.png",
site_url(). "/wp-content/uploads/2016/03/my-pages-football-icon.png",
site_url(). "/wp-content/uploads/2016/03/sports-store-hockey-puck-icon.png",
site_url(). "/wp-content/uploads/2016/03/rescources-golf-icon.png",
/*site_url(). "/wp-content/uploads/2016/03/my-account-volleyball-icon.png",
site_url(). "/wp-content/uploads/2016/03/my-locations-soccerball-icon.png",
site_url(). "/wp-content/uploads/2016/03/logout-baseball-icon.png",
site_url(). "/wp-content/uploads/2016/03/my-pages-football-icon.png",*/
)

?>