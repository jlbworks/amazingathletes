<?php
global $class_programs, $class_types, $coach_pay_scales, $class_payment_informations;

/*$programs = get_field('programs_description', 'option');
$class_programs = array(/*'Amazing Athletes', 'Amazing Tots', 'Amazing Warriors');*/

/*if(is_array($programs)){
    foreach($programs as $program){
        $class_programs[$program['program']] = $program['program'];
    }
}*/

$user_id = get_current_user_id();

global $mypages;

$mypages = array(
	'Home' => '',
	'About' => 'about',
	'Program options' => 'programs',
	'Classes' => array(
		'menu' => 'locations',
		'submenu'=> array(
			'On-Site' => 'locations?type=on-site',
			'Community Classes' => 'locations?type=community-classes',
		),
	),
	'Policies' => 'policies_and_procedures',
	'Staff' => 'staff',
	'Contact' => 'contact',
	'Testimonials' => 'testimonials',
	'Blog' => 'blog',
	'Press' => 'press',
	'Event form' => 'event-form',
	'Coaching opportunity' => 'coaching-opportunity',
	'Calendar' => 'calendar',
	'Pay online' => 'pay_online',
);

$custom_pages = get_user_meta($user_id, 'custom_mypages', true);
if(is_array($custom_pages)) $mypages = array_merge($mypages, $custom_pages);

/*var_dump($custom_pages);
var_dump($mypages);*/

global $mypages_multi;

$mypages_multi = array(
	'testimonials',
	'blog',
	'press',
);

global $mypages_optional;

$mypages_optional = array(
	'testimonials',
	'blog',
	'press',
	'event-form',
	'coaching-opportunity',
	'calendar',
	'pay_online',
);

$class_programs = array(
    'Tots',
    'Amazing Athletes',
    'Training Academy',
    'Summer Camp',
    'Special Event',
);

/*$class_types = array(
    'Demo',
    'Parent-Pay Monthly',
    'Parent-Pay Session',
    'Annual Contract',
    'Camp',
    'Event'
);*/

$class_types = array(
    'Demo',
    'Parent-Pay',
    'Session',
    'Contract',
    'Camp',
    //'Event',
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
