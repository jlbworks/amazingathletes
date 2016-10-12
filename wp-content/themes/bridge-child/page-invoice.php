<?php /* Template Name: Invoice Template */ ?>
<?php 
$invoice_type = $_GET['type']; 
if($invoice_type != 'coach') {
    echo 'Invoice type is not valid';
    die; 
}
$invoice_id = $_GET['id'];
$invoice = get_post( $invoice_id );
if($invoice->post_type != 'invoice') {
    echo 'Invoice ID is not valid';
    die; 
}

$back_link = '';
if($invoice_type == 'coach') {
    $back_link = site_url().'/erp/#coach-invoice/?id='.$invoice_id;
}
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
                    <span style="font-size: 12px; font-weight: bold;">To:</span><br><span style="font-size: 11px;">Tina Ebersberger<br>231 East 18th Street <br> <br> North Vancouver, British Columbia V7L 2X7<br> Canada </span>
                </td>
                <td style="padding-top: 40px;" valign="top" width="30%">
                    <span style="font-size: 12px; font-weight: bold;">From:</span><br><span style="font-size: 11px;">TicketZone<br></span>
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
                <td style="width: 7%;" align="center" valign="middle" bgcolor="#f0f0f0"><span style="font-size: 11px; font-weight: bold;">Taxed</span></td>
                <td style="width: 15%;" align="right" valign="middle" bgcolor="#f0f0f0"><span style="font-size: 11px; font-weight: bold;">Unit cost</span></td>
                <td style="width: 7%;" align="center" valign="middle" bgcolor="#f0f0f0"><span style="font-size: 11px; font-weight: bold;">Qty</span></td>
                <td style="width: 15%;" align="right" valign="middle" bgcolor="#f0f0f0"><span style="font-size: 11px; font-weight: bold;">Price</span></td>
            </tr>
                            <tr>
                    <td style="border-bottom: 1px solid #F0F0F0;" valign="middle"><span style="font-size: 11px;">ENCHANT Dec 17th: Christmas Light Maze &amp; Market &mdash; Adult (16+): Day Pass</span></td>
                    <td style="border-bottom: 1px solid #F0F0F0;" align="center" valign="middle"><span style="font-size: 11px;">$1.00</span></td>
                    <td style="border-bottom: 1px solid #F0F0F0;" align="right" valign="middle"><span style="font-size: 11px;">$19.95</span></td>
                    <td style="border-bottom: 1px solid #F0F0F0;" align="center" valign="middle"><span style="font-size: 11px;">1</span></td>
                    <td style="border-bottom: 1px solid #F0F0F0;" align="right" valign="middle"><span style="font-size: 11px;">$22.95</span></td>
                </tr>
                            <tr>
                    <td style="border-bottom: 1px solid #F0F0F0;" valign="middle"><span style="font-size: 11px;">ENCHANT Dec 17th: Christmas Light Maze &amp; Market &mdash; Adult (16+): Day Pass</span></td>
                    <td style="border-bottom: 1px solid #F0F0F0;" align="center" valign="middle"><span style="font-size: 11px;">$1.00</span></td>
                    <td style="border-bottom: 1px solid #F0F0F0;" align="right" valign="middle"><span style="font-size: 11px;">$19.95</span></td>
                    <td style="border-bottom: 1px solid #F0F0F0;" align="center" valign="middle"><span style="font-size: 11px;">1</span></td>
                    <td style="border-bottom: 1px solid #F0F0F0;" align="right" valign="middle"><span style="font-size: 11px;">$22.95</span></td>
                </tr>
                            <tr>
                    <td style="border-bottom: 1px solid #F0F0F0;" valign="middle"><span style="font-size: 11px;">ENCHANT Dec 17th: Christmas Light Maze &amp; Market &mdash; Children (6-15): Day Pass</span></td>
                    <td style="border-bottom: 1px solid #F0F0F0;" align="center" valign="middle"><span style="font-size: 11px;">$0.75</span></td>
                    <td style="border-bottom: 1px solid #F0F0F0;" align="right" valign="middle"><span style="font-size: 11px;">$14.95</span></td>
                    <td style="border-bottom: 1px solid #F0F0F0;" align="center" valign="middle"><span style="font-size: 11px;">1</span></td>
                    <td style="border-bottom: 1px solid #F0F0F0;" align="right" valign="middle"><span style="font-size: 11px;">$17.70</span></td>
                </tr>
                        <tr>
            <td> </td>
            <td colspan="2" align="right" valign="middle"><span style="font-size: 12px; font-weight: bold;">Subtotal:</span></td>
            <td colspan="2" align="right" valign="middle"><span style="font-size: 12px;">$54.85</span></td>
        </tr>
        <tr>
            <td> </td>
            <td colspan="2" align="right" valign="middle"><span style="font-size: 12px; font-weight: bold;">Discount:</span></td>
            <td colspan="2" align="right" valign="middle"><span style="font-size: 12px;">$0.00</span></td>
        </tr>
        <tr>
            <td> </td>
            <td colspan="2" align="right" valign="middle"><span style="font-size: 12px; font-weight: bold;">Service fee:</span></td>
            <td colspan="2" align="right" valign="middle"><span style="font-size: 12px;">$2.40</span></td>
        </tr>
                    <tr>
                <td> </td>
                <td colspan="2" align="right" valign="middle"><span style="font-size: 12px; font-weight: bold;">Facility Fee:</span></td>
                <td colspan="2" align="right" valign="middle"><span style="font-size: 12px;">$3.60</span></td>
            </tr>
                <tr>
            <td> </td>
            <td colspan="2" align="right" valign="middle"><span style="font-size: 12px; font-weight: bold;">Delivery:</span></td>
            <td colspan="2" align="right" valign="middle"><span style="font-size: 12px;">$0.00</span></td>
        </tr>
        <tr>
            <td> </td>
            <td colspan="2" align="right" valign="middle"><span style="font-size: 12px; font-weight: bold;">Tax:</span></td>
            <td colspan="2" align="right" valign="middle"><span style="font-size: 12px;">$2.74</span></td>
        </tr>
        <tr>
            <td> </td>
            <td colspan="2" align="right" valign="middle"><span style="font-size: 14px; font-weight: bold;">total</span></td>
            <td colspan="2" align="right" valign="middle"><span style="font-size: 14px; font-weight: bold;">$63.59</span></td>
        </tr>
    </tbody></table>
    <table style="margin-top: 50px; width: 100%;" border="0" cellspacing="0" cellpadding="0"><tbody><tr>
        <td style="width: 100%;" align="left" valign="middle"> </td>
    </tr></tbody></table>
                <table style="margin-top: 50px; width: 100%;" border="0" cellspacing="0" cellpadding="0"><tbody><tr>
    <td style="border-top: 1px solid #F0F0F0; padding-top: 10px; width: 100%;" align="center"><span style="font-size: 11px; color: #a4a4a4;">ticketzone.com<br></span></td>
</tr></tbody></table>
</div></body>
</html>
</div>
</div>
<div class="right" id="payform-container">
    <div id="paymenu">
        <a href="#" onclick="window.print();" class="pelem"><i class="icon-print"></i> Print Invoice</a>
        <a href="https://www.ticketzone.com/account/order/printReceipt/166385/1" class="pelem"><i class="icon-download-alt"></i> Download PDF</a>
    </div>
</div>
<div style="clear:both"></div>
</div>


                
        

        <script type="text/javascript">
            am2.ajax_fetch_countries_url    = 'https://www.ticketzone.com/ajax/country';
            am2.ajax_store_country          = 'https://www.ticketzone.com/api/v1/country';

            am2.ajax_state_query            = 'https://www.ticketzone.com/backend/api/state';
            am2.ajax_state_store            = 'https://www.ticketzone.com/backend/api/state';
            am2.ajax_googlePlaces           = 'https://www.ticketzone.com/backend/api/state/googlePlaces';

            am2.ajax_city_query             = 'https://www.ticketzone.com/backend/api/city';
            am2.ajax_city_store             = 'https://www.ticketzone.com/backend/api/city';



        </script>
                

        

                
    </body>
</html>
