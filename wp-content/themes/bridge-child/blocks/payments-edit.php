<?php
global $current_user;
get_currentuserinfo();

$id = $_REQUEST['id'];

restrict_access('administrator,franchisee');

/*echo( "<div>In Development</div>" );
return;*/

$payment = get_post($id);

$customer_id    = get_post_meta( $payment->ID, 'payment_customer_id', true );
$customer       = get_post( $customer_id );

$customer_location_id = get_post_meta( $customer_id, 'location_id' );

$class_id       = get_post_meta( $payment->ID, 'payment_class_id', true );

$franchise_id   = get_post_meta( $payment->ID, 'payment_franchise_id', true );
$franchise      = get_post( $franchise_id );

$location_id   = get_post_meta( $payment->ID, 'payment_location_id', true );
$location      = get_post( $location_id );

$paid_amount    = get_post_meta( $payment->ID, 'payment_paid_amount', true );
$paid_date    = get_post_meta( $payment->ID, 'payment_paid_date', true );
$payment_type    = get_post_meta( $payment->ID, 'payment_type', true );
$payment_description    = get_post_meta( $payment->ID, 'payment_description', true );

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
    <h3 class="card-header">Payment</h3>
    <div class="card-inner">
        <form id="payment-form" class="card-form no-inline-edit js-ajax-form">
        <div class="validation-message"><ul></ul></div>
            <div class="card-table">
            <!-- INPUT DEFAULT (GREEN AND BOLD) -->
            <div class="card-table-row">
                <span class="card-table-cell fixed250">Child Name (Parents Name)<span class="required">*</span></span>
                <div class="card-table-cell">
                    <div class="card-form">
                        <fieldset>
                            <select id="customer_id" name="payment_customer_id" class="form-control">
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
                <span class="card-table-cell fixed250">Paid amount<span class="required">*</span></span>
                <div class="card-table-cell">
                    <div class="card-form">
                        <fieldset>
                            <input type="number" name="payment_paid_amount" class="form-control" title="Please enter the paid amount." value="<?php echo esc_attr( $paid_amount ); ?>" placeholder="eg.: 20" required/>
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
                            <input type="text" data-js="datepicker-format" name="payment_paid_date" class="form-control" title="Please choose the date." value="<?php echo esc_attr( $paid_date ); ?>" required/>
                            <i class="fieldset-overlay" data-js="focus-on-field"></i>
                        </fieldset>
                    </div>
                </div>
            </div>
            <div class="card-table-row">
                <span class="card-table-cell fixed250">Payment Type <span class="required">*</span></span>
                <div class="card-table-cell">
                    <div class="card-form">
                        <fieldset>
                            <select name="payment_type" class="form-control" required>
                                <option value="registration" class="option" <?php selected( 'registration', $payment_type, 1 ); ?>>Registration</option>
                                <!-- /.option -->
                                <option value="tuition" class="option" <?php selected( 'tuition', $payment_type, 1 ); ?>>Tuition</option>
                                <!-- /.option -->
                                <option value="other" class="option" <?php selected( 'other', $payment_type, 1 ); ?>>Other</option>
                                <!-- /.option -->
                            </select>
                            <!-- /# -->
                            <i class="fieldset-overlay" data-js="focus-on-field"></i>
                        </fieldset>
                    </div>
                </div>
            </div>

            <div class="card-table-row">
                <span class="card-table-cell fixed250">Description <span class="required">*</span></span>
                <div class="card-table-cell">
                    <div class="card-form">
                        <fieldset>
                            <textarea name="payment_description" cols="30" rows="10"><?php echo $payment_description; ?></textarea>
                            <!-- /# -->
                            <i class="fieldset-overlay" data-js="focus-on-field"></i>
                        </fieldset>
                    </div>
                </div>
            </div>
            <?php if( is_role( 'administrator') ) : ?>
            <div class="card-table-row">
                <span class="card-table-cell fixed250">Franchise <span class="required">*</span></span>
                <div class="card-table-cell">
                    <div class="card-form">
                        <fieldset>
                            <select id="franchise_id" name="payment_franchise_id" class="form-control" required>
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
                            <select name="payment_location_id" class="form-control" id="location_id">
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
                            <select name="payment_class_id" class="form-control" id="class_id">
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
            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <input type="hidden" name="form_handler" value="payment" />
            </div>
            <div class="card-footer clearfix">
                <button data-remodal-action="cancel" class="left btn btn--secondary" type="button">Cancel</button>
                <button class="right btn btn--primary" type="submit">Save</button>
            </div>
        </form>
    </div>
</div>


<script type="text/javascript">

set_title('Payment');


$(document).ready(function () {

    $("#payment-form").validate({
        // any other options,
        errorContainer: $("#payment-form").find( 'div.validation-message' ),
    		errorLabelContainer: $("#payment-form").find( 'div.validation-message ul' ),
    		wrapper: "li",
    });

    $("#payment-form").ajaxForm({
        // any other options,
        beforeSubmit: function () {
            //$('#sales_reps').val();
            return $("#payment-form").valid(); // TRUE when form is valid, FALSE will cancel submit
        },
        success: function (json) {
            var success = 'success';
            if( !json.success ) {
               success = 'error';
            }
            am2.main.notify('pnotify', success, json.message);
            var inst = $('[data-remodal-id=modal]').remodal({hashTracking: false});
            inst.destroy();
            load_screen('REFRESH');
        },
    		url: '<?php echo site_url();?>/wp-admin/admin-ajax.php?action=submit_data',
    		type: 'post',
    		dataType: 'json'
    });

    $('#franchise_id').select2({
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
                franchise_id: $('#franchise_id').val()
            },
            success: function(data) {
                $('#location_id').html('').select2({
                    placeholder: 'Select a location',
                    width: '100%',
                    data: data
                });

                $('#class_id').html('').select2({
                    placeholder: 'Select a location first',
                    width: '100%'
                });
            }
        })
    });

    $('#customer_id').select2({
        placeholder: 'Select a customer',
        width: '100%',
        minimumResultsForSearch: -1
    });

    $('#location_id').select2({
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
                location_id: $('#location_id').val()
            },
            success: function(data) {
                $('#class_id').html('').select2({
                    placeholder: 'Select a class',
                    data: data,
                    width: '100%'
                });
            }
        })
    });

    $('#class_id').select2({
        placeholder: 'Select a location first',
        width: '100%'
    });
});

</script>