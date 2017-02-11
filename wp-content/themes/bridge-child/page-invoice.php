<?php /* Template Name: Invoice Template */ ?>
<?php 
$invoice_type = $_GET['type']; 
if($invoice_type != 'coach' && $invoice_type !='location') {
    echo 'Invoice type is not valid';
    die; 
}
$invoice_id = $_GET['id'];
$invoice = get_post( $invoice_id );
if($invoice->post_type != 'invoice') {
    echo 'Invoice ID is not valid';
    die; 
}

setlocale(LC_MONETARY, 'en_US');

$back_link = '';
if($invoice_type == 'coach') {
    $back_link = site_url().'/amp/#coach-invoice/?id='.$invoice_id;
}
if($invoice_type == 'location') {
    $back_link = site_url().'/amp/#location-invoice/?id='.$invoice_id;
}
if($invoice_type == 'coach') {
/* Invoice data */
$invoice_data = get_post_meta($invoice_id);
//print_r($invoice_data);
$total = '0.00';
if(!empty($invoice_data['total'][0])) $total = $invoice_data['total'][0];
$other = '0.00';
if(!empty($invoice_data['other'][0])) $other = $invoice_data['other'][0];
$travel_surcharge = '0.00';
if(!empty($invoice_data['travel_surcharge'][0])) $travel_surcharge = $invoice_data['travel_surcharge'][0];
$liability_insurance_rebate = '0.00';
if(!empty($invoice_data['liability_insurance_rebate'][0])) $liability_insurance_rebate = $invoice_data['liability_insurance_rebate'][0];
$equipment_rental_rebate = '0.00';
if(!empty($invoice_data['equipment_rental_rebate'][0])) $equipment_rental_rebate = $invoice_data['equipment_rental_rebate'][0];
$settled_outstanding_student_compensations = '0.00';
if(!empty($invoice_data['settled_outstanding_student_compensations'][0])) $settled_outstanding_student_compensations = $invoice_data['settled_outstanding_student_compensations'][0];
$grand_total = '0.00';
if(!empty($invoice_data['grand_total'][0])) $grand_total = $invoice_data['grand_total'][0];
$items = get_post_meta($invoice_id, 'item', true);

$coach_invoice = get_post($invoice_id);
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
?>
<!doctype html>
<html class="boxed" moznomarginboxes mozdisallowselectionprint>
    <head>
        <!-- Basic -->
        <meta charset="UTF-8">
        <title>
                            <?php echo $back_link; ?> Invoice
                    </title>
                    <meta name="author" content="">
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <!-- Mobile Metas -->
            <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
                

                
                    <link href="https://www.ticketzone.com/print/invoice.css" rel="stylesheet" type="text/css" media="screen">
            <link href="https://www.ticketzone.com/print/invoice_print.css" rel="stylesheet" type="text/css" media="print">
        
        
        <script type="text/javascript" src="https://www.ticketzone.com/assets/vendor/modernizr/modernizr.js"></script>


        


                
        

                    </head>
    <body>

            
<div id="backlink"><a href="<?php echo $back_link; ?>">- Back to Order -</a></div>
<div id="invoice-container" class="unpaid-container">
    <div id="invoice-content">
        <div id="status-ribbon" class="<?php echo ucfirst($invoice_type); ?>"><?php echo ucfirst($invoice_type); ?></div>
        <div>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    </head>
    <body><div id="invoice-table" style="padding: 40px; font-family: Arial;">
        <table style="width: 100%;" border="0" cellspacing="0"><tbody>
            <tr id="invoice-header">
                <td style="padding-left: 10px; text-align: left;" colspan="2" align="left" valign="middle" width="60%">
                    <span style="font-size: 18px; font-weight: bold; color: #484740;" class="receipt__logo">
                        <!-- queue -->
                        <img src="<?php echo get_bloginfo('stylesheet_directory'); ?>/images/invoice_logo.jpg">
                    </span></td>
                <td align="right" valign="middle" width="40%">
                    <table border="0" cellspacing="0" cellpadding="2"><tbody>
                        <tr>
                            <td align="right"><span style="font-size: 12px; font-weight: bold;">Invoice</span></td>
                            <td align="left"><span style="font-size: 12px;"><?php echo $invoice_id; ?></span></td>
                        </tr>
                        <tr>
                            <td align="right"><span style="font-size: 12px; font-weight: bold;">Date</span></td>
                            <td align="left"><span style="font-size: 12px;"><?php echo date('m/d/Y',strtotime($invoice->date_start)); ?> - <?php echo date('m/d/Y',strtotime($invoice->date_end)); ?></span></td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
            <tr id="invoice-details">
                <td style="padding-top: 40px;" valign="top" width="40%">
                    <span style="font-size: 12px; font-weight: bold;">Remit To:</span><br><span style="font-size: 11px;">
                        <?php echo $coach->first_name.' '.$coach->last_name.', '.$coach_data['employment_type'][0]; ?><br>
                        <?php echo $coach_data['street_address'][0]; ?><br>
                        <?php $city__state = explode("|", $coach_data['city__state'][0]); echo $city__state[1].', '.$city__state[0].' '.$coach_data['zip_code'][0]; ?><br>
                        <?php echo $coach_data['contact_number'][0]; ?>
                    </span>
                </td>
                <td style="padding-top: 40px;" valign="top" width="30%">
                    <span style="font-size: 12px; font-weight: bold;">Bill To:</span><br><span style="font-size: 11px;">
                        <?php echo $franchise_name; ?><br>
                        <?php echo $franchise_data['franchise_address'][0]; ?><br>
                        <?php $city__state = explode("|", $franchise_data['city__state'][0]); echo $city__state[1].', '.$city__state[0].' '.$franchise_data['franchise_zip'][0]; ?><br>
                        <?php echo $franchise_data['franchise_telephone'][0]; ?>
                    </span>
                </td>
                <td style="padding-top: 40px;" align="left" valign="top" width="30%">
                    <table border="0" cellspacing="0" cellpadding="2"><tbody>
                        <tr>
                            <td align="right"><span style="font-size: 12px; font-weight: bold;">Status:</span></td>
                            <td align="left"><span style="font-size: 12px; font-weight: bold;">Editing</span></td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
        </tbody></table>
        <table class="invoice-table" style="margin-top: 50px; width: 100%;" border="0" cellspacing="0" cellpadding="6"><tbody>
            <tr>
                <td align="left" valign="middle" bgcolor="#f0f0f0"><span style="font-size: 11px; font-weight: bold;">Description</span></td>
                <td style="width: 7%;" align="center" valign="middle" bgcolor="#f0f0f0"><span style="font-size: 11px; font-weight: bold;">Type</span></td>
                <td style="width: 15%;" align="right" valign="middle" bgcolor="#f0f0f0"><span style="font-size: 11px; font-weight: bold;">Rate</span></td>
                <td style="width: 7%;" align="center" valign="middle" bgcolor="#f0f0f0"><span style="font-size: 11px; font-weight: bold;">Qty</span></td>
                <td style="width: 7%;" align="center" valign="middle" bgcolor="#f0f0f0"><span style="font-size: 11px; font-weight: bold;">Weeks</span></td>
                <td style="width: 15%;" align="right" valign="middle" bgcolor="#f0f0f0"><span style="font-size: 11px; font-weight: bold;">Price</span></td>
            </tr>
            <?php if($items):
            foreach($items as $item): 
                $item['price'] = str_replace("$","",$item['price']); ?>
            <tr>
                <td style="border-bottom: 1px solid #F0F0F0;" valign="middle"><span style="font-size: 11px;"><?php echo $item['description']; ?></span></td>
                <td style="border-bottom: 1px solid #F0F0F0;" align="center" valign="middle"><span style="font-size: 11px;"><?php echo $item['quantity_type']; ?></span></td>
                <td style="border-bottom: 1px solid #F0F0F0;" align="right" valign="middle"><span style="font-size: 11px;"><?php echo "$".number_format($item['price'], 2); ?></span></td>
                <td style="border-bottom: 1px solid #F0F0F0;" align="center" valign="middle"><span style="font-size: 11px;"><?php echo $item['quantity']; ?></span></td>
                <td style="border-bottom: 1px solid #F0F0F0;" align="center" valign="middle"><span style="font-size: 11px;"><?php echo $item['num_of_weeks']; ?></span></td>
                <td style="border-bottom: 1px solid #F0F0F0;" align="right" valign="middle"><span style="font-size: 11px;"><?php echo "$".number_format(($item['price'] * $item['quantity'] * $item['num_of_weeks']), 2); ?></span></td>
            </tr>
            <?php endforeach;
            endif; ?>          
         <tr>

            <td colspan="5" align="right" valign="middle"><span style="font-size: 12px; font-weight: bold;">Subtotal:</span></td>
            <td colspan="5" align="right" valign="middle"><span style="font-size: 12px;"><?php echo "$".number_format($total, 2); ?></span></td>
        </tr>
        <tr>

            <td colspan="5" align="right" valign="middle"><span style="font-size: 12px; font-weight: bold;">Travel Surcharge:</span></td>
            <td colspan="5" align="right" valign="middle"><span style="font-size: 12px;"><?php echo "$".number_format($travel_surcharge, 2); ?></span></td>
        </tr>
        <tr>

            <td colspan="5" align="right" valign="middle"><span style="font-size: 12px; font-weight: bold;">Liability Insurance Rebate:</span></td>
            <td colspan="5" align="right" valign="middle"><span style="font-size: 12px;"><?php echo "$".number_format($liability_insurance_rebate, 2); ?></span></td>
        </tr>
                    <tr>

                <td colspan="5" align="right" valign="middle"><span style="font-size: 12px; font-weight: bold;">Equipment Rental Rebate :</span></td>
                <td colspan="5" align="right" valign="middle"><span style="font-size: 12px;"><?php echo "$".number_format($equipment_rental_rebate, 2); ?></span></td>
            </tr>
                <tr>

            <td colspan="5" align="right" valign="middle"><span style="font-size: 12px; font-weight: bold;">Settled Outstanding Student Compensations:</span></td>
            <td colspan="5" align="right" valign="middle"><span style="font-size: 12px;"><?php echo "$".number_format($settled_outstanding_student_compensations, 2); ?></span></td>
        </tr>
        <tr>

            <td colspan="5" align="right" valign="middle"><span style="font-size: 12px; font-weight: bold;">Other:</span></td>
            <td colspan="5" align="right" valign="middle"><span style="font-size: 12px;"><?php echo "$".number_format($other, 2); ?></span></td>
        </tr>
        <tr>

            <td colspan="5" align="right" valign="middle"><span style="font-size: 14px; font-weight: bold;">Total</span></td>
            <td colspan="5" align="right" valign="middle"><span style="font-size: 14px; font-weight: bold;"><?php echo "$".number_format($grand_total, 2); ?></span></td>
        </tr>
    </tbody></table>
    <table style="margin-top: 50px; width: 100%;" border="0" cellspacing="0" cellpadding="0"><tbody><tr>
        <td style="width: 100%;" align="left" valign="middle"> </td>
    </tr></tbody></table>
                <table style="margin-top: 50px; width: 100%;" border="0" cellspacing="0" cellpadding="0"><tbody><tr>
    <td style="border-top: 1px solid #F0F0F0; padding-top: 10px; width: 100%;" align="center"><span style="font-size: 11px; color: #a4a4a4;">http://amazingathletes.com/<br></span></td>
</tr></tbody></table>
</div></body>
</html>
</div>
</div>
<div class="right" id="payform-container">
    <div id="paymenu">
        <a href="#" onclick="window.print();" class="pelem"><i class="icon-print"></i> Print Invoice</a>
        <?php /*<a href="https://www.ticketzone.com/account/order/printReceipt/166385/1" class="pelem"><i class="icon-download-alt"></i> Download PDF</a>*/ ?>
    </div>
</div>
<div style="clear:both"></div>
</div>

        

                
    </body>
</html>
<?php } 
//END COACH TEMPLATE
?>

<?php
if($invoice_type == 'location') {
/* Invoice data */
$invoice_data = get_post_meta($invoice_id);
$total = '0.00';
if(!empty($invoice_data['total'][0])) $total = $invoice_data['total'][0];
$other = '0.00';
if(!empty($invoice_data['other'][0])) $other = $invoice_data['other'][0];
$grand_total = '0.00';
if(!empty($invoice_data['grand_total'][0])) $grand_total = $invoice_data['grand_total'][0];


$location_invoice = get_post($invoice_id);
$franchise = get_user_by('id', $location_invoice->franchise_id); 
$franchise_name = $franchise->display_name;
if(!empty($franchise->first_name) || !empty($franchise->last_name)) {
    $franchise_name = $franchise->first_name . ' ' . $franchise->last_name;
}
$franchise_data = get_user_meta($location_invoice->franchise_id);

$location = get_post( $location_invoice->location_id);
$location_name = $location->post_title;
$location_data = get_post_meta($location_invoice->location_id);

$items = get_post_meta($invoice_id, 'item', true);

?>
<!doctype html>
<html class="boxed" moznomarginboxes mozdisallowselectionprint>
    <head>
        <!-- Basic -->
        <meta charset="UTF-8">
        <title>
                            <?php echo $back_link; ?> Invoice
                    </title>
                    <meta name="author" content="">
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <!-- Mobile Metas -->
            <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
                

                
                    <link href="https://www.ticketzone.com/print/invoice.css" rel="stylesheet" type="text/css" media="screen">
            <link href="https://www.ticketzone.com/print/invoice_print.css" rel="stylesheet" type="text/css" media="print">
        
        
        <script type="text/javascript" src="https://www.ticketzone.com/assets/vendor/modernizr/modernizr.js"></script>


        


                
        

                    </head>
    <body>

            
<div id="backlink"><a href="<?php echo $back_link; ?>">- Back to Order -</a></div>
<div id="invoice-container" class="unpaid-container">
    <div id="invoice-content">
        <div id="status-ribbon" class="<?php echo ucfirst($invoice_type); ?>"><?php echo ucfirst($invoice_type); ?></div>
        <div>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    </head>
    <body><div id="invoice-table" style="padding: 40px; font-family: Arial;">
        <table style="width: 100%;" border="0" cellspacing="0"><tbody>
            <tr id="invoice-header">
                <td style="padding-left: 10px; text-align: left;" colspan="2" align="left" valign="middle" width="60%">
                    <span style="font-size: 18px; font-weight: bold; color: #484740;" class="receipt__logo">
                        <!-- queue -->
                        <img src="<?php echo get_bloginfo('stylesheet_directory'); ?>/images/invoice_logo.jpg">
                    </span></td>
                <td align="right" valign="middle" width="40%">
                    <table border="0" cellspacing="0" cellpadding="2"><tbody>
                        <tr>
                            <td align="right"><span style="font-size: 12px; font-weight: bold;">Invoice</span></td>
                            <td align="left"><span style="font-size: 12px;"><?php echo $invoice_id; ?></span></td>
                        </tr>
                        <tr>
                            <td align="right"><span style="font-size: 12px; font-weight: bold;">Date</span></td>
                            <td align="left"><span style="font-size: 12px;"><?php echo date('m/d/Y h:i A',strtotime($invoice->post_date)); ?></span></td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
            <tr id="invoice-details">
                <td style="padding-top: 40px;" valign="top" width="40%">
                    <span style="font-size: 12px; font-weight: bold;">From:</span><br><span style="font-size: 11px;">
                        <?php echo $franchise_name; ?><br>
                        <?php echo $franchise_data['franchise_address'][0]; ?><br>
                        <?php $city__state = explode("|", $franchise_data['city__state'][0]); echo $city__state[1].', '.$city__state[0].' '.$franchise_data['franchise_zip'][0]; ?><br>
                        <?php echo $franchise_data['franchise_telephone'][0]; ?>
                    </span>
                </td>
                <td style="padding-top: 40px;" valign="top" width="30%">
                    <span style="font-size: 12px; font-weight: bold;">Bill To:</span><br><span style="font-size: 11px;">
                        <?php echo $location->post_title; ?><br>
                        <?php echo $location_data['faddress'][0]; ?><br>
                        <?php $city__state = explode("|", $location_data['city__state'][0]); echo $city__state[1].', '.$city__state[0].' '.$location_data['zip'][0]; ?><br>
                        <?php echo $location_data['telephone'][0]; ?>
                    </span>
                </td>
                <td style="padding-top: 40px;" align="left" valign="top" width="30%">
                    <table border="0" cellspacing="0" cellpadding="2"><tbody>
                        <tr>
                            <td align="right"><span style="font-size: 12px; font-weight: bold;">Status:</span></td>
                            <td align="left"><span style="font-size: 12px; font-weight: bold;">Editing</span></td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
        </tbody></table>
        <table class="invoice-table" style="margin-top: 50px; width: 100%;" border="0" cellspacing="0" cellpadding="6"><tbody>
            <tr>
                <td align="left" valign="middle" bgcolor="#f0f0f0"><span style="font-size: 11px; font-weight: bold;">Description</span></td>
                <td style="width: 15%;" align="right" valign="middle" bgcolor="#f0f0f0"><span style="font-size: 11px; font-weight: bold;">Unit cost</span></td>
                <td style="width: 7%;" align="center" valign="middle" bgcolor="#f0f0f0"><span style="font-size: 11px; font-weight: bold;">Qty</span></td>
                <td style="width: 15%;" align="right" valign="middle" bgcolor="#f0f0f0"><span style="font-size: 11px; font-weight: bold;">Price</span></td>
            </tr>
            <?php if($items):
            foreach($items as $item): 
                $item['price'] = str_replace("$","",$item['price']); ?>
            
            <tr>
                <td style="border-bottom: 1px solid #F0F0F0;" valign="middle"><span style="font-size: 11px;"><?php echo $item['description']; ?></span></td>
                <td style="border-bottom: 1px solid #F0F0F0;" align="right" valign="middle"><span style="font-size: 11px;"><?php echo "$".number_format((float)$item['price'], 2); ?></span></td>
                <td style="border-bottom: 1px solid #F0F0F0;" align="center" valign="middle"><span style="font-size: 11px;"><?php echo $item['quantity']; ?></span></td>
                <td style="border-bottom: 1px solid #F0F0F0;" align="right" valign="middle"><span style="font-size: 11px;"><?php echo "$".number_format((float)($item['price'] * $item['quantity']), 2); ?></span></td>
            </tr>
            <?php endforeach;
            endif; ?>          
         <tr>

            <td colspan="3" align="right" valign="middle"><span style="font-size: 12px; font-weight: bold;">Subtotal:</span></td>
            <td colspan="3" align="right" valign="middle"><span style="font-size: 12px;"><?php echo "$".number_format((float)$total, 2); ?></span></td>
        </tr>
         <tr>

            <td colspan="3" align="right" valign="middle"><span style="font-size: 12px; font-weight: bold;">Other:</span></td>
            <td colspan="3" align="right" valign="middle"><span style="font-size: 12px;"><?php echo "$".number_format($other, 2); ?></span></td>
        </tr>
        <tr>

            <td colspan="3" align="right" valign="middle"><span style="font-size: 14px; font-weight: bold;">Total</span></td>
            <td colspan="3" align="right" valign="middle"><span style="font-size: 14px; font-weight: bold;"><?php echo "$".number_format($grand_total, 2); ?></span></td>
        </tr>
    </tbody></table>
    <table style="margin-top: 50px; width: 100%;" border="0" cellspacing="0" cellpadding="0"><tbody><tr>
        <td style="width: 100%;" align="left" valign="middle"> </td>
    </tr></tbody></table>
                <table style="margin-top: 50px; width: 100%;" border="0" cellspacing="0" cellpadding="0"><tbody><tr>
    <td style="border-top: 1px solid #F0F0F0; padding-top: 10px; width: 100%;" align="center"><span style="font-size: 11px; color: #a4a4a4;">http://amazingathletes.com/<br></span></td>
</tr></tbody></table>
</div></body>
</html>
</div>
</div>
<div class="right" id="payform-container">
    <div id="paymenu">
        <a href="#" onclick="window.print();" class="pelem"><i class="icon-print"></i> Print Invoice</a>
        <?php /*<a href="https://www.ticketzone.com/account/order/printReceipt/166385/1" class="pelem"><i class="icon-download-alt"></i> Download PDF</a>*/ ?>
    </div>
</div>
<div style="clear:both"></div>
</div>

        

                
    </body>
</html>
<?php } 
//END LOCATION TEMPLATE
?>