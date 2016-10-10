<?php /*Template Name: add_coach_role */
    $franchisees = get_users(
        array(
            'role' => 'franchisee',
        )
    );

    foreach($franchisees as $franchisee){
        $franchisee->add_role('coach');
    }
?>