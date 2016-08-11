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
  GET CLIENTS COMPANY DATA, USED IN WORK ORDERS WHEN SELECTING CLIENT
 */
/*add_action('wp_ajax_get_client_data', 'get_client_data');

function get_client_data() {
    header('Content-type: application/json');
    $json = array();
    $id = $_REQUEST['bolnica_id'];
    if (!empty($id)) {
        $bolnica = get_post($id);
        $json['bolnica_id'] = $bolnica->ID;
        $json['am_rep'] = $bolnica->am_rep;
        // find and set sales rep
        $sales_reps = $bolnica->sales_reps;
        if (is_array($sales_reps)) {
            foreach ($sales_reps as $index => $sr_id) {
                $json['sales_rep'] = $sr_id;
                break;
            }
        } else {
            $json['sales_rep'] = '';
        }

        // find and set billing currency
        if ($bolnica->country == 'Canada') {
            $json['currency'] = 'CAD';
        } else {
            $json['currency'] = 'USD';
        }
    }
    exit(json_encode($json));
}*/

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

// fx to delete photos saved to meta fields
/*function ajax_delete_field() {
    $type = $_POST['type'];
    $field = $_POST['field'];
    $item_id = $_POST['item_id'];
    if ($type == 'user') { // Gledamojel treba zvati user_meta ili post_meta
        $attachmentid = get_user_meta($_POST['item_id'], $_POST['field'], true); //vadimo att_id
        delete_user_meta($_POST['item_id'], $_POST['field']); // brišemo custom field
        wp_delete_attachment($attachmentid, true); // brišemo sliku
    }

    if ($type == 'post') {
        $attachmentid = get_post_meta($_POST['item_id'], $_POST['field'], true);
        delete_post_meta($_POST['item_id'], $_POST['field']);
        wp_delete_attachment($attachmentid, true);
    }

    if ($type == 'photos') {
        $attachmentid = $_POST['item_id'];

        $gallery = get_post_meta($_POST['post_id'], $_POST['field'], true);

        $a_gallery = $gallery;
        $b_old_gallery = false;

        if (isset($a_gallery['photos'])) {
            $a_gallery = $a_gallery['photos'];
        } //$a_gallery = $gallery;// explode(",",$gallery);
        if (isset($a_gallery['old_gallery'])) {
            $b_old_gallery = $a_gallery['old_gallery'];
        };

        $i = 0;
        foreach ($a_gallery as $key => $att) {
            if ($att == $attachmentid) {
                unset($a_gallery[$key]);
                $a_gallery = array_values($a_gallery);
                break;
            }
            $i++;
        }

        if ($b_old_gallery) {
            $gallery = $a_gallery;
            update_post_meta($_POST['post_id'], $_POST['field'], $gallery);
        } else {
            $gallery = array('old_gallery' => $b_old_gallery, 'photos' => $a_gallery); // $a_gallery; // implode(",", $a_gallery);
            update_post_meta($_POST['post_id'], $_POST['field'], $gallery);
            //delete_post_meta($_POST['item_id'],$_POST['field']);
            wp_delete_attachment($attachmentid, true);
        }
    } elseif ($type == 'places') {
        $attachmentid = $_POST['item_id'];

        $gallery = get_post_meta($_POST['post_id'], $_POST['field'], true);

        $a_gallery = $gallery;

        $i = 0;
        foreach ($a_gallery as $key => $att) {
            if ($att == $attachmentid) {
                unset($a_gallery[$key]);
                $a_gallery = array_values($a_gallery);
                break;
            }
            $i++;
        }


        $gallery = $a_gallery;
        update_post_meta($_POST['post_id'], $_POST['field'], $gallery);
        //delete_post_meta($_POST['item_id'],$_POST['field']);
        wp_delete_attachment($attachmentid, true);
    } elseif ($type == 'artists') {
        $attachmentid = $_POST['item_id'];

        $gallery = get_post_meta($_POST['post_id'], $_POST['field'], true);

        $a_gallery = $gallery;

        $i = 0;
        foreach ($a_gallery as $key => $att) {
            if ($att == $attachmentid) {
                unset($a_gallery[$key]);
                $a_gallery = array_values($a_gallery);
                break;
            }
            $i++;
        }


        $gallery = $a_gallery;
        update_post_meta($_POST['post_id'], $_POST['field'], $gallery);
        //delete_post_meta($_POST['item_id'],$_POST['field']);
        wp_delete_attachment($attachmentid, true);
    }
    die();
}

add_action('wp_ajax_ajax_delete_field', 'ajax_delete_field');*/

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
?>