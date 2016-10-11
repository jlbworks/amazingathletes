<?php
//setlocale(LC_MONETARY, 'en_US');

global $current_user; 
get_currentuserinfo(); 

global $target_args;
$id = $target_args['id'];

restrict_access('administrator');

$rss_report = get_post($id);

$franchise = get_user_by('id', $rss_report->rss_franchise_id);
$franchise_name = $franchise->franchise_name;
if(!empty($franchise->first_name) || !empty($franchise->last_name)) {
    $franchise_name = $franchise->first_name . ' ' . $franchise->last_name;
}

$month = get_post_meta($rss_report->ID, 'rss_month', true);
$year = get_post_meta($rss_report->ID, 'rss_year', true);

$args = array(
    'post_type' => 'location',
    'post_status' => 'publish',
    'posts_per_page' => -1,
);

$args['author']  =  $rss_report->rss_franchise_id;

$master_array = array();

$locations = get_posts($args);
$location_ids = array_map(function($loc){
    return $loc->ID;
}, $locations);

$roster = get_posts(
    array(
        'post_type' => 'roster',
        'post_status' => 'publish',
        'posts_per_page' => -1,
    )
);

$args = array(
  'post_type'   => 'attendance',
  'post_status' => 'publish',
  'posts_per_page'=> -1,
);
//if( is_role('franchisee') ) {
  $args['author ']  =  $rss_report->rss_franchise_id;
//}
$attendances = get_posts($args);

if(!empty($locations)):
    $total_enrollment = 0;
    foreach($locations as $location):
        $location_array = array('monthly_enrollment'=> 0);
        $location_array['post'] = $location;

        $classes = get_posts(
            array(
                'post_type' => 'location_class',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'meta_query' => array(
                    array( 'key' => 'location_id', 'value' => $location->ID, 'compare' => '='),
                )
            )        
        );        

        $location_array['max_royalty'] = 0;        
        $location_array['earned_gross_revenue'] = 0;        

        foreach($classes as $class):
            $class_array = array();
            $class_array['post'] = $class;

            $attendance_dates = array();            

            $class_array['program'] = get_post_meta($class->ID, 'program', true);
            $class_array['program_code'] = '';
            if($class_array['program'] == 'Amazing Athletes') {
                $class_array['program_code'] = 'AA';
            } elseif ( $class_array['program'] == 'Tots' ) {
                $class_array['program_code'] = 'Tots';
            } elseif ( $class_array['program'] == 'Training Academy' ) {
                $class_array['program_code'] = 'TA';
            } elseif ( $class_array['program'] == 'Amazing Birthdays' ) {
                $class_array['program_code'] = 'AB';
            }

            $class_array['class_type'] = get_post_meta($class->ID, 'type', true);
            $class_array['class_code'] = '';            
            if($class_array['class_type'] == 'Contract') {
                $class_array['class_code'] = 'LPC';
            } elseif ( $class_array['class_type'] == 'Demo' ) {
                $class_array['class_code'] = 'D';
            } elseif ( $class_array['class_type'] == 'Parent-Pay' ) {
                $class_array['class_code'] = 'MPP';
            } elseif ( $class_array['class_type'] == 'Session' ) {
                $class_array['class_code'] = 'SPP';
            } elseif ( $class_array['class_type'] == 'Camp' ) {
                $class_array['class_code'] = 'C';
            } elseif ( $class_array['class_type'] == 'Special Event' /* || $class_array['program'] == 'Special Event'*/ ) {
                $class_array['class_code'] = 'E';
            }

            $monthly_enrollment = 0;
            foreach($roster as $rost){
                if($class->ID == $rost->roster_class_id){
                    $monthly_enrollment++;
                }
            }            

            $class_array['monthly_enrollment'] = $monthly_enrollment;

            $class_array['class_costs'] = get_post_meta($class->ID, 'class_costs', true);
            
            if($class_array['class_costs'] == 'Parent-Pay Monthly'){
                $class_array['standard_tuition'] = get_post_meta($class->ID, 'parent_pay_monthly_monthly_tuition', true);
                $class_array['standard_no_weeks'] = get_post_meta($class->ID, 'parent_pay_monthly_classes_monthly', true);
                $class_array['weekly_tuition'] = round($class_array['standard_tuition'] / $class_array['standard_no_weeks'],2); 
            }
            elseif($class_array['class_costs'] == 'Parent-Pay Session'){    
                $class_array['standard_tuition'] = get_post_meta($class->ID, 'parent_pay_session_session_tuition', true);
                $class_array['standard_no_weeks'] = get_post_meta($class->ID, 'parent_pay_session_weeks_in_session', true);
                $class_array['weekly_tuition'] = round($class_array['standard_tuition'] / $class_array['standard_no_weeks'],2);
            } 
            elseif($class_array['class_costs'] == 'Contracts/Events'){
                //$class_array['standard_tuition'] = get_post_meta($class->ID, 'parent_pay_session_session_tuition', true);
            }

            foreach($attendances as $attendance ){
                $class_dates = get_post_meta($class->ID, 'date', false);
                foreach($class_dates as $class_date){
                    if($attendance->attendance_date == $class_date){
                        $attendance_dates[$class_date] = $class_date;
                    }
                }                
            }

            $class_array['status_code'] = 'Y';
            $class_array['class_status'] = 'Ongoing';

            $class_array['no_weeks_taught'] = count($attendance_dates);

            $earned_gross_revenue = ($class_array['no_weeks_taught'] > 0 ? ( $class_array['no_weeks_taught'] * ($class_array['weekly_tuition'] * $class_array['monthly_enrollment'] ) ) : 0);
            $class_array['earned_gross_revenue'] = $earned_gross_revenue;

            $royalty_estimate = (
                $class_array['status_code']==="B" ? 0 : 
                    ( 
                        ($class_array['status_code']=="N"||$class_array['status_code']=="RS"||$class_array['class_code']=="SPP"||$class_array['class_code']=="C"||$class_array['class_code']=="E")
                            ? ($class_array['weekly_tuition']>10 
                                ?$class_array['weekly_tuition']*$class_array['no_weeks_taught']
                                :10*$class_array['no_weeks_taught']
                                )
                            : (
                                ($class_array['class_code']=="MPP"||$class_array['class_code']=="LPC")
                                    ?($class_array['weekly_tuition']>10
                                        ?$class_array['weekly_tuition']*$class_array['standard_no_weeks']
                                        :10*$class_array['standard_no_weeks']
                                    )
                                    :($class_array['class_code']=="D"
                                        ?0
                                        :0
                                    )
                                )
                            )
                        );
            $class_array['royalty_estimate'] = $royalty_estimate;

            $location_array['classes'][] = $class_array;

            $location_array['earned_gross_revenue'] += $earned_gross_revenue;
            $location_array['max_royalty'] = $location_array['max_royalty'] > $royalty_estimate ? $location_array['max_royalty'] : $royalty_estimate;            
            $location_array['monthly_enrollment'] += $monthly_enrollment;
            //var_dump($location_array['monthly_enrollment'], $monthly_enrollment);
        endforeach;

        $total_enrollment += $location_array['monthly_enrollment'];

        //Add to Master Array
        $master_array['locations'][] = $location_array;
        $master_array['total_enrollment'] = $total_enrollment;
        $master_array['rss_total'] += $location_array['max_royalty'];
        $master_array['earned_gross_revenue'] += $location_array['earned_gross_revenue'];        
    endforeach;
    $master_array['total_due_royalties'] = ($master_array['rss_total']>600 ? $master_array['rss_total'] : 600);
endif;


?>
<!-- CONTENT HEADER -->
<div class="layout context--pageheader">
    <div class="container clearfix">
        <div class="col-12 break-big">
            <h1>RSS Report #<?php echo $rss_report->ID; ?></h1>
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
                    <span class="card-table-cell fixed250">Month</span>
                    <div class="card-table-cell">
                        <?php echo $month; ?>
                    </div>
                </div>

                <div class="card-table-row">
                    <span class="card-table-cell fixed250">Year</span>
                    <div class="card-table-cell">
                        <?php echo $year; ?>
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
        <input type="button" onclick="tableToExcel('rssTable', '<?php echo $month.'-'.$year; ?>')" value="Export to Excel">
        <style>
            table td {
                padding: 5px;
                border: #888 1px solid;
            }
        </style>
        <table width="100%" id="rssTable">
            <?php foreach($master_array['locations'] as $location): ?>

                <tr style="">
                    <td style="background: #0070c0; color: #fff; padding: 5px; border: #000 1px solid;">ZIP</td>
                    <td style="background: #0070c0; color: #fff; padding: 5px; border: #000 1px solid;" colspan="5"><?php echo get_the_title($location['post']->ID); ?></td>
                    <td style="background: #0070c0; color: #fff; padding: 5px; border: #000 1px solid;" colspan="2">Enrollment <?php echo $location_array['monthly_enrollment'];?></td>
                    <td style="background: #0070c0; color: #fff; padding: 5px; border: #000 1px solid;" colspan="2">Total Gross: <?php echo $location_array['earned_gross_revenue'];?></td>
                    <td style="background: #0070c0; color: #fff; padding: 5px; border: #000 1px solid;" colspan="3">ROY Due: <?php echo $location_array['max_royalty'];?></td>
                </tr>
                <tr style="">
                    <td style="background: #e7e6e6; color: #000; padding: 5px; border: #000 1px solid;">Program Code</td>
                    <td style="background: #e7e6e6; color: #000; padding: 5px; border: #000 1px solid;">Program</td>
                    <td style="background: #e7e6e6; color: #000; padding: 5px; border: #000 1px solid;">Class Code</td>
                    <td style="background: #e7e6e6; color: #000; padding: 5px; border: #000 1px solid;">Class Type</td>
                    <td style="background: #e7e6e6; color: #000; padding: 5px; border: #000 1px solid;">Monthly Engagement</td>
                    <td style="background: #e7e6e6; color: #000; padding: 5px; border: #000 1px solid;">Standard Tuition</td>
                    <td style="background: #e7e6e6; color: #000; padding: 5px; border: #000 1px solid;">Standard # Weeks</td>
                    <td style="background: #e7e6e6; color: #000; padding: 5px; border: #000 1px solid;">Weekly Tuition</td>
                    <td style="background: #e7e6e6; color: #000; padding: 5px; border: #000 1px solid;">Status Code</td>
                    <td style="background: #e7e6e6; color: #000; padding: 5px; border: #000 1px solid;">Class Status</td>
                    <td style="background: #e7e6e6; color: #000; padding: 5px; border: #000 1px solid;"># Weeks Thought</td>
                    <td style="background: #e7e6e6; color: #000; padding: 5px; border: #000 1px solid;">Earned Gross Revenue</td>
                    <td style="background: #e7e6e6; color: #000; padding: 5px; border: #000 1px solid;">Royalty Estimate</td>
                </tr>
                <?php 
                if($location['classes']):
                    foreach($location['classes'] as $class): ?>
                        <tr>
                            <td style="padding: 5px; border: #000 1px solid;"><?php echo $class['program_code']; ?></td>
                            <td style="padding: 5px; border: #000 1px solid;"><?php echo $class['program']; ?></td>
                            <td style="padding: 5px; border: #000 1px solid;"><?php echo $class['class_code']; ?></td>
                            <td style="padding: 5px; border: #000 1px solid;"><?php echo $class['class_type']; ?></td>
                            <td style="padding: 5px; border: #000 1px solid;"><?php echo $class['monthly_enrollment']; ?></td>
                            <td style="padding: 5px; border: #000 1px solid;" class="price"><?php echo '$'. $class['standard_tuition']; ?></td>
                            <td style="padding: 5px; border: #000 1px solid;"><?php echo $class['standard_no_weeks']; ?></td>
                            <td style="padding: 5px; border: #000 1px solid;" class="price"><?php echo '$'. $class['weekly_tuition']; ?></td>
                            <td style="padding: 5px; border: #000 1px solid;"><?php echo $class['status_code'];?></td>
                            <td style="padding: 5px; border: #000 1px solid;"><?php echo $class['class_status'];?></td>
                            <td style="padding: 5px; border: #000 1px solid;"><?php echo $class['no_weeks_taught'];?></td>
                            <td style="padding: 5px; border: #000 1px solid;" class="price"><?php echo $class['earned_gross_revenue'];?></td>
                            <td style="padding: 5px; border: #000 1px solid;" class="price"><?php echo $class['royalty_estimate'];?></td>
                        </tr>
                <?php endforeach; 
                endif;
                ?>
            <?php endforeach; ?>
        </table>

        <?php //var_dump($master_array);?>

        <table width="100%">
            <tr style="background: #e7e6e6; color: #000">
                <th colspan="7">Franchise Totals</th>
            </tr>            
            <tr style="background: #e7e6e6; color: #000">
                <th>Active Locations</th>
                <th>Total Enrollment</th>
                <th>Average Enrollment</th>
                <th>RSS Total</th>
                <th>Royalties as a %</th>
                <th>Gross Revenue</th>
                <th>Total Due Royalties</th>                
            </tr>
            <tr>
                <th><?php echo count($locations);?></th>
                <th><?php echo $master_array['total_enrollment'] ;?></th>
                <th><?php echo round($master_array['total_enrollment'] / count($master_array['locations']),2) ;?></th>
                <th><?php echo $master_array['rss_total'];?></th>
                <th><?php echo (100 * ($master_array['total_due_royalties'] / $master_array['earned_gross_revenue'])).'%';?></th>
                <th><?php echo $master_array['earned_gross_revenue'];?></th>
                <th><?php echo $master_array['total_due_royalties'];?></th>
            <tr>
        </table>

    </div>
</div>
</div>
</div>

<script src="<?php bloginfo('stylesheet_directory'); ?>/js-erp/vendor/jquery.maskMoney/jquery.maskMoney.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  'use strict';

  //addToTotal();
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



var tableToExcel = (function() {
  var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
  return function(table, name) {
    if (!table.nodeType) table = document.getElementById(table)
    var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
    window.location.href = uri + base64(format(template, ctx))
  }
})();



  
</script>

