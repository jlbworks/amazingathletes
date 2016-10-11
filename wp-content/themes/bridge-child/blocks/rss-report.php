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

if(is_role('franchisee')){
    $args['author']  =  $rss_report->rss_franchise_id;
}

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

if(!empty($locations)):
    foreach($locations as $location):
        $location_array = array();
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

        foreach($classes as $class):
            $class_array = array();
            $class_array['post'] = $class;



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
                $class_array['class_code'] = 'Location Pay Contract';
            } elseif ( $class_array['class_type'] == 'Demo' ) {
                $class_array['class_code'] = 'Demo';
            } elseif ( $class_array['class_type'] == 'Parent-Pay' ) {
                $class_array['class_code'] = 'Monthly Parent Pay';
            } elseif ( $class_array['class_type'] == 'Session' ) {
                $class_array['class_code'] = 'Session Parent Pay';
            } elseif ( $class_array['class_type'] == 'Camp' ) {
                $class_array['class_code'] = 'Camp';
            } elseif ( $class_array['class_type'] == 'Special Event' /* || $class_array['program'] == 'Special Event'*/ ) {
                $class_array['class_code'] = 'Event';
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

            $location_array['classes'][] = $class_array;
        endforeach;

        //Add to Master Array
        $master_array['locations'][] = $location_array;
    endforeach;
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
        <style>
            table td {
                padding: 5px;
                border: #888 1px solid;
            }
        </style>
        <table width="100%">
            <?php foreach($master_array['locations'] as $location): ?>
                <tr style="background: #0070c0; color: #fff">
                    <td>ZIP</td>
                    <td colspan="5"><?php echo get_the_title($location['post']->ID); ?></td>
                    <td colspan="2">Enrollment 39</td>
                    <td colspan="2">Total Gross: $689</td>
                    <td colspan="2">ROY Due: $52</td>
                </tr>
                <tr style="background: #e7e6e6; color: #000">
                    <td>Program Code</td>
                    <td>Program</td>
                    <td>Class Code</td>
                    <td>Class Type</td>
                    <td>Monthly Engagement</td>
                    <td>Standard Tuition</td>
                    <td>Standard # Weeks</td>
                    <td>Weekly Tuition</td>
                    <td>Status Code</td>
                    <td>Class Status</td>
                    <td># Weeks Thought</td>
                    <td>Earned Gross Revenue</td>
                </tr>
                <?php 
                if($location['classes']):
                    foreach($location['classes'] as $class): ?>
                        <tr>
                            <td><?php echo $class['program_code']; ?></td>
                            <td><?php echo $class['program']; ?></td>
                            <td><?php echo $class['class_code']; ?></td>
                            <td><?php echo $class['class_type']; ?></td>
                            <td><?php echo $class['monthly_enrollment']; ?></td>
                            <td class="price"><?php echo '$'. $class['standard_tuition']; ?></td>
                            <td><?php echo $class['standard_no_weeks']; ?></td>
                            <td class="price"><?php echo '$'. $class['weekly_tuition']; ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="price"></td>
                        </tr>
                <?php endforeach; 
                endif;
                ?>
            <?php endforeach; ?>
        </table>

    </div>
</div>
</div>
</div>

<script src="<?php bloginfo('stylesheet_directory'); ?>/js-erp/vendor/jquery.maskMoney/jquery.maskMoney.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  'use strict';

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

  
</script>

