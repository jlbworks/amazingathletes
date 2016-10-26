<?php
global $current_user;
global $wpdb; 
get_currentuserinfo(); 

$id = $_REQUEST['id'];

restrict_access('administrator');

$create_city = empty($id);

$states = $wpdb->get_results("SELECT * FROM states");

?>

<div class="card-wrapper">
    <h3 class="card-header"><?php echo ($create_city ? 'Create City' : 'Edit City');?></h3>
    <form id="city-form" class="card-form no-inline-edit js-ajax-form">
        <div class="card-inner">
            
        <div class="validation-message"><ul></ul></div>
            <div class="card-table">

                <div class="card-table-row">
                    <span class="card-table-cell fixed250">State <span class="required">*</span></span>
                    <div class="card-table-cell">
                        <div class="card-form">
                            <fieldset>
                                <select name="state" class="form-control" id="state" title="Please select a state." required>
                                    <option value=""></option>
                                    <?php foreach( $states as $state ) : ?>
                                        <option value="<?php echo $state->state_code; ?>" <?php selected( $sel_state, $state->state_code, true ); ?> required><?php echo $state->state; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <!-- /# -->
                                <i class="fieldset-overlay" data-js="focus-on-field"></i>
                            </fieldset>
                        </div>
                    </div>
                </div>

                <div class="card-table-row">
                    <span class="card-table-cell fixed250">City <span class="required">*</span></span>
                    <div class="card-table-cell">
                        <div class="card-form">
                            <fieldset>
                                <input type="text" name="city" id="city" value="<?php echo $sel_city ? $sel_city : '';?>" <?php echo $create_city ? 'disabled' : '';?> /> 
                                <!-- /# -->
                                <i class="fieldset-overlay" data-js="focus-on-field"></i>
                            </fieldset>
                        </div>
                    </div>
                </div>

                <div class="card-table-row">
                    <span class="card-table-cell fixed250">ZIP code <span class="required">*</span></span>
                    <div class="card-table-cell">
                        <div class="card-form">
                            <fieldset>
                                <input type="number" name="zip" id="zip" value="<?php echo $sel_zip ? $sel_zip : '';?>" <?php echo $create_city ? 'disabled' : '';?> /> 
                                <!-- /# -->
                                <i class="fieldset-overlay" data-js="focus-on-field"></i>
                            </fieldset>
                        </div>
                    </div>
                </div>
                
                <input type="hidden" name="id" value="<?php echo $id; ?>" />
                <input type="hidden" name="form_handler" value="create_city" />

            </div>
        
            <div class="card-footer clearfix">
                <button data-remodal-action="cancel" class="left btn btn--secondary" type="button">Cancel</button>
                <button class="right btn btn--primary" type="submit">Save</button>
            </div>
            <?php am2_add_preloader(); ?>
        </div>
    </form>
</div>

<script type="text/javascript">

set_title('City');

var class_dates;

$(document).ready(function () {

    var form = $("#city-form");
    form.validate({});

    form.ajaxForm({
        // any other options,
        beforeSubmit: function () {
            am2_show_preloader(form);
            return $("#city-form").valid(); // TRUE when form is valid, FALSE will cancel submit
        },
        success: function (json) {
      		am2.main.notify('pnotify','success', json.message);
            var inst = $('[data-remodal-id=modal]').remodal({hashTracking: false});
            if(inst) {
                inst.destroy();
                load_screen('REFRESH');
            }
            else {
                empty_form($("#city-form"));
            }
            am2_hide_preloader(form);
        },
    		url: '<?php echo site_url();?>/wp-admin/admin-ajax.php?action=submit_data',
    		type: 'post',
    		dataType: 'json'
    });

    $('#state').select2({
        placeholder: 'Select a State',
        width: '100%',
        minimumResultsForSearch: -1
    })
    .on('select2:select', function() {
       form.find(':input').prop('disabled',$('#state').val() == '');                
    });
    
});
</script>

