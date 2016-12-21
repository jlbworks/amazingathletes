<?php /*Template Name: 2nd individual to coach */
$args = array(
    'role' => 'franchisee'
);
$franchisees = get_users($args);

foreach($franchisees as $franchisee){
    insert_2nd_individual_as_coach($franchisee);
}

