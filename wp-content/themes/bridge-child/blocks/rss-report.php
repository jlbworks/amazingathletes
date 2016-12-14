<?php
//setlocale(LC_MONETARY, 'en_US');

global $current_user; 
get_currentuserinfo(); 

global $target_args;
$id = $target_args['id'];

restrict_access('super_admin,administrator,franchisee,coach');

$hash_query = str_replace('?','',$_REQUEST['target_args']);
parse_str($hash_query,$hash_query);

$rss_report = get_post($id);
$rss_classes = $rss_report->classes;

$author = get_user_by('id', $rss_report->rss_franchise_id); 

if(am2_has_role($author, 'franchisee')){
    $author_franchise = $author;
    $author_role = 'franchisee';
}
else if(am2_has_role($author, 'coach')){
    $author_franchise = get_user_by('id', $author->franchisee);
    $author_role = 'coach';
}

if(am2_has_role($current_user, 'administrator')){
    /* */
    $current_user_role = 'administrator';
}
else if(am2_has_role($current_user, 'franchisee')){
    $franchise_user = $current_user;
    $current_user_role = 'franchisee';
}
else if(am2_has_role($current_user, 'coach')){
    $franchise_user = get_user_by('id', $current_user->franchisee);
    $current_user_role = 'coach';
}

if($current_user_role != 'administrator' && $franchise_user->ID != $author_franchise->ID){
    exit('Not Allowed.');
}

$franchise_name = $author_franchise->franchise_name;
if(!empty($author_franchise->first_name) || !empty($author_franchise->last_name)) {
    $franchise_name = $author_franchise->first_name . ' ' . $author_franchise->last_name;
}

$month = get_post_meta($rss_report->ID, 'rss_month', true);
$year = get_post_meta($rss_report->ID, 'rss_year', true);

$args = array(
    'post_type' => 'location',
    'post_status' => 'publish',
    'posts_per_page' => -1,
);

$args['author']  = $author_franchise->ID; //$rss_report->rss_franchise_id;

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
  $args['author ']  =  $author_franchise->ID; //$rss_report->rss_franchise_id;
//}
$attendances = get_posts($args);

$status_codes = array('New Location' => 'N', 'Location Re-Start' => 'RS', 'Ongoing Classes' => 'Y', 'Break' => 'B');
$status_options = '';
foreach($status_codes as $key => $opt){    
    $status_options .= "<option value=\"{$opt}\">{$key}</option>\n";    
}  

$territories = get_field('territories', 'user_' . $author_franchise->ID);

if(!empty($locations)):
    $total_enrollment = 0;
    foreach($locations as $location):
        if(isset($hash_query['f_territory_id']) && $location->unit_number != $hash_query['f_territory_id']){
            continue;
        }
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
            if($current_user_role == 'coach' && !in_array($current_user->ID, $class->coaches)){                                
                //continue;
            }

            $class_array = array();
            $class_array['post'] = $class;

            $rss_status_code = null;
            $rss_no_weeks_taught = null;            
            
            if(is_array($rss_classes)){
                foreach($rss_classes as $k_rss_class => $rss_class){
                    if($k_rss_class == $class->ID) {                                               
                        $rss_status_code = isset($rss_class['status_code']) && !empty($rss_class['status_code'])? $rss_class['status_code'] : $rss_class['status_code'];
                        $rss_no_weeks_taught = isset($rss_class['no_weeks_taught']) && !empty($rss_class['no_weeks_taught'])? $rss_class['no_weeks_taught'] : $rss_class['no_weeks_taught'];                                                
                    }
                }
            }            

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
                $no_weeks = get_post_meta($class->ID, 'parent_pay_monthly_classes_monthly', true);
                $standard_tuition = str_replace('$','',$class_array['standard_tuition']);
                $class_array['standard_tuition'] = get_post_meta($class->ID, 'parent_pay_monthly_monthly_tuition', true);
                $class_array['standard_tuition'] = !empty($standard_tuition) ? $standard_tuition : 0 ;
                $class_array['standard_no_weeks'] = !empty($no_weeks) ? $no_weeks : 0; 
                $class_array['weekly_tuition'] = !empty($no_weeks) ? round($class_array['standard_tuition'] / $class_array['standard_no_weeks'],2) : 0 ; 
            }
            elseif($class_array['class_costs'] == 'Parent-Pay Session'){    
                $no_weeks = get_post_meta($class->ID, 'parent_pay_session_weeks_in_session', true);
                $standard_tuition = str_replace('$','',$class_array['standard_tuition']);
                $class_array['standard_tuition'] = get_post_meta($class->ID, 'parent_pay_session_session_tuition', true);
                $class_array['standard_tuition'] = !empty($standard_tuition) ? $standard_tuition : 0 ;
                $class_array['standard_no_weeks'] = !empty($no_weeks) ? $no_weeks : 0;
                $class_array['weekly_tuition'] = !empty($no_weeks) ? round($class_array['standard_tuition'] / $class_array['standard_no_weeks'],2) : 0 ; 
            } 
            elseif($class_array['class_costs'] == 'Contracts/Events'){
                $contracts_events_type = get_post_meta($class->ID, 'contracts_events_type', true);
                $class_array['standard_no_weeks'] = 4; //auto set to 4

                if($contracts_events_type == 'Paid Per Class'){
                    $amount = get_post_meta($class->ID, 'amount_earned_per_class', true);
                    $per_month = get_post_meta($class->ID, 'classes_per_month', true);
                    $class_array['standard_tuition'] = ($amount * $per_month) / $monthly_enrollment;
                }
                else if($contracts_events_type == 'Paid Per Student'){
                    $amount = get_post_meta($class->ID, 'amount_earned_per_student', true);
                    $per_month = get_post_meta($class->ID, 'classes_per_month', true);
                    $class_array['standard_tuition'] = ($amount * $per_month);
                }
                else if($contracts_events_type == 'Paid Per Hour'){
                    $amount = get_post_meta($class->ID, 'amount_earned_per_hour', true);
                    $hours_per_month = get_post_meta($class->ID, 'hours_per_month', true);
                    //$per_month = get_post_meta($class->ID, 'classes_per_month', true);
                    $class_array['standard_tuition'] = ($amount * $hours_per_month);
                }
                else if($contracts_events_type == 'Paid Per Day'){
                    $amount = get_post_meta($class->ID, 'amount_earned_per_day', true);
                    $days_per_month = get_post_meta($class->ID, 'days_per_month', true);
                    //$per_month = get_post_meta($class->ID, 'classes_per_month', true);
                    $class_array['standard_tuition'] = ($amount * $days_per_month);
                }
                                                
                $class_array['weekly_tuition'] = round($class_array['standard_tuition'] / $class_array['standard_no_weeks'],2);
            }
            else {                
                $class_array['standard_tuition'] = 0;
                $class_array['standard_no_weeks'] = 0;
                $class_array['weekly_tuition'] = 0;
            }

            //var_dump($class_array['standard_no_weeks']);

            $attendances = get_posts(array(
                'post_type' => 'attendance',
                'post_status' => 'any',
                'posts_per_page' => -1,
                'meta_query' => array(
                    array(
                        'key' => 'attendance_class_id',
                        'value' => $class->ID,
                        'compare' => '=',
                    ),
                )
            ));                                    

            $weeks = array();
            foreach($attendances as $attendance){   
                $attendance_date = $attendance->attendance_date;
                $formatted = vsprintf('%3$04d-%1$02d-%2$02d', sscanf($attendance_date,'%02d/%02d/%04d'));                     
                $weeks[ am2GetWeekInMonth($formatted, "sunday") -1 ] = am2GetWeekInMonth($formatted, "sunday") -1;
            }

            $class_array['status_code'] = $rss_status_code ? $rss_status_code : 'Y';
            $class_array['class_status'] = 'Ongoing';

            $class_array['no_weeks_taught'] = $rss_no_weeks_taught != null ? $rss_no_weeks_taught : count($weeks);

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
            $royalty_estimate = $class_array['monthly_enrollment'] > 0 && $class_array['no_weeks_taught'] > 0 ? $royalty_estimate : 0;
            $class_array['royalty_estimate'] =  $royalty_estimate;

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

<!-- Filter -->
<div class="layout context--filter">
    <div class="container clearfix">
        <div class="col-12 break-big" id="filter">
            Filter by:
            <?php if(is_role('administrator') || is_role('franchisee')){?>
                <select id="f_territory_id" name="f_territory_id" >
                    <option value="">Choose Territory</option>
                    <?php foreach($territories as $territory){  ?>
                    <option value="<?php echo $territory['unit_number'];?>" <?php if( in_array($territory['unit_number'], array($hash_query['f_territory_id'] ) ) ) echo "selected";?>>Territory <?php echo $territory['territory_name'];?></option>
                    <?php } ?>
                </select>
            <?php } ?> 
        </div>
    </div>
</div>

<!-- PRODUCT INFORMATION -->
<div class="layout">
    <div class="container clearfix">
        <div class="col-1 break-big">

        <div class="card-wrapper " style="overflow:hidden;">

            <div class="card-inner">

                <table style="width:100%; background:#fff;">
                    <tr>
                        <td colspan=2 rowspan=3 height="67" align="left" valign=bottom><font face="Century Gothic" color="#000000"><br><img src="<?php echo get_stylesheet_directory_uri();?>/img/logo.jpg" width="auto" hspace=48 vspace=4 style="margin:0px">
                        </font></td>
                        <td align="left" valign=bottom><font face="Century Gothic" color="#000000"><br></font></td>
                        <td style="border-right: 1px solid #000000" colspan=4 align="center" valign=bottom><b><font face="Century Gothic" color="#FF0000">Royalty Summary Sheet</font></b></td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=3 align="center" valign=middle sdnum="1033;0;_(&quot;$&quot;* #,##0.00_);_(&quot;$&quot;* (#,##0.00);_(&quot;$&quot;* &quot;-&quot;??_);_(@_)"><font face="Century Gothic" color="#000000"> RSS for Month: </font></td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 rowspan=3 align="center" valign=middle sdval="42615" sdnum="1033;1033;[$-409]MMM-YY;@"><font face="Century Gothic" size=7><?php echo ucfirst($month);?>-<?php echo $year;?></font></td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=3 align="center" valign=middle sdnum="1033;0;_(&quot;$&quot;* #,##0.00_);_(&quot;$&quot;* (#,##0.00);_(&quot;$&quot;* &quot;-&quot;??_);_(@_)"><font face="Century Gothic" color="#000000"> Franchise<br>Number: </font></td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 rowspan=3 align="center" valign=middle sdval="105" sdnum="1033;"><font face="Century Gothic" size=7><?php echo $author_franchise->ID;?></font></td>
                    </tr>
                    <tr>
                        <td align="right" valign=bottom><font face="Century Gothic" color="#000000">Name:</font></td>
                        <td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000" colspan=4 align="center" valign=bottom><font face="Century Gothic" color="#000000"><?php echo $author_franchise->franchise_name;?></font></td>
                        </tr>
                    <tr>
                        <td align="right" valign=bottom><font face="Century Gothic" color="#000000">Date:</font></td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" colspan=4 align="center" valign=bottom sdval="42615" sdnum="1033;1033;M/D/YYYY"><font face="Century Gothic" color="#000000"><?php echo date('m/d/Y');?></font></td>
                    </tr>
                </table>
            </div>
        </div>

<div class="card-wrapper tbl_header" style="overflow:hidden;">

    <?php /*<div class="card-inner col-45 no_margin">        
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
    </div> */?>

<div class="col-1 break-big">
<div class="card-wrapper">
<div class="card-header">
    </div>
    <div class="card-inner">
        <input type="button" onclick="tableToExcel('rssTable', '<?php echo $month.'-'.$year; ?>')" value="Export to Excel">
        <input type="button" onclick="printTable()" value="Print">
        <style>
            table td {
                padding: 5px;
                border: #888 1px solid;
            }
        </style>
        <table width="100%" id="rssTable">
            <?php foreach($master_array['locations'] as $location): ?>

            <?php //var_dump($location);?>

                <tr style="">
                    <td style="background-color: #0070c0 !important; color: #fff; padding: 5px; border: #000 1px solid;">ZIP: <?php echo $location['post']->zip;?></td>
                    <td style="background: #0070c0 !important; color: #fff; padding: 5px; border: #000 1px solid;" colspan="5"><?php echo get_the_title($location['post']->ID); ?></td>
                    <td style="background: #0070c0 !important; color: #fff; padding: 5px; border: #000 1px solid;" colspan="2">Enrollment <?php echo $location_array['monthly_enrollment'];?></td>
                    <td style="background: #0070c0 !important; color: #fff; padding: 5px; border: #000 1px solid;" colspan="2">Total Gross: <?php echo $location_array['earned_gross_revenue'];?></td>
                    <td style="background: #0070c0 !important; color: #fff; padding: 5px; border: #000 1px solid;" colspan="3">ROY Due: <?php echo $location_array['max_royalty'];?></td>
                </tr>
                <tr style="">
                    <?php /*<td style="background: #e7e6e6; color: #000; padding: 5px; border: #000 1px solid;">Program Code</td>*/ ?>
                    <td style="background: #e7e6e6; color: #000; padding: 5px; border: #000 1px solid;">Program</td>
                    <?php /*<td style="background: #e7e6e6; color: #000; padding: 5px; border: #000 1px solid;">Class Code</td>*/?>
                    <td style="background: #e7e6e6; color: #000; padding: 5px; border: #000 1px solid;">Class Type</td>
                    <td style="background: #e7e6e6; color: #000; padding: 5px; border: #000 1px solid;">Monthly Enrollment</td>
                    <td style="background: #e7e6e6; color: #000; padding: 5px; border: #000 1px solid;">Standard Tuition</td>
                    <td style="background: #e7e6e6; color: #000; padding: 5px; border: #000 1px solid;">Standard # Weeks</td>
                    <td style="background: #e7e6e6; color: #000; padding: 5px; border: #000 1px solid;">Weekly Tuition</td>
                    <td style="background: #e7e6e6; color: #000; padding: 5px; border: #000 1px solid;">Status Code</td>
                    <td style="background: #e7e6e6; color: #000; padding: 5px; border: #000 1px solid;">Class Status</td>
                    <td style="background: #e7e6e6; color: #000; padding: 5px; border: #000 1px solid;"># Weeks Taught</td>
                    <td style="background: #e7e6e6; color: #000; padding: 5px; border: #000 1px solid;">Earned Gross Revenue</td>
                    <td style="background: #e7e6e6; color: #000; padding: 5px; border: #000 1px solid;">Royalty Estimate</td>
                </tr>
                <?php 
                if($location['classes']):
                    foreach($location['classes'] as $class): ?>
                        <tr data-class-id="<?php echo $class['post']->ID ;?>">
                            <?php /*<td style="padding: 5px; border: #000 1px solid;"><?php echo $class['program_code']; ?></td>*/?>
                            <td style="padding: 5px; border: #000 1px solid;"><?php echo $class['program']; ?></td>
                            <?php /*<td style="padding: 5px; border: #000 1px solid;"><?php echo $class['class_code']; ?></td>*/ ?>
                            <td style="padding: 5px; border: #000 1px solid;"><?php echo $class['class_type']; ?></td>
                            <td style="padding: 5px; border: #000 1px solid;"><?php echo $class['monthly_enrollment']; ?></td>
                            <td style="padding: 5px; border: #000 1px solid;" class="price"><?php echo '$'. $class['standard_tuition']; ?></td>
                            <td style="padding: 5px; border: #000 1px solid;"><?php echo $class['standard_no_weeks']; ?></td>
                            <td style="padding: 5px; border: #000 1px solid;" class="price"><?php echo '$'. $class['weekly_tuition']; ?></td>
                            <td class="status_code" style="padding: 5px; border: #000 1px solid;"><span><?php echo $class['status_code'];?></span><select class="hidden"><?php echo $status_options; ?></select></td>
                            <td style="padding: 5px; border: #000 1px solid;"><?php echo $class['class_status'];?></td>
                            <td class="no_weeks_taught" style="padding: 5px; border: #000 1px solid;"><span><?php echo $class['no_weeks_taught'];?></span><input type="text" class="hidden" /></td>
                            <td style="padding: 5px; border: #000 1px solid;" class="price"><?php echo '$'. $class['earned_gross_revenue'];?></td>
                            <td style="padding: 5px; border: #000 1px solid;" class="price"><?php echo '$'. $class['royalty_estimate'];?></td>
                        </tr>
                <?php endforeach; 
                endif;
                ?>
            <?php endforeach; ?>
        </table>

        <?php //var_dump($master_array);?>

        <table width="100%" border="1px">
            <tr style="background: #000; color: #fff">
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
                <th><?php echo count($master_array['locations']);?></th>
                <th style="background-color:#FFCCCC;"><?php echo $master_array['total_enrollment'] ;?></th>
                <th><?php echo round($master_array['total_enrollment'] / count($master_array['locations']),2) ;?></th>
                <th style="background-color:#FFCCCC;"><?php echo '$'. $master_array['rss_total'];?></th>
                <th><?php echo number_format(100 * ($master_array['total_due_royalties'] / $master_array['earned_gross_revenue'] ),2).'%';?></th>
                <th><?php echo '$'. $master_array['earned_gross_revenue'];?></th>
                <th style="background-color:#FFCCCC;"><?php echo '$'. $master_array['total_due_royalties'];?></th>
            <tr>
        </table>

    </div>
</div>
</div>
</div>

<?php //var_dump($master_array);?>

<script src="<?php bloginfo('stylesheet_directory'); ?>/js-erp/vendor/jquery.maskMoney/jquery.maskMoney.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  'use strict';

  //addToTotal();
  initMasks();

  $('#rssTable td').on('click', function(){
      console.log('td click');

      if(!$(this).hasClass('edit')){
          $(this).addClass('edit');
          console.log('edit');
          $(this).children('input,select').eq(0).val($(this).children('span').text()).focus().select();
      }      
      else {          
      }
  });  

  /*$('#rssTable td.edit :input').on('blur', function(){

  });*/

  $('#rssTable td :input').on('blur', function(){
    //$(this).closest('td').trigger('click');
    var $tr = $(this).closest('tr');
    var $td = $(this).closest('td');
    var new_val = $(this).val();

    //alert(new_val);
    
    $td.children('span').text(new_val);

    var class_id = $tr.data('class-id');
    var status_code = $tr.find('.status_code span').text();
    var no_weeks_taught = $tr.find('.no_weeks_taught span').text();

    $.post('<?php echo site_url();?>/wp-admin/admin-ajax.php?action=submit_data', {action: 'submit_data', form_handler:'rss_inline_edit', rss_id: <?php echo $id;?>, class_id : class_id, no_weeks_taught: no_weeks_taught, status_code: status_code  }, function(resp){
        console.log(resp);
        $td.removeClass('edit');
    });
  });

  $('#f_territory_id').select2({
        placeholder: 'Select a territory',
        width: '100%',
        minimumResultsForSearch: -1
    })
    .on('select2:select', function() {
        
    });

    $('#filter select').on('select2:select', function(){
        if( true || $('#f_class_id').val()){
            var filters = new Array;

            var sep = '&'; // '?';            
            if(window.location.hash.indexOf('&')>-1){                
                var query = window.location.hash.split('&')[0];
            }
            else {
                var query = window.location.hash;
            }
            
            $('#filter select').each(function(){
                if($(this).val()){
                    //query += sep + $(this).attr('name') + '=' + $(this).val();
                    query += sep + $(this).attr('name') + '=' + $(this).val();
                    sep = '&';
                }            
            });
            window.location.hash =  query;
        }        
    });

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

var printTable = function(){
    window.print();  
}



  
</script>

