<?php
global $current_user; 
get_currentuserinfo(); 

global $target_args;
$id = $target_args['id'];

restrict_access('administrator,franchisee,coach');

$coach_invoice = get_post($id);
$franchise = get_user_by('id', $coach_invoice->franchise_id);
$franchise_name = $franchise->display_name;
if(!empty($franchise->first_name) || !empty($franchise->last_name)) {
    $franchise_name = $franchise->first_name . ' ' . $franchise->last_name;
}

$coach = get_user_by('id', $coach_invoice->coach_id);
$coach_name = $coach->display_name;
if(!empty($coach->first_name) || !empty($coach->last_name)) {
    $coach_name = $coach->first_name . ' ' . $coach->last_name;
}
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
                <?php if( is_role( 'administrator') ) : ?>
                    <div class="card-table-row">
                        <span class="card-table-cell fixed250">Franchise</span>
                        <div class="card-table-cell">
                            <?php echo $franchise_name; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="card-table-row">
                    <span class="card-table-cell fixed250">Coach</span>
                    <div class="card-table-cell">
                        <?php echo $coach_name; ?>
                    </div>
                </div>

                <div class="card-table-row">
                    <span class="card-table-cell fixed250">Date Start</span>
                    <div class="card-table-cell">
                        <?php echo $coach_invoice->date_start; ?>
                    </div>
                </div>
                <div class="card-table-row">
                    <span class="card-table-cell fixed250">Date End</span>
                    <div class="card-table-cell">
                        <?php echo $coach_invoice->date_end; ?>
                    </div>
                </div>
            </div>
             </div>

   
</div>
<div class="col-1 break-big">
<div class="card-wrapper">
    <div class="card-inner">
<form method="POST" class="form-horizontal well" role="form">
<fieldset class="fields-group">
<h3>Some Group Of Services</h3>
    <div class="clearfix">
        <div class="col-14">
            Description
        </div>
        <div class="col-14">
            Quantity
        </div>
        <div class="col-14">
            Amount
        </div>
        <div class="col-14">
            Actions
        </div>
    </div>
    <div class="repeater-custom-show-hide card-table">
      <div data-repeater-list="item">
        <div data-repeater-item="">
          <div class="form-group clearfix">
            
            <div class="col-14">
              <select name="item[0][type]" class="form-control">
                <option value="" selected="">Choose description</option>
                <option value="service2">Service 2</option>
                <option value="service3">Service 3</option>
              </select>
            </div>

            
            <div class="col-14">
              <input type="text" name="item[0][quantity]" value="0" class="form-control number js-quantity" placeholder="Quantity">
            </div>
            
            
            <div class="col-14">
              <input type="text" name="item[0][amount]" value="0" class="form-control currency js-add-to-total" placeholder="Amount">
            </div>
            

            <div class="col-14">
              <a class="am2-ajax-modal-delete btn btn--danger is-smaller" data-repeater-delete=""
                                       data-original-title="Delete" data-placement="top" data-toggle="tooltip"
                                       data-object="S" data-id=""><i class="fa fa-trash-o"></i></a>
            </div>
          </div>
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

            <div class="card-table">
                    <div class="card-table-row">
                        <span class="card-table-cell fixed250"><strong>Total</strong> </span>
                        <div class="card-table-cell">
                            <div class="card-form">
                                <fieldset>
                                <input type="text"  id="js-total" data-js="" name="bonus" class="form-control currency js-add-to-grand-total" title="Please add bonus" value="$0.00" disabled />
                                </fieldset>
                            </div>
                        </div>

                    </div>
                    <div class="card-table-row">
                        <span class="card-table-cell fixed250">Bonus </span>
                        <div class="card-table-cell">
                            <div class="card-form">
                            <fieldset>
                                <input type="text" data-js="" name="bonus" class="form-control currency js-add-to-grand-total" title="Please add bonus" value="$0.00" />
                            </fieldset>
                        </div>
                        </div>
                    </div>

                    <div class="card-table-row">
                        <span class="card-table-cell fixed250">Equipment deductions </span>
                        <div class="card-table-cell">
                            <div class="card-form">
                            <fieldset>
                                <input type="text" data-js="" name="equipment_deductions" class="form-control currency js-add-to-grand-total" title="Please add equipment deductions" value="$0.00" />
                            </fieldset>
                        </div>
                        </div>
                    </div>

                    <div class="card-table-row">
                        <span class="card-table-cell fixed250">Insurance </span>
                        <div class="card-table-cell">
                            <div class="card-form">
                            <fieldset>
                                <input type="text" data-js="" name="Insurance" class="form-control currency js-add-to-grand-total" title="Please add bonus" value="$0.00" />
                            </fieldset>
                        </div>
                        </div>
                    </div>

                    <div class="card-table-row">
                        <span class="card-table-cell fixed250"><strong>Grand Total</strong> </span>
                        <div class="card-table-cell">
                            $<strong><span id="js-grand-total">0.00</span></strong>
                        </div>
                        </div>
                    </div>
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

 

  addToTotal();
  initMasks();

});

function initMasks() {
    $('.currency').maskMoney({thousands:',', decimal:'.', allowZero: true, prefix: '$'});
    $('.number').maskMoney({thousands:'', decimal:'', precision: 0, allowZero: true, prefix: ''});
}

function parseCurrency( num ) {
    num = num.replace('$','');
    return parseFloat( num.replace( /,/g, '') );
  }

  function addToTotal() {

    var total = 0;
    $('.js-add-to-total').each(function() {
        var this_val = parseCurrency($(this).val());
        var this_quantity = $(this).closest('.form-group').find('.js-quantity').val(); console.log(this_quantity);
        total = total + (this_val*this_quantity);
        //

    });
    total = parseFloat(total).toFixed(2);
    $('#js-total').val(parseFloat(total).toFixed(2));

    var grand_total = 0;
    $('.js-add-to-grand-total').each(function() {
        var this_val = parseCurrency($(this).val());
        grand_total = grand_total + this_val;
        //

    });
    grand_total = parseFloat(grand_total).toFixed(2);
    $('#js-grand-total').empty().append(parseFloat(grand_total).toFixed(2));
  }
</script>

