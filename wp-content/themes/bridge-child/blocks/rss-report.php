<?php
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

$locations = get_posts($args);
$location_ids = array_map(function($loc){
    return $loc->ID;
}, $locations);

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
            <?php foreach($locations as $location): ?>
            <tr style="background: #0070c0; color: #fff">
                <td>ZIP</td>
                <td colspan="5"><?php echo get_the_title($location->ID); ?></td>
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
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>s</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
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

