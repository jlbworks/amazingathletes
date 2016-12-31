<?php /*Template Name: Territories to CPT */

restrict_access('super_admin,administrator');

$args = array(
    'role' => 'franchisee'
);
$franchisees = get_users($args);

function repeater_entries_to_cpts($franchisee){
    $territories = get_field('territories', 'user_' .$franchisee->ID);
    
    var_dump($territories);

    foreach($territories as $territory){
        $args = array(
            'post_type' => 'territory',
            'meta_query' => array(
                array(
                    'key' => 'franchisee',
                    'value' => $franchisee->ID,
                    'compare' => '='
                ),
                array(
                    'key' => 'unit_number',
                    'value' => $territory['unit_number'],
                    'compare' => '='
                ),
            )
        );

        $_territory = get_posts($args);

        if(count($_territory)<1){
            $args = array(
                'post_title'    => $territory['territory_name'],        
                'post_status'   => 'publish',
                'post_author'   => $franchisee->ID,  
                'post_type'     => 'territory', 
            );
            $post_id = wp_insert_post($args);
        }        
        else {
            $post_id  = $_territory[0]->ID;
        }

        update_post_meta($post_id, 'unit_number', $territory['unit_number']);
        update_post_meta($post_id, 'territory_name', $territory['territory_name']);
        update_post_meta($post_id, 'franchisee', $franchisee->ID);
    }    
}

foreach($franchisees as $franchisee){
    repeater_entries_to_cpts($franchisee);
}

