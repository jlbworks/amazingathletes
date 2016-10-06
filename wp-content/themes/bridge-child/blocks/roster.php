<?php 
global $current_user; 
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

if( is_role('franchisee') ) {
  $args['author ']  =  get_current_user_id();
  $meta_query[] =
        array('key'=> 'roster_franchise_id', 'value'=> $current_user->ID, 'compare'=>'=');
}

if( is_role('coach') ){
    $meta_query[] =
        array('key'=> 'roster_coach_id', 'value'=> $current_user->ID, 'compare'=>'=');    
}

if( isset($hash_query['f_franchise_id']) ){
    $meta_query[] = 
        array('key' => 'roster_franchise_id', 'value' => $hash_query['f_franchise_id'], 'compare' => '=');
}

if( isset($hash_query['f_location_id']) ){
    $meta_query[] = 
        array('key' => 'roster_location_id', 'value' => $hash_query['f_location_id'], 'compare' => '=');
}

if( isset($hash_query['f_class_id']) ){
    $meta_query[] = 
        array('key' => 'roster_class_id', 'value' => $hash_query['f_class_id'], 'compare' => '=');
}

if( isset($hash_query['f_coach_id']) ){
    $meta_query[] = 
        array('key' => 'roster_coach_id', 'value' => $hash_query['f_coach_id'], 'compare' => '=');
}


$args['meta_query'] = $meta_query;

$roster = get_posts($args);

if(is_role('franchisee')){
    $args = array(
        'role' => 'franchisee'         
    );
    $args['include'] = get_current_user_id();

    $franchises = get_users($args);

    $args = array(
        'post_type' => 'location',
        'post_status' => 'publish',
        'posts_per_page' => -1,
    );

    $args['author']  =  get_current_user_id();

    $locations = get_posts($args);
    $location_ids = array_map(function($loc){
        return $loc->ID;
    }, $locations);

    $classes = get_posts(
        array(
            'post_type' => 'location_class',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'meta_query' => array(
                array( 'key' => 'location_id', 'value' => $location_ids, 'compare' => 'IN'),
            )
        )        
    );
    $class_ids = array_map(function($class){
        return $class->ID;
    }, $classes);

    $coach_ids = array();
    foreach($classes as $class){
        if(is_array($class->coaches)){
            foreach($class->coaches as $coach){
                $coach_ids[] = $coach;
            }
        }
    }

    $coaches = get_users(
        array(
            'role' => 'coach',        
        )                
    );
}

if(is_role('coach')){
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
                <?php if(is_role('administrator')||is_role('franchisee')){?>
                <select id="f_franchise_id" name="f_franchise_id" >
                    <option value="">Choose Franchise</option>
                    <?php foreach($franchises as $franchise){  ?>
                    <option value="<?php echo $franchise->ID;?>" <?php if($hash_query['f_franchise_id'] == $franchise->ID) echo "selected";?>><?php echo $franchise->franchise_name;?></option>
                    <?php } ?>
                </select>                
                <select id="f_location_id" name="f_location_id" >
                    <option value="">Choose Location</option>
                    <?php foreach($locations as $location){ if(!in_array($location->ID, $location_ids)) continue; ?>
                    <option value="<?php echo $location->ID;?>" <?php if($hash_query['f_location_id'] == $location->ID) echo "selected";?>><?php echo $location->post_title;?></option>
                    <?php } ?>
                </select>
                
                <select id="f_class_id" name="f_class_id" >
                    <option value="">Choose Class</option>
                    <?php foreach($classes as $class){ if(!in_array($class->ID, $class_ids)) continue;?>
                    <option value="<?php echo $class->ID;?>" <?php if($hash_query['f_class_id'] == $class->ID) echo "selected";?>><?php echo $class->post_title;?></option>
                    <?php } ?>
                </select>
                <select id="f_coach_id" name="f_coach_id" >
                    <option value="">Choose Coach</option>
                    <?php foreach($coaches as $coach){ if(!in_array($coach->ID, $coach_ids)) continue;?>
                    <option value="<?php echo $coach->ID;?>" <?php if($hash_query['f_coach_id'] == $coach->ID) echo "selected";?>><?php echo $coach->display_name;?></option>
                    <?php } ?>
                </select>
                <?php }                
                
                else if(is_role('coach')){?>                
                <select id="f_class_id" name="f_class_id" >
                    <option value="">Choose Class</option>
                    <?php foreach($classes as $class){ if(!in_array($class->ID, $class_ids)) continue;?>
                    <option value="<?php echo $class->ID;?>" <?php if($hash_query['f_class_id'] == $class->ID) echo "selected";?>><?php echo $class->post_title;?></option>
                    <?php } ?>
                </select>
                <?php } ?>
            </div>
            <br/>
            <br/>
            <div class="col-1 break-big">
                <!-- TABLE (LIST OF USERS) -->
                <table class="table js-responsive-table" id="datatable-editable">
                  <thead>
                    <tr>
                        <th><span>Franchise</span></th>
                        <th><span>Location</span></th>
                        <th><span>Class</span></th>
                        <th><span>Coach</span></th>
                        <th><span>Customer Name</span></th>
                        <th><span>Actions</span></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      foreach($roster as $rost){
                          $franchise_id = get_post_meta( $rost->ID, 'roster_franchise_id', true );
                          $location_id = get_post_meta( $rost->ID, 'roster_location_id', true );                          
                          $class_id = get_post_meta( $rost->ID, 'roster_class_id', true );
                          $coach_id = get_post_meta( $rost->ID, 'roster_coach_id', true );
                          $customer_id = get_post_meta( $rost->ID, 'roster_customer_id', true );

                          $franchise = get_user_meta( (int) $franchise_id, 'franchise_name', true);
                          $location = get_post( (int) $location_id );
                          $class = get_post( (int) $class_id );
                          $coach = get_user_by ('id', (int) $coach_id); 
                          $customer = get_post( (int) $customer_id );
                          
                          /*$sel_coaches = get_post_meta($class_id, 'coaches', true);
                          $sel_coaches = array_map(function($coach){
                              return get_user_by('id',$coach)->display_name;
                          },$sel_coaches);*/
                          
                          //$str_coaches = implode(',',$sel_coaches);


                    ?>
                    <tr class="gradeA">
                      <td style="white-space:nowrap"><a class="am2-ajax-modal"
                        data-original-title="Edit" data-placement="top" data-toggle="tooltip"
                        data-modal="<?php echo get_ajax_url('modal','roster-edit') .'&id='.$rost->ID; ?>"><?php echo $franchise; ?></a></td>
                      <td><?php echo $location->post_title; ?></td>                                            
                      <td><?php echo $class->post_title;?></td>                      
                      <td><?php echo $coach->display_name;?></td>
                      <td><?php echo $customer->post_title ?></td>                      
                      <td>
                        <a class="am2-ajax-modal btn btn--primary is-smaller"
                        data-original-title="Edit" data-placement="top" data-toggle="tooltip"
                        data-modal="<?php echo get_ajax_url('modal','roster-edit') .'&id='.$rost->ID; ?>"><i class="fa fa-pencil"></i></a>
                        <?php if( is_role('administrator') ){ ?>
                          <a class="am2-ajax-modal-delete btn btn--danger is-smaller"
                          data-original-title="Delete" data-placement="top" data-toggle="tooltip"
                          data-object="attend" data-id="<?php echo $rost->ID; ?>"><i class="fa fa-trash-o"></i></a>
                        <?php }; ?>
                    </tr>
                    <?php }; ?>
                  </tbody>
                </table>
            </div>
        </div>
    </div>
        
<script type="text/javascript">

set_title('Roster');

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
    });
});
</script>

<?php get_template_part('blocks/modal-template'); ?>