<?php
global $current_user; 
get_currentuserinfo(); 

$id = $_REQUEST['id'];

restrict_access('administrator,doctor,admin_doctor');

/*echo( "<div>In Development</div>" );
return;*/

$payment = get_post($id);

$customer_id    = get_post_meta( $payment->ID, 'payment_customer_id', true );
$customer       = get_post( $customer_id );

$class_id       = get_post_meta( $payment->ID, 'payment_class_id', true );
$class          = get_post( $class_id );

$franchise_id   = get_post_meta( $payment->ID, 'payment_franchise_id', true );
$franchise      = get_post( $franchise_id );

$location_id   = get_post_meta( $payment->ID, 'payment_location_id', true );
$location      = get_post( $location_id );

$paid_amount    = get_post_meta( $payment->ID, 'payment_paid_amount', true );
$paid_date    = get_post_meta( $payment->ID, 'payment_paid_date', true );
$payment_type    = get_post_meta( $payment->ID, 'payment_type', true );

$customers_args = array(
    'post_type'         => 'customer',
    'post_status'       => 'publish',
    'posts_per_page'    => -1
);
if( is_role( 'franchisee' ) ) {
    $customers_args['meta_query'] = array(
        array(
            'key'       => 'payment_franchise_id',
            'value'     => get_current_user_id(),
            'compare'   => '='
        )
    );
}
$customers = get_posts( $customers_args );

$class_args = array(
    'post_type'         => 'class',
    'post_status'       => 'publish',
    'posts_per_page'    => -1
);
if( is_role( 'franchisee' ) ) {
    $class_args['meta_query'] = array(
        array(
            'key'       => 'payment_franchise_id',
            'value'     => get_current_user_id(),
            'compare'   => '='
        )
    );
}
$customers = get_posts( $class_args );

$location_args = array(
    'post_type' => 'location',
    'post_status'       => 'publish',
    'posts_per_page'    => -1
);
if( is_role( 'franchisee' ) ) {
    $location_args['post_author'] = get_current_user_id();
}
$locations = get_posts( $location_args );

?>

<div class="card-wrapper">
    <h3 class="card-header">Payment</h3>
    <div class="card-inner">
        <form id="payment-form" class="card-form no-inline-edit js-ajax-form">
        <div class="validation-message"><ul></ul></div>
            <div class="card-table">
            <!-- INPUT DEFAULT (GREEN AND BOLD) -->
            <div class="card-table-row">
                <span class="card-table-cell fixed250">Customer Name (Child Name)<span class="required">*</span></span>
                <div class="card-table-cell">
                    <div class="card-form">
                        <fieldset>
                            <select name="customer_id" class="form-control">
                                <?php foreach( $customers as $cust ) :
                                    $childs_first_name = get_post_meta( $cust->ID, 'childs_first_name', true );
                                    $childs_last_name = get_post_meta( $cust->ID, 'childs_last_name', true );
                                    $parents_name = get_post_meta( $cust->ID, 'parents_name', true ); ?>
                                <option value="<?php echo $cust->ID; ?>"><?php echo $childs_first_name . ' ' . $childs_last_name . '(' . $parents_name . ')'; ?></option>
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
                            <input type="number" name="paid_amount" class="form-control" title="Please enter the paid amount." value="<?php echo esc_attr( $paid_amount ); ?>" placeholder="eg.: 20" required/>
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
                            <input type="text" data-js="datepicker-format" name="paid_date" class="form-control" title="Please choose the date." value="<?php echo esc_attr( $paid_date ); ?>" required/>
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
                            <select name="payment_type" class="form-control">
                                <option value="registration" class="option" <? selected( 'registration', $payment_type, 1 ); ?>Registration</option>
                                <!-- /.option -->
                                <option value="tuition" class="option" <? selected( 'tuition', $payment_type, 1 ); ?>Tuition</option>
                                <!-- /.option -->
                                <option value="other" class="option" <? selected( 'other', $payment_type, 1 ); ?>Other</option>
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
            <div class="card-table-row">
                <span class="card-table-cell fixed250">Franchise <span class="required">*</span></span>
                <div class="card-table-cell">
                    <div class="card-form">
                        <fieldset>
                            <select name="class_id" class="form-control">
                                <?php foreach( $customers as $cust ) :
                                    $childs_first_name = get_post_meta( $cust->ID, 'childs_first_name', true );
                                    $childs_last_name = get_post_meta( $cust->ID, 'childs_last_name', true );
                                    $parents_name = get_post_meta( $cust->ID, 'parents_name', true ); ?>
                                    <option value="<?php echo $cust->ID; ?>"><?php echo $childs_first_name . ' ' . $childs_last_name . '(' . $parents_name . ')'; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <!-- /# -->
                            <i class="fieldset-overlay" data-js="focus-on-field"></i>
                        </fieldset>
                    </div>
                </div>
            </div>

            <div class="card-table-row">
                <span class="card-table-cell fixed250">Location <span class="required">*</span></span>
                <div class="card-table-cell">
                    <div class="card-form">
                        <fieldset>
                            <select name="location_id" class="form-control" id="location_id">
                                <?php
                                foreach( $locations as $loc ) :
                                    $childs_first_name = get_post_meta( $cust->ID, 'childs_first_name', true );
                                    $childs_last_name = get_post_meta( $cust->ID, 'childs_last_name', true );
                                    $parents_name = get_post_meta( $cust->ID, 'parents_name', true ); ?>
                                    <option value="<?php echo $loc->ID; ?>">sadasdasdad<?php echo get_field( 'location_name', $loc->ID );?></option>
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
                            <select name="class_id" class="form-control">
                                <?php foreach( $customers as $cust ) :
                                    $childs_first_name = get_post_meta( $cust->ID, 'childs_first_name', true );
                                    $childs_last_name = get_post_meta( $cust->ID, 'childs_last_name', true );
                                    $parents_name = get_post_meta( $cust->ID, 'parents_name', true ); ?>
                                    <option value="<?php echo $cust->ID; ?>"><?php echo $childs_first_name . ' ' . $childs_last_name . '(' . $parents_name . ')'; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <!-- /# -->
                            <i class="fieldset-overlay" data-js="focus-on-field"></i>
                        </fieldset>
                    </div>
                </div>
            </div>


            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <input type="hidden" name="doktor" value="<?php echo $current_user->ID; ?>" />
            <input type="hidden" name="bolnica" value="<?php echo get_user_meta($current_user->ID,'bolnica_id',true); ?>" />
            <input type="hidden" name="form_handler" value="pacijent" />
            </div>
            <div class="card-footer clearfix">
                <button data-remodal-action="cancel" class="left btn btn--secondary" type="button">Cancel</button>
                <button class="right btn btn--primary" type="submit">Save</button>
            </div>
        </form>
    </div>
</div>
        

<script type="text/javascript">

set_title('Bolnica');


$(document).ready(function () {

    $("#pacijent-form").validate({
        // any other options,
        errorContainer: $("#pacijent-form").find( 'div.validation-message' ),
    		errorLabelContainer: $("#pacijent-form").find( 'div.validation-message ul' ),
    		wrapper: "li",
    });

    $("#pacijent-form").ajaxForm({
        // any other options,
        beforeSubmit: function () {
            //$('#sales_reps').val();
            return $("#pacijent-form").valid(); // TRUE when form is valid, FALSE will cancel submit
        },
        success: function (json) {
      		am2.main.notify('pnotify','success', json.message);
            var inst = $('[data-remodal-id=modal]').remodal({hashTracking: false});
            inst.destroy();
            load_screen('REFRESH');
        },
    		url: '<?php echo site_url();?>/wp-admin/admin-ajax.php?action=submit_data',
    		type: 'post',
    		dataType: 'json'
    });

    $('#location_id').select2({
        placeholder: 'Choose now'
    });

});

</script>