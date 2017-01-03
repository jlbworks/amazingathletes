<?php /*Template name: Post registration */?>
<?php if(!isset($_GET['class_id'])) exit('No class selected');?>
<?php
    $class_id = (int)$_GET['class_id'];   
    //$paid_tuition = $_GET['paid_tuition']; 
    $_class = get_post($class_id);
    $_class_meta = get_post_meta($class_id);
    $class = array_merge((array)$_class_meta, (array)$_class);        

    foreach($class as $kc => $c){
        if(!is_array($c)) continue;
        $class[$kc] = $c[0];
    }
    
    $payment_options = json_encode(unserialize($class['payment_options']));    

    $location_id = $class['location_id'];
    $location = get_post($location_id);
    $franchisee_id = $location->post_author;

    $_franchisee = get_user_by('id', $franchisee_id);
    $_franchisee_meta = get_user_meta($franchisee_id);    
    
    foreach($_franchisee_meta as $kf => $fm){
        $_franchisee_meta[$kf] = $fm[0];        
    }   

    $wpautop_fields = array('payment_intro_msg', 'personal_check_payment_msg', 'one_time_credit_card_payment_msg', 'recurring_payment_msg');        

    $franchise =  (array)$_franchisee_meta;    

    foreach($wpautop_fields as $wpautop_field){
        if(isset($franchise->{$wpautop_field})) {
            $franchise->{$wpautop_field} = wpautop($franchise->{$wpautop_field});
        }        
        if(isset($class->{$wpautop_field})) {
            $class->{$wpautop_field} = wpautop($class->{$wpautop_field});
        }             
    } 
    // $franchise = array_merge((array)$_franchisee, (array)$_franchisee_meta);    
?>
<?php if(isset($_GET['iframe'])) wp_head(); else get_header();?>

<?php while(have_posts()) { the_post();?>
<style type="text/css">
    body {
        min-height:500px;        
    }
    p {
        padding:10px;
    }
    .payment-header p {
        color: #fff !important;
        padding:5px;
    }
    header,footer {display:none;}
    .accordion_content {display:none;}

    .ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active, a.ui-button:active, .ui-button:active, .ui-button.ui-state-active:hover {
        background-color:#DD3333;
        color:white !important;
    }

    .ui-accordion h5.ui-accordion-header {
        border:0px none !important; 
    }

    .ui-accordion h5.ui-accordion-header:hover{
        background-color: #DD3333 !important;
    }
    .ui-accordion h5.ui-accordion-header:hover span {
        color:white !important;
    }

    .fa-lg {
        padding-top: 25px;
    }

    .vc_col-sm-3 {
        width: 15%;
    }

</style>
<div class="paid_tuition_wrap">
    <label><input type="checkbox" name="paid_tuition" id="paid_tuition" value="Yes"/>&nbsp; I have already paid the registration fee.</label>
    <br/>
</div>
<?php the_content();?>
<div style="display:none;">
    <div class="payment_intro_text">
        {data.franchise_name} currently offers the following payment options to pay for {data.program_name}. Please select one of the following and follow the instructions to complete your payment and finalize your registration.
        <br/>
        &nbsp;
        If you have any questions regarding the payment options below please contact {data.contact_name} at {data.contact_number} or {data.contact_email}.
    </div>
    <div class="payment_personal_check_text">
        Thank you for enrolling your child in Amazing Athletes! Complete your enrollment by leaving a personal check for {data.amount_due} made out to {data.franchise_name} at your child’s class location. Please be sure to put your child’s first and last name in the notes section. If you have any questions regarding this payment, please don’t hesitate to contact at {data.contact_number} or {data.contact_email}.
    </div>
    <div class="payment_one_time_cc_text">
        Thank you for enrolling your child in Amazing Athletes! By selecting One-Time Credit Card Payment, you agree to be charged immediately for your selected program {data.tuition} and the annual registration fee {data.registration_fee}. Complete your enrollment by clicking “Make a One-Time Payment” below. If you have any questions regarding this payment, please don’t hesitate to contact at {data.contact_number} or {data.contact_email}.
        <br/>
        {data.payment_link_onetime}
    </div>
    <div class="payment_recurring_text">
        Thank you for enrolling your child in Amazing Athletes! By selecting auto-pay you agree to be charged immediately for your selected program {data.tuition} and the annual registration fee {data.registration_fee}. You will then be charged again for just the monthly tuition {data.tuition} on the 1st of every month until a 2-week written notice is received to cancel the auto-pay. Complete your enrollment by clicking “Enrolling in Auto-Pay” below. If you have any questions regarding this payment, please don’t hesitate to contact at {data.contact_number} or {data.contact_email}.
        <br/>
        {data.payment_link_auto}
    </div>
</div>
<?php } ?>
<script>          
    (function($){
        $(document).ready(function(){
            var franchisee = <?php echo json_encode($franchise);?>;
            var location_class = <?php echo json_encode($class);?>;
            var paid_tuition = $('#paid_tuition').is(':checked'); // <?php echo json_encode($paid_tuition == true); ?>;

            /*var class_costs = {
                "Parent-Pay Monthly" : "parent_pay_monthly",
                "Parent-Pay Session" : "parent_pay_session",
                "Contracts/Events" : "contracts_events"
            };*/

            var class_costs = am2_registration.possible_class_costs;

            var registration_fee = 0;
            var monthly_tuition = 0;
            var session_tuition = 0;                        
            var contract_tuition = 0;

            var payment_type = class_costs[location_class.class_costs]; 

            if($.inArray(payment_type, ['parent_pay_monthly', 'parent_pay_session']) > -1){
                 registration_fee = !paid_tuition ? location_class[payment_type + '_registration_fee'] ? parseFloat(location_class[payment_type + '_registration_fee']) : 0 : 0;
            }
            else {
                registration_fee = 0;
            }            

            try {
                monthly_tuition = parseFloat(location_class[payment_type + '_monthly_tuition']);                
                session_tuition = parseFloat(location_class[payment_type + '_session_tuition']);

                if(payment_type == 'contracts_events'){
                    var contracts_events_type = location_class['contracts_events_type'];
                    var price, num_units;

                    switch(contracts_events_type){
                        case 'Paid Per Class':
                            price = location_class['amount_earned_per_class'];
                            num_units = location_class['classes_per_month'];
                        break;
                        case 'Paid Per Student':
                            price = location_class['amount_earned_per_student'];
                            num_units = 1;
                        break;
                        case 'Paid Per Hour':
                            price = location_class['amount_earned_per_hour'];
                            num_units = location_class['hours_per_month'];
                        break;
                        case 'Paid Per Day':
                            price = location_class['amount_earned_per_day'];
                            num_units = location_class['days_per_month'];
                        break;
                    }
                    contract_tuition = parseFloat(price) * parseFloat(num_units); 
                } 
                
            }   
            catch(exc){
                //console.log(exc, monthly_tuition, session_tuition); 
            }    

            var tuition = monthly_tuition ? monthly_tuition : session_tuition ? session_tuition : contract_tuition ? contract_tuition : 0;                               

            var tokens = {                   
                franchise_name : franchisee.franchise_name,
                program_name : location_class.program,
                tuition : '$' +  ((monthly_tuition) ? monthly_tuition : ((session_tuition) ? session_tuition : 0)),
                registration_fee : '<span class="registration_fee">$' + registration_fee + '</span>',
                amount_due : '$' + (registration_fee + tuition),
                individual_1_first_name : franchisee.individual_1_first_name,            
                individual_1_last_name : franchisee.individual_1_last_name,
                contact_name : franchisee.individual_1_first_name + ' ' + franchisee.individual_1_last_name,
                contact_number : franchisee.telephone,
                contact_email : '<a href="'+franchisee.aa_email_address+'">'+franchisee.aa_email_address+'</a>',
                payment_link_onetime : '<a href="'+location_class.one_time_credit_card_payment_url+'">New Student One-Time Payment</a>',
                payment_link_auto : '<a href="'+location_class.recurring_credit_card_payments_url+'">New Student Auto-Pay</a>',                

                payment_intro: $.trim(location_class.payment_intro_msg) != '' ? location_class.payment_intro_msg : $.trim(franchisee.payment_intro_msg) != '' ? franchisee.payment_intro_msg : $('.payment_intro_text').html(),
                payment_personal_check: $.trim(location_class.personal_check_payment_msg) != '' ? location_class.personal_check_payment_msg : $.trim(franchisee.personal_check_payment_msg) != '' ?  franchisee.personal_check_payment_msg : $('.payment_personal_check_text').html(),
                payment_one_time_cc: $.trim(location_class.one_time_credit_card_payment_msg) != '' ? location_class.one_time_credit_card_payment_msg : $.trim(franchisee.one_time_credit_card_payment_msg) != '' ? franchisee.one_time_credit_card_payment_msg : $('.payment_one_time_cc_text').html(),
                payment_recurring: $.trim(location_class.recurring_payment_msg) != '' ? location_class.recurring_payment_msg : $.trim(franchisee.recurring_payment_msg) != '' ? franchisee.recurring_payment_msg : $('.payment_recurring_text').html() 
            } ;     

            var payment_options_table = {
                "Personal Check Or Cash Payments" : "PERSONAL CHECK PAYMENTS",
                "One Time Credit Card Payment" : "ONE TIME CREDIT CARD PAYMENT",
                "Recurring Credit Card Payments" : "RECURRING CREDIT CARD PAYMENTS"
            }    

            var payment_options = <?php echo $payment_options;?>;      

            $('h5').hide();
            //$('.accordion_content').hide();            
            $.each(payment_options, function(i,v){                
                $('.tab-title:contains('+payment_options_table[v]+')').closest('h5').show();
            });

            replace_tokens(tokens);

            $('#paid_tuition').on('change', function(){
                console.log('#paid_tuition change');

                var paid_tuition = $('#paid_tuition').is(':checked'); 
                if($.inArray(payment_type, ['parent_pay_monthly', 'parent_pay_session']) > -1){
                    registration_fee = !paid_tuition ? location_class[payment_type + '_registration_fee'] ? parseFloat(location_class[payment_type + '_registration_fee']) : 0 : 0;
                }
                else {
                    registration_fee = 0;
                }  
                tokens.registration_fee = '$' + registration_fee;
                
                $('.registration_fee').text(tokens.registration_fee);

            });
        });

        function replace_tokens(tokens){
            $('.payment-subheader').append($('.paid_tuition_wrap').eq(0));

            var html = $('.full_section_inner').html();
            html = html.replace(/{(.*?)}/g, function(a,b) {         
                console.log(a,b);                       
                return tokens[b.replace('data.','')];
            });
            $('.full_section_inner').html(html);

            //console.log(tuition, franchise_name, individual_1_first_name, individual_1_last_name, contact_number, contact_email, one_time_payment_url, recurring_credit_card_payments_url);            
            var html = $('.full_section_inner').html();
            html = html.replace(/{(.*?)}/g, function(a,b) {                                
                return tokens[b.replace('data.','')];
            });
            $('.full_section_inner').html(html);
        }
    })(jQuery);
</script>
<?php if(isset($_GET['iframe'])) wp_footer(); else get_footer();?>