<?php
global $current_user; 
get_currentuserinfo(); 

$id = $_REQUEST['id'];

restrict_access('administrator,franchisee,coach');
/*
echo( "<div>In Development</div>" );
return;*/

$roster = get_post($id);

$customer_id    = get_post_meta( $roster->ID, 'roster_customer_id', true );
$customer       = get_post( $customer_id );

$customer_location_id = get_post_meta( $customer_id, 'location_id' );

$class_id       = get_post_meta( $roster->ID, 'roster_class_id', true );

$franchise_id   = get_post_meta( $roster->ID, 'roster_franchise_id', true );
$franchise      = get_user_by( 'id', $franchise_id );

$coach_id   = get_post_meta( $roster->ID, 'roster_coach_id', true );
$coach = get_user_by('id', $coach_id);

$location_id   = get_post_meta( $roster->ID, 'roster_location_id', true );
$location      = get_post( $location_id );



$roster_date = get_post_meta( $roster->ID, 'roster_date', true );

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

$coaches = array();
foreach($classes as $class){
    $_coaches = get_post_meta($class->ID, 'coaches', true);   

    $location = get_post($class->location_id);          

    if(is_array($_coaches)){
        $_coaches = array_merge(array($location->post_author),$_coaches);
        $_coaches = array_unique($_coaches);
        foreach($_coaches as $_coach){
            $coaches[$_coach] = get_user_by('id',(int) $_coach);
        }
    }        
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

$customer_statuses = array('','E','N','FT');
$customer_media = array('y','n');
$customer_discounts = array('','SIB');
$payment_types = array('','Ck/$');

?>

<div class="card-wrapper">
    <h3 class="card-header">Roster<?php if( !empty($first_name) ) echo " : $first_name"." ".$last_name; ?></h3>
    <form id="roster-form" class="card-form no-inline-edit js-ajax-form">
    <div class="card-inner">
        
        <div class="validation-message"><ul></ul></div>
            <div class="card-table">
                <?php if( is_role( 'administrator') ) : ?>
                    <div class="card-table-row">
                        <span class="card-table-cell fixed250">Franchise <span class="required">*</span></span>
                        <div class="card-table-cell">
                            <div class="card-form">
                                <fieldset>
                                    <select id="roster_franchise_id" name="roster_franchise_id" class="form-control" title="Please select a franchise." required>
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
                                <select name="roster_location_id" class="form-control" id="roster_location_id" title="Please select a location." required>
                                    <option value=""></option>
                                    <?php foreach( $locations as $loc ) : ?>
                                        <option value="<?php echo $loc->ID; ?>" <?php selected( $location_id, $loc->ID, true ); ?> required><?php echo ($loc->location_name ? $loc->location_name : $loc->post_title);?></option>
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
                                <select name="roster_class_id" class="form-control" id="roster_class_id" title="Please select a class." required>
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
                                <select id="roster_customer_id" name="roster_customer_id" class="form-control" title="Please select a customer." required>
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
                    <span class="card-table-cell fixed250">Customer Status<span class="required">*</span></span>
                    <div class="card-table-cell">
                        <div class="card-form">
                            <fieldset>
                                <select id="roster_customer_status" name="roster_customer_status" class="form-control" title="Please select a customer status." required>
                                    <?php foreach($customer_statuses as $status) {?>
                                    <option value="<?php echo $status;?>" <?php echo $status == $roster->roster_customer_status ? 'selected':'' ;?>><?php echo $status;?></option>
                                    <?php } ;?>
                                </select>
                                <!-- /# -->
                                <i class="fieldset-overlay" data-js="focus-on-field"></i>
                            </fieldset>
                        </div>
                    </div>
                </div>

                <div class="card-table-row">
                    <span class="card-table-cell fixed250">Customer Media<span class="required">*</span></span>
                    <div class="card-table-cell">
                        <div class="card-form">
                            <fieldset>
                                <select id="roster_customer_media" name="roster_customer_media" class="form-control" title="Please select a customer media." required>
                                    <?php foreach($customer_media as $media) {?>
                                    <option value="<?php echo $media;?>" <?php echo $media == $roster->roster_customer_media ? 'selected':'' ;?>><?php echo $media;?></option>
                                    <?php } ;?>                             
                                </select>
                                <!-- /# -->
                                <i class="fieldset-overlay" data-js="focus-on-field"></i>
                            </fieldset>
                        </div>
                    </div>
                </div>

                <div class="card-table-row">
                    <span class="card-table-cell fixed250">Customer Discount<span class="required">*</span></span>
                    <div class="card-table-cell">
                        <div class="card-form">
                            <fieldset>
                                <select id="roster_customer_discount" name="roster_customer_discount" class="form-control" title="Please select a customer discount." required>
                                    <?php foreach($customer_discounts as $discount) {?>
                                    <option value="<?php echo $discount;?>" <?php echo $discount == $roster->roster_customer_discount ? 'selected':'' ;?>><?php echo $discount;?></option>
                                    <?php } ;?>                                                                        
                                </select>
                                <!-- /# -->
                                <i class="fieldset-overlay" data-js="focus-on-field"></i>
                            </fieldset>
                        </div>
                    </div>
                </div>

                <div class="card-table-row">
                    <span class="card-table-cell fixed250">Payment Type<span class="required">*</span></span>
                    <div class="card-table-cell">
                        <div class="card-form">
                            <fieldset>
                                <select id="roster_payment_type" name="roster_payment_type" class="form-control" title="Please select a payment type." required>
                                    <?php foreach($payment_types as $pay_type) {?>
                                    <option value="<?php echo $pay_type;?>" <?php echo $pay_type == $roster->roster_payment_type ? 'selected':'' ;?>><?php echo $pay_type;?></option>
                                    <?php } ;?>                                                                        
                                </select>
                                <!-- /# -->
                                <i class="fieldset-overlay" data-js="focus-on-field"></i>
                            </fieldset>
                        </div>
                    </div>
                </div>

                <div class="card-table-row">
                    <span class="card-table-cell fixed250">Coach Name<span class="required">*</span></span>
                    <div class="card-table-cell">
                        <div class="card-form">
                            <fieldset>
                                <select id="roster_coach_id" name="roster_coach_id" class="form-control" title="Please select a coach." required>
                                    <?php   foreach( $coaches as $coach ) : ?>                                        
                                        <option value="<?php echo $coach->ID; ?>" <?php selected( $coach_id, $coach->ID, true ); ?>><?php echo $coach->display_name;  ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <!-- /# -->
                                <i class="fieldset-overlay" data-js="focus-on-field"></i>
                            </fieldset>
                        </div>
                    </div>
                </div>

                <?php /*<div class="card-table-row">
                    <span class="card-table-cell fixed250">Date <span class="required">*</span></span>
                    <div class="card-table-cell">
                        <div class="card-form">
                            <fieldset>
                                <input type="text" data-js="datepicker-format" name="roster_date" class="form-control" title="Please choose the date." value="<?php echo esc_attr( $roster_date ); ?>" required/>
                                <i class="fieldset-overlay" data-js="focus-on-field"></i>
                            </fieldset>
                        </div>
                    </div>
                </div>*/ ?>

            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <input type="hidden" name="form_handler" value="roster" />
            </div>
             </div>
            <div class="card-footer clearfix">
                <button data-remodal-action="cancel" class="left btn btn--secondary" type="button">Cancel</button>
                <button class="right btn btn--primary" type="submit">Save</button>
            </div>
            <?php am2_add_preloader(); ?>
        </form>
   
</div>

<script type="text/javascript">

set_title('Bolnica');

var class_dates;

$(document).ready(function () {

    var form = $("#roster-form");
    form.validate({});

    form.ajaxForm({
        // any other options,
        beforeSubmit: function () {
            am2_show_preloader(form);
            return $("#roster-form").valid(); // TRUE when form is valid, FALSE will cancel submit
        },
        success: function (json) {
      		am2.main.notify('pnotify','success', json.message);
            var inst = $('[data-remodal-id=modal]').remodal({hashTracking: false});
            if(inst) {
                inst.destroy();
                load_screen('REFRESH');
            }
            else {
                empty_form($("#roster-form"));
            }
            am2_hide_preloader(form);
        },
    		url: '<?php echo site_url();?>/wp-admin/admin-ajax.php?action=submit_data',
    		type: 'post',
    		dataType: 'json'
    });

    $('#roster_franchise_id').select2({
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
                franchise_id: $('#roster_franchise_id').val()
            },
            beforeSend: function() {
                am2_show_preloader(form);
            },
            success: function(data) {
                var placeholder = data.length == 1 ? "No locations found for this franchise" : "Select a location";

                $('#roster_location_id').html('').select2({
                    placeholder: placeholder,
                    width: '100%',
                    data: data
                });

                $('#roster_class_id').html('').select2({
                    placeholder: 'Select a location first',
                    width: '100%'
                });

                am2_hide_preloader(form);
            }
        })
    });

    $('#roster_customer_id').select2({
        placeholder: 'Select a customer',
        width: '100%',
        minimumResultsForSearch: -1
    });

    $('#roster_coach_id').select2({
        placeholder: 'Select a coach',
        width: '100%',
        minimumResultsForSearch: -1
    });

    $('#roster_location_id').select2({
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
                location_id: $('#roster_location_id').val()
            },
            beforeSend: function() {
                am2_show_preloader(form);
            },
            success: function(data) {
                var placeholder = data.length == 1 ? "No classes found for this location" : "Select a class";

                $('#roster_class_id').html('').select2({
                    placeholder: placeholder,
                    data: data,
                    width: '100%'
                });
                am2_hide_preloader(form);
            }
        })
    });

    $('#roster_class_id').select2({
        placeholder: 'Select a location first',
        width: '100%'
    }).on('change',function(){      
        $.ajax({
            url: '<?php echo site_url();?>/wp-admin/admin-ajax.php?action=submit_data',
            type: 'POST',
            dataType: 'json',
            data: {
                form_handler: 'get_coaches',
                class_id: $('#roster_class_id').val()
            },
            beforeSend: function() {
                am2_show_preloader(form);
            },
            success: function(data) {
                var placeholder = data.length == 1 ? "No coaches found for this location" : "Select a coach";

                $('#roster_coach_id').html('').select2({
                    placeholder: placeholder,
                    data: data,
                    width: '100%'
                });
                am2_hide_preloader(form);
            }
        })  
    
    });
    $('#roster_customer_status').select2({
        placeholder: 'Select a Status',
        width: '100%',
        minimumResultsForSearch: -1
    });
    $('#roster_customer_media').select2({
        placeholder: 'Select a Media Status',
        width: '100%',
        minimumResultsForSearch: -1
    });
    $('#roster_customer_discount').select2({
        placeholder: 'Select a Discount Type',
        width: '100%',
        minimumResultsForSearch: -1
    });
    $('#roster_payment_type').select2({
        placeholder: 'Select a Payment Type',
        width: '100%',
        minimumResultsForSearch: -1
    });
});
</script>

