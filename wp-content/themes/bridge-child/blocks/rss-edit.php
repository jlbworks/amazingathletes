<?php
global $current_user; 
get_currentuserinfo(); 

$id = $_REQUEST['id'];

restrict_access('administrator','franchisee');
/*
echo( "<div>In Development</div>" );
return;*/

$rss_report = get_post($id);


$franchise_id   = get_post_meta( $roster->ID, 'rss_franchise_id', true );
$franchise      = get_user_by( 'id', $franchise_id );

$month = array(
    'jan' => 'January',
    'feb' => 'February',
    'mar' => 'March',
    'apr' => 'April',
    'may' => 'May',
    'jun' => 'June',
    'jul' => 'July',
    'aug' => 'August',
    'sep' => 'September',
    'oct' => 'October',
    'nov' => 'November',
    'dec' => 'December',
);
$year = array(
    '2016','2017','2018','2019','2020'
);


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
    <h3 class="card-header">New RSS Report</h3>
    <form id="rss-create-form" class="card-form no-inline-edit js-ajax-form">
    <div class="card-inner">
        
        <div class="validation-message"><ul></ul></div>
            <div class="card-table">
                <?php if( is_role( 'administrator') ) : ?>
                    <div class="card-table-row">
                        <span class="card-table-cell fixed250">Franchise <span class="required">*</span></span>
                        <div class="card-table-cell">
                            <div class="card-form">
                                <fieldset>
                                    <select id="rss_franchise_id" name="rss_franchise_id" class="form-control" title="Please select a franchise." required>
                                        <option value="">Select Franchisee</option>
                                        <?php foreach( $franchises as $franchisee ) :
                                            $franchise_name = $franchisee->display_name;  
                                              /*$franchise_name = $franchise->franchise_name;
                                                if(!empty($franchise->first_name) || !empty($franchise->last_name)) {
                                                    $franchise_name = $franchise->first_name . ' ' . $franchise->last_name;
                                                }*/ 
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
                    <span class="card-table-cell fixed250">Month <span class="required">*</span></span>
                    <div class="card-table-cell">
                        <div class="card-form">
                            <fieldset>
                                <select name="rss_month" class="form-control" id="rss_month" title="Please select month." required>
                                    <option value="">Select Month</option>
                                    <?php foreach( $month as $key => $value ) : ?>
                                        <option value="<?php echo $key; ?>"><?php echo $value;?></option>
                                    <?php endforeach; ?>
                                </select>
                                <!-- /# -->
                                <i class="fieldset-overlay" data-js="focus-on-field"></i>
                            </fieldset>
                        </div>
                    </div>
                </div>

                <div class="card-table-row">
                    <span class="card-table-cell fixed250">Year <span class="required">*</span></span>
                    <div class="card-table-cell">
                        <div class="card-form">
                            <fieldset>
                                <select name="rss_year" class="form-control" id="rss_year" title="Please select year." required>
                                    <option value="">Select Year</option>
                                    <?php foreach( $year as $yr ) : ?>
                                        <option value="<?php echo $yr; ?>"><?php echo $yr;?></option>
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
            <input type="hidden" name="form_handler" value="rss_create" />
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


var class_dates;

$(document).ready(function () {

    var form = $("#rss-create-form");
    form.validate({});

    form.ajaxForm({
        // any other options,
        beforeSubmit: function () {
            am2_show_preloader(form);
            return $("#rss-create-form").valid(); // TRUE when form is valid, FALSE will cancel submit
        },
        success: function (json) {
      		am2.main.notify('pnotify','success', json.message);
            var inst = $('[data-remodal-id=modal]').remodal({hashTracking: false});
            if(inst) {
                inst.destroy();
                load_screen('REFRESH');
            }
            else {
                empty_form($("#rss-create-form"));
            }
            am2_hide_preloader(form);
        },
    		url: '<?php echo site_url();?>/wp-admin/admin-ajax.php?action=submit_data',
    		type: 'post',
    		dataType: 'json'
    });

    $('#rss_franchise_id').select2({
        placeholder: 'Select a Franchise',
        width: '100%',
        minimumResultsForSearch: -1
    });
    $('#rss_year').select2({
        placeholder: 'Select a Year',
        width: '100%',
        minimumResultsForSearch: -1
    });
    $('#rss_month').select2({
        placeholder: 'Select a Month',
        width: '100%',
        minimumResultsForSearch: -1
    });
   

});
</script>

