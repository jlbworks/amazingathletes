<?php
global $current_user; 
get_currentuserinfo(); 

global $target_args;
$id = $target_args['id'];

restrict_access('super_admin,administrator,franchisee,coach');

$coach_invoice = get_post($id);
$franchise = get_user_by('id', $coach_invoice->franchise_id); 
$franchise_name = $franchise->display_name;
if(!empty($franchise->first_name) || !empty($franchise->last_name)) {
    $franchise_name = $franchise->first_name . ' ' . $franchise->last_name;
}
$franchise_data = get_user_meta($coach_invoice->franchise_id);

$coach = get_user_by('id', $coach_invoice->coach_id); 
$coach_name = $coach->display_name;
if(!empty($coach->first_name) || !empty($coach->last_name)) {
    $coach_name = $coach->first_name . ' ' . $coach->last_name;
}
$coach_data = get_user_meta($coach_invoice->coach_id);

/* Invoice data */
$total = '0.00';
if(!empty($coach_invoice->total)) $total = $coach_invoice->total;
$other = '0.00';
if(!empty($coach_invoice->bonus)) $other = $coach_invoice->other;
$travel_surcharge = '0.00';
if(!empty($coach_invoice->travel_surcharge)) $travel_surcharge = $coach_invoice->travel_surcharge;
$liability_insurance_rebate = '0.00';
if(!empty($coach_invoice->liability_insurance_rebate)) $liability_insurance_rebate = $coach_invoice->liability_insurance_rebate;
$equipment_rental_rebate = '0.00';
if(!empty($coach_invoice->equipment_rental_rebate)) $equipment_rental_rebate = $coach_invoice->equipment_rental_rebate;
$settled_outstanding_student_compensations = '0.00';
if(!empty($coach_invoice->settled_outstanding_student_compensations)) $settled_outstanding_student_compensations = $coach_invoice->settled_outstanding_student_compensations;

/* GET DATA FOR COACH */
$args = array(
  'post_type'   => 'attendance',
  'post_status' => 'publish',
  'posts_per_page'=> -1,
  'meta_query' => array(
        array(
            'key' => 'attendance_coach_id',
            'value' => $coach_invoice->coach_id,
            'compare' => '='
        ),
        array(
            'key' => 'attendance_date',
            'value' => array($coach_invoice->date_start,$coach_invoice->date_end),
            'compare' => 'BETWEEN'
        ),

    ),
);
$attendance = get_posts($args);
$payment_totals = array();
$items = get_post_meta($coach_invoice->ID, 'item', true);
if(!empty($items)) {
    $payment_totals = $items;
} else {
    if($attendance):
    foreach($attendance as $attend):
        $class_id = $attend->attendance_class_id;
        $class = get_post($class_id);
        $location = get_post($class->location_id);

        $coach_pay_scale = $class->coach_pay_scale;
        $payment_totals[$class_id]['description'] = $location->post_title.', '.$class->program.' ('.$class->coach_pay_scale.')';
        $payment_totals[$class_id]['quantity']++;

        if($coach_pay_scale == 'Per Student per Class Pay') {
            $payment_totals[$class_id]['price'] = $class->per_student_per_class_pay;
            $payment_totals[$class_id]['total_earned'] += $class->per_student_per_class_pay;
        }
        //new_student_bonus 
    endforeach;
endif;
}

/* END GET DATA */

?>
<!-- CONTENT HEADER -->
<div class="layout context--pageheader">
    <div class="container clearfix">
        <div class="col-12 break-big">
            <h1>Coach Invoice #<?php echo $coach_invoice->ID; ?></h1>
        </div>
    </div>
</div>

<!-- PRODUCT INFORMATION -->
<div class="layout">
    <div class="container clearfix">
        <div class="col-1 break-big">

<div class="card-wrapper">

    <div class="card-inner">
        
        <div class="validation-message"><ul></ul></div>
            <div class="card-table">
                <div class="card-header">
                </div>
                <div class="card-inner">
                <div class="col-12">
                    <h2>Remit To:</h2>
                    <p>
                        <?php echo $coach->first_name.' '.$coach->last_name.', '.$coach_data['employment_type'][0]; ?><br>
                        <?php echo $coach_data['street_address'][0]; ?><br>
                        <?php $city__state = explode("|", $coach_data['city__state'][0]); echo $city__state[1].', '.$city__state[0].' '.$coach_data['zip_code'][0]; ?><br>
                        <?php echo $coach_data['contact_number'][0]; ?>
                    </p>
                </div>
                <div class="col-12">
                    <h2>Bill To:</h2>
                    <?php echo $franchise_name; ?><br>
                    <?php echo $franchise_data['franchise_address'][0]; ?><br>
                    <?php $city__state = explode("|", $franchise_data['city__state'][0]); echo $city__state[1].', '.$city__state[0].' '.$franchise_data['franchise_zip'][0]; ?><br>
                    <?php echo $franchise_data['franchise_telephone'][0]; ?>
                </div>
                <div class="spacer"></div>
                <div class="col-1 clearfix">
                    <h2>Invoice for:</h2>
                    <p><?php echo date('F d, Y',strtotime($coach_invoice->date_start)); ?> - <?php echo date('F d, Y',strtotime($coach_invoice->date_end)); ?> </p>
                </div>
                
            </div>
             </div>
            </div>

   
</div>
<div class="col-1 break-big">
<div class="card-wrapper">
<div class="card-header">
    </div>
    <div class="card-inner">
<form method="POST" class="form-horizontal well" role="form" id="coach-invoice-form">
<fieldset class="fields-group">
<h3>Description of Services</h3>
    <div class="clearfix">
        <div class="col-16">
            Description
        </div>
        <div class="col-16">
            Quantity
        </div>
        <div class="col-16">
            Quantity Type
        </div>
        <div class="col-16">
            Rate
        </div>
        <div class="col-16">
            Number of weeks
        </div>
        <div class="col-16 no_margin">
            Actions
        </div>
    </div>
    <?php   ?>
    <div class="repeater repeater-custom-show-hide card-table">
      <div data-repeater-list="item">
        <?php 

        if(empty($payment_totals)) { ?>
        <div data-repeater-item="">
          <div class="form-group clearfix">
            
            <div class="col-16">
                <input type="text" name="item[0][description]" class="form-control" placeholder="Description"> 
            </div>

            <div class="col-16">
              <input type="text" name="item[0][quantity]" value="0" class="form-control number js-quantity" placeholder="Quantity">
            </div>
            
            <div class="col-16">
                <select name="item[0][quantity_type]" class="form-control" id="item[0][quantity_type]" title="Please select quantity type" required>
                    <option value="students">Students</option>
                    <option value="hours">Hours</option>
                    <option value="classes">Classes</option>
                </select>
            </div>
            
            <div class="col-16">
              <input type="text" name="item[0][price]" value="0" class="form-control currency js-add-to-total" placeholder="Amount">
            </div>

            <div class="col-16">
              <input type="text" name="item[0][num_of_weeks]" value="1" class="form-control number js-multiply-to-total" placeholder="Amount">
            </div>

            <div class="col-16 no_margin">
              <a class="am2-ajax-modal-delete btn btn--danger is-smaller" data-repeater-delete=""
                                       data-original-title="Delete" data-placement="top" data-toggle="tooltip"
                                       data-object="S" data-id=""><i class="fa fa-trash-o"></i></a>
            </div>
          </div>
        <?php } else {
            foreach($payment_totals as $payment_total) {
                ?>
                <div data-repeater-item="">
                  <div class="form-group clearfix">
                    
                    <div class="col-16">
                        <input type="text" name="item[0][description]" class="form-control" value="<?php echo $payment_total['description']; ?>" placeholder="Description"> 
                    </div>

                    <div class="col-16">
                      <input type="text" name="item[0][quantity]" value="<?php echo $payment_total['quantity']; ?>" class="form-control number js-quantity" placeholder="Quantity">
                    </div>
                    
                    <div class="col-16">
                        <select name="item[0][quantity_type]" class="form-control" id="item[0][quantity_type]" title="Please select quantity type" required>
                            <option <?php if($payment_total['quantity_type'] == "students") { echo "selected"; } ?> value="students">Students</option>
                            <option <?php if($payment_total['quantity_type'] == "hours") { echo "selected"; } ?> value="hours">Hours</option>
                            <option <?php if($payment_total['quantity_type'] == "classes") { echo "selected"; } ?> value="classes">Classes</option>
                        </select>
                    </div>
                    
                    
                    <div class="col-16">
                      <input type="text" name="item[0][price]" value="<?php echo $payment_total['price']; ?>" class="form-control currency js-add-to-total" placeholder="Amount">
                    </div>

                    <div class="col-16">
                      <input type="text" name="item[0][num_of_weeks]" value="1" class="form-control number js-multiply-to-total" placeholder="Amount">
                    </div>                    

                    <div class="col-16 no_margin">
                      <a class="am2-ajax-modal-delete btn btn--danger is-smaller" data-repeater-delete=""
                                               data-original-title="Delete" data-placement="top" data-toggle="tooltip"
                                               data-object="S" data-id=""><i class="fa fa-trash-o"></i></a>
                    </div>
                  </div>
                <?php
            }
        }
        ?>
        </div>

        
      </div>
      <div class="form-group clearfix">
        <div class="col-14">
            <a class="left btn btn--primary" data-repeater-create=""><i class="fa fa-plus"></i> Add</a>

        </div>
      </div>



    </div>
</fieldset>
        
        <div class="validation-message"><ul></ul></div>

            <div class="card-table frm_invoice_additional">
                    <div class="card-table-row">
                        <span class="card-table-cell fixed250"><strong>Total</strong> </span>
                        <div class="card-table-cell">
                            <div class="card-form">
                                <fieldset>
                                <input type="text"  id="js-total" data-js="" name="total" class="form-control currency js-add-to-grand-total" title="Please add bonus" value="$<?php echo $total; ?>" readonly />
                                </fieldset>
                            </div>
                        </div>

                    </div>
                     <div class="card-table-row">
                        <span class="card-table-cell fixed250">Travel Surcharge </span>
                        <div class="card-table-cell">
                            <div class="card-form">
                            <fieldset>
                                <input type="text" data-js="" name="travel_surcharge" class="form-control currency js-add-to-grand-total editable" title="Please add travel surcharge" value="$<?php echo $travel_surcharge; ?>" />
                            </fieldset>
                        </div>
                        </div>
                    </div>
                     <div class="card-table-row">
                        <span class="card-table-cell fixed250">Liability Insurance Rebate </span>
                        <div class="card-table-cell">
                            <div class="card-form">
                            <fieldset>
                                <input type="text" data-js="" name="liability_insurance_rebate" class="form-control currency js-add-to-grand-total editable" title="Please add Liability Insurance Rebate" value="$<?php echo $liability_insurance_rebate; ?>" />
                            </fieldset>
                        </div>
                        </div>
                    </div>
                     <div class="card-table-row">
                        <span class="card-table-cell fixed250">Equipment Rental Rebate </span>
                        <div class="card-table-cell">
                            <div class="card-form">
                            <fieldset>
                                <input type="text" data-js="" name="equipment_rental_rebate" class="form-control currency js-add-to-grand-total editable" title="Please add bonus" value="$<?php echo $equipment_rental_rebate; ?>" />
                            </fieldset>
                        </div>
                        </div>
                    </div>
                    <div class="card-table-row">
                        <span class="card-table-cell fixed250">Settled Outstanding Student Compensations </span>
                        <div class="card-table-cell">
                            <div class="card-form">
                            <fieldset>
                                <input type="text" data-js="" name="settled_outstanding_student_compensations" class="form-control currency js-add-to-grand-total editable" title="Please add Settled Outstanding Student Compensations" value="$<?php echo $settled_outstanding_student_compensations; ?>" />
                            </fieldset>
                        </div>
                        </div>
                    </div>
                    <div class="card-table-row">
                        <span class="card-table-cell fixed250">Other </span>
                        <div class="card-table-cell">
                            <div class="card-form">
                            <fieldset>
                                <input type="text" data-js="" name="other" class="form-control currency js-add-to-grand-total editable" title="Please add Others" value="$<?php echo $other; ?>" />
                            </fieldset>
                        </div>
                        </div>
                    </div>

                    <div class="card-table-row" style="color: red;">
                        <span class="card-table-cell fixed250"><strong>Grand Total</strong> </span>
                        <div class="card-table-cell">
                        <div class="card-form">
                            <fieldset>
                            <input type="text" id="js-grand-total" data-js="" name="grand_total" class="form-control currency js-grand-total" title="Grand Total" value="$<?php echo $grand_total; ?>" readonly />
                            </fieldset>
                        </div>
                        </div>
                        </div>
                    </div>

                    <input type="hidden" name="invoice_type" value="coach" />
                    <input type="hidden" name="invoice_id" value="<?php echo $id; ?>" />
                    <input type="hidden" name="form_handler" value="edit_coach_invoice" />

                    <div class="card-table-row clearfix">
                        <button class="left btn btn--primary" type="submit">Save Invoice</button>
                        <a class="left btn btn--transparent" style="margin-left:10px;" href="<?php echo site_url(); ?>/invoice?type=coach&id=<?php echo $id; ?>" type="submit" target="_blank">View Printable Invoice</a>
                    </div>
                    <div class="spacer"></div>
            </div>
    
</form>

</div>
</div>
</div>
</div>
<script src="<?php bloginfo('stylesheet_directory'); ?>/js-erp/vendor/jquery.repeater/jquery.repeater.js"></script>
<script src="<?php bloginfo('stylesheet_directory'); ?>/js-erp/vendor/jquery.maskMoney/jquery.maskMoney.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  'use strict';

  var form = $("#coach-invoice-form");
    form.validate({});

    form.ajaxForm({
        // any other options,
        beforeSubmit: function () {
            am2_show_preloader(form);
            return $("#coach-invoice-form").valid(); // TRUE when form is valid, FALSE will cancel submit
        },
        success: function (json) {
            am2.main.notify('pnotify','success', json.message);
            am2_hide_preloader(form);
        },
        url: '<?php echo site_url();?>/wp-admin/admin-ajax.php?action=submit_data',
        type: 'post',
        dataType: 'json'
    });

  $('.repeater-custom-show-hide').repeater({
    show: function () {
      $(this).slideDown();
      initMasks();
    },
    hide: function (remove) {
      //if(confirm('Are you sure you want to remove this item?')) {
        $(this).slideUp(remove);
      //}
    },
    isFirstItemUndeletable: true,
  });

  $(document).on('keyup', '.js-add-to-total', function() {
     addToTotal();
  });
  $(document).on('keyup', '.js-add-to-grand-total', function() {
     addToTotal();
  });
  $(document).on('keyup', '.js-quantity', function() {
     addToTotal();
  });
  $(document).on('keyup', '.js-multiply-to-total', function() {
     addToTotal();
  });

 

  addToTotal();
  initMasks();

});

function initMasks() {
    $('.currency').maskMoney({thousands:',', decimal:'.', allowZero: true, prefix: '$', allowNegative: true});
    $('.number').maskMoney({thousands:'', decimal:'', precision: 0, allowZero: true, prefix: '', allowNegative: true});
}

function parseCurrency( num ) {
    num = num.replace('$','');
    return parseFloat( num.replace( /,/g, '') );
  }

  function addToTotal() {

    var total = 0;
    $('.js-add-to-total').each(function() {
        if($(this).val() !== "") {
            var this_val = parseCurrency($(this).val());
            var this_quantity = $(this).closest('.form-group').find('.js-quantity').val();
            var this_weeks = $(this).closest('.form-group').find('.js-multiply-to-total').val();
            total = total + (this_val*this_quantity*this_weeks);            
        }
    });
    total = parseFloat(total).toFixed(2);
    $('#js-total').val('$'+parseFloat(total).toFixed(2));

    var grand_total = 0;
    $('.js-add-to-grand-total').each(function() {
        var this_val = parseCurrency($(this).val());
        grand_total = grand_total + this_val;
        //

    });
    grand_total = parseFloat(grand_total).toFixed(2);
    $('#js-grand-total').val('$'+parseFloat(grand_total).toFixed(2));
  }
</script>

