<?php /*Template Name: Copy franchise slug */

    $franchisees = get_users(
        array(
            'role' => 'franchisee',
        )
    );

    foreach($franchisees as $franchisee){
        if(!isset($franchisee->franchise_slug) || empty($franchisee->franchise_slug)){
            update_user_meta($franchisee->ID, 'franchise_slug', $franchisee->franchise_name);
        }
    }
?>