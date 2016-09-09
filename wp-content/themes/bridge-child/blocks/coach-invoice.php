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
    <div class="repeater-custom-show-hide card-table">
       Here we will add invoice dynamic calculation (work in progress)


    </div>
    
        
        <div class="validation-message"><ul></ul></div>

            <div class="card-table">
                    <div class="card-table-row">
                        <span class="card-table-cell fixed250"><strong>Total</strong> </span>
                        <div class="card-table-cell">
                            <div class="card-form">
                                <fieldset>
                                <input type="text" data-js="" name="bonus" class="form-control currency js-add-to-total" title="Please add bonus" value="$2,000.00" disabled />
                                </fieldset>
                            </div>
                        </div>

                    </div>
                    <div class="card-table-row">
                        <span class="card-table-cell fixed250">Bonus </span>
                        <div class="card-table-cell">
                            <div class="card-form">
                            <fieldset>
                                <input type="text" data-js="" name="bonus" class="form-control currency js-add-to-total" title="Please add bonus" value="$0.00" />
                            </fieldset>
                        </div>
                        </div>
                    </div>

                    <div class="card-table-row">
                        <span class="card-table-cell fixed250">Equipment deductions </span>
                        <div class="card-table-cell">
                            <div class="card-form">
                            <fieldset>
                                <input type="text" data-js="" name="equipment_deductions" class="form-control currency js-add-to-total" title="Please add equipment deductions" value="$0.00" />
                            </fieldset>
                        </div>
                        </div>
                    </div>

                    <div class="card-table-row">
                        <span class="card-table-cell fixed250">Bonus </span>
                        <div class="card-table-cell">
                            <div class="card-form">
                            <fieldset>
                                <input type="text" data-js="" name="bonus" class="form-control currency js-add-to-total" title="Please add bonus" value="$0.00" />
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
    },
    hide: function (remove) {
      if(confirm('Are you sure you want to remove this item?')) {
        $(this).slideUp(remove);
      }
    }
  });

  $('.js-add-to-total').on('keyup',function() {
     
  });

  $('.currency').maskMoney({thousands:',', decimal:'.', allowZero: true, prefix: '$'});

  addToTotal();

});

function parseCurrency( num ) {
    num = num.replace('$','');
    return parseFloat( num.replace( /,/g, '') );
  }

  function addToTotal() {
    var grand_total = 0;
      $('.js-add-to-total').each(function() {
        var this_val = parseCurrency($(this).val());
        grand_total = grand_total + this_val;
        //

      });
      grand_total = parseFloat(grand_total).toFixed(2);
     $('#js-grand-total').empty().append(parseFloat(grand_total).toFixed(2));
  }
</script>

