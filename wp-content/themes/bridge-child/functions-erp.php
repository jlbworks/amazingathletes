<?php
if (!session_id()) {
    session_start();
}


// Load jQuery
if (!is_admin()) {
    wp_deregister_script('jquery');
//    wp_register_script('jquery', (get_bloginfo('template_directory') . "/assets/vendor/jquery/jquery.js"), false);
    wp_enqueue_script('jquery');
}

// Custom roles
$role_options = array(
    'staff' => "AA Staff",
    'client' => "Client"
);

// include helpers
include(dirname(__FILE__) . '/functions-format-helpers.php');
//include_once(dirname(__FILE__) . '/blocks/wo_functions.php');

function is_role($role, $user_id = null) {

    if (is_numeric($user_id)) {
        $user = get_userdata($user_id);
    } else {
        $user = wp_get_current_user();
    }

    if (empty($user)) {
        return false;
    }
    //pr($user->roles);
    return in_array($role, (array) $user->roles);
}

function restrict_access($roles = array(), $redirect = null) {
    if (!is_array($roles)) {
        $roles = explode(',', $roles);
    }
    $valid = false;
    foreach ($roles as $role) {
        if (is_role($role)) {
            $valid = true;
        }
    }
    if ($valid == false) {
        die('No access'); // or redirect?
    }
}

/**
  CUSTOM POST TYPES
 */
add_action('init', 'my_custom4_init');

function my_custom4_init() {

    // Registruj Bolnica CPT
    $labels = array(
        'name' => _x('Payments', 'post type general name'),
        'singular_name' => _x('Payment', 'post type singular name'),
        'add_new' => _x('Add new', 'Payment'),
        'add_new_item' => __('Add new Payment'),
        'edit_item' => __('Edit Payment'),
        'new_item' => __('New Payment'),
        'view_item' => __('View Payment'),
        'search_items' => __('Search Payments'),
        'not_found' => __('Not found'),
        'not_found_in_trash' => __('Not found in trash'),
        'parent_item_colon' => ''
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'has_archive' => false,
        //'rewrite' => true,
        'rewrite' => array('slug' => 'payment'),
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'author', 'editor', 'custom-fields'),
        'taxonomies' => array()
    );
    register_post_type('payment', $args);

    // Registruj Pacijent CPT
    $labels = array(
        'name' => _x('Attendance', 'post type general name'),
        'singular_name' => _x('Attendance', 'post type singular name'),
        'add_new' => _x('Add new', 'Attendance'),
        'add_new_item' => __('Add new Attendance'),
        'edit_item' => __('Edit Attendance'),
        'new_item' => __('New Attendance'),
        'view_item' => __('View Attendance'),
        'search_items' => __('Search Attendance'),
        'not_found' => __('Not found'),
        'not_found_in_trash' => __('Not found in trash'),
        'parent_item_colon' => ''
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'has_archive' => false,
        //'rewrite' => true,
        'rewrite' => array('slug' => 'attendance'),
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'author', 'editor', 'custom-fields'),
        'taxonomies' => array()
    );
    register_post_type('attendance', $args);

    // Registriraj Roster CPT
    $labels = array(
        'name' => _x('Roster', 'post type general name'),
        'singular_name' => _x('Roster', 'post type singular name'),
        'add_new' => _x('Add new', 'Roster'),
        'add_new_item' => __('Add new Roster'),
        'edit_item' => __('Edit Roster'),
        'new_item' => __('New Roster'),
        'view_item' => __('View Roster'),
        'search_items' => __('Search Roster'),
        'not_found' => __('Not found'),
        'not_found_in_trash' => __('Not found in trash'),
        'parent_item_colon' => ''
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'has_archive' => false,
        //'rewrite' => true,
        'rewrite' => array('slug' => 'roster'),
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'author', 'editor', 'custom-fields'),
        'taxonomies' => array()
    );
    register_post_type('roster', $args);

    // Registriraj RSS CPT
    $labels = array(
        'name' => _x('RSS', 'post type general name'),
        'singular_name' => _x('RSS', 'post type singular name'),
        'add_new' => _x('Add new', 'RSS'),
        'add_new_item' => __('Add new RSS'),
        'edit_item' => __('Edit RSS'),
        'new_item' => __('New RSS'),
        'view_item' => __('View RSS'),
        'search_items' => __('Search RSS'),
        'not_found' => __('Not found'),
        'not_found_in_trash' => __('Not found in trash'),
        'parent_item_colon' => ''
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'has_archive' => false,
        //'rewrite' => true,
        'rewrite' => array('slug' => 'rss'),
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'author', 'editor', 'custom-fields'),
        'taxonomies' => array()
    );
    register_post_type('rss', $args);

}

function get_ajax_url($action = '', $target_page = '') {
    if ($action == 'page') {
        $action = 'account_screen_change';
    } elseif ($action == 'modal') {
        $action = 'get_modal_page';
    }

    if (empty($target_page)) {
        $target_page = 'dashboard';
    }

    return site_url() . '/wp-admin/admin-ajax.php?action=' . $action . '&target_page=' . $target_page;
}

add_action('wp_ajax_submit_data', 'submit_data');

function submit_data() {

    global $current_user;
    get_currentuserinfo();

    /**
      SAVE USER PROFILE
     */
    if ($_POST['form_handler'] == 'profile') {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $user_id = wp_update_user(array(
            'ID' => $current_user->ID,
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'user_email' => $_POST['email']
        ));
        if (is_wp_error($user_id)) {
            exit(json_encode(array('success' => false, 'message' => "Error saving profile")));
        } else {
            // Success!
        }
        update_user_meta($current_user->ID, 'phone', $_POST['phone']);
        update_user_meta($current_user->ID, 'website', $_POST['website']);
        update_user_meta($current_user->ID, 'department', $_POST['department']);
        update_user_meta($current_user->ID, 'facebook', $_POST['facebook']);
        update_user_meta($current_user->ID, 'linkedin', $_POST['linkedin']);
        update_user_meta($current_user->ID, 'responsibilities', $_POST['responsibilities']);
        exit(json_encode(array('success' => true, 'message' => "Profile saved successfully", 'user_id' => $user_id)));
    }

    /**
      EDIT USER
     */
    if ($_POST['form_handler'] == 'user_edit') {
        $id = $_POST['id'];
        $userdata = array(
            'ID' => $id,
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'user_email' => $_POST['email']
        );


        if ($id > 0) {
            $userdata['ID'] = $id;
            $user_id = wp_update_user($userdata);
        } else {
            $userdata['user_login'] = $userdata['user_email'];
            $user_pass = $_POST['password'];
            if (empty($user_pass)) {
                $user_pass = sanitize_title($userdata['first_name'] . $userdata['last_name'] . '1234');
                //exit( json_encode(array('success'=>false,'message'=>"Password is empty!")) );
            }
            $userdata['user_pass'] = $user_pass;
            $user_id = wp_insert_user($userdata);
        }

        $fields = array( 'role', 'telephone', 'mailing_address', 'zip_code', 'franchise_name' );
        foreach ($fields as $field) {
            if (empty($_POST[$field])) {
                delete_user_meta($user_id, $field);
            } else {
                update_user_meta($user_id, $field, $_POST[$field]);
            }
        }

        // set role
        if (in_array($_POST['role'], array('doctor', 'admin_doctor'))) {
            $profile = get_user_by('id', $user_id);
            //$roles = array($_POST['role']);
            if (!in_array('administrator', $profile->roles)) {
                //$profile->set_role('administrator');
                $profile->set_role($_POST['role']);
            }
        }

        //set state and city
        $city_state = sanitize_text_field( $_POST['state'] ) . '|' . sanitize_text_field( $_POST['city'] );
        update_user_meta( $user_id, 'city__state', $city_state );

        if (is_wp_error($user_id)) {
            exit(json_encode(array('success' => false, 'message' => "Error creating user")));
        }

        exit(json_encode(array('success' => true, 'message' => "User saved successfully", 'user_id' => $user_id)));
    }

    /**
      CHANGE USER PASSWORD
     */
    if ($_POST['form_handler'] == 'user_changepassword') {
        $id = $_POST['id'];
        $userdata = array(
            'ID' => $id,
            'user_pass' => $_POST['password']
        );

        if ($id > 0) {
            $user_id = wp_update_user($userdata);
        }

        if (is_wp_error($user_id)) {
            exit(json_encode(array('success' => false, 'message' => "Error updating user")));
        }

        exit(json_encode(array('success' => true, 'message' => "Password changed successfully", 'user_id' => $user_id)));
    }

    /**
      Snimi Bolnica
     */
    /*if ($_POST['form_handler'] == 'bolnica') {

        $post_data = array(
            'ID' => $_POST['id'],
            'post_type' => 'bolnice',
            'post_title' => stripslashes($_POST['bolnica_title']),
            'post_name' => sanitize_title($_POST['bolnica_title']),
            'post_status' => 'publish',
        );

        $meta_data = array();
        $meta_fields = array(
            'address', 'city', 'zip',
            'phone', 'contact_email'
        );
        foreach ($meta_fields as $field) {
            $meta_data[$field] = $_POST[$field];
        }


        $created = false;
        // update
        if ($_POST['id'] > 0) {
            $post_id = $_POST['id'];
            wp_update_post($post_data);

            // insert
        } else {
            $post_id = wp_insert_post($post_data);
            $created = true;
        }

        // meta
        foreach ($meta_fields as $field) {
            if (empty($meta_data[$field])) {
                delete_post_meta($post_id, $field);
            } else {
                update_post_meta($post_id, $field, $meta_data[$field]);
            }
        }
        
        if (is_wp_error($user_id)) {
            exit(json_encode(array('success' => false, 'message' => "Bolnica not saved")));
        }

        exit(json_encode(array('success' => true, 'message' => "Bolnica saved successfully")));
    }*/


    /**
      Snimi Pacijent
     */
    /*if ($_POST['form_handler'] == 'pacijent') {

        $naslov = $_POST['first_name']." ".$_POST['last_name'];
        $post_data = array(
            'ID' => $_POST['id'],
            'post_type' => 'pacijenti',
            'post_title' => stripslashes($naslov),
            'post_name' => sanitize_title($naslov),
            'post_status' => 'publish',
        );

        $meta_data = array();
        $meta_fields = array(
            'first_name','last_name','address', 'city', 'zip','datum_rodjenja',
            'phone', 'contact_email','doktor','bolnica'
        );
        foreach ($meta_fields as $field) {
            $meta_data[$field] = $_POST[$field];
        }


        $created = false;
        // update
        if ($_POST['id'] > 0) {
            $post_id = $_POST['id'];
            wp_update_post($post_data);

            // insert
        } else {
            $post_id = wp_insert_post($post_data);
            $created = true;
        }

        // meta
        foreach ($meta_fields as $field) {
            if (empty($meta_data[$field])) {
                delete_post_meta($post_id, $field);
            } else {
                update_post_meta($post_id, $field, $meta_data[$field]);
            }
        }
        
        if (is_wp_error($user_id)) {
            exit(json_encode(array('success' => false, 'message' => "Pacijent nije snimljen")));
        }

        exit(json_encode(array('success' => true, 'message' => "Pacijent dodat.")));
    }*/

    /**
      SHOW COMPANY NOTES (COMPACT)
     */
    if ($_POST['form_handler'] == 'show_client_notes') {

        $bolnica_id = $_POST['bolnica_id'];

        if ($bolnica_id > 0) {
            $bolnica = get_post($bolnica_id);
            $html = listClientNotes($bolnica);
            exit($html);
        }

        exit(json_encode(array('success' => true, 'message' => "Invalid bolnica")));
    }

    /**
      SHOW MORE NOTES FOR COMPANY
     */
    if ($_POST['form_handler'] == 'show_more_client_notes') {

        $bolnica_id = $_POST['bolnica_id'];

        if ($bolnica_id > 0) {
            $bolnica = get_post($bolnica_id);
            $html = listClientNotes($bolnica, TRUE);
            exit($html);
        }

        exit(json_encode(array('success' => true, 'message' => "Invalid bolnica")));
    }

    /**
     * Edit customer
     */
    if ($_POST['form_handler'] == 'customer_edit') {
        $post_data = array(
            'ID' => $_POST['id'],
            'post_type' => 'customer',
            'post_title' => stripslashes($_POST['childs_first_name']) . ' ' . stripslashes($_POST['childs_last_name']) . ' (' . stripslashes($_POST['parents_name']) . ')',
            'post_name' => sanitize_title($_POST['childs_first_name']),
            'post_status' => 'publish',
        );

        $meta_data = array();
        $meta_fields = array(
            'childs_first_name', 'childs_last_name', 'childs_birthday',
            'childs_gender', 'childs_shirt_size', 'classroom_number_or_teachers_name',
            'parents_name', 'address', 'state', 'city', 'zip_code', 'telephone', 'email',
            'liability_release', 'photo_release', 'comments_or_questions', 'paid_tuition', 'location_id'
        );
        foreach ($meta_fields as $field) {
            $meta_data[$field] = $_POST[$field];
        }


        $created = false;
        // update
        if ($_POST['id'] > 0) {
            $post_id = $_POST['id'];
            wp_update_post($post_data);

            // insert
        } else {
            $post_id = wp_insert_post($post_data);
            $created = true;
        }

        // meta
        foreach ($meta_fields as $field) {
            if (empty($meta_data[$field])) {
                delete_post_meta($post_id, $field);
            } else {
               update_post_meta($post_id, $field, $meta_data[$field]);
            }
        }

        if( current_user_can( 'administrator' ) ) {
            $franchise_id = $_POST['franchise_id'];
        }
        else {
            $franchise_id = $current_user->ID;
        }

        update_post_meta( $post_id, 'franchise_id', $franchise_id );

        if (is_wp_error($user_id)) {
            exit(json_encode(array('success' => false, 'message' => "Customer not saved")));
        }

        exit(json_encode(array('success' => true, 'message' => "Customer saved successfully")));
    }

    /**
     * Add/Edit payment
     */
    if ($_POST['form_handler'] == 'payment') {
        $id = sanitize_text_field( $_POST['id'] );
        $franchise_id = sanitize_text_field( $_POST['payment_franchise_id'] );
        $customer_childs_name = get_post_meta( sanitize_text_field( $_POST['payment_customer_id'] ), 'childs_first_name', true );
        $class = get_post( sanitize_text_field( $_POST['payment_class_id'] ) );
        $title = $customer_childs_name . ' ' . $class->post_title;
        $author = is_role('administrator') || is_role('super_admin') ? $franchise_id : get_current_user_id();

        $post_data = array(
            'ID' => $id,
            'post_type' => 'payment',
            'post_title' => $title,
            'post_name' => sanitize_title_with_dashes( $title ),
            'post_status' => 'publish',
            'post_author' => $author,
        );

        $meta_data = array();
        $meta_fields = array(
           'payment_class_id', 'payment_customer_id', 'payment_description',
            'payment_location_id', 'payment_paid_amount', 'payment_paid_date', 'payment_type'
        );
        foreach ( $meta_fields as $field ) {
            $meta_data[$field] = sanitize_text_field($_POST[$field]);
        }


        $created = false;
        // update
        if ( $id > 0 ) {
            $post_id = $id;
            wp_update_post($post_data);

            // insert
        } else {
            $post_id = wp_insert_post($post_data);
            $created = true;
        }

        // meta
        foreach ( $meta_fields as $field ) {
            if  (empty( $meta_data[$field] ) ) {
                delete_post_meta( $post_id, $field );
            } else {
                update_post_meta( $post_id, $field, $meta_data[$field] );
            }
        }

        if( current_user_can( 'administrator' ) ) {
            $franchise_id = $_POST['payment_franchise_id'];
        }
        else {
            $franchise_id = $current_user->ID;
        }

        update_post_meta( $post_id, 'payment_franchise_id', $franchise_id );

        exit(json_encode(array('success' => true, 'message' => "Payment saved successfully")));
    }

    /**
     * Add new location invoice
     */
    if ($_POST['form_handler'] == 'add_location_invoice') {
        $coach_id = sanitize_text_field( $_POST['coach_id'] );
        $franchise_id = sanitize_text_field( $_POST['franchise_id'] );
        $date_start = sanitize_text_field( $_POST['date_start'] );
        $date_end = sanitize_text_field( $_POST['date_end'] );
        $author = get_current_user_id();

        $post_data = array(
            'post_type' => 'invoice',
            'post_title' => 'Location Invoice',
            'post_status' => 'publish',
            'post_author' => $author,
        );

        $meta_data = array();
        $meta_fields = array(
            'date_start', 'date_end',
            'location_id', 'franchise_id', 'invoice_type'
        );
        foreach ( $meta_fields as $field ) {
            $meta_data[$field] = sanitize_text_field($_POST[$field]);
        }


        $created = false;
        // update

        $post_id = wp_insert_post($post_data);
        $created = true;


        // meta
        foreach ( $meta_fields as $field ) {
            if  (empty( $meta_data[$field] ) ) {
                delete_post_meta( $post_id, $field );
            } else {
                update_post_meta( $post_id, $field, $meta_data[$field] );
            }
        }

        exit(json_encode(array('success' => true, 'message' => "Coach Invoice Created successfully")));
    }

    /**
     * Edit location invoice
     */
    if ($_POST['form_handler'] == 'edit_location_invoice') {
        $post_id = sanitize_text_field( $_POST['invoice_id'] );
        if(empty($post_id)) {
            exit(json_encode(array('success' => false, 'message' => "Missing ID")));
        }

        $meta_data = array();
        $meta_fields = array(
            'total', 'subtotal','grand_total', 'other'
        );
        foreach ( $meta_fields as $field ) {
            $meta_data[$field] = str_replace('$','',sanitize_text_field($_POST[$field]));
        }

        // meta
        foreach ( $meta_fields as $field ) {
            if  (empty( $meta_data[$field] ) ) {
                delete_post_meta( $post_id, $field );
            } else {
                update_post_meta( $post_id, $field, $meta_data[$field] );
            }
        }

        // Save items
        update_post_meta( $post_id, 'item', $_POST['item'] );

        exit(json_encode(array('success' => true, 'message' => "Location Invoice Edited successfully")));
    }

    /**
     * Add new coach invoice
     */
    if ($_POST['form_handler'] == 'add_coach_invoice') {
        $coach_id = sanitize_text_field( $_POST['coach_id'] );
        $franchise_id = sanitize_text_field( $_POST['franchise_id'] );
        $date_start = sanitize_text_field( $_POST['date_start'] );
        $date_end = sanitize_text_field( $_POST['date_end'] );
        $author = get_current_user_id();

        $post_data = array(
            'post_type' => 'invoice',
            'post_title' => 'Coach Invoice',
            'post_status' => 'publish',
            'post_author' => $author,
        );

        $meta_data = array();
        $meta_fields = array(
            'date_start', 'date_end',
            'coach_id', 'franchise_id', 'invoice_type'
        );
        foreach ( $meta_fields as $field ) {
            $meta_data[$field] = sanitize_text_field($_POST[$field]);
        }


        $created = false;
        // update

        $post_id = wp_insert_post($post_data);
        $created = true;


        // meta
        foreach ( $meta_fields as $field ) {
            if  (empty( $meta_data[$field] ) ) {
                delete_post_meta( $post_id, $field );
            } else {
                update_post_meta( $post_id, $field, $meta_data[$field] );
            }
        }

        exit(json_encode(array('success' => true, 'message' => "Coach Invoice Created successfully")));
    }

    /**
     * Edit coach invoice
     */
    if ($_POST['form_handler'] == 'edit_coach_invoice') {
        $post_id = sanitize_text_field( $_POST['invoice_id'] );
        if(empty($post_id)) {
            exit(json_encode(array('success' => false, 'message' => "Missing ID")));
        }

        $meta_data = array();
        $meta_fields = array(
            'total', 'subtotal','grand_total', 'other', 'travel_surcharge', 'liability_insurance_rebate', 'equipment_rental_rebate', 'settled_outstanding_student_compensations'
        );
        foreach ( $meta_fields as $field ) {
            $meta_data[$field] = str_replace('$','',sanitize_text_field($_POST[$field]));
        }

        // meta
        foreach ( $meta_fields as $field ) {
            if  (empty( $meta_data[$field] ) ) {
                delete_post_meta( $post_id, $field );
            } else {
                update_post_meta( $post_id, $field, $meta_data[$field] );
            }
        }

        // Save items
        update_post_meta( $post_id, 'item', $_POST['item'] );

        exit(json_encode(array('success' => true, 'message' => "Coach Invoice Edited successfully")));
    }

    /**
      Add/Edit roster
     */
    if ($_POST['form_handler'] == 'roster') {
        $id = sanitize_text_field( $_POST['id'] );
        $franchise_id = sanitize_text_field( $_POST['roster_franchise_id'] );
        $customer_childs_name = get_post_meta( sanitize_text_field( $_POST['roster_customer_id'] ), 'childs_first_name', true );
        $class = get_post( sanitize_text_field( $_POST['roster_class_id'] ) );
        $title = $customer_childs_name . ' ' . $class->post_title;
        $author = is_role('administrator') || is_role('super_admin') ? $franchise_id : get_current_user_id();

        $post_data = array(
            'ID' => $id,
            'post_type' => 'roster',
            'post_title' => $title,
            'post_name' => sanitize_title_with_dashes( $title ),
            'post_status' => 'publish',
            'post_author' => $author,
        );

        $meta_data = array();
        $meta_fields = array(
            'roster_class_id', 'roster_customer_id',
            'roster_location_id', 'roster_coach_id',
            'roster_customer_status', 'roster_customer_media',
            'roster_customer_discount', 'roster_payment_type',
        );
        foreach ( $meta_fields as $field ) {
            $meta_data[$field] = sanitize_text_field($_POST[$field]);
        }

        //$meta_data['roster_coach_id'] = get_post($_POST['roster_class_id'])->coaches;

        $created = false;
        // update
        if ( $id > 0 ) {
            $post_id = $id;
            wp_update_post($post_data);

            // insert
        } else {
            $post_id = wp_insert_post($post_data);
            $created = true;
        }

        // meta
        foreach ( $meta_fields as $field ) {
            
            if  (empty( $meta_data[$field] ) ) {
                delete_post_meta( $post_id, $field );
            } else {
                update_post_meta( $post_id, $field, $meta_data[$field] );
            }
        }

        //update_post_meta( $post_id, 'roster_coach_id', $meta_data['roster_coach_id']);

        if( current_user_can( 'administrator' ) ) {
            $franchise_id = $_POST['roster_franchise_id'];
        }
        else {
            $franchise_id = $current_user->ID;
        }

        update_post_meta( $post_id, 'roster_franchise_id', $franchise_id );

        exit(json_encode(array('success' => true, 'message' => "Roster saved successfully")));
    }

     /**
      Add/Edit RSS
     */
    if ($_POST['form_handler'] == 'rss_create') {
        $id = sanitize_text_field( $_POST['id'] );
        $franchise_id = sanitize_text_field( $_POST['rss_franchise_id'] );
        $author = $franchise_id = is_role('administrator') || is_role('super_admin') ? $franchise_id : get_current_user_id();

        $post_data = array(
            'ID' => $id,
            'post_type' => 'rss',
            'post_title' => 'RSS Report',
            'post_name' => sanitize_title_with_dashes( 'RSS Report' ),
            'post_status' => 'publish',
            'post_author' => $author,
        );

        $meta_data = array();
        $meta_fields = array(
            'rss_franchise_id', 'rss_month',
            'rss_year'
        );
        foreach ( $meta_fields as $field ) {
            $meta_data[$field] = sanitize_text_field($_POST[$field]);
        }
        $meta_data['rss_franchise_id'] = $franchise_id;


        $created = false;
        // update
        if ( $id > 0 ) {
            $post_id = $id;
            wp_update_post($post_data);

            // insert
        } else {
            $post_id = wp_insert_post($post_data);
            $created = true;
        }

        // meta
        foreach ( $meta_fields as $field ) {
            if  (empty( $meta_data[$field] ) ) {
                delete_post_meta( $post_id, $field );
            } else {
                update_post_meta( $post_id, $field, $meta_data[$field] );
            }
        }

        exit(json_encode(array('success' => true, 'message' => "RSS Created successfully")));
    }

    /**
      Add/Edit attendance
     */
    if ($_POST['form_handler'] == 'attendance') {
        $id = sanitize_text_field( $_POST['id'] );
        $franchise_id = sanitize_text_field( $_POST['attendance_franchise_id'] );
        $customer_childs_name = get_post_meta( sanitize_text_field( $_POST['attendance_customer_id'] ), 'childs_first_name', true );
        $class = get_post( sanitize_text_field( $_POST['attendance_class_id'] ) );
        $title = $customer_childs_name . ' ' . $class->post_title;
        $author = is_role('administrator') || is_role('super_admin') ? $franchise_id : get_current_user_id();

        $post_data = array(
            'ID' => $id,
            'post_type' => 'attendance',
            'post_title' => $title,
            'post_name' => sanitize_title_with_dashes( $title ),
            'post_status' => 'publish',
            'post_author' => $author,
        );

        $meta_data = array();
        $meta_fields = array(
            'attendance_class_id', 'attendance_customer_id',
            'attendance_location_id', 'attendance_date', 'attendance_coach_id'
        );
        foreach ( $meta_fields as $field ) {
            $meta_data[$field] = sanitize_text_field($_POST[$field]);
        }


        $created = false;
        // update
        if ( $id > 0 ) {
            $post_id = $id;
            wp_update_post($post_data);

            // insert
        } else {
            $post_id = wp_insert_post($post_data);
            $created = true;
        }

        // meta
        foreach ( $meta_fields as $field ) {
            if  (empty( $meta_data[$field] ) ) {
                delete_post_meta( $post_id, $field );
            } else {
                update_post_meta( $post_id, $field, $meta_data[$field] );
            }
        }

        if( current_user_can( 'administrator' ) ) {
            $franchise_id = $_POST['attendance_franchise_id'];
        }
        else {
            $franchise_id = $current_user->ID;
        }

        update_post_meta( $post_id, 'attendance_franchise_id', $franchise_id );

        exit(json_encode(array('success' => true, 'message' => "Attendance saved successfully")));
    }

    /**
     * Return list of coaches for class
     */
    if ($_POST['form_handler'] == 'get_coaches') {
        $class_id = sanitize_text_field( $_POST['class_id'] );
        /*if( !current_user_can( 'edit_post', $location_id ) ) {
            exit( json_encode( array( 'success' => false, 'message' => "Unauthorized action." ) ) );
        }*/

        $franchisee = get_post($class_id);
        $franchisee_id = $franchisee->post_author;
        $coaches = array($franchisee_id);
        $_coaches = get_post_meta($class_id, 'coaches', true);
        $coaches = array_unique (array_merge($coaches,$_coaches) );         

        if(is_array($coaches)){
            $coaches = array_map(function($_coach){
                $coach = get_user_by('id', $_coach);
                $coach_name = $coach->first_name.' '.$coach->last_name;
                $coach = array( 'id' => $_coach, 'text' => $coach_name);            
                return $coach;
            },$coaches);
        }        
        else {
            $coaches = array();
        }

        exit(json_encode( $coaches ) );
    }

    /**
     * Return list of classes for location
     */
    if ($_POST['form_handler'] == 'get_classes') {
        $location_id = sanitize_text_field( $_POST['location_id'] );
        /*if( !current_user_can( 'edit_post', $location_id ) ) {
            exit( json_encode( array( 'success' => false, 'message' => "Unauthorized action." ) ) );
        }*/

        $args = array(
            'post_type'         => 'location_class',
            'posts_per_page'    => -1,
            'post_status'       => 'publish',
            'meta_query'        => array (
                array (
                    'key'       => 'location_id',
                    'value'     => $location_id,
                    'compare'   => '='
                )
            )
        );

        $classes_unordered = get_posts( $args );
        $classes = array(
            array(
                'id'    => '',
                'text'  => 'Select a class',
                'location_id' => '',
                'franchise_id' => ''
            )
        );

        foreach( $classes_unordered as $class ) {
            $location = get_post($class->location_id);                            

            $single_class['id'] = $class->ID;
            $single_class['text'] = $class->post_title;
            $single_class['location_id'] = $class->location_id;
            $single_class['franchise_id'] = $location->post_author;

            $classes[] = $single_class;
        }

        exit(json_encode( $classes ) );
    }

    /**
     * Return list of territories for a franchise
     */
    if ($_POST['form_handler'] == 'get_territories') {
        $franchise_id = sanitize_text_field( $_POST['franchise_id'] );

        $territories = get_field('territories', 'user_' .$franchise_id);
        $territories = array_map(function($terr){
            return array('id'=> $terr['unit_number'], 'text' => $terr['territory_name']);
        },$territories);

        exit(json_encode( $territories ) );
    }

    /**
     * Return list of locations for a franchise
     */
    if ($_POST['form_handler'] == 'get_locations') {
        $franchise_id = sanitize_text_field( $_POST['franchise_id'] );
        $territory_id = sanitize_text_field( $_POST['territory_id'] );

        $args = array(
            'post_type'         => 'location',
            'posts_per_page'    => -1,
            'post_status'       => 'any',
            'author'            => $franchise_id
        );

        if(!empty($territory_id)) {
            $args['meta_query'] = array(
                array(
                    'key' => 'unit_number',
                    'value' => $territory_id,
                    'compare' => '=',
                )
            );
        }

        $locations_unordered = get_posts( $args );
        $locations = array(
            array(
                'id'    => '',
                'text'  => ''
            )
        );

        foreach( $locations_unordered as $location ) {
            $single_location['id'] = $location->ID;
            $single_location['text'] = $location->post_title;

            $locations[] = $single_location;
        }

        exit(json_encode( $locations ) );
    }    

     /**
     * Create City
     */
    if ($_POST['form_handler'] == 'create_city') {       
        global $wpdb;

        $result = $wpdb->query($wpdb->prepare("INSERT INTO `zips`(`zip`, `state`, `city`, `lat`, `lng`, `review`) VALUES (%d, %s, %s, NULL, NULL, 2 )", $_POST['zip'], $_POST['state'], $_POST['city']));        

        exit(json_encode(array('success' => $result == true, 'message' => "City added successfully")));
    }

    /**
        rss_inline_edit
    **/
    if($_POST['form_handler'] == 'rss_inline_edit'){
        $rss_id = (int) $_REQUEST['rss_id'];
        $class_id = (int) $_REQUEST['class_id'];

        if(! current_user_can( 'administrator' ) && !current_user_can( 'franchisee' ) ) {
            exit(json_encode(array('success' => false , 'message' => "RSS edit failed" ) ) ) ;
        }
        
        $rss = get_post($rss_id);

        $classes = $rss->classes;

        if(!is_array($classes)){
            $classes = array();
        }

        $classes[$class_id] = array(
            'no_weeks_taught' => $_REQUEST['no_weeks_taught'],
            'status_code' => $_REQUEST['status_code'],
        );        
        
        $result = update_post_meta($rss_id,'classes', $classes);        

        exit(json_encode(array('success' => $result , 'message' => "RSS edit " . ($result ? 'success' : 'failed') )));
    }

    /**
      END OF SUBMIT FORM HANDLERS
     */
    //
    exit(json_encode(array('success' => false, 'message' => "Invalid handler!")));
}

add_action('wp_ajax_delete_object', 'delete_object');

function delete_object() {

    global $current_user;
    get_currentuserinfo();

    $object = $_REQUEST['object'];
    $id = (int) $_REQUEST['id'];

    /**
      DELETE Bolnica and Pacijent
     */
    /*if (($object == 'bolnica' || $object == 'pacijent') && $id > 0) {
        wp_trash_post($id);
        exit(json_encode(array('success' => true, 'object' => $object, 'id' => $id, 'message' => "Bolnica deleted")));
    }*/

    /**
      DELETE USER
     */
    if ($object == 'user' and $id > 0) {
        wp_delete_user($id);
        exit(json_encode(array('success' => true, 'object' => $object, 'id' => $id, 'message' => "User deleted")));
    }

    /**
      DELETE CLIENT NOTES
     */
    if ($object == 'client_note' and $id > 0) {
        deleteClientNote($id);
        exit(json_encode(array('success' => true, 'object' => $object, 'id' => $id, 'message' => "Note deleted")));
    }

    if ($object == 'customer' and $id > 0) {
        if( !current_user_can( 'edit_posts' ) ) {
            exit(json_encode(array('success' => false, 'object' => $object, 'id' => $id, 'message' => "You are not authorised to perform this action")));

        }

        $customer_object = array(
            'ID' => $id,
            'post_status' => 'trash'
        );
        wp_update_post( $customer_object );
        exit(json_encode(array('success' => true, 'object' => $object, 'id' => $id, 'message' => "Customer deleted")));

    }

    if ($object == 'payment' and $id > 0) {
        if( !current_user_can( 'edit_posts' ) ) {
            exit(json_encode(array('success' => false, 'object' => $object, 'id' => $id, 'message' => "You are not authorised to perform this action")));

        }

        $payment_object = array(
            'ID' => $id,
            'post_status' => 'trash'
        );
        wp_update_post( $payment_object );
        exit(json_encode(array('success' => true, 'object' => $object, 'id' => $id, 'message' => "Payment deleted")));

    }

    if ($object == 'rss' and $id > 0) {
        if( !current_user_can( 'edit_posts' ) ) {
            exit(json_encode(array('success' => false, 'object' => $object, 'id' => $id, 'message' => "You are not authorised to perform this action")));

        }

        wp_delete_post( $id, true );
        exit(json_encode(array('success' => true, 'object' => $object, 'id' => $id, 'message' => "RSS deleted")));

    }


    exit(json_encode(array('success' => 'false')));
}

/**
  LIST COMPANY CONTACT INFORMATION
 */
/*add_action('wp_ajax_get_bolnica_info', 'get_bolnica_info');

function get_bolnica_info() {
    // upcoming_events_list
    $bolnica = get_post($_REQUEST['bolnica_id']);

    $info = array();
    $info['id'] = $bolnica->ID;
    $info['name'] = $bolnica->post_title;
    $info['address'] = $bolnica->address;
    $info['city'] = $bolnica->city;
    $info['country'] = $bolnica->country;

    $info['phone'] = $bolnica->phone;
    $info['email'] = $bolnica->contact_email;
    $info['website'] = $bolnica->website;

    $contacts = get_posts(array(
        'post_type' => 'contacts',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'meta_query' => array(
            array('key' => 'bolnica_id', 'compare' => '=', 'value' => $bolnica->ID)
        )
    ));

    $formated = array();
    foreach ($contacts as $contact) {
        $formated[] = array(
            'id' => $contact->ID,
            'title' => $contact->post_title,
            'email' => $contact->email,
            'invoice' => $contact->invoice,
            'ext1' => $contact->ext1,
            'phone1' => $contact->phone1,
            'ext2' => $contact->ext2,
            'phone2' => $contact->phone2
        );
    }
    $info['contacts'] = $formated;

    $sales_reps = $bolnica->sales_reps;
    if (is_array($sales_reps)) {
        foreach ($sales_reps as $index => $sr_id) {
            $rep = get_user_by('id', $sr_id);
            $sales_reps[$index] = $rep->first_name . ' ' . $rep->last_name;
        }
        $display = implode(', ', $sales_reps);
    } else {
        $display = '-';
    }

    $info['sales_reps'] = $display;

    $info['am_rep'] = $bolnica->am_rep;

    header('Content-type: application/json');
    exit(json_encode($info));
}*/

/**
  SAVE DATATABLE FILTERS
 */
add_action('wp_ajax_save_datatable_filters', 'save_datatable_filters');

function save_datatable_filters() {
    $page = $_POST['page'];
    $columns = $_REQUEST['columns'];
    if (empty($columns)) {
        $columns = array();
    }
    $_SESSION['dtf-' . $page] = $columns;
}

function load_datatables_filters($page) {
    $columns = unserialize($_COOKIE('dtf-' . $page));
    if (empty($columns)) {
        $columns = array();
    }
    return $columns;
}

function urlQueryToArray($qry) {
    $result = array();
    //string must contain at least one = and cannot be in first position
    if (strpos($qry, '=')) {

        if (strpos($qry, '?') !== false) {
            $q = parse_url($qry);
            $qry = $q['query'];
        }
    } else {
        return false;
    }

    foreach (explode('&', $qry) as $couple) {
        list ($key, $val) = explode('=', $couple);
        $result[$key] = $val;
    }

    return empty($result) ? false : $result;
}

add_action('wp_ajax_account_screen_change', 'account_screen_change');
add_action('am2_ajax_handler_account_screen_change', 'account_screen_change');

function account_screen_change() {
    if (empty($_REQUEST['target_page'])) {
        die;
    }

    if (!empty($_REQUEST['target_args'])) {
        global $target_args;
        $target_args = urlQueryToArray(urldecode($_REQUEST['target_args']));
    }

    $filepath = locate_template('blocks/' . $_REQUEST['target_page'] . '.php');
    if (file_exists($filepath)) {
        echo $_REQUEST['refresh_page'];
        include($filepath);
    } else {
        exit(json_encode(array('success' => false, 'title' => "Error 404", 'message' => "Page not found")));
    }

    exit('');
}

add_action('wp_ajax_get_modal_page', 'get_modal_page');

function get_modal_page() {
    if (empty($_REQUEST['target_page'])) {
        die;
    }

    if (!empty($_REQUEST['target_args'])) {
        global $target_args;
        $target_args = urlQueryToArray(urldecode($_REQUEST['target_args']));
    }

    include(locate_template('blocks/' . $_REQUEST['target_page'] . '.php'));

    exit();
}
/**
  PROFILE PHOTO UPLOAD
 */
add_action('wp_ajax_profile_photo_upload', 'profile_photo_upload');

function profile_photo_upload() {
    if (!$_FILES)
        exit();
    if (isset($_FILES['qqfile'])) {
        $files = $_FILES['qqfile'];
    }

    // CUSTOM resize fotografija!!!
    global $am2_resize_images_to;
    $am2_resize_images_to = array('thumbnail', 'medium');
    //add_filter('intermediate_image_sizes_advanced', 'am2_handle_media_image_sizes');

    $attach_id = am2_handle_media_upload($files);
    $attach_url = wp_get_attachment_image_src($attach_id, 'thumbnail');
    update_user_meta($_POST['user_id'], $_POST['field'], $attach_id);

    $json['success'] = true;
    $json['data'] = $_FILES;
    $json['image_id'] = $attach_id;
    $json['image_url'] = $attach_url[0];
    echo json_encode($json);
    exit();
}

function am2_handle_media_upload($files) {

    $upload_dir = wp_upload_dir();
    $upload_overrides = array('test_form' => false);
    $file_post = wp_handle_upload($files, $upload_overrides); //Posts File

    $file_link = $file_post['file'];
    $file_type = wp_check_filetype(basename($file_link), null); //File Extension
    $post_name = preg_replace('/.[^.]+$/', '', basename($file_link)); //Post Name
    $attachment = array(
        'guid' => $file_link,
        'post_mime_type' => $file_type['type'],
        'post_title' => $post_name,
        'post_content' => '',
        'post_status' => 'inherit'
    );

    $attach_id = wp_insert_attachment($attachment, $file_link, $_POST['post_id']);
    $attach_data = wp_generate_attachment_metadata($attach_id, $file_link);
    $attach_final = wp_update_attachment_metadata($attach_id, $attach_data);
    return $attach_id;
}

/**
  GET USER ROLE
 */
function get_user_role() {
    global $current_user;

    $user_roles = $current_user->roles;
    $user_role = array_shift($user_roles);

    return $user_role;
}

add_filter('show_admin_bar', '__return_false');

add_editor_style('editor-styles.css');
//add_image_size ( 'smallthumb', 272, 155, true);
//default za fancybox
update_option('image_default_link_type', 'file');
// Registriramo menu
register_nav_menus(array('main' => __('Main menu', 'Main menu')));
// HEADER Options page	
if (function_exists("register_options_page")) {
    //register_options_page('Postavke');
    register_options_page('Home page');
    register_options_page('Header');
    register_options_page('Footer');
}

// Clean up the <head>
function removeHeadLinks() {
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'index_rel_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'start_post_rel_link', 10, 0);
}

add_action('init', 'removeHeadLinks');
remove_action('wp_head', 'wp_generator');

//add_theme_support( 'post-thumbnails' );
/*
  add_action( 'init', 'my_add_excerpts_to_pages' );
  function my_add_excerpts_to_pages() {
  add_post_type_support( 'page', 'excerpt' );
  } */





// Short & pretty print_r function 
function pr($obj) {
    ob_start();
    print_r($obj);
    $out = ob_get_contents();
    ob_end_clean();
    $out = str_replace(" ", "&nbsp;", $out);
    $out = str_replace("\n", "<br>", $out);
    echo $out;
}

/**
  Helper functions from TSYS3 form_helper.php
 */
// ------------------------------------------------------------------------
// Create Atrributes String
// Generate attributes from array with key, value pairs
// ------------------------------------------------------------------------
function _attributes($attributes = '') {
    if (is_array($attributes)) {
        $atts = '';
        foreach ($attributes as $key => $val) {
            if ($val !== NULL) {
                $atts.=' ' . $key . '="' . $val . '"';
            }
        }
        return $atts;
    }
    return $attributes;
}

// ------------------------------------------------------------------------
// Generates hidden input field tag
// ------------------------------------------------------------------------
function hidden($name, $value = '', $attributes = array()) {
    $value = str_replace('"', '&quot;', $value);
    $default_attributes = array(
        'name' => $name,
        'value' => $value,
        'type' => "hidden",
        'id' => NULL,
        'size' => NULL,
        'style' => NULL,
        'class' => NULL
    );
    $attributes = array_merge($default_attributes, $attributes);
    return '<input ' . _attributes($attributes) . ' />';
}

// ------------------------------------------------------------------------
// Generates input field tag
// ------------------------------------------------------------------------
function input($name, $value = '', $attributes = array()) {
    $value = str_replace('"', '&quot;', $value);
    $default_attributes = array(
        'name' => $name,
        'value' => esc_attr(stripslashes($value)),
        'type' => "text",
        'id' => NULL,
        'size' => NULL,
        'style' => NULL,
        'class' => NULL
    );
    $attributes = array_merge($default_attributes, $attributes);
    return '<input ' . _attributes($attributes) . ' />';
}

// ------------------------------------------------------------------------
// Generates textarea input tag
// ------------------------------------------------------------------------
function textarea($name, $value = '', $attributes = array()) {
    $default_attributes = array(
        'name' => $name,
        'id' => NULL,
        'rows' => 3,
        'style' => NULL,
        'class' => NULL
    );
    $attributes = array_merge($default_attributes, $attributes);
    return '<textarea ' . _attributes($attributes) . '>' . esc_textarea(stripslashes($value)) . '</textarea>';
}

// ------------------------------------------------------------------------
// Generates radio group input tag
// ------------------------------------------------------------------------
function radio($name, $value = '', $options = array(), $attributes = array(), $prefix = "", $sufix = "") {
    $default_attributes = array(
        'name' => $name,
        'style' => NULL,
        'class' => NULL
    );
    $out = "";
    $attributes = array_merge($default_attributes, $attributes);
    foreach ($options as $val => $opt) {
        if ($val == $value) {
            $sel = ' checked="checked"';
        } else {
            $sel = "";
        };
        $out.= $prefix . '<input type="radio"' . _attributes($attributes) . ' value="' . $val . '"' . $sel . ' /><span>' . $opt . '</span>' . $sufix . "\n";
    };
    return $out;
}

// ------------------------------------------------------------------------
// Generates checkbox input tag
// ------------------------------------------------------------------------
function checkbox($name, $value = 0, $attributes = array()) {
    if ($value == 0) {
        $checked = NULL;
    } else {
        $checked = "checked";
    }
    $default_attributes = array(
        'name' => $name,
        'value' => 1,
        'id' => NULL,
        'checked' => $checked,
        'style' => NULL,
        'class' => NULL
    );
    $attributes = array_merge($default_attributes, $attributes);
    return '<input type="checkbox" ' . _attributes($attributes) . ' />';
}

// ------------------------------------------------------------------------
// Generates checklist input tag
// ------------------------------------------------------------------------
function checklist($name, $values = array(), $options = array(), $sufix = '<br>') {
    $out = '';
    $index = 0;
    //pr($options);
    if (!is_array($values)) {
        $values = explode(',', $values);
    }
    //pr($values);
    foreach ($options as $value => $title) {
        if (in_array($value, $values)) {
            $checked = "checked";
        } else {
            $checked = NULL;
        }
        $id = sanitize_title($name . '[' . $index . ']');
        $attributes = array(
            'id' => $id,
            'name' => $name . '[' . $index . ']',
            'value' => $value,
            'checked' => $checked,
            'style' => NULL,
            'class' => NULL
        );
        $out.= '<div class="checklist-row"><input type="checkbox" ' . _attributes($attributes) . ' /> <label for="' . $id . '">' . $title . '</label></div>';
        $index++;
    }
    return '
<style>
.checklist {
	margin: 4px 0;
}
.checklist input[type="checkbox"] {
	cursor: pointer;
	margin: 4px 0;
}
.checklist label {
	cursor:pointer;
	color: #222;
	font-size: 15px;
    padding: 3px 6px
}
.checklist-row:hover label {
	color: #000;
	background-color: #eee;
}
</style>
<div class="checklist">' . $out . '</div>
';
}

// ------------------------------------------------------------------------
// Generates basic dropdown form
// ------------------------------------------------------------------------
function dropdown($varname, $value = '', $options = array(), $attributes = array(), $onChange = false) {
    if ($onChange == false) {
        $onChange = '';
    } else {
        $onChange = ' onChange="' . $onChange . '"';
    }
    $default_attributes = array(
        'name' => $varname,
        'id' => $varname,
        'style' => NULL,
        'class' => NULL,
        'onChange' => NULL
    );
    if (!is_array($attributes)) {
        $attributes = array($attributes);
    }
    $attributes = array_merge($default_attributes, $attributes);
    $out = '<select' . _attributes($attributes) . $onChange . '>';
    if (!is_array($options)) {
        $options = array($options);
    }
    $fc = 'class="first-child" ';
    foreach ($options as $val => $opt) {
        if ($val == $value) {
            $sel = ' selected';
        } else {
            $sel = '';
        };
        $out.='<option ' . $fc . 'value="' . $val . '"' . $sel . '>' . esc_attr($opt) . "</option>\n";
        $fc = '';
    };
    $out.='</select>';
    return $out;
}

// ------------------------------------------------------------------------
// Generates insertable list component
// ------------------------------------------------------------------------
function insertable_list($name, $values = array()) {
    $out = '<div style="display:inline-block;width:60%;">';
    $out.='<ul id="' . $name . '" style="margin:0;padding:2px 0px;">';
    foreach ($values as $key => $value) {
        $stripped = str_replace(array('"'), array('&quot;'), $value);
        $out.= '<li><input name="' . $name . '[' . $key . ']" type="text" value="' . $stripped . '" /><a class="btn-mini" onclick="removeRow_' . $name . '(this);">Remove</a></li>';
    }
    $out.='</ul>';
    $out.='<a onclick="addNewRow_' . $name . '()" class="btn-mini">+ Add new</a><br>';
    $out.='
		<script>
            function addNewRow_' . $name . '(){
                $("#' . $name . '").append(\'<li><input name="' . $name . '[]" type="text" value="" /><a class="btn-mini" onclick="removeRow_' . $name . '(this);">Remove</a></li>\');
            }
            function removeRow_' . $name . '(el){
                $(el).parent(\'li\').remove();
            }
        </script>
	';
    $out.='</div>';

    return $out;
}

// ------------------------------------------------------------------------
// Generates insertable list component for key value pairs
// ------------------------------------------------------------------------
function insertable_keyvalue_list($name, $options = array(), $titles = array()) {
    if (empty($titles)) {
        $titles = array(0 => "Key", 1 => "Value");
    }
    $out = '<div style="display:inline-block;width:60%;">';
    $out.='<ul id="' . $name . '" style="margin:0;padding:2px 0px;">';
    $out.= '<li><div style="display:inline-block;width:30%;">' . $titles[0] . '</div><div style="display:inline-block;width:40%;">' . $titles[1] . '</div></li>';
    foreach ($options as $key => $value) {
        $stripped_key = str_replace(array('"'), array('&quot;'), $key);
        $stripped_value = str_replace(array('"'), array('&quot;'), $value);
        $out.= '<li><input style="width:30% !important;" name="' . $name . '[key][]" type="text" value="' . $stripped_key . '" /><input style="width:40% !important;" name="' . $name . '[value][]" type="text" value="' . $stripped_value . '" /><a class="btn-mini" onclick="removeRow_' . $name . '(this);">Remove</a></li>';
    }
    $out.='</ul>';
    $out.='<a onclick="addNewRow_' . $name . '()" class="btn-mini">+ Add new</a><br>';
    $out.='
		<script>
            function addNewRow_' . $name . '(){
                $("#' . $name . '").append(\'<li><input style="width:30% !important;" name="' . $name . '[key][]" type="text" value="" /><input style="width:40% !important;" name="' . $name . '[value][]" type="text" value="" /><a class="btn-mini" onclick="removeRow_' . $name . '(this);">Remove</a></li>\');
            }
            function removeRow_' . $name . '(el){
                $(el).parent(\'li\').remove();
            }
        </script>
	';
    $out.='</div>';

    return $out;
}

// ------------------------------------------------------------------------
// Insert to the beggining of array
// ------------------------------------------------------------------------
function _array_begin($arr, $beginwith) {
    $out = array();
    if (is_array($beginwith)) {
        $out = $beginwith;
    } else {
        $out[0] = $beginwith;
    }
    foreach ($arr as $key => $val) {
        $out[$key] = $val;
    }
    return $out;
}

// ------------------------------------------------------------------------
// Connect array keys to values from another array and join with delimiter
// ------------------------------------------------------------------------
function _array_connect_keys($values, $options, $delimiter = null) {
    if (!is_array($values)) {
        $values = explode(',', $values);
    }
    $arr = array();
    foreach ($values as $key) {
        $v = $options[$key];
        if (!empty($v)) {
            $arr[] = $v;
        }
    }
    if (is_null($delimiter)) {
        return $arr;
    }
    return implode($delimiter, $arr);
}


// ------------------------------------------------------------------------

/**
 * Prepare and return variables for dashboard view
 */

function get_dashboard_data() {
    $data = array();

    $args = array(
        'role' => 'franchisee'
    );
    $data['total_franchises'] = count(get_users($args));


    $args = array(
        'post_type'   => 'location',
        'post_status' => 'publish',
        'posts_per_page'=>-1
    );
    if( is_role( 'franchisee' ) ) {
        $args['author'] = get_current_user_id();
    }
    $data['total_locations'] = count(get_posts($args));


    $args = array(
        'role' => 'coach'
    );
    if( is_role( 'franchisee' ) ) {
        $args['meta_key'] = 'franchisee';
        $args['meta_value'] = get_current_user_id();
        $args['meta_compare'] = '=';
    }
    $data['total_coaches'] = count(get_users($args));

    $args = array(
        'post_type'   => 'customer',
        'post_status' => 'publish',
        'posts_per_page'=>-1
    );
    if( is_role( 'franchisee' ) ) {
        $args['author'] = get_current_user_id();
    }
    $data['total_customers'] = count(get_posts($args));

    return $data;
}

function am2_insert_customer( ) {
    global $wpdb;
    $state = sanitize_text_field( $_POST['state'] );
    $state_code = $wpdb->get_var("SELECT state_code FROM states WHERE state = '$state'");

    $date_epoch = date_create_from_format( 'm/d/Y', $_POST['child-birthday'] );
    $date = $date_epoch->format( 'm/d/Y' );
    // $date = $date_epoch->format( 'd/m/Y' );

    $customer_data = array(
        'childs_first_name'                 => $_POST['child-first-name'],
        'childs_last_name'                  => $_POST['child-last-name'],
        'childs_birthday'                   => $date,
        'childs_gender'                    => strtolower( $_POST['child-gender'] ),
        'childs_shirt_size'                 => stripos( $_POST['child-shirt-size'], 'x-small' ) ? 'x-small' :
                                                stripos( $_POST['child-shirt-size'], 'small' ) ? 'small' : 'medium',
        'classroom_number_or_teachers_name' => $_POST['classroom-teacher'],
        'parents_name'  => $_POST['parent-name'],
        'address'   => $_POST['address'],
        'state'   => $state_code,
        'city'   => $_POST['city'],
        'zip_code'   => $_POST['zipcode'],
        'telephone'   => $_POST['primary-phone'],
        'email'   => $_POST['email'],
        'liability_release'   => !empty( $_POST['liability'][0] ) ? 1 : '',
        'photo_release'   => !empty( $_POST['photo_release'][0] ) ? 1 : '',
        'comments_or_questions'   => $_POST['comments'],
        'paid_tuition'   => !empty( $_POST['paid_tuition'] ) ? 1 : '' ,
        'location_id'   => $_POST['location_id'],
        'class_id'   => $_POST['class_id'],
        'franchise_id'  => get_post( $_POST['location_id'] )->post_author
    );

    $post_data = array(
        'post_type' => 'customer',
        'post_title' => stripslashes($customer_data['childs_first_name']) . ' ' . stripslashes($customer_data['childs_last_name']) . ' (' . stripslashes($customer_data['parents_name']) . ')',
        'post_name' => sanitize_title($customer_data['childs_first_name']),
        'post_status' => 'publish',
    );

    $meta_data = array();
    $meta_fields = array(
        'childs_first_name', 'childs_last_name', 'childs_birthday',
        'childs_gender', 'childs_shirt_size', 'classroom_number_or_teachers_name',
        'parents_name', 'address', 'state', 'city', 'zip_code', 'telephone', 'email',
        'liability_release', 'photo_release', 'comments_or_questions', 'paid_tuition', 'location_id',
        'franchise_id', 'class_id'
    );
    foreach ($meta_fields as $field) {
        $meta_data[$field] = $customer_data[$field];
    }


    $created = false;
    // update
    if ($_POST['id'] > 0) {
        $post_id = $_POST['id'];
        wp_update_post($post_data);

        // insert
    } else {
        $post_id = wp_insert_post($post_data);
        $created = true;
    }

    // meta
    foreach ($meta_fields as $field) {
        if (empty($meta_data[$field])) {
            delete_post_meta($post_id, $field);
        } else {
            update_post_meta($post_id, $field, $meta_data[$field]);
        }
    }   

    am2_insert_roster($post_id);
}

function am2_insert_roster($customer_id){
    $id = null; //sanitize_text_field( $_POST['id'] );
    $customer_meta = get_post_meta($customer_id);

    $franchise_id = sanitize_text_field( $customer_meta['roster_franchise_id'][0] );
    $customer_childs_name = get_post_meta( $customer_meta['childs_first_name'][0] );
    $class = get_post( sanitize_text_field( $customer_meta['class_id'][0] ) );
    $title = $customer_childs_name . ' ' . $class->post_title;
    //$author = is_role( 'administrator' ) ? $franchise_id : get_current_user_id();

    $data = array(
        'roster_class_id' => $class->ID, 'roster_customer_id' => $customer_id,
        'roster_location_id' => $class->location_id, /*'roster_coach_id',*/
        /*'roster_customer_status', 'roster_customer_media',
        'roster_customer_discount', 'roster_payment_type',*/
    );

    $post_data = array(
        'ID' => $id,
        'post_type' => 'roster',
        'post_title' => $title,
        'post_name' => sanitize_title_with_dashes( $title ),
        'post_status' => 'publish',
        //'post_author' => $author,
    );

    $meta_data = array();
    $meta_fields = array(
        'roster_class_id', 'roster_customer_id',
        'roster_location_id', 'roster_coach_id',
        'roster_customer_status', 'roster_customer_media',
        'roster_customer_discount', 'roster_payment_type',
    );
    foreach ( $meta_fields as $field ) {
        $meta_data[$field] = sanitize_text_field($data[$field]);
    }

    //$meta_data['roster_coach_id'] = get_post($_POST['roster_class_id'])->coaches;

    $created = false;
    // update
    if ( $id > 0 ) {
        $post_id = $id;
        wp_update_post($post_data);

        // insert
    } else {
        $post_id = wp_insert_post($post_data);
        $created = true;
    }

    // meta
    foreach ( $meta_fields as $field ) {
        
        if  (empty( $meta_data[$field] ) ) {
            delete_post_meta( $post_id, $field );
        } else {
            update_post_meta( $post_id, $field, $meta_data[$field] );
        }
    }

    //update_post_meta( $post_id, 'roster_coach_id', $meta_data['roster_coach_id']);

    // if( current_user_can( 'administrator' ) ) {
    //     $franchise_id = $_POST['roster_franchise_id'];
    // }
    // else {
    //     $franchise_id = $current_user->ID;
    // }

    $franchise_id = $class->post_author;

    update_post_meta( $post_id, 'roster_franchise_id', $franchise_id );

    //exit(json_encode(array('success' => true, 'message' => "Roster saved successfully")));
}

add_action('wp_ajax_get_class_dates', 'erp_get_class_dates');
function erp_get_class_dates(){    

    $class_id = $_REQUEST['class_id'];
    $class = get_post($class_id);

    $dates = array();

    if($class->datetype == 'dates'){
        $dates = get_post_meta($class_id, 'date', false);
    }
    else if($class->datetype == 'session'){
        $occurrences = am2_get_occurrences($class);

        foreach ($occurrences as $o) {
            $dates[] = $o->format('m/d/Y');
        }
    }
    else if($class->datetype == 'recurring') {
        $occurrences = am2_get_occurrences($class);

        foreach ($occurrences as $o) {
            $dates[] = $o->format('m/d/Y');
        }
    }    

    header('Content-Type: application/json');
    echo json_encode($dates);   
    exit();
}

?>