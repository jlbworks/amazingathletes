<?php 
global $current_user; 
get_currentuserinfo();

restrict_access('administrator,franchisee');

$args = array(
  'post_type'   => 'attendance',
  'post_status' => 'publish',
  'posts_per_page'=> -1,
);
if( is_role('franchisee') ) {
  $args['author ']  =  get_current_user_id();
}
$attendance = get_posts($args);

?>

    <!-- CONTENT HEADER -->
    <div class="layout context--pageheader">
        <div class="container clearfix">
            <div class="col-12 break-big">
                <h1>Attendance</h1>
                <button class="btn btn--primary am2-ajax-modal modal-with-move-anim" data-modal="<?php echo get_ajax_url('modal','attendance-edit') .'&id='; ?>"><i class="fa fa-plus"></i>&nbsp; Add New Attendance Entry</button>
            </div>
        </div>
    </div>

    <!-- PRODUCT INFORMATION -->
    <div class="layout">
        <div class="container clearfix">
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
                        <th><span>Date</span></th>
                        <th><span>Actions</span></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      foreach($attendance as $attend){
                          $franchise_id = get_post_meta( $attend->ID, 'attendance_franchise_id', true );
                          $location_id = get_post_meta( $attend->ID, 'attendance_location_id', true );
                          $customer_id = get_post_meta( $attend->ID, 'attendance_customer_id', true );
                          $class_id = get_post_meta( $attend->ID, 'attendance_class_id', true );
                          $coach_id = get_post_meta( $attend->ID, 'attendance_coach_id', true );

                          $franchise = get_user_meta( (int)$franchise_id, 'franchise_name', true);
                          $location = get_post( (int)$location_id );
                          $customer = get_post( (int)$customer_id );
                          $class = get_post( (int)$class_id );
                          $coach = get_user_by('id', $coach_id, true);

                          $coach_name = $coach->first_name . ' ' . $coach->last_name;

                    ?>
                    <tr class="gradeA">
                      <td style="white-space:nowrap"><a class="am2-ajax-modal"
                        data-original-title="Edit" data-placement="top" data-toggle="tooltip"
                        data-modal="<?php echo get_ajax_url('modal','attendance-edit') .'&id='.$attend->ID; ?>"><?php echo $franchise; ?></a></td>
                      <td><?php echo $location->post_title; ?></td>
                      <td><?php echo $class->post_title ?></td>
                      <td><?php echo $coach_name; ?></td>
                      <td><?php echo $customer->post_title ?></td>
                      <td><?php echo get_post_meta( $attend->ID, 'attendance_date', true ); ?></td>
                      <td>
                        <a class="am2-ajax-modal btn btn--primary is-smaller"
                        data-original-title="Edit" data-placement="top" data-toggle="tooltip"
                        data-modal="<?php echo get_ajax_url('modal','attendance-edit') .'&id='.$attend->ID; ?>"><i class="fa fa-pencil"></i></a>
                        <?php if( is_role('administrator') ){ ?>
                          <a class="am2-ajax-modal-delete btn btn--danger is-smaller"
                          data-original-title="Delete" data-placement="top" data-toggle="tooltip"
                          data-object="attend" data-id="<?php echo $attend->ID; ?>"><i class="fa fa-trash-o"></i></a>
                        <?php }; ?>
                    </tr>
                    <?php }; ?>
                  </tbody>
                </table>
            </div>
        </div>
    </div>
        
<script type="text/javascript">

set_title('Attendance');

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
});
</script>

<?php get_template_part('blocks/modal-template'); ?>