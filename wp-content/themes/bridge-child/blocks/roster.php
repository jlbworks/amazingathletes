<?php 
global $current_user, $possible_class_costs; 
get_currentuserinfo();

restrict_access('administrator,franchisee,coach');

$hash_query = str_replace('?','',$_REQUEST['target_args']);
parse_str($hash_query,$hash_query);

$meta_query = array();

$args = array(
  'post_type'   => 'roster',
  'post_status' => 'publish',
  'posts_per_page'=> -1,
);

if( am2_is_top_role('franchisee') ) {
  $curr_franchise = $args['author ']  =  get_current_user_id();

  $meta_query[] =
        array('key'=> 'roster_franchise_id', 'value'=> $current_user->ID, 'compare'=>'=');
}
else if( am2_is_single_role('coach') ){
    $curr_franchise = $current_user->franchisee;
    
    $meta_query[] =
        array('key'=> 'roster_coach_id', 'value'=> $current_user->ID, 'compare'=>'=');    
}

if( !isset($curr_franchise) && isset($hash_query['f_franchise_id']) ){
    $curr_franchise = $hash_query['f_franchise_id'];

    $meta_query[] = 
        array('key' => 'roster_franchise_id', 'value' => $hash_query['f_franchise_id'], 'compare' => '=');
}

if(isset($curr_franchise)){
    $territories = get_field('territories', 'user_' .$curr_franchise);
}

if( isset($hash_query['f_location_id']) ){
    $meta_query[] = 
        array('key' => 'roster_location_id', 'value' => $hash_query['f_location_id'], 'compare' => '=');
    $location = get_post($hash_query['f_location_id']);

    $class_franchise_id = $location->post_author; 
}

if( isset($hash_query['f_class_id']) ){
    $meta_query[] = 
        array('key' => 'roster_class_id', 'value' => $hash_query['f_class_id'], 'compare' => '=');

    $class_id = (int)$hash_query['f_class_id'];
    $sel_class = get_post($class_id); 

    /*$possible_class_costs = array(
        "Parent-Pay Monthly" => "parent_pay_monthly",
        "Parent-Pay Session" =>  "parent_pay_session",
        "Contracts/Events" => "contracts_events",
    );*/

    $parent_pay = $possible_class_costs[$sel_class->class_costs];
    
    if($parent_pay == 'parent_pay_monthly'){
        $tuition = $sel_class->{$parent_pay.'_monthly_tuition'};
    }    
    else if($parent_pay == 'parent_pay_session'){
        $tuition = $sel_class->{$parent_pay.'_session_tuition'};
    }

    $registration_fee = $sel_class->{$parent_pay .'_registration_fee'};

    $class_location_id = $sel_class->location_id; 
    $location = get_post($class_location_id);

    $class_franchise_id = $location->post_author;    
}

$month = !empty($hash_query['f_month']) ? $hash_query['f_month'] : date('m');
$year = !empty($hash_query['f_year']) ? $hash_query['f_year'] : date('Y');

if( isset($hash_query['f_coach_id']) ){
    $meta_query[] = 
        array('key' => 'roster_coach_id', 'value' =>  $hash_query['f_coach_id'] , 'compare' => '=');
}

$args['meta_query'] = $meta_query;

$_rosters = get_posts($args);

$args = array(
    'role' => 'franchisee'         
);

if( am2_is_top_role('franchisee') ){
    $args['include'] = get_current_user_id();
}
/*else if(isset($hash_query['f_franchise_id'])){
    $args['include'] = $hash_query['f_franchise_id'];    
}*/

$franchises = get_users($args);

usort($franchises, function($a, $b) {   
    return $a->franchise_name < $b->franchise_name ? -1 : 1;
});

$args = array(
    'post_type' => 'location',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'orderby' => 'title',
    'order' => 'ASC',
);

if(is_role('administrator') || is_role('super_admin')){
    if(isset($hash_query['f_franchise_id'])){
        $args['author'] = $hash_query['f_franchise_id'];    
    }
}
else if(is_role('franchisee')){
    $args['author'] = get_current_user_id();        
} 

if(isset($hash_query['f_territory_id'])){
    $args['meta_query'][] = array(
        array(
            'key' => 'unit_number',
            'value' => $hash_query['f_territory_id'],
            'compare' => '=',
        )
    );
} 

$locations = get_posts($args);

if(false && isset($hash_query['f_location_id'])){
    $location_ids = array($hash_query['f_location_id']);
}
else {
    $location_ids = array_map(function($loc){
        return (int)$loc->ID;
    }, $locations);
}

$classes_args = array(
    'post_type' => 'location_class',
    'post_status' => 'publish',
    'posts_per_page' => -1,    
    'orderby' => 'title',
    'order' => 'ASC',
);

if(isset($hash_query['f_location_id'])){
    $classes_args['meta_query'] =  array(
        array( 'key' => 'location_id', 'value' => $hash_query['f_location_id'], 'compare' => '='),
    );
}
else {
    $classes_args['meta_query'] =  array(
        array( 'key' => 'location_id', 'value' => $location_ids, 'compare' => 'IN'),
    );
}

$classes = get_posts($classes_args);
$class_ids = array_map(function($class){
    return $class->ID;
}, $classes);

$coach_ids = array();

foreach($classes as $kclass => $class){
    $location = get_post($class->location_id);
    $class->franchise_id = $location->post_author;
    $classes[$kclass] = $class;
}

if(isset($hash_query['f_class_id'])){
    if(is_array($sel_class->coaches)){                
        foreach($sel_class->coaches as $coach){            
            $location = get_post($sel_class->location_id);                
            $sel_class->franchise_id = $location->post_author;

            //$coach_ids[] = (int)$coach;
        }        
    }
}
else {
    foreach($classes as $kclass => $class){
        $location = get_post($class->location_id);
        $class->franchise_id = $location->post_author;
        $classes[$kclass] = $class;

        /*if(is_array($class->coaches)){                
            foreach($class->coaches as $coach){                               
                $coach_ids[] = (int)$coach;
            }
        }*/
    }
}

$_coaches = array_map(function($_roster){
    return $_roster->roster_coach_id;
}, $_rosters);

//$coach_ids[] = (int) $class_franchise_id;
$coach_ids = array_filter(array_unique (array_merge((array)$coach_ids,(array)$_coaches) ) );   

$coaches = get_users(
    array(
        'role' => 'coach',        
    )                
);

usort($coaches, function($a, $b) {
    if($a->first_name == $b->first_name)
        return $a->last_name < $b->last_name ? -1 : 1;
    return $a->first_name < $b->first_name ? -1 : 1;
});

if(am2_is_single_role('coach')){
    $sel_coach_id = get_current_user_id();

    $classes = get_posts(
        array(
            'post_type' => 'location_class',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'meta_query' => array(
                array('key' => 'coaches', 'value' => '"' . $sel_coach_id . '"', 'compare' => 'LIKE' ),
            )
        )
    );

    $class_ids = array_map(function($class){
        return $class->ID;
    }, $classes);
}
else if( isset($hash_query['f_coach_id']) ){
    $sel_coach_id = $hash_query['f_coach_id'];
}    

$roster = array();
foreach($_rosters as $krost => $rost){
    $class_id = $rost->roster_class_id;
    $franchise_id = $rost->roster_franchise_id;
    $franchise = get_post($franchise_id);
    $_coaches = get_post($class_id)->coaches ;    
    $_coaches = array_filter(array_merge(array($franchise_id), (array)$_coaches) );

    if(is_array($_coaches)){
        if( am2_is_single_role('coach') || isset($hash_query['f_coach_id']) ){
            if(in_array($sel_coach_id, $_coaches)) 
                $roster[] = $rost;                                        
        }    
        else {
            $roster[] = $rost;
        }
    }    
    else {
        $roster[] = $rost;
    }
}

$coach_ids = array_unique($coach_ids);
$location_ids = array_unique($location_ids);

$customer_statuses = array('' => '', 'E' => 'E', 'N' => 'N', 'FT' => 'FT');
$status_options = '';
foreach($customer_statuses as $key => $opt){    
    $status_options .= "<option value=\"{$opt}\">{$key}</option>\n";    
}  

$customer_media = array('' => '', 'Y' => 'Y', 'N' => 'N');
$customer_media_options = '';
foreach($customer_media as $key => $opt){    
    $customer_media_options .= "<option value=\"{$opt}\">{$key}</option>\n";    
}  

$_discount = array('' => '', 'SIB' => 'SIB');
$discount_options = '';
foreach($_discount as $key => $opt){    
    $discount_options .= "<option value=\"{$opt}\">{$key}</option>\n";    
}  

$_payment_options = array('' => '', 'Ck/$' => 'Ck/$');
$payment_options = '';
foreach($_payment_options as $key => $opt){    
    $payment_options .= "<option value=\"{$opt}\">{$key}</option>\n";    
}  
?>

    <!-- CONTENT HEADER -->
    <div class="layout context--pageheader">
        <div class="container clearfix">
            <div class="col-12 break-big">
                <h1>Roster</h1>
                <button class="btn btn--primary am2-ajax-modal modal-with-move-anim" data-modal="<?php echo get_ajax_url('modal','roster-edit') .'&id='; ?>"><i class="fa fa-plus"></i>&nbsp; Add New Roster Entry</button>
            </div>
        </div>
    </div>

    <!-- PRODUCT INFORMATION -->
    <div class="layout">
        <div class="container clearfix">
            <div class="col-1 break-big" id="filter">
                Filter by: 
                <?php if(is_role('administrator') || is_role('super_admin')) { ?>
                <select id="f_franchise_id" name="f_franchise_id" >
                    <option value="">Choose Franchise</option>
                    <?php foreach($franchises as $franchise){  ?>
                    <option value="<?php echo $franchise->ID;?>" <?php if(in_array($franchise->ID, array($hash_query['f_franchise_id'], $class_franchise_id ) ) ) echo "selected";?>><?php echo $franchise->franchise_name;?> <?php //echo $franchise->ID;?></option>
                    <?php } ?>
                </select>                
                <?php } ?> 
                <?php if(is_role('administrator') || is_role('franchisee')){?>
                <select id="f_territory_id" name="f_territory_id" >
                    <option value="">Choose Territory</option>
                    <?php foreach($territories as $territory){  ?>
                    <option value="<?php echo $territory['unit_number'];?>" <?php if( in_array($territory['unit_number'], array($hash_query['f_territory_id'] ) ) ) echo "selected";?>><?php echo $territory['territory_name'];?></option>
                    <?php } ?>
                </select>
                <select id="f_location_id" name="f_location_id" >
                    <option value="">Choose Location</option>
                    <?php foreach($locations as $location){ if(!in_array($location->ID, $location_ids)) continue; ?>
                    <option value="<?php echo $location->ID;?>" <?php if( in_array($location->ID, array($hash_query['f_location_id'], $class_location_id) ) ) echo "selected";?>><?php echo $location->post_title;?> <?php //echo $location->ID;?></option>
                    <?php } ?>
                </select>                                
                <select id="f_class_id" name="f_class_id" >
                    <option value="">Choose Class</option>
                    <?php foreach($classes as $class){ if(!in_array($class->ID, $class_ids)) continue;?>
                    <option  value="<?php echo $class->ID;?>" data-location-id="<?php echo $class->location_id ?>" data-franchise-id="<?php echo $class->franchise_id ?>" <?php if($hash_query['f_class_id'] == $class->ID) echo "selected";?>><?php echo $class->post_title;?> <?php //echo $class->ID;?></option>
                    <?php } ?>
                </select>
                <?php //var_dump($coach_ids);?>
                <select id="f_coach_id" name="f_coach_id" >
                    <option value="">Choose Coach</option>                    
                    <?php foreach($coaches as $coach){  if(!in_array($coach->ID, $coach_ids)) continue;
                    $coach_name = $coach->display_name;                    
                    if(isset($coach->first_name) && !empty($coach->first_name) || isset($coach->last_name) && !empty($coach->last_name)) {
                        $coach_name = $coach->first_name . ' ' . $coach->last_name;
                    }
                    ?>
                    <option value="<?php echo $coach->ID;?>" <?php if($hash_query['f_coach_id'] == $coach->ID) echo "selected";?>><?php echo $coach_name;?> <?php //echo $coach->ID;?></option>
                    <?php } ?>
                </select>
                
                <select id="f_year" name="f_year" >
                    <?php 
                    $starting_year = (int) date('Y');
                    $ending_year = (int) date('Y', strtotime('-10 year'));                   

                    for($starting_year; $starting_year >= $ending_year; $starting_year--) {
                        if($starting_year == $year) {
                            echo '<option value="'.$starting_year.'" selected="selected">'.$starting_year.'</option>';
                        } else {
                            echo '<option value="'.$starting_year.'">'.$starting_year.'</option>';
                        }
                    }?> 
                </select>     

                <select id="f_month" name="f_month" >
                    <?php 
                    $starting_month = 1;
                    $ending_month = 12;                   

                    for($starting_month; $starting_month <= $ending_month; $starting_month++) {
                        $dt = DateTime::createFromFormat('!m', $starting_month);                        
                        if($starting_month == $month) {
                            echo '<option value="'.$starting_month.'" selected="selected">'. $dt->format('F').'</option>';
                        } else {
                            echo '<option value="'.$starting_month.'">'.$dt->format('F').'</option>';
                        }
                    }?> 
                </select>                    
                <?php }                
                ?>     

                <?php
                /*else if(is_role('coach')){?>                
                <select id="f_class_id" name="f_class_id" >
                    <option value="">Choose Class</option>
                    <?php foreach($classes as $class){ if(!in_array($class->ID, $class_ids)) continue;?>
                    <option value="<?php echo $class->ID;?>" <?php if($hash_query['f_class_id'] == $class->ID) echo "selected";?>><?php echo $class->post_title;?></option>
                    <?php } ?>
                </select>
                <?php } */?>

                <a href="#roster" class="btn btn-primary">Reset</a>
            </div>
            <br/>
            <br/>
            <div class="col-1 break-big">
                <!-- TABLE (LIST OF USERS) -->
                <?php if( isset($hash_query['f_class_id']) || is_role('coach') ){?>
                <table class="table js-responsive-table" id="datatable-editable">
                  <thead>
                    <tr>
                        <th data-colid="0"></th>
                        <th data-colid="1">#</th>                                                
                        <th data-colid="2"><span>Status</span></th>
                        <th data-colid="3"><span>Media</span></th>
                        <th data-colid="4"><span>Student Name</span></th>
                        <th data-colid="5"><span>G</span></th>
                        <th data-colid="6"><span>Reg Fee</span></th>
                        <th data-colid="7"><span>Pd?</span></th>
                        <th data-colid="8"><span>Discount</span></th>
                        <th data-colid="9"><span>Amt. Due</span></th>
                        <th data-colid="10"><span>Pay Type</span></th>
                        <th data-colid="11"><span>Amt. Pd</span></th>
                        <th data-colid="12"><span>Date Pd</span></th>
                        <th data-colid="13"><span>Week 1</span></th>
                        <th data-colid="14"><span>Week 2</span></th>
                        <th data-colid="15"><span>Week 3</span></th>
                        <th data-colid="16"><span>Week 4</span></th>
                        <th data-colid="17"><span>Room</span></th>
                        <th data-colid="18"><soan>Actions</span></th>

                        <th data-colid="19" style="display:none;">Birthday</th>
                        <th data-colid="20" style="display:none;">Guardian</th>
                        <th data-colid="21" style="display:none;">E-mail</th>
                        <th data-colid="22" style="display:none;">Notes</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i=0;
                    foreach($roster as $rost){
                        //   $franchise_id = get_post_meta( $rost->ID, 'roster_franchise_id', true );
                        //   $location_id = get_post_meta( $rost->ID, 'roster_location_id', true );                          
                        //   $class_id = get_post_meta( $rost->ID, 'roster_class_id', true );
                        //   $coach_ids = get_post($class_id)->coaches; // get_post_meta( $rost->ID, 'roster_coach_id', true );
                        $modifications = $rost->modifications;
                        $customer_id = get_post_meta( $rost->ID, 'roster_customer_id', true );                                                    

                        //$franchise = get_user_meta( (int) $franchise_id, 'franchise_name', true);
                        //$location = get_post( (int) $location_id );
                        //$class = get_post( (int) $class_id );
                        //$coach = get_user_by ('id', (int) $coach_id);
                    
                        $customer = get_post( (int) $customer_id );
                        //$customer_paid_registration_fee = $customer->paid_tuition ? 'x' : '';
                        $tuition_paid_date = '';
                        $registration_paid = '';
                        $tuition_paid_amt = 0;
                        $registration_paid_amt = 0;
                        $weeks = ['','','','',''];

                        $payments = get_posts(array(
                            'post_type' => 'payment',
                            'post_status' => 'any',
                            'posts_per_page' => -1,
                            'meta_query' => array(
                                array(
                                    'key' => 'payment_customer_id',
                                    'value' => $customer_id,
                                    'compare' => '=',
                                ),
                                /*array(
                                    'key' => 'payment_paid_date',
                                    'value' => "$month/",
                                    'compare' => 'LIKE',
                                )*/
                            )
                        ));

                        
                    
                        foreach($payments as $payment){                            
                            if($payment->payment_type == 'registration'){
                                $registration_paid_amt = $payment->payment_paid_amount;
                                if($registration_fee > $registration_paid_amt){
                                    $registration_paid = 'partial';
                                }
                                else {
                                    $registration_paid = 'x';
                                }
                            }
                            else if($payment->payment_type == 'tuition' && $tuition_paid_amt == 0){                                
                                if(date('Y',strtotime($payment->payment_paid_date)) == $year && date('m',strtotime($payment->payment_paid_date)) == $month){
                                    $tuition_paid_date = $payment->payment_paid_date;
                                    $tuition_paid_amt = $payment->payment_paid_amount;
                                    //break;
                                }                                                                
                            }
                        }                                            

                        $attendances = get_posts(array(
                            'post_type' => 'attendance',
                            'post_status' => 'any',
                            'posts_per_page' => -1,
                            'meta_query' => array(
                                array(
                                    'key' => 'attendance_customer_id',
                                    'value' => $customer_id,
                                    'compare' => '=',
                                )
                            )
                        ));                        

                        foreach($attendances as $attendance){   
                            $attendance_date = $attendance->attendance_date;
                            $formatted = vsprintf('%3$04d-%1$02d-%2$02d', sscanf($attendance_date,'%02d/%02d/%04d'));                     
                            $weeks[ am2GetWeekInMonth($formatted, "sunday") -1 ] = 'x';
                        }

                        $roster_customer_status = isset($modifications['roster_customer_status']) ? $modifications['roster_customer_status'] : $rost->roster_customer_status;
                        $roster_customer_media = isset($modifications['roster_customer_media']) ? $modifications['roster_customer_media'] : $rost->roster_customer_media;                    
                        $roster_customer_discount = isset($modifications['roster_customer_discount']) ? $modifications['roster_customer_discount'] : $rost->roster_customer_discount;  
                        $roster_payment_type = isset($modifications['roster_payment_type']) ? $modifications['roster_payment_type'] : $rost->roster_payment_type;                        
                        $registration_paid = isset($modifications['registration_paid']) ? $modifications['registration_paid'] : $registration_paid;
                        $tuition_paid_date = isset($modifications['tuition_paid_date']) ? $modifications['tuition_paid_date'] : $tuition_paid_date;
                        $tuition_paid_amt = isset($modifications['tuition_paid_amt']) ? $modifications['tuition_paid_amt'] : $tuition_paid_amt;
                        
                        $week1 = isset($modifications['week1']) ? $modifications['week1'] : $weeks[0];
                        $week2 = isset($modifications['week2']) ? $modifications['week2'] : $weeks[1];
                        $week3 = isset($modifications['week3']) ? $modifications['week3'] : $weeks[2];
                        $week4 = isset($modifications['week4']) ? $modifications['week4'] : $weeks[3];                        
                        
                        
                        /*$sel_coaches = get_post_meta($class_id, 'coaches', true);
                        $sel_coaches = array_map(function($coach){
                            return get_user_by('id',$coach)->display_name;
                        },$sel_coaches);*/
                        
                        //$str_coaches = implode(',',$sel_coaches);
                    ?>
                    <tr class="gradeA" data-roster-id="<?php echo $rost->ID;?>">
                        <td><span class="a_details">+</span></td>
                        <td style="white-space:nowrap"><a class="am2-ajax-modal"
                        data-original-title="Edit" data-placement="top" data-toggle="tooltip"
                        data-modal="<?php echo get_ajax_url('modal','roster-edit') .'&id='.$rost->ID; ?>"><?php echo $i+1; ?></a></td>
                        <td class="editable"><span><?php echo $roster_customer_status;?></span><select name="roster_customer_status" class="hidden"><?php echo $status_options; ?></select></td>
                        <td class="editable"><span><?php echo $roster_customer_media;?></span><select name="roster_customer_media" class="hidden"><?php echo $customer_media_options; ?></select></td>
                        <td><span><?php echo $customer->childs_first_name . ' ' . $customer->childs_last_name;?></span></td>
                        <td><span><?php echo $customer->childs_gender;?></span></td>
                        <td><span><?php echo $registration_fee;?></span></td>
                        <td class="editable_direct"><input type="checkbox" name="registration_paid" value="x" <?php if($registration_paid == 'x') echo 'checked="checked"';?>/></td>
                        <td class="editable"><span><?php echo $roster_customer_discount;?></span><select name="roster_customer_discount" class="hidden"><?php echo $discount_options; ?></select></td>
                        <td><span><?php echo $tuition;?></span></td>
                        <td class="editable"><span><?php echo $roster_payment_type;?></span><select name="roster_payment_type" class="hidden"><?php echo $payment_options; ?></select></td>
                        <td class="editable"><span><?php echo $tuition_paid_amt;?></span><input name="tuition_paid_amt" class="hidden" /></td>
                        <td class="editable"><span><?php echo $tuition_paid_date;?></span><input name="tuition_paid_date" class="hidden" /></td>
                        <td class="editable_direct"><span><?php echo $weeks[0];?></span><input type="checkbox" name="week1" value="x" <?php if($week1 == 'x') echo 'checked="checked"';?>/></td>
                        <td class="editable_direct"><span><?php echo $weeks[1];?></span><input type="checkbox" name="week2" value="x" <?php if($week2 == 'x') echo 'checked="checked"';?>/></td>
                        <td class="editable_direct"><span><?php echo $weeks[2];?></span><input type="checkbox" name="week3" value="x" <?php if($week3 == 'x') echo 'checked="checked"';?>/></td>
                        <td class="editable_direct"><span><?php echo $weeks[3];?></span><input type="checkbox" name="week4" value="x" <?php if($week4 == 'x') echo 'checked="checked"';?>/></td>
                        <td><span><?php //echo "F{$rost->roster_franchise_id} L{$rost->roster_location_id} C{$rost->roster_class_id} CO{$rost->roster_coach_id}";?></span></td>             
                        <td style="display:none;"><?php echo $customer->childs_birthday;?></td>
                        <td style="display:none;"><?php echo $customer->parents_name;?></td>
                        <td style="display:none;"><?php echo $customer->email;?></td>
                        <td style="display:none;"></td>
                      <td>
                        <a class="am2-ajax-modal btn btn--primary is-smaller"
                        data-original-title="Edit" data-placement="top" data-toggle="tooltip"
                        data-modal="<?php echo get_ajax_url('modal','roster-edit') .'&id='.$rost->ID; ?>"><i class="fa fa-pencil"></i></a>
                        <?php if( is_role('administrator') || is_role('super_admin') ){ ?>
                          <a class="am2-ajax-modal-delete btn btn--danger is-smaller"
                          data-original-title="Delete" data-placement="top" data-toggle="tooltip"
                          data-object="attend" data-id="<?php echo $rost->ID; ?>"><i class="fa fa-trash-o"></i></a>
                        <?php }; ?>
                    </tr>
                    <?php $i++; }; ?>
                  </tbody>
                </table>
                <?php } ?>
            </div>
        </div>
    </div>
        
<script type="text/javascript">

set_title('Roster');

$(document).ready(function() {
    var exportColumns = [];

    for(i=1; i<=22; i++){
        exportColumns.push(i);
    }

    console.log(exportColumns);

    var dt = $('#datatable-editable').DataTable({
        dom: 'Blfrtip',
        "paging":   false,
        "ordering": false,
        "info":     false,
        buttons: [
            {
                extend: 'csv',
                className: 'btn btn--secondary',
                exportOptions: {
                    columns: exportColumns
                }
            },
        ]
    });

    var detailRows = [];

    function formatDetails ( d ) {
        console.log(d);
        return "<table>"+
            "<tr>"+
            '<td>Birthday: '+d[18]+'</td>'+
            '<td>Guardian: '+d[19]+'</td>'+
            '<td><a href="mailto:'+d[20]+'">E-mail</a></td>'+
            '<td>Notes: ' + d[21] + '</td>'+
            '<tr>'+
            '</table>';

    } 

    $('#datatable-editable tbody').on( 'click', 'tr .a_details', function () {
        var tr = $(this).closest('tr');
        var row = dt.row( tr );
        var idx = $.inArray( tr.attr('id'), detailRows );
 
        if ( row.child.isShown() ) {
            tr.removeClass( 'details' );
            row.child.hide();
 
            // Remove from the 'open' array
            detailRows.splice( idx, 1 );
        }
        else {
            tr.addClass( 'details' );
            row.child( formatDetails( row.data() ) ).show();
 
            // Add to the 'open' array
            if ( idx === -1 ) {
                detailRows.push( tr.attr('id') );
            }
        }
    } );
 
    // On each draw, loop over the `detailRows` array and show any child rows
    dt.on( 'draw', function () {
        $.each( detailRows, function ( i, id ) {
            $('#'+id+' .a_details').trigger( 'click' );
        } );
    } );

    var form = $("body");

    $('#f_franchise_id').select2({
        placeholder: 'Select a franchise',
        width: '100%',
        minimumResultsForSearch: -1
    })
    .on('select2:select', function() {
        console.log('f_franchise_id select()');
        $.ajax({
            url: '<?php echo site_url();?>/wp-admin/admin-ajax.php?action=submit_data',
            type: 'POST',
            dataType: 'json',
            data: {
                form_handler: 'get_territories',
                franchise_id: ($('#f_franchise_id').val() ? $('#f_franchise_id').val() : <?php echo $curr_franchise ? $curr_franchise : 'null';?>)
            },
            beforeSend: function() {
                am2_show_preloader(form);
            },
            success: function(data) {
                var placeholder = data.length == 1 ? "No territories found for this franchise" : "Select a territory";

                $('#f_territory_id').html('').select2({
                    placeholder: placeholder,
                    data: data,
                    width: '100%',
                    id: 'unit_number',
                    formatSelection: function (item) { return item.territory_name; },
                    formatResult: function (item) { return item.territory_name; }
                });

                am2_hide_preloader(form);
            }
        });
    });

    $('#f_territory_id').select2({
        placeholder: 'Select a territory',
        width: '100%',
        minimumResultsForSearch: -1
    })
    .on('select2:select', function() {
        $.ajax({
            url: '<?php echo site_url();?>/wp-admin/admin-ajax.php?action=submit_data',
            type: 'POST',
            dataType: 'json',
            data: {
                form_handler: 'get_locations',
                franchise_id: ($('#f_franchise_id').val() ? $('#f_franchise_id').val() : <?php echo $curr_franchise ? $curr_franchise : 'null';?>),
                territory_id: $('#f_territory_id').val()
            },
            beforeSend: function() {
                am2_show_preloader(form);
            },
            success: function(data) {
                var placeholder = data.length == 1 ? "No locations found for this franchise" : "Select a location";

                $('#f_location_id').html('').select2({
                    placeholder: placeholder,
                    data: data,
                    width: '100%'                    
                });

                am2_hide_preloader(form);
            }
        });
    });

    $('#f_location_id').select2({
        placeholder: 'Select a location',
        width: '100%',
        minimumResultsForSearch: -1
    })
    .on('select2:select', function() {
        $.ajax({
            url: '<?php echo site_url();?>/wp-admin/admin-ajax.php?action=submit_data',
            type: 'POST',
            dataType: 'json',
            data: {
                form_handler: 'get_classes',
                location_id: $('#f_location_id').val()
            },
            beforeSend: function() {
                am2_show_preloader(form);
            },
            success: function(data) {
                var placeholder = data.length == 1 ? "No classes found for this location" : "Select a class";

                data = $.map(data, function(item, a) {
                    return "<option value=" + item.id + " data-franchise-id='"+item.franchise_id+"' data-location-id='"+item.location_id+"'>" + item.text + "</option>";
                });

                console.log(data);

                $('#f_class_id').html(data);

                $('#f_class_id').select2({
                    placeholder: placeholder,
                    //data: data,
                    width: '100%'
                });
                am2_hide_preloader(form);
            }
        });
    });

    $('#f_class_id').select2({
        placeholder: 'Select a location first',
        width: '100%',
        minimumResultsForSearch: -1
    }).on('select2:select',function(){      
        $.ajax({
            url: '<?php echo site_url();?>/wp-admin/admin-ajax.php?action=submit_data',
            type: 'POST',
            dataType: 'json',
            data: {
                form_handler: 'get_coaches',
                class_id: $('#f_class_id').val()
            },
            beforeSend: function() {
                am2_show_preloader(form);
            },
            success: function(data) {
                //alert(123);
                var placeholder = data.length == 1 ? "No coaches found for this class" : "Select a coach";                
                
                $('#f_coach_id').select2({
                    placeholder: placeholder,
                    data: data,
                    width: '100%'
                });
                am2_hide_preloader(form);
            }
        })
    });

    $('#f_coach_id').select2({
        placeholder: 'Select a coach',
        width: '100%',
        minimumResultsForSearch: -1
    });

    $('#f_year').select2({
        placeholder: 'Select a year',
        width: '100%',
        minimumResultsForSearch: -1
    });

    $('#f_month').select2({
        placeholder: 'Select a month',
        width: '100%',
        minimumResultsForSearch: -1
    });

    $('#filter select').on('select2:select', function(){
        console.log('select2:select');

        var idx = $(this).index();

        /*if($(this).attr('id')=='f_franchise_id'){
            window.location.hash = '#roster/?f_franchise_id=' + $(this).val();
        }
        else if($(this).attr('id')=='f_location_id'){            
            window.location.hash = '#roster/?f_franchise_id=' + $('#f_franchise_id').val() + '&f_location_id=' + $(this).val();
        }
        else*/
        $('#filter select').each(function(){
            if($(this).index() > idx){
                $(this).html('').val('').trigger('change');
            }
        });

        if( $('#f_class_id').val() ){            
            var filters = new Array;

            var sep = '?';
            var query = '';

            $('#filter select').each(function(){                
                if($(this).val()){
                    query += sep + $(this).attr('name') + '=' + $(this).val();
                    sep = '&';
                }            
            });

            window.location.hash = '#roster/' + query;
        }        
    });

    $('#datatable-editable td.editable').on('click', function(){
      console.log('td click');

      if(!$(this).hasClass('edit')){
          $(this).addClass('edit');
          console.log('edit');
          $(this).children('input,select').eq(0).val($(this).children('span').text()).focus().select();
      }      
      else {          
      }
  });  

  $('#datatable-editable td.editable_direct :input').on('change', function(){
    var $tr = $(this).closest('tr');
    var $td = $(this).closest('td');        
    var roster_id = $tr.data('roster-id');
    var row_data = {};
    var name = $(this).attr('name');
    var val = $(this).val();
    var type = $(this).attr('type');    

    console.log(val);   
    if(type=='checkbox' && !this.checked){
       val = '';
    }
    console.log(val);

    row_data[name] = val;    
    $.post('<?php echo site_url();?>/wp-admin/admin-ajax.php?action=submit_data', {action: 'submit_data', form_handler:'roster_inline_edit', roster_id: roster_id, modifications: row_data  }, function(resp){
        console.log(resp);
        $td.removeClass('edit');
    });

  });

  $('#datatable-editable td.editable :input').on('blur', function(){    
    var $tr = $(this).closest('tr');
    var $td = $(this).closest('td');
    var name = $(this).attr('name');
    var val = $(this).val();
    var roster_id = $tr.data('roster-id');
    var row_data = {};
    
    $td.children('span').text(val);    

    row_data[name] = val;    

    $.post('<?php echo site_url();?>/wp-admin/admin-ajax.php?action=submit_data', {action: 'submit_data', form_handler:'roster_inline_edit', roster_id: roster_id, modifications: row_data  }, function(resp){
        console.log(resp);
        $td.removeClass('edit');
    });
  });
});
</script>

<?php get_template_part('blocks/modal-template'); ?>