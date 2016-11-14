<?php /*Template name: Post registration */?>
<?php if(!isset($_GET['class_id'])) exit('No class selected');?>
<?php
    $class_id = (int)$_GET['class_id'];   
    $paid_tuition = $_GET['paid_tuition']; 
    $_class = get_post($class_id);
    $_class_meta = get_post_meta($class_id);
    $class = array_merge((array)$_class_meta, (array)$_class);        

    foreach($class as $kc => $c){
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

    $franchise = array_merge((array)$_franchisee, (array)$_franchisee_meta);    
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
<?php the_content();?>
<?php } ?>
<script>          
    (function($){
        $(document).ready(function(){
            var franchisee = <?php echo json_encode($franchise);?>;
            var location_class = <?php echo json_encode($class);?>;
            var paid_tuition = <?php echo $paid_tuition; ?>;

            /*var class_costs = {
                "Parent-Pay Monthly" : "parent_pay_monthly",
                "Parent-Pay Session" : "parent_pay_session",
                "Contracts/Events" : "contracts_events"
            };*/

            var class_costs = am2_registration.possible_class_costs;

            var payment_type = class_costs[location_class.class_costs];    
            var registration_fee = !paid_tuition ? parseInt(location_class[payment_type + '_registration_fee']) : 0;
            var monthly_tuition = 0;
            var session_tuition = 0;

            try {
                monthly_tuition = parseInt(location_class[payment_type + '_monthly_tuition']);                
                session_tuition = parseInt(location_class[payment_type + '_session_tuition']);
            }   
            catch(exc){
                //console.log(exc, monthly_tuition, session_tuition); 
            }    

            var tuition = ((monthly_tuition) ? monthly_tuition : ((session_tuition) ? session_tuition : 0));                               

            var tokens = {                   
                franchise_name : franchisee.franchise_name,
                program_name : location_class.program,
                tuition : '$' +  ((monthly_tuition) ? monthly_tuition : ((session_tuition) ? session_tuition : 0)),
                registration_fee : '$' + registration_fee,
                amount_due : '$' + (registration_fee + tuition),
                individual_1_first_name : franchisee.individual_1_first_name,            
                individual_1_last_name : franchisee.individual_1_last_name,
                contact_name : franchisee.individual_1_first_name + ' ' + franchisee.individual_1_last_name,
                contact_number : franchisee.telephone,
                contact_email : '<a href="'+franchisee.aa_email_address+'">'+franchisee.aa_email_address+'</a>',
                payment_link_onetime : '<a href="'+location_class.one_time_credit_card_payment_url+'">New Student One-Time Payment</a>',
                payment_link_auto : '<a href="'+location_class.recurring_credit_card_payments_url+'">New Student Auto-Pay</a>',
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

            //console.log(tuition, franchise_name, individual_1_first_name, individual_1_last_name, contact_number, contact_email, one_time_payment_url, recurring_credit_card_payments_url);            
            var html = $('.full_section_inner').html();
            html = html.replace(/{(.*?)}/g, function(a,b) {                                
                return tokens[b.replace('data.','')];
            });
            $('.full_section_inner').html(html);
        });
    })(jQuery);
</script>
<?php if(isset($_GET['iframe'])) wp_footer(); else get_footer();?>