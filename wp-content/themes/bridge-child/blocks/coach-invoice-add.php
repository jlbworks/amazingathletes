<?php
global $current_user; 
get_currentuserinfo(); 

$id = $_REQUEST['id'];

restrict_access('administrator,franchisee');
/*
echo( "<div>In Development</div>" );
return;*/

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
$location_args = array(
        'post_type' => 'location',
        'post_status'       => 'publish',
        'posts_per_page'    => -1,
    );
if( !$franchise_id &&  is_role( 'franchisee' )) {
    $location_args['author'] = get_current_user_id(); 
}
elseif( $franchise_id ) {
    $location_args['author'] = $franchise_id;
}
$locations = get_posts( $location_args );

$franchise_args = array(
    'role' => 'franchisee'
);
if( is_role( 'franchisee' ) ) {
    $franchise_args['include'] = array(
        get_current_user_id(),
    );
}
$franchises = get_users( $franchise_args );

$coach_args = array(
    'role' => 'coach'
);
if( is_role( 'coach' ) ) {
    $coach_args['include'] = array(
        get_current_user_id(),
    );
}
$coaches = get_users( $coach_args );

?>

<div class="card-wrapper">
    <h3 class="card-header">New Coach Invoice</h3>
    <form id="attendance-form" class="card-form no-inline-edit js-ajax-form">
    <div class="card-inner">
        
        <div class="validation-message"><ul></ul></div>
            <div class="card-table">
                <?php if( is_role( 'administrator') ) : ?>
                    <div class="card-table-row">
                        <span class="card-table-cell fixed250">Franchise <span class="required">*</span></span>
                        <div class="card-table-cell">
                            <div class="card-form">
                                <fieldset>
                                    <select id="attendance_franchise_id" name="franchise_id" class="form-control" title="Please select a franchise." required>
                                        <option value=""></option>
                                        <?php 
                                        foreach( $franchises as $franchisee ) :
                                            $franchise_name = $franchise->display_name;
                                            if(!empty($franchisee->first_name) || !empty($franchisee->last_name)) {
                                                $franchise_name = $franchisee->first_name . ' ' . $franchisee->last_name;
                                            }
                                         ?>
                                            <option value="<?php echo $franchisee->ID; ?>" <?php selected($franchise_id, $franchisee->ID, true ); ?>><?php echo $franchise_name; ?></option>
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
                    <span class="card-table-cell fixed250">Coach <span class="required">*</span></span>
                    <div class="card-table-cell">
                        <div class="card-form">
                            <fieldset>
                                <select name="coach_id" class="form-control" id="coach_id" title="Please select a coach." required>
                                    <option value=""></option>
                                    <?php foreach( $coaches as $coach ) :
                                        $user_name = $coach->display_name;
                                        if(!empty($coach->first_name) || !empty($coach->last_name)) {
                                            $user_name = $coach->first_name . ' ' . $coach->last_name;
                                        }
                                     ?>
                                        <option value="<?php echo $coach->ID; ?>" required><?php echo $user_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <!-- /# -->
                                <i class="fieldset-overlay" data-js="focus-on-field"></i>
                            </fieldset>
                        </div>
                    </div>
                </div>

                <div class="card-table-row">
                    <span class="card-table-cell fixed250">Date Start <span class="required">*</span></span>
                    <div class="card-table-cell">
                        <div class="card-form">
                            <fieldset>
                                <input type="text" data-js="datepicker-format" name="date_start" class="form-control" title="Please choose the date." value="" required/>
                                <i class="fieldset-overlay" data-js="focus-on-field"></i>
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="card-table-row">
                    <span class="card-table-cell fixed250">Date End <span class="required">*</span></span>
                    <div class="card-table-cell">
                        <div class="card-form">
                            <fieldset>
                                <input type="text" data-js="datepicker-format" name="date_end" class="form-control" title="Please choose the date." value="" required/>
                                <i class="fieldset-overlay" data-js="focus-on-field"></i>
                            </fieldset>
                        </div>
                    </div>
                </div>

            <input type="hidden" name="invoice_type" value="coach" />
            <input type="hidden" name="form_handler" value="add_coach_invoice" />
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

set_title('Coach Invoice');


$(document).ready(function () {

    var form = $("#attendance-form");
    form.validate({});

    form.ajaxForm({
        // any other options,
        beforeSubmit: function () {
            am2_show_preloader(form);
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
            am2_hide_preloader(form);
        },
    		url: '<?php echo site_url();?>/wp-admin/admin-ajax.php?action=submit_data',
    		type: 'post',
    		dataType: 'json'
    });

    $('#coach_id').select2({
        placeholder: 'Select a coach',
        width: '100%',
        minimumResultsForSearch: -1
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
                am2_show_preloader(form);
            },
            success: function(data) {
                var placeholder = data.length == 1 ? "No locations found for this franchise" : "Select a location";

                $('#attendance_location_id').html('').select2({
                    placeholder: placeholder,
                    width: '100%',
                    data: data
                });

                $('#attendance_class_id').html('').select2({
                    placeholder: 'Select a location first',
                    width: '100%'
                });

                am2_hide_preloader(form);
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
                am2_show_preloader(form);
            },
            success: function(data) {
                var placeholder = data.length == 1 ? "No classes found for this location" : "Select a class";

                $('#attendance_class_id').html('').select2({
                    placeholder: placeholder,
                    data: data,
                    width: '100%'
                });
                am2_hide_preloader(form);
            }
        })
    });

    $('#attendance_class_id').select2({
        placeholder: 'Select a location first',
        width: '100%'
    });
});
</script>

