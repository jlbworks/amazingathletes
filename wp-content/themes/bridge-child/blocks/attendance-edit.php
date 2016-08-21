<?php
global $current_user; 
get_currentuserinfo(); 

$id = $_REQUEST['id'];

restrict_access('administrator,franchisee');
/*
echo( "<div>In Development</div>" );
return;*/

$attendance = get_post($id);

$customer_id    = get_post_meta( $attendance->ID, 'attendance_customer_id', true );
$customer       = get_post( $customer_id );

$customer_location_id = get_post_meta( $customer_id, 'location_id' );

$class_id       = get_post_meta( $attendance->ID, 'attendance_class_id', true );

$franchise_id   = get_post_meta( $attendance->ID, 'attendance_franchise_id', true );
$franchise      = get_post( $franchise_id );

$location_id   = get_post_meta( $attendance->ID, 'attendance_location_id', true );
$location      = get_post( $location_id );

$attendance_date = get_post_meta( $attendance->ID, 'attendance_date', true );

$customers_args = array(
    'post_type'         => 'customer',
    'post_status'       => 'publish',
    'posts_per_page'    => -1
);
if( is_role( 'franchisee' ) ) {
    $customers_args['meta_query'] = array(
        array(
            'key'       => 'franchise_id',
            'value'     => get_current_user_id(),
            'compare'   => '='
        )
    );
}
$customers = get_posts( $customers_args );

$classes = array();
if( $location_id) {
    $class_args = array(
        'post_type'         => 'location_class',
        'post_status'       => 'publish',
        'posts_per_page'    => -1,
        'meta_query'        => array(
            array(
                'key'       => 'location_id',
                'value'     => $location_id,
                'compare'   => '='
            )
        )
    );

    $classes = get_posts( $class_args );
}

$locations = array();
if( !$franchise_id &&  is_role( 'franchisee' )) {
    $location_args = array(
        'post_type' => 'location',
        'post_status'       => 'publish',
        'posts_per_page'    => -1,
        'author'            => get_current_user_id()
    );
    $locations = get_posts( $location_args );
}
elseif( $franchise_id ) {
    $location_args = array(
        'post_type' => 'location',
        'post_status'       => 'publish',
        'posts_per_page'    => -1,
        'author'            => $franchise_id
    );
    $locations = get_posts( $location_args );
}

$franchise_args = array(
    'role' => 'franchisee'
);
if( is_role( 'franchisee' ) ) {
    $franchise_args['include'] = array(
        get_current_user_id(),
    );
}

$franchises = get_users( $franchise_args );

?>

<div class="card-wrapper">
    <h3 class="card-header">Attendance<?php if( !empty($first_name) ) echo " : $first_name"." ".$last_name; ?></h3>
    <div class="card-inner">
        <form id="attendance-form" class="card-form no-inline-edit js-ajax-form">
        <div class="validation-message"><ul></ul></div>
            <div class="card-table">
                <?php if( is_role( 'administrator') ) : ?>
                    <div class="card-table-row">
                        <span class="card-table-cell fixed250">Franchise <span class="required">*</span></span>
                        <div class="card-table-cell">
                            <div class="card-form">
                                <fieldset>
                                    <select id="attendance_franchise_id" name="attendance_franchise_id" class="form-control" title="Please select a franchise." required>
                                        <option value=""></option>
                                        <?php foreach( $franchises as $franchisee ) : ?>
                                            <option value="<?php echo $franchisee->ID; ?>" <?php selected($franchise_id, $franchisee->ID, true ); ?>><?php echo $franchisee->first_name . ' ' . $franchisee->last_name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <!-- /# -->
                                    <i class="fieldset-overlay" data-js="focus-on-field"></i>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="card-table-row">
                    <span class="card-table-cell fixed250">Location <span class="required">*</span></span>
                    <div class="card-table-cell">
                        <div class="card-form">
                            <fieldset>
                                <select name="attendance_location_id" class="form-control" id="attendance_location_id" title="Please select a location." required>
                                    <option value=""></option>
                                    <?php foreach( $locations as $loc ) : ?>
                                        <option value="<?php echo $loc->ID; ?>" <?php selected( $location_id, $loc->ID, true ); ?> required><?php echo get_field( 'location_name', $loc->ID      );?></option>
                                    <?php endforeach; ?>
                                </select>
                                <!-- /# -->
                                <i class="fieldset-overlay" data-js="focus-on-field"></i>
                            </fieldset>
                        </div>
                    </div>
                </div>

                <div class="card-table-row">
                    <span class="card-table-cell fixed250">Class <span class="required">*</span></span>
                    <div class="card-table-cell">
                        <div class="card-form">
                            <fieldset>
                                <select name="attendance_class_id" class="form-control" id="attendance_class_id" title="Please select a class." required>
                                    <option value=""></option>
                                    <?php foreach( $classes as $class ) : ?>
                                        <option value="<?php echo $class->ID; ?>" <?php selected($class_id, $class->ID, true );?> required><?php echo $class->post_title; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <!-- /# -->
                                <i class="fieldset-overlay" data-js="focus-on-field"></i>
                            </fieldset>
                        </div>
                    </div>
                </div>

                <div class="card-table-row">
                    <span class="card-table-cell fixed250">Child Name (Parents Name)<span class="required">*</span></span>
                    <div class="card-table-cell">
                        <div class="card-form">
                            <fieldset>
                                <select id="attendance_customer_id" name="attendance_customer_id" class="form-control" title="Please select a customer." required>
                                    <?php foreach( $customers as $cust ) :
                                        $childs_first_name = get_post_meta( $cust->ID, 'childs_first_name', true );
                                        $childs_last_name = get_post_meta( $cust->ID, 'childs_last_name', true );
                                        $parents_name = get_post_meta( $cust->ID, 'parents_name', true ); ?>
                                        <option value="<?php echo $cust->ID; ?>" <?php selected( $customer_id, $cust->ID, true ); ?>><?php echo $childs_first_name . ' ' . $childs_last_name . '(' . $parents_name . ')'; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <!-- /# -->
                                <i class="fieldset-overlay" data-js="focus-on-field"></i>
                            </fieldset>
                        </div>
                    </div>
                </div>

                <div class="card-table-row">
                    <span class="card-table-cell fixed250">Date <span class="required">*</span></span>
                    <div class="card-table-cell">
                        <div class="card-form">
                            <fieldset>
                                <input type="text" data-js="datepicker-format" name="attendance_date" class="form-control" title="Please choose the date." value="<?php echo esc_attr( $attendance_date ); ?>" required/>
                                <i class="fieldset-overlay" data-js="focus-on-field"></i>
                            </fieldset>
                        </div>
                    </div>
                </div>

            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <input type="hidden" name="form_handler" value="attendance" />
            </div>
            <div class="card-footer clearfix">
                <button data-remodal-action="cancel" class="left btn btn--secondary" type="button">Cancel</button>
                <button class="right btn btn--primary" type="submit">Save</button>
            </div>
        </form>
    </div>
</div>
<?php am2_add_preloader(); ?>

<script type="text/javascript">

set_title('Bolnica');


$(document).ready(function () {

    $("#attendance-form").validate({});

    $("#attendance-form").ajaxForm({
        // any other options,
        beforeSubmit: function () {
            am2_show_preloader();
            return $("#attendance-form").valid(); // TRUE when form is valid, FALSE will cancel submit
        },
        success: function (json) {
      		am2.main.notify('pnotify','success', json.message);
            var inst = $('[data-remodal-id=modal]').remodal({hashTracking: false});
            if(inst) {
                inst.destroy();
                load_screen('REFRESH');
            }
            else {
                empty_form($("#attendance-form"));
            }
            am2_hide_preloader();
        },
    		url: '<?php echo site_url();?>/wp-admin/admin-ajax.php?action=submit_data',
    		type: 'post',
    		dataType: 'json'
    });

    $('#attendance_franchise_id').select2({
        placeholder: 'Select a franchise',
        width: '100%',
        minimumResultsForSearch: -1
    })
    .on('select2:select', function() {
        $.ajax({
            url: '<?php echo site_url();?>/wp-admin/admin-ajax.php?action=submit_data',
            type: 'POST',
            dataType: 'json',
            data: {
                form_handler: 'get_locations',
                franchise_id: $('#attendance_franchise_id').val()
            },
            beforeSend: function() {
                am2_show_preloader();
            },
            success: function(data) {
                $('#attendance_location_id').html('').select2({
                    placeholder: 'Select a location',
                    width: '100%',
                    data: data
                });

                $('#attendance_class_id').html('').select2({
                    placeholder: 'Select a location first',
                    width: '100%'
                });

                am2_hide_preloader();
            }
        })
    });

    $('#attendance_customer_id').select2({
        placeholder: 'Select a customer',
        width: '100%',
        minimumResultsForSearch: -1
    });

    $('#attendance_location_id').select2({
        placeholder: 'Select a location',
        width: '100%'
    })
    .on('select2:select', function() {
        $.ajax({
            url: '<?php echo site_url();?>/wp-admin/admin-ajax.php?action=submit_data',
            type: 'POST',
            dataType: 'json',
            data: {
                form_handler: 'get_classes',
                location_id: $('#attendance_location_id').val()
            },
            beforeSend: function() {
                am2_show_preloader();
            },
            success: function(data) {
                $('#attendance_class_id').html('').select2({
                    placeholder: 'Select a class',
                    data: data,
                    width: '100%'
                });
                am2_hide_preloader();
            }
        })
    });

    $('#attendance_class_id').select2({
        placeholder: 'Select a location first',
        width: '100%'
    });
});
</script>

