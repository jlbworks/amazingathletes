<?php 
global $current_user, $wpdb; 
get_currentuserinfo();

restrict_access('super_admin','administrator,franchisee,coach');

$hash_query = str_replace('?','',$_REQUEST['target_args']);
parse_str($hash_query,$hash_query);

$meta_query = array();

$args = array(
  'post_type'   => 'rss',
  'post_status' => 'publish',
  'posts_per_page'=> -1,
);

$hash_query = str_replace('?','',$_REQUEST['target_args']);
parse_str($hash_query,$hash_query); 

if(is_role('administrator') || is_role('super_admin')){
    if( isset($hash_query['f_franchise_id']) ){

        $coaches = $wpdb->get_col(
            $wpdb->prepare("SELECT DISTINCT u.ID FROM $wpdb->users u INNER JOIN $wpdb->usermeta um ON u.ID = um.user_id WHERE um.meta_key = 'franchisee' AND um.meta_value = %s", $hash_query['f_franchise_id'])
        );    

        $coaches[] = $hash_query['f_franchise_id'];                

        $meta_query[] =
            array('key'=> 'rss_franchise_id', 'value'=> $coaches , 'compare'=>'IN');
    }
}

else if( is_role('franchisee') ) {
    $coaches = $wpdb->get_col(
        $wpdb->prepare("SELECT DISTINCT u.ID FROM $wpdb->users u INNER JOIN $wpdb->usermeta um ON u.ID = um.user_id WHERE um.meta_key = 'franchisee' AND um.meta_value = %s",$current_user->ID)
    );    

    $coaches[] = $current_user->ID;

    $meta_query[] =
        array('key'=> 'rss_franchise_id', 'value'=> $coaches, 'compare'=>'IN');
}
else if(is_role('coach')){
    $meta_query[] =
        array('key'=> 'rss_franchise_id', 'value'=> array(/*$current_user->franchisee,*/ $current_user->ID) , 'compare'=>'IN');
}

if( isset($hash_query['f_year']) ){
    $year = $hash_query['f_year'];
    $meta_query[] =
        array('key'=> 'rss_year', 'value'=> $year , 'compare'=>'=');
}

if( isset($hash_query['f_month']) ){
    $month = (int)$hash_query['f_month'];
    $dateObj = DateTime::createFromFormat('!m', $month);    
    $month_name = $dateObj->format('M');
    $month_name = strtolower($month_name);
    
    $meta_query[] =
        array('key'=> 'rss_month', 'value'=> $month_name , 'compare'=>'=');
}

$args['meta_query'] = $meta_query;

$rss_reports = get_posts($args);


$args = array(
    'role' => 'franchisee',
    'orderby' => 'first_name,last_name', 
    'order' => 'ASC'        
);
if( am2_is_top_role('franchisee') ){
    $args['include'] = get_current_user_id();
}

$franchises = get_users($args);

usort($franchises, function($a, $b) {
    if($a->first_name == $b->first_name)
        return $a->last_name < $b->last_name ? -1 : 1;
    return $a->first_name < $b->first_name ? -1 : 1;
});

/*if(am2_is_single_role('coach')){
    $classes = get_posts(
        array(
            'post_type' => 'location_class',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'meta_query' => array(
                array('key' => 'coaches', 'value' => '"' .  get_current_user_id() . '"', 'compare' => 'LIKE' ),
            )
        )
    );
    $class_ids = array_map(function($class){
        return $class->ID;
    }, $classes);
}*/

$months = array(
    'jan' => 'January',
    'feb' => 'February',
    'mar' => 'March',
    'apr' => 'April',
    'may' => 'May',
    'jun' => 'June',
    'jul' => 'July',
    'aug' => 'August',
    'sep' => 'September',
    'oct' => 'October',
    'nov' => 'November',
    'dec' => 'December',
);


?>

    <!-- CONTENT HEADER -->
    <div class="layout context--pageheader">
        <div class="container clearfix">
            <div class="col-12 break-big">
                <h1>RSS</h1>
                <button class="btn btn--primary am2-ajax-modal modal-with-move-anim" data-modal="<?php echo get_ajax_url('modal','rss-edit') .'&id='; ?>"><i class="fa fa-plus"></i>&nbsp; Create New RSS Report</button>
            </div>
        </div>
    </div>

    <!-- PRODUCT INFORMATION -->
    <div class="layout">
        <div class="container clearfix">
            <?php if(is_role('administrator') || is_role('super_admin') || is_role('franchisee')) { ?>
            <div class="col-1 break-big" id="filter">
                Filter by: 
                <?php if(is_role('administrator') || is_role('super_admin')){ ?>
                <select id="f_franchise_id" name="f_franchise_id" >
                    <option value="">Choose Franchise</option>
                    <?php foreach($franchises as $franchise){   
                            $franchise_name = $franchise->display_name;
                            if(!empty($franchise->first_name) || !empty($franchise->last_name)) {
                                $franchise_name = $franchise->first_name . ' ' . $franchise->last_name;
                            }     
                        ?>
                    <option value="<?php echo $franchise->ID;?>" <?php if($hash_query['f_franchise_id'] == $franchise->ID) echo "selected";?>><?php echo $franchise_name;?></option>
                    <?php } ?>
                </select>                
                <?php } ?>
                <select id="f_year" name="f_year" >
                    <option value="">Choose a Year</option>
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
                    <option value="">Choose a Month</option>
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
            </div>
            <?php } ?> 
            <br/>
            <br/>
            <div class="col-1 break-big">
                <!-- TABLE (LIST OF USERS) -->
                <table class="table js-responsive-table" id="datatable-editable">
                  <thead>
                    <tr>
                        <th><span>Franchise</span></th>
                        <th><span>Month</span></th>
                        <th><span>Year</span></th>
                        <th><span>Actions</span></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      foreach($rss_reports as $rss){
                          $franchise_id = get_post_meta( $rss->ID, 'rss_franchise_id', true );
                          $month = get_post_meta( $rss->ID, 'rss_month', true );    
                          $year = get_post_meta( $rss->ID, 'rss_year', true );    

                          $franchise = get_user_by( 'id', (int) $franchise_id);  
                          $franchise_name = $franchise->franchise_name;
                            if(!empty($franchise->first_name) || !empty($franchise->last_name)) {
                                $franchise_name = $franchise->first_name . ' ' . $franchise->last_name;
                            }                  

                    ?>
                    <tr class="gradeA">
                      <td style="white-space:nowrap"><a class=""
                        data-original-title="Edit" data-placement="top" data-toggle="tooltip"
                        href="#rss-report/?id=<?php echo $rss->ID; ?><?php echo isset($rss->rss_territory_id) ? '&f_territory_id=' . $rss->rss_territory_id : '';?>"><?php echo $franchise_name; ?></a></td>
                      <td><?php echo $months[$month]; ?></td>                                            
                      <td><?php echo $year;?></td>                                          
                      <td>
                        <a class="btn btn--primary is-smaller"
                                   data-original-title="Edit" data-placement="top" data-toggle="tooltip"
                                   href="#rss-report/?id=<?php echo $rss->ID; ?>"><i class="fa fa-pencil"></i></a>
                        <?php if( is_role('administrator') || is_role('super_admin') ){ ?>
                          <a class="am2-ajax-modal-delete btn btn--danger is-smaller"
                          data-original-title="Delete" data-placement="top" data-toggle="tooltip"
                          data-object="rss" data-id="<?php echo $rss->ID; ?>"><i class="fa fa-trash-o"></i></a>
                        <?php }; ?>
                    </tr>
                    <?php }; ?>
                  </tbody>
                </table>
            </div>
        </div>
    </div>
        
<script type="text/javascript">

set_title('RSS Reports');

$(document).ready(function() {
    $('#datatable-editable').DataTable({
        dom: 'Blfrtip',
        "paging":   false,
        "ordering": false,
        "info":     false,
        buttons: [
            {
                extend: 'csv',
                className: 'btn btn--secondary',
                exportOptions: {
                    columns: [0,1,2,3]
                }
            },
        ]
    });

    /*$('#f_franchise_id').select2({
        placeholder: 'Select a franchise',
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
                franchise_id: $('#f_franchise_id').val()
            },
            beforeSend: function() {
                am2_show_preloader(form);
            },
            success: function(data) {
                var placeholder = data.length == 1 ? "No locations found for this franchise" : "Select a location";

                $('#f_location_id').html('').select2({
                    placeholder: placeholder,
                    width: '100%',
                    data: data
                });

                $('#f_class_id').html('').select2({
                    placeholder: 'Select a location first',
                    width: '100%'
                });

                am2_hide_preloader(form);
            }
        })
    });

    $('#f_customer_id').select2({
        placeholder: 'Select a customer',
        width: '100%',
        minimumResultsForSearch: -1
    });

    $('#f_coach_id').select2({
        placeholder: 'Select a coach',
        width: '100%',
        minimumResultsForSearch: -1
    });

    $('#f_location_id').select2({
        placeholder: 'Select a location',
        width: '100%'
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

                $('#f_class_id').html('').select2({
                    placeholder: placeholder,
                    data: data,
                    width: '100%'
                });
                am2_hide_preloader(form);
            }
        })
    });

    $('#f_class_id').select2({
        placeholder: 'Select a location first',
        width: '100%'
    }).on('change',function(){      
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
                var placeholder = data.length == 1 ? "No coaches found for this location" : "Select a coach";

                $('#f_coach_id').html('').select2({
                    placeholder: placeholder,
                    data: data,
                    width: '100%'
                });
                am2_hide_preloader(form);
            }
        })  
    
    });*/
    $('#filter select').on('change', function(){
        var idx = $(this).index();
        var filters = new Array;

        $('#filter select').each(function(){
            if($(this).index() > idx){
                //console.log($(this).index());
                $(this)/*.html('')*/.val('').trigger('change');
            }
        });

        var sep = '?';
        var query = '';
        $('#filter select').each(function(){
            if($(this).val()){
                query += sep + $(this).attr('name') + '=' + $(this).val();
                sep = '&';
            }            
        });
        window.location.hash = '#rss/' + query;
    });
});
</script>

<?php get_template_part('blocks/modal-template'); ?>