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

    $franchisee_id = $class['post_author'];
    $_franchisee = get_user_by('id', $franchisee_id);
    $_franchisee_meta = get_user_meta($franchisee_id);
    
    foreach($_franchisee_meta as $kf => $fm){
        $franchisee_meta[$kf] = $fm[0];
    }    

    $franchise = array_merge((array)$_franchisee, (array)$_franchisee_meta);    
?>
<?php if(isset($_GET['iframe'])) wp_head(); else get_header();?>
<?php while(have_posts()) { the_post();?>
<style type="text/css">
    header,footer {display:none;}
</style>
<?php the_content();?>
<?php } ?>
<script>
    var franchisee = <?php echo json_encode($franchise);?>;
    var location_class = <?php echo json_encode($class);?>;
    var paid_tuition = <?php echo $paid_tuition; ?>;

    var class_costs = {
        "Standard Registration Form" : "parent_pay_monthly",
        "Session Registration Form" : "parent_pay_session",
        "3rd Party Registrations" : "contracts_events"
    };

    var payment_type = class_costs[location_class.registration_option];    
    var registration_fee = !paid_tuition ? parseInt(location_class[payment_type + '_registration_fee']) : 0;
    var monthly_tuition = 0;
    var session_tuition = 0;
    
    try {
        monthly_tuition = parseInt(location_class[payment_type + '_monthly_tuition']);                
        session_tuition = parseInt(location_class[payment_type + '_session_tuition']);
    }   
    catch(exc){
        console.log(exc, monthly_tuition, session_tuition); 
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

    (function($){
        $(document).ready(function(){
            //console.log(tuition, franchise_name, individual_1_first_name, individual_1_last_name, contact_number, contact_email, one_time_payment_url, recurring_credit_card_payments_url);
            console.log($('.full_section_inner').html());
            var html = $('.full_section_inner').html();
            html = html.replace(/{(.*?)}/g, function(a,b) {                
                console.log(a,b);
                return tokens[b.replace('data.','')];
            });
            $('.full_section_inner').html(html);
        });
    })(jQuery);
</script>
<?php if(isset($_GET['iframe'])) wp_footer(); else get_footer();?>